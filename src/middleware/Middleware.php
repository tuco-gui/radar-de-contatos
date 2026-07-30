<?php

namespace Fernandothedev\BaseBotTelegramPhp\Middleware;

use \Exception;
use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Controller\Logger;
use Fernandothedev\BaseBotTelegramPhp\Controller\Controller;
use Fernandothedev\BaseBotTelegramPhp\Model\Commands;
use Fernandothedev\BaseBotTelegramPhp\Model\Callbacks;

final class Middleware
{
    private Logger $logger;

    public function __construct() {
        $this->logger = new Logger();
    }

    private function userDetect(Context $ctx): string|bool
    {
        $controller = new Controller($ctx);
        $data_user = $controller->getDataUser();

        if (!$data_user) {
            if (!$controller->register()) {
                return "Não foi possível salvar sua conta!";
            }
        }

        if (isset($data_user['banned']) && $data_user['banned']) {
            return "Você está banido!";
        }

        return false;
    }

    private function makeYourWork(bool $type, Context $ctx, string $message): void
    {
        if ($type) {
            $ctx->sendMessage($message, [
                "reply_to_message_id" => $ctx->getMessage()->getMessageId()
            ]);
        } else {
            $ctx->answerCallbackQuery([
                "show_alert" => true,
                "text" => $message,
            ]);
        }
    }

    public function message(Commands $commands, Context $ctx): void
    {
        try {
            /* Antes*/
            $check = $this->userDetect($ctx);

            if ($check !== false) {
                $this->makeYourWork(1, $ctx, $check);
                return;
            }
            /* Agora */
            $commands->handler($ctx);
        } catch (Exception $e) {
            $this->logger->exceptionError($ctx, $e);
        }
    }

    public function callback(Callbacks $callbacks, Context $ctx): void
    {
        try {
            /* Antes*/
            $check = $this->userDetect($ctx);

            if ($check !== false) {
                $this->makeYourWork(0, $ctx, $check);
                return;
            }

            $user_id = @ $ctx
            ->getUpdate()
            ->getEffectiveUser()
            ->getId();

            $from_id = @ $ctx
            ->getCallbackQuery()
            ->getMessage()
            ->getReplyToMessage()
            ->getFrom()
            ->getId();

            if (is_null($from_id) or is_null($user_id)) {
                $this->makeYourWork(0, $ctx, "Erro interno");
                return;
            }

            if ($user_id !== $from_id) {
                $this->makeYourWork(0, $ctx, "❌ Sem permissão.");
                return;
            }
            /* Agora */
            $callbacks->handler($ctx);
        } catch (Exception $e) {
            $this->logger->exceptionError($ctx, $e);
        }
    }
}