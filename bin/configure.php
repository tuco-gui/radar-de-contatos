<?php

use Symfony\Component\Dotenv\Dotenv;
use Fernandothedev\BaseBotTelegramPhp\Db\Db;

require_once(__DIR__ . '/../vendor/autoload.php');

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . "/../.env");

$sql = file_get_contents(__DIR__ . "/../src/db/database.sql");
$stmt = Db::get(0)->prepare($sql);

if (!$stmt->execute()) {
	die("Não foi possível configurar seu banco de dados." . PHP_EOL);
}
die("Banco de dados configurado com sucesso." . PHP_EOL);