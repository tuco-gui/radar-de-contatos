# Auditoria inicial de segurança

## Escopo

Revisão estática da cópia disponibilizada no Google Drive, sem executar o bot nem realizar consultas externas.

## Achados

### Crítico: credencial embutida no código

O cliente de CPF original continha um token diretamente na URL da API. O token foi removido da versão publicada. Ele deve ser considerado comprometido e revogado pelo responsável pelo serviço.

A próxima implementação deve ler a credencial de variável de ambiente e nunca registrá-la em logs ou mensagens.

### Alto: TLS desativado

O cliente HTTP original usava `verify => false`. Isso permite conexões sem validação adequada do certificado. A versão publicada não deve manter essa configuração.

### Médio: dados pessoais no seed do banco

O SQL original continha IDs de usuários do Telegram. Eles foram removidos do schema publicado. Dados reais devem ser criados apenas no ambiente local e protegido.

### Baixo: resíduos do macOS

Arquivos `._*` foram encontrados no Drive. São metadados do macOS e não fazem parte do projeto.

## Limitações da auditoria

Não foi feita auditoria completa das dependências de terceiros nem análise dinâmica. O diretório `vendor/` não foi publicado; as dependências devem ser instaladas novamente pelo Composer e revisadas antes de um ambiente de produção.

## Regra de publicação

Nenhum segredo, base de pessoas, CPF, telefone, e-mail ou endereço residencial deve entrar neste repositório público.
