<?php

namespace Fernandothedev\BaseBotTelegramPhp\Telegram\Callbacks;

use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Model\Buttons as Btn;
use Fernandothedev\BaseBotTelegramPhp\Telegram\CallbackInterface;

final class Developement implements CallbackInterface
{
	private Context $ctx;
	private bool $admin = false;
	private bool $arg = false;

	public function __construct(Context $ctx) {
		$this->ctx = $ctx;
	}

	public function handler(?string $arg = null): void
	{
		$text = "⚙️ *Desenvolvimento do bot.*\n\n";
		$text .= "👾 *Informações:*\n";
		$text .= "*├* Linguagem: *PHP (8.2.4)*\n";
		$text .= "*└* Versão atual: *2.0.0*\n\n";
		$text .= "*➥ O que a difere dos outros:*\n";
		$text .= "*    ➠ Tecnologia avançada.*\n";
		$text .= "*    ➠ Utilização de segurança robusta.*\n";
		$text .= "*    ➠ Todos os sistemas feito do zero.*\n";
		$text .= "*    ➠ Desenvolvido por quem sabe.*\n\n";
		$text .= "_Todas as atualizações e novidades são postas no canal de desenvolvimento desta source._";

		$buttons = new Btn();
		$buttons->make("💸 Adquira um bot", 1, "t.me/fernandothedev");
		$buttons->make("👾 Desenvolvedor", 1, "t.me/fernandothedev");
		$buttons->make("🔙 Voltar", 0, "home");

		$this->ctx->editMessageText($text, [
			"reply_markup" => $buttons->menu(2)
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