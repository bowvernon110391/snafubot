<?php

use Longman\TelegramBot\Request;

include __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/config.php';
include __DIR__ . '/funcs.php';

// main body
try {
    
    // prevent overlapping
    $lock = attemptLock();
    if ($lock === false) {
        echo "Process already running...bailing.\n";
        exit();
    }
    
    echo "CRON boT started @ " . date("Y-m-d H:i:s") . "\n";
    echo "==============================================\n";
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Enable MySQL
    // $telegram->enableMySql($mysql_credentials);
    // $telegram->useGetUpdatesWithoutDatabase();

    // Handle telegram getUpdates request
    // $response = $telegram->handleGetUpdates();

    // var_dump($response);

    echo "Checking status: {$serviceAddress}\n";
    if (!serviceIsAlive($serviceAddress)) {
        
        alertEveryone($subIds, "Service '{$serviceAddress}' is <b>NOT</b> reachable.");
        echo "status: dead.\n";
    } else {
        echo "status: alive.\n";
    }
    
    releaseLock($lock);

    echo "CRON boT ended @ " . date("Y-m-d H:i:s") . "\n";
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // log telegram errors
    // echo $e->getMessage();
}