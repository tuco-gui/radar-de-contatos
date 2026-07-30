<?php

namespace Fernandothedev\BaseBotTelegramPhp\Controller;

use \Exception;
use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Middleware\Middleware;
use Fernandothedev\BaseBotTelegramPhp\Model\Commands;
use Fernandothedev\BaseBotTelegramPhp\Model\Callbacks;

final class Bot
{
    private Commands $commands;
    private Callbacks $callbacks;
    private Logger $logger;
    private Middleware $middleware;

    public function __construct() {
        $this->commands = new Commands();
        $this->callbacks = new Callbacks();
        $this->logger = new Logger();
        $this->middleware = new Middleware();
    }

    public function handler(Context $ctx): void
    {
        try {
            $this->checkTypeAndRedirect($ctx);
        } catch (Exception $e) {
            $this->logger->exceptionError($e, $ctx);
        }
    }

    private function checkTypeAndRedirect(Context $ctx): void
    {
        if ($ctx->getCallbackQuery() !== null && method_exists($ctx->getCallbackQuery(), "getData")) {
            $this->middleware->callback($this->callbacks, $ctx);
            return;
        }

        if ($ctx->getMessage() !== null) {
            $this->middleware->message($this->commands, $ctx);
            return;
        }
    }
}