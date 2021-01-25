<?php

use Longman\TelegramBot\Request;

include __DIR__ . '/vendor/autoload.php';

$bot_api_key    = '1548044862:AAFUKrLj5p1o1rQWrpP3tG-mYlhLo9K_sbQ';
$bot_username   = 'snafup2_bot';

/* $mysql_credentials = [
    'host'     => 'localhost',
    'port'     => 3306, // optional
    'user'     => 'localdev',
    'password' => 'thel0newolf',
    'database' => 'tgbot',
]; */

$serviceAddress = "http://103.233.88.114:9119/";

$subIds = [
    1560492661
];

// check if the app is reachable
function serviceIsAlive($address) {
    $curl = curl_init($address);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    // curl_setopt($curl, CURLOPT_PORT, $port);
    $result = curl_exec($curl);

    var_dump($result);

    if ($result !== false) {
        // if 404, error then
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        echo "statusCode: {$statusCode}\n";

        if ($statusCode >= 404) {
            return false;
        }

        return true;
    }

    return false;
}


// main body
try {
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
        
        // try to send something
        foreach ($subIds as $subId) {
            // send to em all
            Request::sendMessage([
                'chat_id' => $subId,
                'text' => "Service '{$serviceAddress}' is <b>NOT</b> reachable.",
                'parse_mode' => 'HTML'
            ]);
        }
        echo "status: dead.\n";
    } else {
        echo "status: alive.\n";
    }
    
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // log telegram errors
    // echo $e->getMessage();
}