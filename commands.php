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

/**
 * logTail : /logtail
 * this function check server's last n logs, reply with the logs contents
 */
$logTail = function(array $params) {
    // first, read some of the line?
    $nLines = intval($params['params'][1] ?? 10);   // read 10 by default
    $logs = readLastLines(__DIR__ . '/bot.log', $nLines);

    $msg = "Here's last <b>{$nLines}</b> lines of logs:\n";
    if (is_null($logs)) {
        // change message
        $msg = "Can't read logs, the log doesn't exist yet I guess :(";
    } else {
        $msg .= "------------SNIP--------------\n\n" . $logs;
        $msg .= "\n------------SNAP--------------";
    }

    alertSomeone($params['chatId'], $msg);
};

$commands = [
    '/status' => $getStatus,
    '/logtail' => $logTail
];