<?php

use Symfony\Component\Dotenv\Dotenv;

require_once(__DIR__ . '/../vendor/autoload.php');

(new Dotenv())->load(__DIR__ . '/../.env');

$database = $_ENV['DATABASE'] ?? 'storage/database.sqlite';
$pdo = new PDO('sqlite:' . $database);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$ask = static function (string $label, bool $required = false, string $default = ''): string {
    do {
        $suffix = $required ? ' (obrigatório)' : ($default !== '' ? " [$default]" : '');
        $value = trim((string) readline($label . $suffix . ': '));
        if ($value === '' && $default !== '') return $default;
        if (!$required || $value !== '') return $value;
        fwrite(STDERR, "Esse campo é obrigatório." . PHP_EOL);
    } while (true);
};

echo "Cadastro local de um registro autorizado" . PHP_EOL;
echo "Os dados serão gravados somente no banco configurado em DATABASE." . PHP_EOL . PHP_EOL;

$record = [
    'full_name' => $ask('Nome completo', true),
    'birth_date' => $ask('Data de nascimento (AAAA-MM-DD)'),
    'mother_name' => $ask('Nome da mãe'),
    'mother_birth_date' => $ask('Data de nascimento da mãe (AAAA-MM-DD)'),
    'father_name' => $ask('Nome do pai'),
    'father_birth_date' => $ask('Data de nascimento do pai (AAAA-MM-DD)'),
    'city' => $ask('Cidade'),
    'state' => $ask('Estado'),
    'profession' => $ask('Profissão'),
    'source' => $ask('Fonte', false, 'informado pelo usuário autorizado'),
    'source_reference' => $ask('Referência da fonte'),
    'purpose' => $ask('Finalidade autorizada', false, 'teste local autorizado'),
];

$stmt = $pdo->prepare(
    'INSERT INTO person_records
     (full_name, birth_date, mother_name, mother_birth_date, father_name, father_birth_date,
      city, state, profession, source, source_reference, purpose)
     VALUES (:full_name, :birth_date, :mother_name, :mother_birth_date, :father_name, :father_birth_date,
      :city, :state, :profession, :source, :source_reference, :purpose)'
);
$stmt->execute($record);

echo PHP_EOL . 'Registro local criado. Ele não foi enviado ao GitHub.' . PHP_EOL;
