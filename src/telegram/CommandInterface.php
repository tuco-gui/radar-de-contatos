<?php

namespace Fernandothedev\BaseBotTelegramPhp\Telegram;

use Zanzara\Context;

interface CommandInterface
{
    public function handler(?string $arg): void;
    public function getAdmin(): bool;
    public function getArg(): bool;
}