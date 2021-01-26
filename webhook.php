<?php

use Longman\TelegramBot\Exception\TelegramException;

use function PHPSTORM_META\type;

include __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/config.php';
include __DIR__ . '/commands.php';

// main body
try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // call update without db
    $telegram->useGetUpdatesWithoutDatabase();

    // $response = $telegram->handleGetUpdates();
    $json = file_get_contents("php://input");
    $data = json_decode($json);

    $isOk = !is_null($data);


    echo "WEBHOOK started @ " . date('Y-m-d H:i:s') . "\n";
    echo "=====================================\n";
    echo "getUpdates is Ok? {$isOk}\n";
    $result = [$data];

    // do we get something?
    if (!is_null($result) && count($result)) {
        foreach ($result as $r) {
            // echo the message text
            echo $r->message->text . "\n";
            $msg = trim($r->message->text);

            if (array_key_exists($msg, $commands)) {
                // execute it?
                $cmd = $commands[$msg];
                $sender = [
                    'id' => $r->message->from->id,
                    'name' => $r->message->from->first_name . ' ' . $r->message->from->last_name
                ];
                $chatId = $r->message->chat->id;

                $params = [
                    'sender' => $sender,
                    'chatId' => $chatId,
                    'params' => explode(' ', $msg)
                ];

                echo "Executing: {$msg}\n";

                $cmd($params);
            }
        }
    }

    echo "WEBHOOK ended @ " . date('Y-m-d H:i:s') . "\n\n";

    // touch(__DIR__ . "/webhook.log");
} catch (TelegramException $e) {
    die("Some error happened: " . $e->getMessage());
}