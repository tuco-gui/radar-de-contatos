<?php

namespace Fernandothedev\BaseBotTelegramPhp\Api;

use Fernandothedev\BaseBotTelegramPhp\Model\Promise;
use GuzzleHttp\Client;

final class ApiCpf
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.legitimuz.com/external/kyc/',
            'verify' => true,
        ]);
    }

    public function getData(int $cpf): Promise
    {
        $promise = new Promise();
        $token = trim((string) ($_ENV['CPF_API_TOKEN'] ?? ''));

        if ($token === '') {
            $promise->reject('CPF_API_TOKEN não configurado.');
            return $promise;
        }

        try {
            $response = $this->client->get('cpf-history', [
                'query' => [
                    'cpf' => $cpf,
                    'token' => $token,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Language' => 'pt-BR,pt;q=0.9,en;q=0.8',
                ],
            ]);

            $promise->resolve(json_decode((string) $response->getBody(), true));
        } catch (\Throwable $e) {
            $promise->reject($e->getMessage());
        }

        return $promise;
    }
}
