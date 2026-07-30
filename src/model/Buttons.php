<?php

namespace Fernandothedev\BaseBotTelegramPhp\Model;

final class Buttons
{
    protected array $buttons = [];

    public function make(string|int $message, bool $type, string $value): void
    {
        $button = [
            "text" => $message,
            "callback_data" => $value
        ];

        if ($type) {
            unset($button["callback_data"]);
            $button["url"] = $value;
        }

        $this->buttons[] = $button;
    }

    public function menu(int $columns = 1): array
    {
        $buttonRows = array_chunk($this->buttons, $columns);
        return ["inline_keyboard" => $buttonRows];
    }
}
