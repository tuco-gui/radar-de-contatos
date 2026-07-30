<?php

namespace Fernandothedev\BaseBotTelegramPhp\Telegram\Callbacks;

use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Model\Buttons as Btn;
use Fernandothedev\BaseBotTelegramPhp\Telegram\CallbackInterface;

final class BaseCpf implements CallbackInterface
{
	private Context $ctx;
	private bool $admin = false;
	private bool $arg = false;

	public function __construct(Context $ctx) {
		$this->ctx = $ctx;
	}

	public function handler(?string $arg = null): void
	{
		$name = $this->ctx->getEffectiveUser()->getFirstName();
		$text = "🔎 *Base CPF - EDV* 🔎\n\n";
		$text .= "*• Comando:* `/cpf`\n";
		$text .= "*Exemplo:* `/cpf 12345678912`";

		$buttons = new Btn();
		$buttons->make("🔙 Voltar", 0, "bases");

		$this->ctx->editMessageText($text, [
			"reply_markup" => $buttons->menu()
		]);
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