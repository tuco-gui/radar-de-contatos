# Radar de Contatos

Base inicial para uma ferramenta de atualização cadastral, pesquisa de contatos e desambiguação de pessoas, reaproveitada de um bot PHP para Telegram.

> Status: protótipo em auditoria. Ainda não é um produto de produção nem uma base nacional de pessoas.

## O que existe hoje

- Bot Telegram em PHP usando Zanzara.
- Persistência local em SQLite.
- Controle básico de usuários, administradores e bloqueios.
- Comando inicial de consulta de CPF por uma API externa já existente no projeto original.
- Estrutura separada em controller, API, banco, modelos, middleware e comandos Telegram.

## O que foi preservado

A estrutura original foi mantida para permitir um primeiro teste no macOS e facilitar a evolução gradual do motor de consulta para uma API/interface própria.

Não foi incluído o diretório `vendor/`, arquivos `.env`, arquivos `._*` do macOS nem credenciais reais.

## Segurança e privacidade

Antes de qualquer uso real:

- configure as credenciais somente em um arquivo `.env` local;
- não publique tokens, CPFs, telefones, e-mails ou listas de pessoas;
- use apenas fontes com origem, autorização e finalidade documentadas;
- mantenha trilha de auditoria, controle de acesso e retenção mínima;
- trate resultados por nome como possíveis correspondências, nunca como identificação definitiva;
- não implemente scraping de perfis privados, bases vazadas, bypass de CAPTCHA ou consulta massiva sem finalidade legítima.

Consulte [SECURITY-AUDIT.md](docs/SECURITY-AUDIT.md) para os achados da cópia recebida.

## Requisitos

- PHP compatível com as dependências do projeto.
- Composer.
- Extensão PDO SQLite.
- Um bot do Telegram, se o modo Telegram for utilizado.
- Credenciais da API externa configuradas localmente.

## Instalação no macOS

```bash
brew install php composer
composer install
cp .env.example .env
php bin/configure.php
composer run bot
```

Edite o `.env` antes de executar.

## Estrutura

```
bin/                  scripts de configuração e inicialização
src/api/              clientes de APIs externas
src/controller/       orquestração do bot e logs
src/db/               conexão e schema SQLite
src/middleware/       autenticação e autorização básica
src/model/            modelos auxiliares
src/telegram/         comandos e callbacks
docs/                 auditoria e roadmap
```

## Roadmap

O plano está em [ROADMAP.md](docs/ROADMAP.md). A próxima etapa técnica recomendada é separar o motor de consultas do Telegram e criar um contrato de resultados com fonte, data, evidência e nível de confiança.

## Origem da cópia

A versão inicial foi recuperada da pasta compartilhada no Google Drive:

https://drive.google.com/drive/folders/1anF2PcL7t8ct5tw5Kw4vhOa_ikZG4eoF

Cópia local informada pelo usuário:

`/Volumes/HD EXTERNO/MACBOOK/consultas`
