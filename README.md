# Radar de Contatos

Base inicial para uma ferramenta de atualização cadastral, pesquisa de contatos e desambiguação de pessoas, reaproveitada de um bot PHP para Telegram.

> Status: protótipo em auditoria e evolução. Ainda não é um produto de produção nem uma base nacional de pessoas.

## O que existe hoje

- Bot Telegram em PHP usando Zanzara.
- Persistência local em SQLite.
- Consulta de CPF por uma integração externa já presente na cópia original.
- Comando \`/buscar\` para pesquisar registros locais por nome, cidade, estado, nascimento, filiação e profissão.
- Pontuação indicativa de compatibilidade e mascaramento da filiação na resposta.
- Cadastro local de data de nascimento dos pais e profissão para testes de desambiguação.

A busca por nome desta fase não consulta automaticamente pessoas na internet. Ela pesquisa somente registros inseridos no banco local do ambiente autorizado. Isso permite validar o motor de desambiguação antes de conectar fontes externas.

## Repositório público e configuração local

Este README é público e não contém credenciais, tokens, CPFs, telefones, e-mails ou registros reais.

As credenciais devem permanecer somente no arquivo local \`.env\`. Anotações específicas da instalação podem ficar em \`README.local.md\`, que é ignorado pelo Git e não deve ser publicado. O modelo está em [LOCAL-README.template.md](docs/LOCAL-README.template.md).

Integrações identificadas no código:

- \`TOKEN_BOT\`: token do bot Telegram criado pelo BotFather.
- \`CPF_API_TOKEN\`: token da integração de CPF usada em \`src/api/ApiCpf.php\`.
- \`LOGS_CHAT_ID\`: chat opcional para mensagens técnicas.

Veja [CREDENTIALS.md](docs/CREDENTIALS.md) para a configuração detalhada.

## Instalação no macOS

Requisitos: macOS, Homebrew, PHP 8.2 ou superior, Composer e a extensão PDO SQLite.

O Composer 2.10 pode tentar inicializar um plugin legado dessa base. Por isso, neste protótipo, instale as dependências sem plugins:

\`\`\`bash
brew install php composer
git clone https://github.com/tuco-gui/radar-de-contatos.git
cd radar-de-contatos
composer install --no-plugins
cp .env.example .env
chmod 600 .env
php bin/configure.php
composer run bot
\`\`\`

Edite o \`.env\` antes de executar. Para usar uma cópia local já existente, entre na pasta do projeto e execute a partir de \`composer install --no-plugins\`.

## Instalação no Windows

Requisitos: Windows 10/11, PHP 8.2 ou superior com PDO SQLite habilitado, Composer e Git.

No PowerShell:

\`\`\`powershell
git clone https://github.com/tuco-gui/radar-de-contatos.git
Set-Location radar-de-contatos
composer install --no-plugins
Copy-Item .env.example .env
php bin/configure.php
composer run bot
\`\`\`

Se \`php\` ou \`composer\` não forem reconhecidos, instale PHP e Composer seguindo a documentação oficial dos respectivos projetos e confirme que as pastas foram adicionadas ao PATH. No \`.env\`, use barras normais ou o caminho absoluto do SQLite, por exemplo \`DATABASE=storage/database.sqlite\`.

## Primeiro teste da busca por nome

A busca exige um registro no banco local. Para o teste, execute:

\`\`\`bash
php bin/add-person.php
\`\`\`

O script perguntará pelo nome, data de nascimento, nome e data de nascimento da mãe, nome e data de nascimento do pai, cidade, estado, profissão, fonte e finalidade. Os dados ficam somente no SQLite local e nunca são enviados ao GitHub.

Depois, execute o bot:

\`\`\`bash
composer run bot
\`\`\`

No Telegram, use:

\`\`\`text
/buscar nome="Nome da Pessoa" nascimento=1980-01-01 nascimento_mae=1955-02-03 cidade="São Paulo" profissao="profissão"
/buscar nome="Nome da Pessoa" mae="Nome da Mãe" nascimento_mae=1955-02-03 cidade="São Paulo"
\`\`\`

Campos aceitos: \`nome\`, \`nascimento\`, \`mae\`, \`nascimento_mae\`, \`pai\`, \`nascimento_pai\`, \`cidade\`, \`estado\` e \`profissao\`.

O resultado mostra possíveis correspondências, fonte e uma pontuação indicativa. Não confirma identidade automaticamente.

## Segurança e privacidade

- não publique tokens ou dados pessoais;
- use somente fontes com origem, autorização e finalidade documentadas;
- não use bases vazadas, scraping de perfis privados ou bypass de CAPTCHA;
- trate resultados como possíveis correspondências, nunca como identificação definitiva;
- mantenha controle de acesso, retenção mínima e registro das consultas.

Consulte [SECURITY-AUDIT.md](docs/SECURITY-AUDIT.md).

## Estrutura

\`\`\`
bin/                  scripts de configuração, inicialização e entrada local
src/api/              clientes de APIs externas
src/controller/       orquestração do bot e logs
src/db/               conexão e schema SQLite
src/middleware/       autenticação e autorização básica
src/search/           busca local e pontuação
src/model/            modelos auxiliares
src/telegram/         comandos e callbacks
docs/                 auditoria, credenciais, busca e roadmap
\`\`\`

## Roadmap

O plano está em [ROADMAP.md](docs/ROADMAP.md).

## Origem da cópia

A versão inicial foi recuperada de uma pasta compartilhada no Google Drive. O caminho local original informado para o Mac foi \`/Volumes/HD EXTERNO/MACBOOK/consultas\`. Esses caminhos não são necessários para quem clonar o repositório.
