# Credenciais e integrações

O repositório público não contém tokens reais. As credenciais devem existir somente no arquivo local `.env`, que está protegido pelo `.gitignore`.

## Integrações identificadas no código

### Telegram

A variável `TOKEN_BOT` é o token do bot usado pelo pacote Zanzara.

Para criar ou obter um bot:

1. Abra o Telegram e converse com o **BotFather**.
2. Use `/newbot` ou consulte o token de um bot já criado.
3. Copie o token para `TOKEN_BOT` no arquivo local `.env`.

### Consulta de CPF

O arquivo `src/api/ApiCpf.php` chama atualmente o endpoint `https://api.legitimuz.com/external/kyc/cpf-history` e envia `CPF_API_TOKEN` como parâmetro da requisição.

A Legitimuz apresenta o produto como uma solução de verificação de identidade e informa que o acesso às integrações é feito pela documentação/conta do fornecedor. Consulte a documentação oficial em https://docs.legitimuz.com/ e confirme no painel ou com o suporte se o endpoint e o formato do token continuam válidos antes de usar em produção.

Não gere, publique ou compartilhe o token em issues, commits, screenshots ou mensagens. Se o token original for desconhecido, o caminho é:

1. entrar na conta da Legitimuz que autorizou o projeto;
2. verificar as credenciais da integração/API;
3. criar uma credencial nova ou solicitar acesso ao suporte;
4. colocar o valor apenas em `CPF_API_TOKEN` no `.env`;
5. testar com um CPF autorizado e finalidade documentada.

### Logs opcionais

`LOGS_CHAT_ID` identifica o chat do Telegram usado para mensagens técnicas de erro. Se não for necessário, deixe vazio e não use o valor padrão do código original.

## Configuração local

```bash
cp .env.example .env
chmod 600 .env
```

Exemplo de estrutura, sem valores reais:

```dotenv
TOKEN_BOT=token_do_bot_telegram
DATABASE=storage/database.sqlite
CPF_API_TOKEN=token_da_legitimuz
LOGS_CHAT_ID=
```

Verifique antes de executar:

```bash
git status --short
git diff -- .env
```

O arquivo `.env` nunca deve aparecer como arquivo a ser commitado. Se um segredo for publicado por acidente, considere-o comprometido e revogue-o no fornecedor.
