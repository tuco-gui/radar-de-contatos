<?php

namespace Fernandothedev\BaseBotTelegramPhp\Telegram;

use Zanzara\Context;

interface CallbackInterface
{
    public function handler(?string $arg): void;
    public function getAdmin(): bool;
    public function getArg(): bool;
}