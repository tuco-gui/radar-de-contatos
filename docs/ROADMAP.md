# Roadmap

## Fase 0 — Base segura

- [x] Publicar a estrutura inicial do protótipo.
- [x] Remover credenciais do código publicado.
- [x] Remover dados pessoais do seed do banco.
- [x] Criar `.env.example`, `.gitignore` e documentação inicial.
- [x] Documentar as integrações identificadas e a configuração local de credenciais.
- [ ] Revogar e substituir o token antigo no provedor da API.

## Fase 1 — Executar o protótipo no macOS

- [ ] Confirmar versão do PHP e extensões necessárias.
- [ ] Instalar dependências com Composer.
- [ ] Configurar bot e banco em ambiente local.
- [ ] Testar somente com dados fictícios e CPFs de teste autorizados.
- [ ] Registrar erros sem expor respostas completas de APIs.

## Fase 2A — Fundação de busca local

- [x] Criar tabela `person_records` com fonte, referência e finalidade.
- [x] Implementar busca por nome, cidade, estado, nascimento e filiação.
- [x] Criar pontuação indicativa de compatibilidade.
- [x] Mascarar nomes de mãe e pai na resposta do Telegram.
- [x] Documentar o comando e as limitações da busca.
- [ ] Criar entrada administrativa autenticada para registros autorizados.
- [ ] Adicionar testes automatizados para homônimos, normalização e entradas inválidas.
- [ ] Criar auditoria de consultas e retenção.

## Fase 2B — Separar o motor de consultas

- [ ] Extrair consultas para serviços independentes do Telegram.
- [ ] Criar um contrato comum de resultado: tipo, valor mascarado, fonte, data, evidência e confiança.
- [ ] Criar validação de CPF e CNPJ sem afirmar identidade por coincidência.
- [ ] Adicionar adaptadores de provedores sem acoplar a aplicação a um único fornecedor.

## Fase 3 — Fontes legítimas

- [ ] Integrar dados abertos de CNPJ.
- [ ] Avaliar provedor oficial/licenciado para CPF.
- [ ] Avaliar validação técnica de telefone e e-mail.
- [ ] Mapear somente perfis e contatos profissionais publicamente publicados.
- [ ] Registrar contrato, finalidade, origem e data de cada fonte.
- [ ] Não integrar bases vazadas, scraping de áreas privadas ou fontes sem procedência.

## Fase 4 — Produto

- [ ] Criar API HTTP.
- [ ] Criar painel web autenticado.
- [ ] Multiempresa e permissões.
- [ ] Histórico de consultas e tentativas de contato.
- [ ] Exportação controlada e mascaramento de dados.
- [ ] Canal para correção, acesso e exclusão de dados.

## Fase 5 — Produção

- [ ] Revisão jurídica e de privacidade.
- [ ] DPIA/registro de tratamento quando aplicável.
- [ ] Criptografia, gestão de segredos e backups.
- [ ] Rate limiting, alertas e logs de auditoria.
- [ ] Teste de segurança independente.
- [ ] Política de retenção e resposta a incidentes.
