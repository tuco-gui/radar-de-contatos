<?php

namespace Fernandothedev\BaseBotTelegramPhp\Telegram\Commands;

use Zanzara\Context;
use Fernandothedev\BaseBotTelegramPhp\Model\Buttons as Btn;
use Fernandothedev\BaseBotTelegramPhp\Api\ApiCpf;
use Fernandothedev\BaseBotTelegramPhp\Model\Promise;
use Fernandothedev\BaseBotTelegramPhp\Telegram\CommandInterface;

final class Cpf implements CommandInterface
{
	private Context $ctx;
	protected string|array $message;
	private bool $admin = false;
	private bool $arg = true;

	private const RESULT_SUCCESS = '*EDV BUSCAS [ BOT ]*

📟 *DADOS BÁSICOS*

*NOME:* `%s`
*CPF:* `%s`
*GÊNERO:* `%s`
*DATA DE NASCIMENTO:* `%s`

*SIGNO:* `%s`
*NACIONALIDADE:* `%s`

*SITUAÇÃO:* `%s`
*UF:* `%s`

_Abraço pra Receita Federal que liberou os dados :)_

Abraço pro @EUTHEUZIN por liberar a api e o buraquinho...

*@escoladedevs*
*@fernandothedev*';

	public function __construct(Context $ctx) {
		$this->ctx = $ctx;
	}

	public function handler(?string $arg = null): void
	{
		$text = $this->search($arg);
		$buttons = new Btn();
		$buttons->make("🗑️ Apagar", 0, "trash");

		$this->ctx->reply($text, [
			"reply_markup" => $buttons->menu()
		]);
	}

	private function search(?string $cpf = null): string
	{
		$cpf = intval($cpf);
		if ($cpf == "" or $cpf == null) {
			return "*Cpf em branco!*\n\n*Result:* `CPF is invalid because it has not been passed.`";
		}

		if (!$this->validCpf($cpf)) {
			return "*Cpf Inválido!*\n\n*Result:* `{$this->getMessage()}`";
		}

		$api = new ApiCpf();
		$promise = $api->getData($cpf);

		$promise->then(function (array $data) {
			$this->setMessage($data);
		})->otherwise(function (\Exception $e) {
			$this->setMessage($e->getMessage());
		});

		if (!is_array($this->getMessage())) {
			return "*Error:* {$this->getMessage()}";
		}

		var_dump($this->getMessage());

		if (strpos($this->getMessage()["message"], "Successfully") !== false) {
			return $this->makeMessage();
		}

		return "*Cpf não encontrado!*\n\n*Result:* `" . $this->getMessage()["errors"][0] . "`";
	}

	private function makeMessage(): string
	{
		$opt = $this->getMessage()["dados"];
		return sprintf(
			self::RESULT_SUCCESS,
			$opt['nome'],
			$opt['cpf'],
			$opt['genero'],
			$opt['data_nascimento'],
			$opt['signo'],
			$opt['nacionalidade'],
			$opt['outros_campos']['situacao'],
			$opt['outros_campos']['uf_cpf']
		);
	}

	private function validCpf(string $cpf): bool
	{
		$cpf = preg_replace('/[^0-9]/', '', $cpf);

		if (strlen($cpf) != 11) {
			$this->setMessage("CPF size is invalid.");
			return false;
		}

		if (preg_match('/(\d)\1{10}/', $cpf)) {
			$this->setMessage("The CPF is not the correct type.");
			return false;
		}

		return true;
	}

	private function getMessage(): string|array
	{
		return $this->message;
	}

	private function setMessage(string|array $data): void
	{
		$this->message = $data;
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