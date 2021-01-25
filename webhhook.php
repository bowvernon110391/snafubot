<?php

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

include __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/config.php';
include __DIR__ . '/commands.php';

// main body
try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // call update without db
    $telegram->useGetUpdatesWithoutDatabase();

    $response = $telegram->handleGetUpdates();

    echo "WEBHOOK started @ " . date('Y-m-d H:i:s') . "\n";
    echo "=====================================\n";
    echo "getUpdates is Ok? {$response->isOk()}\n";
    $result = $response->getResult();

    // do we get something?
    if (count($result)) {
        foreach ($result as $r) {
            // echo the message text
            echo $r->message["text"] . "\n";
            $msg = trim($r->message["text"]);

            if (array_key_exists($msg, $commands)) {
                // execute it?
                $cmd = $commands[$msg];
                $params = explode(' ', $msg);

                echo "Executing: {$msg}\n";

                $cmd($params);
            }
        }
    }

    echo "WEBHOOK ended @ " . date('Y-m-d H:i:s') . "\n\n";
} catch (TelegramException $e) {
    die("Some error happened: " . $e->getMessage());
}