<?php

namespace Fernandothedev\BaseBotTelegramPhp\Model;

/**
* Sistema de Promises
*/
final class Promise
{
    /**
    * Criando atributos.
    */
    protected mixed $resolve = false;
    protected Exception|string $reject = '';

    /**
    * Structure
    * Index: {
    *    status: bool
    *    callable: value
    }
    */
    protected array $resolves = [];
    protected array $rejects = [];

    private function getResolve(): mixed
    {
        return $this->resolve;
    }

    private function getReject(): Exception|string
    {
        return $this->reject;
    }

    public function then(callable $callable): Promise
    {
        if (!$this->getReject()) {
            $this->resolves[] = [
                "status" => true,
                "callable" => $callable
            ];
            $this->resolveCallables($this->resolves);
        }
        return $this;
    }

    public function otherwise(callable $callable): Promise
    {
        if (!$this->getResolve()) {
            $this->rejects[] = [
                "status" => true,
                "callable" => $callable
            ];
            $this->rejectCallables($this->rejects);
        }
        return $this;
    }

    public function resolve(mixed $value): void
    {
        $this->resolve = $value;
    }

    public function reject(mixed $value): void
    {
        $this->reject = new Exception($value);
    }

    private function resolveCallables(array $callables): void
    {
        foreach ($callables as $callable => $value) {
            if ($value["status"]) {
                $value["callable"]($this->resolve);
                $this->resolves[$callable]["status"] = false;
            }
        }
    }

    private function rejectCallables(array $callables): void
    {
        foreach ($callables as $callable => $value) {
            if ($value["status"]) {
                $value["callable"]($this->reject);
                $this->rejects[$callable]["status"] = false;
            }
        }
    }
}