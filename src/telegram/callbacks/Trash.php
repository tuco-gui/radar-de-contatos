<?php

namespace Fernandothedev\BaseBotTelegramPhp\Telegram\Callbacks;

use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Telegram\CallbackInterface;

final class Trash implements CallbackInterface
{
	private Context $ctx;
	private bool $admin = false;
	private bool $arg = false;

	public function __construct(Context $ctx) {
		$this->ctx = $ctx;
	}

	public function handler(?string $arg = null): void
	{
		$chat_id = $this->ctx->getEffectiveChat()->getId();

		$this->ctx->deleteMessage($chat_id, $this->ctx->getCallbackQuery()->getMessage()->getMessageId());
		$this->ctx->deleteMessage($chat_id, $this->ctx->getCallbackQuery()->getMessage()->getReplyToMessage()->getMessageId());
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