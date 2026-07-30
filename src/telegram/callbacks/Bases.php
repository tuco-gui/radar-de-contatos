<?php

namespace Fernandothedev\BaseBotTelegramPhp\Telegram\Callbacks;

use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Model\Buttons as Btn;
use Fernandothedev\BaseBotTelegramPhp\Telegram\CallbackInterface;

final class Bases implements CallbackInterface
{
	private Context $ctx;
	private bool $admin = false;
	private bool $arg = false;

	public function __construct(Context $ctx) {
		$this->ctx = $ctx;
	}

	public function handler(?string $arg = null): void
	{
		$text = "🦄 *Veja minhas bases:*";

		$buttons = new Btn();
		$buttons->make("CPF", 0, "baseCpf");
		
		if (!count($buttons->menu(2)) % 2 == 0) {
            $buttons->make("", 0, ".");
        }
        
		$buttons->make("🔙 Voltar", 0, "home");

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