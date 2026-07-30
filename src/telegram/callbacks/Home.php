<?php

namespace Fernandothedev\BaseBotTelegramPhp\Telegram\Callbacks;

use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Model\Buttons as Btn;
use Fernandothedev\BaseBotTelegramPhp\Telegram\CallbackInterface;

final class Home implements CallbackInterface
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
		$text = "👾 *Escola de Devs - Search* 👾\n\n";
		$text .= "Bem vindo *{$name}*, sou um bot de consultas *Open Source* onde você pode realizar algumas puxadas de forma totalmente grátis.\n\n";
		$text .= "Caso goste do projeto e deseja doar alguma *API* para uso no bot contate o dev.\n\n";
		$text .= "Veja minhas bases disponíveis com o botão *Bases* abaixo.";

		$buttons = new Btn();
		$buttons->make("🦄 Bases", 0, "bases");
		$buttons->make("⚙️ Desenvolvimento", 0, "developement");

		$this->ctx->editMessageText($text, [
			"reply_markup" => $buttons->menu(1)
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