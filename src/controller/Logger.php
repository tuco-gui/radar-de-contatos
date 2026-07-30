<?php

namespace Fernandothedev\BaseBotTelegramPhp\Controller;

use \Exception;
use Zanzara\Context;

final class Logger
{
    private const MESSAGE_ERROR_USER = 'Tivemos um erro interno, o desenvolvedor foi constatado!';
    private const MESSAGE_ERROR_DEV = "<b>• Erro:</b> %s\n\n<b>• Path:</b> %s\n\n<b>• Line:</b> %s";

    private int $chatIdLogs;

    public function __construct() {
        $this->chatIdLogs = $_ENV["LOGS_CHAT_ID"] ?? 5678591197;
    }

    private function quitHtml(?string $message) {
        return @str_replace(
            ["<", ">", "≤", "≥"],
            ["&lt;", "&gt;", "&le;", "&ge;"],
            $message
        );
    }

    private function removeNoAlpha(?string $message = null): ?string
    {
        if (is_null($message)) {
            return null;
        }
        return preg_replace("/[^a-zA-Z0-9\s]/", " ", $message);
    }

    public function cleanMessage(string $message): string
    {
        return $this->removeNoAlpha($this->quitHtml($message));
    }

    private function prepareMessage($e): string
    {
        return sprintf(self::MESSAGE_ERROR_DEV, $this->cleanMessage($e->getMessage()), $e->getFile(), $e->getLine());
    }

    public function exceptionError(Context|null|int $ctx, $e) {
        if ($ctx === null) {
            return;
        }
        
        if (is_int($ctx)) {
        	file_put_contents('php://stderr', $this->prepareMessage($e));
        	return;
        }
        
        $ctx->reply(self::MESSAGE_ERROR_USER);

        $ctx->sendMessage($this->prepareMessage($e), [
            "chat_id" => $this->chatIdLogs,
            "parse_mode" => "html"
        ]);
    }
}