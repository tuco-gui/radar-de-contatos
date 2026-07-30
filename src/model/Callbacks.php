<?php

namespace Fernandothedev\BaseBotTelegramPhp\Model;

use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Controller\Logger;
use Fernandothedev\BaseBotTelegramPhp\Controller\Controller;

final class Callbacks
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

	private function tryCall(Context $ctx, string $data): void
	{
		$tokens = explode(" ", $data);
		$class_name = "Fernandothedev\BaseBotTelegramPhp\Telegram\Callbacks\\{$tokens[0]}";

		if (!class_exists($class_name)) {
			$ctx->answerCallbackQuery([
				"show_alert" => true,
				"text" => "🚧 Em desenvolvimento.",
			]);
			return;
		}

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

	public function handler(Context $ctx) {
		$data = $ctx->getCallbackQuery()->getData();
		$this->tryCall($ctx, $data);
	}
}