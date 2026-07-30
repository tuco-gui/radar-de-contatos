<?php

namespace Fernandothedev\BaseBotTelegramPhp\Model;

use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Controller\Logger;
use Fernandothedev\BaseBotTelegramPhp\Controller\Controller;

final class Commands
{
	private function userIsAdmin(Context $ctx): bool
	{
		$controller = new Controller($ctx);
		$data_user = $controller->getDataUser();
		return $data_user["admin"];
	}

	private function call(object $class, array $tokens): void
	{
		if ($class->getArg()) {
			$class->handler(implode(" ", $tokens));
			return;
		}

		$class->handler();
	}

	private function tryCall(Context $ctx, string $text): void
	{
		$tokens = explode(" ", substr($text, 1));
		$class_name = "Fernandothedev\BaseBotTelegramPhp\Telegram\Commands\\{$tokens[0]}";

		if (class_exists($class_name)) {
			array_shift($tokens);
			$class = new $class_name($ctx);

			if ($class->getAdmin()) {
				if (!$this->userIsAdmin($ctx)) {
					return;
				}
				$this->call($class, $tokens);
				return;
			}

			$this->call($class, $tokens);
		}
	}

	private function isCommand(string $text): bool
	{
		return $text[0] == '/';
	}

	public function handler(Context $ctx) {
		$text = $ctx->getMessage()->getText() ?? $ctx->getMessage()->getCaption();

		if ($this->isCommand($text)) {
			$this->tryCall($ctx, $text);
		}
	}
}