<?php

namespace Fernandothedev\BaseBotTelegramPhp\Telegram\Commands;

use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Db\Db;
use Fernandothedev\BaseBotTelegramPhp\Telegram\CommandInterface;

final class Sql implements CommandInterface
{
	private Context $ctx;
	private bool $admin = true;
	private bool $arg = true;

	public function __construct(Context $ctx) {
		$this->ctx = $ctx;
	}

	public function handler(?string $arg = null): void
	{
		if (is_null($arg) or $arg == "") {
			$this->ctx->reply("*Cadê o SQL*");
			return;
		}

		try {
			$stmt = Db::get($this->ctx)->prepare($arg);
			$stmt->execute();
			$result = json_encode($stmt->fetchAll(), JSON_PRETTY_PRINT);
			$this->ctx->reply("*Resultado:*\n\n`{$result}`");
		} catch (\PDOException $pdoE) {
			$this->ctx->reply("*PDO:*\n\n`{$pdoE->getMessage()}`");
		} catch (\Exception $e) {
			$this->tx->reply("*Erro:*\n\n`{$e->getMessage()}`");
		}
	}

	public function getAdmin(): bool
	{
		return $this->admin;
	}

	public function getArg(): bool
	{
		return $this->arg;
	}
}