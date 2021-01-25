<?php

use Longman\TelegramBot\Request;

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

function alertSomeone($id, $msg) {
    Request::sendMessage([
        'chat_id' => $id,
        'text' => $msg,
        'parse_mode' => 'HTML'
    ]);
}

function alertEveryone($ids, $msg) {
    foreach ($ids as $id) {
        alertSomeone($id, $msg);
    }
}

function attemptLock($fname = "some.lock") {
    $fp = fopen($fname, "r+");

    if (flock($fp, LOCK_EX | LOCK_NB)) {
        return $fp;
    } else {
        return false;
    }
}

function releaseLock($fp) {
    flock($fp, LOCK_UN);
    fclose($fp);
}