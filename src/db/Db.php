<?php

namespace Fernandothedev\BaseBotTelegramPhp\Db;

use \PDO;
use \PDOException;
use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Controller\Logger;

abstract class Db
{
	public static function get(Context|int $ctx): PDO|null
	{
		try {
			$pdo = new PDO("sqlite:" . $_ENV['DATABASE']);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			return $pdo;
		} catch (PDOException $e) {
			$logger = new Logger();
			$logger->exceptionError($ctx, $e);
		}
	}
}