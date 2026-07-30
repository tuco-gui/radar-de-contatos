<?php

namespace Fernandothedev\BaseBotTelegramPhp\Controller;

use \PDO;
use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Db\Db;

final class Controller
{
    private PDO $conn;
    private int $user;

    public function __construct(Context $ctx) {
        $this->conn = Db::get($ctx);
        $this->user = $ctx->getEffectiveUser()->getId();
    }

    public function getDataUser(): array|bool
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user = :user");
        $stmt->bindParam(":user", $this->user);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function register(): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO users (user) VALUES (:user)");
        $stmt->bindParam(":user", $this->user);
        return $stmt->execute();
    }
}