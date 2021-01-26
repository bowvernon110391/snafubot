<?php

include __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/config.php';
include __DIR__ . '/funcs.php';

/**
 * getStatus : /status
 * this function check server's status, and reply the requester with the information
 * could reply individuals, or group
 */
$getStatus = function(array $params) use ($serviceAddress, $subIds) {
    // no need to check params for now....
    $msg = "Service: '{$serviceAddress}' is <b>DOING WELL</b>. Nothing to report.";

    if (!serviceIsAlive($serviceAddress)) {
        // alert everyone
        $msg = "Service: '{$serviceAddress}' is <b>DEAD</b>. <u>PLEASE TAKE ACTION!</u>.";
    }

    $msg .= "\nTime: "  . date("Y-m-d, H:i:s");

    // alert everyone?
    // alertEveryone($subIds, $msg);
    // nah, just reply the chatId
    alertSomeone($params['chatId'], $msg);
};

$commands = [
    '/status' => $getStatus
];