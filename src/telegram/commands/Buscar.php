<?php

namespace Fernandothedev\\BaseBotTelegramPhp\\Telegram\\Commands;

use Zanzara\\Context;
use Fernandothedev\\BaseBotTelegramPhp\\Db\\Db;
use Fernandothedev\\BaseBotTelegramPhp\\Search\\SearchRepository;
use Fernandothedev\\BaseBotTelegramPhp\\Telegram\\CommandInterface;

final class Buscar implements CommandInterface
{
    private bool $admin = false;
    private bool $arg = true;

    public function __construct(private Context $ctx) {}

    public function handler(?string $arg = null): void
    {
        $criteria = $this->parseCriteria($arg ?? '');
        if (!$criteria) {
            $help = '*Busca local por nome*' . PHP_EOL . PHP_EOL
                . 'Use: /buscar nome="Ana Souza" cidade=Botucatu' . PHP_EOL
                . 'Opcional: estado=SP nascimento=1980-01-01 mae="Maria Souza" pai="Joao Souza"';
            $this->ctx->reply($help);
            return;
        }

        $db = Db::get($this->ctx);
        if ($db === null) {
            $this->ctx->reply('*Não foi possível acessar a base local.*');
            return;
        }

        $rows = (new SearchRepository($db))->search($criteria);
        if (!$rows) {
            $this->ctx->reply('*Nenhuma correspondência local encontrada.*');
            return;
        }

        $lines = ["*Possíveis correspondências locais:*", ''];
        foreach ($rows as $row) {
            $location = trim(($row['city'] ?? '') . ' - ' . ($row['state'] ?? ''), ' -');
            $lines[] = sprintf('• *%s* — %s — confiança indicativa: *%d%%*', $row['full_name'], $location ?: 'local não informado', $row['match_score']);
            $lines[] = '  Nascimento: ' . ($row['birth_date'] ?: 'não informado');
            $lines[] = '  Filiação: ' . ($row['mother_name'] ?: 'não informado') . ' / ' . ($row['father_name'] ?: 'não informado');
            $lines[] = '  Fonte: ' . ($row['source'] ?: 'não informada') . ' (' . ($row['source_reference'] ?: 'sem referência') . ')';
            $lines[] = '';
        }
        $lines[] = '_Resultado indicativo. Não confirma identidade e não substitui validação jurídica ou cadastral._';
        $this->ctx->reply(implode(PHP_EOL, $lines));
    }

    private function parseCriteria(string $input): array
    {
        preg_match_all('/(nome|cidade|estado|nascimento|mae|pai)=("[^"]+"|\\S+)/ui', $input, $matches, PREG_SET_ORDER);
        $criteria = [];
        foreach ($matches as $match) {
            $key = match (mb_strtolower($match[1])) {
                'nascimento' => 'birth_date',
                'mae' => 'mother_name',
                'pai' => 'father_name',
                default => mb_strtolower($match[1]),
            };
            $criteria[$key] = trim($match[2], '"');
        }
        return $criteria;
    }

    public function getAdmin(): bool { return $this->admin; }
    public function getArg(): bool { return $this->arg; }
}
