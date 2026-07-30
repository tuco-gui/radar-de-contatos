# Radar de Contatos

Base inicial para uma ferramenta de atualização cadastral, pesquisa de contatos e desambiguação de pessoas, reaproveitada de um bot PHP para Telegram.

> Status: protótipo em auditoria e evolução. Ainda não é um produto de produção nem uma base nacional de pessoas.

## O que existe hoje

- Bot Telegram em PHP usando Zanzara.
- Persistência local em SQLite.
- Controle básico de usuários, administradores e bloqueios.
- Consulta de CPF por uma API externa já presente na cópia original.
- Comando `/buscar` para pesquisar registros locais por nome, cidade, estado, nascimento e filiação.
- Pontuação indicativa de compatibilidade e mascaramento da filiação na resposta.
- Schema preparado para registrar fonte, referência e finalidade de cada registro.

## Configuração das credenciais

As credenciais originais não são publicadas no GitHub. Elas devem permanecer somente no `.env` local. Isso não impede o teste: basta copiar o modelo e preencher os valores da conta que autorizou o projeto.

Integrações identificadas no código:

- `TOKEN_BOT`: token do bot Telegram criado pelo BotFather.
- `CPF_API_TOKEN`: token do endpoint de CPF da Legitimuz usado em `src/api/ApiCpf.php`.
- `LOGS_CHAT_ID`: chat opcional para receber erros técnicos.

Veja o passo a passo em [CREDENTIALS.md](docs/CREDENTIALS.md). A documentação oficial pública da Legitimuz está em https://docs.legitimuz.com/; confirme com o fornecedor o acesso e o formato atual da integração antes de uso real.

## O que foi preservado

A estrutura original foi mantida para permitir um primeiro teste no macOS e facilitar a evolução gradual do motor de consulta para uma API/interface própria.

Não foi incluído o diretório `vendor/`, arquivos `.env`, arquivos `._*` do macOS nem credenciais reais. O arquivo local original, quando existir no Mac, deve permanecer fora do repositório público.

## Instalação no macOS

```bash
brew install php composer
composer install
cp .env.example .env
chmod 600 .env
php bin/configure.php
composer run bot
```

Edite o `.env` antes de executar. Use somente dados fictícios ou consultas para as quais exista autorização e finalidade documentada.

## Busca local por nome

Exemplo:

```
/buscar nome="Ana Souza" cidade=Botucatu estado=SP nascimento=1980-01-01 mae="Maria Souza"
```

A busca local consulta apenas registros alimentados no banco do ambiente autorizado. Ela não consulta cartórios, redes sociais, bases vazadas ou fontes externas em massa. Os resultados são possíveis correspondências, não uma confirmação automática de identidade.

Mais detalhes em [SEARCH-MODEL.md](docs/SEARCH-MODEL.md).

## Segurança e privacidade

- não publique tokens, CPFs, telefones, e-mails ou listas de pessoas;
- use apenas fontes com origem, autorização e finalidade documentadas;
- mantenha trilha de auditoria, controle de acesso e retenção mínima;
- não implemente scraping de perfis privados, bases vazadas, bypass de CAPTCHA ou consulta massiva sem finalidade legítima.

Consulte [SECURITY-AUDIT.md](docs/SECURITY-AUDIT.md).

## Estrutura

```
bin/                  scripts de configuração e inicialização
src/api/              clientes de APIs externas
src/controller/       orquestração do bot e logs
src/db/               conexão e schema SQLite
src/middleware/       autenticação e autorização básica
src/search/           busca local e pontuação de compatibilidade
src/model/            modelos auxiliares
src/telegram/         comandos e callbacks
docs/                 auditoria, credenciais, busca e roadmap
```

## Roadmap

O plano está em [ROADMAP.md](docs/ROADMAP.md).

## Origem da cópia

A versão inicial foi recuperada da pasta compartilhada no Google Drive:

https://drive.google.com/drive/folders/1anF2PcL7t8ct5tw5Kw4vhOa_ikZG4eoF

Cópia local informada pelo usuário:

`/Volumes/HD EXTERNO/MACBOOK/consultas`
