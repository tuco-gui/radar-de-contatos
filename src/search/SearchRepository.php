<?php

namespace Fernandothedev\BaseBotTelegramPhp\Search;

use PDO;

final class SearchRepository
{
    public function __construct(private PDO $db) {}

    public function search(array $criteria, int $limit = 10): array
    {
        $criteria = $this->normalizeCriteria($criteria);
        if (($criteria['name'] ?? '') === '' && ($criteria['city'] ?? '') === '') return [];

        $where = [];
        $params = [];
        foreach ([
            'name' => 'full_name',
            'city' => 'city',
            'state' => 'state',
            'birth_date' => 'birth_date',
            'profession' => 'profession',
            'mother_birth_date' => 'mother_birth_date',
            'father_birth_date' => 'father_birth_date',
        ] as $key => $column) {
            if (($criteria[$key] ?? '') !== '') {
                $where[] = "LOWER($column) LIKE LOWER(:$key)";
                $params[$key] = '%' . $criteria[$key] . '%';
            }
        }
        foreach (['mother_name' => 'mother_name', 'father_name' => 'father_name'] as $key => $column) {
            if (($criteria[$key] ?? '') !== '') {
                $where[] = "LOWER($column) LIKE LOWER(:$key)";
                $params[$key] = '%' . $criteria[$key] . '%';
            }
        }

        $sql = 'SELECT id, full_name, birth_date, mother_name, mother_birth_date,
                       father_name, father_birth_date, city, state, profession,
                       source, source_reference
                FROM person_records WHERE ' . implode(' AND ', $where) . ' ORDER BY full_name LIMIT :limit';
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
        $stmt->bindValue(':limit', max(1, min($limit, 25)), PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        foreach ($rows as &$row) {
            $row['match_score'] = $this->score($row, $criteria);
            $row['mother_name'] = $this->maskName($row['mother_name']);
            $row['father_name'] = $this->maskName($row['father_name']);
        }
        unset($row);
        usort($rows, fn (array $a, array $b): int => $b['match_score'] <=> $a['match_score']);
        return $rows;
    }

    private function normalizeCriteria(array $criteria): array
    {
        return array_map(static fn ($value): string => trim((string) $value), array_change_key_case($criteria, CASE_LOWER));
    }

    private function score(array $row, array $criteria): int
    {
        $score = 0;
        foreach ([
            'name' => 'full_name',
            'city' => 'city',
            'state' => 'state',
            'birth_date' => 'birth_date',
            'profession' => 'profession',
            'mother_name' => 'mother_name',
            'mother_birth_date' => 'mother_birth_date',
            'father_name' => 'father_name',
            'father_birth_date' => 'father_birth_date',
        ] as $key => $column) {
            if (($criteria[$key] ?? '') !== '' && mb_strtolower((string) $row[$column]) === mb_strtolower($criteria[$key])) {
                $score += $key === 'name' ? 35 : 8;
            }
        }
        return min($score, 100);
    }

    private function maskName(?string $name): string
    {
        if (!$name) return '';
        $parts = preg_split('/\s+/', trim($name));
        return count($parts) < 2 ? mb_substr($parts[0], 0, 1) . '***' : $parts[0] . ' ' . mb_substr($parts[count($parts) - 1], 0, 1) . '***';
    }
}
