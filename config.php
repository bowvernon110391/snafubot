<?php

// read teh env file here I guess

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

date_default_timezone_set("Asia/Jakarta");

$bot_api_key    = $_ENV['BOT_API_KEY'];
$bot_username   = $_ENV['BOT_USERNAME'];

/* $mysql_credentials = [
    'host'     => 'localhost',
    'port'     => 3306, // optional
    'user'     => 'localdev',
    'password' => 'thel0newolf',
    'database' => 'tgbot',
]; */

$serviceAddress = $_ENV['SERVICE_ADDRESS'];

$subIds = explode(",", $_ENV['SUBSCRIBER_IDS'] ?? '');

$groupId = $_ENV['GROUP_ID'];
