<?php

use Symfony\Component\Dotenv\Dotenv;
use Fernandothedev\BaseBotTelegramPhp\Controller\Bot;
use Fernandothedev\BaseBotTelegramPhp\Controller\Logger;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

require_once(__DIR__ . '/../vendor/autoload.php');

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . "/../.env");

$config = new Config();
$config->setParseMode(Config::PARSE_MODE_MARKDOWN_LEGACY);
$config->setConnectorOptions(["dns" => "8.8.8.8"]);

$bot = new Zanzara($_ENV["TOKEN_BOT"], $config);

$bot->onMessage([new Bot(), "handler"]);
$bot->onCbQuery([new Bot(), "handler"]);
$bot->onException(function (Context $ctx, $e) {
    $logger = new Logger();
    $logger->exceptionError($ctx, $e);
});

$bot->run();