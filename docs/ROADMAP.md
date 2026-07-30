# Roadmap

## Fase 0 — Base segura

- [x] Publicar a estrutura inicial do protótipo.
- [x] Remover credenciais do código publicado.
- [x] Remover dados pessoais do seed do banco.
- [x] Criar \`.env.example\`, \`.gitignore\` e documentação inicial.
- [x] Documentar as integrações identificadas e a configuração local de credenciais.
- [ ] Revogar e substituir o token antigo no provedor da API.

## Fase 1 — Primeiro teste local

- [ ] Confirmar PHP, Composer e PDO SQLite no macOS.
- [x] Adotar instalação com \`composer install --no-plugins\` para compatibilidade com Composer 2.10.
- [x] Documentar instalação no Windows.
- [ ] Configurar bot e banco em ambiente local.
- [x] Criar script local para inserir um registro autorizado, sem publicá-lo.
- [ ] Executar uma busca real por nome, data de nascimento, filiação, cidade e profissão.
- [x] Corrigir erro de sintaxe encontrado no script de cadastro e no comando de busca.
- [x] Tornar os dados auxiliares opcionais no cadastro; somente o nome é obrigatório.
- [ ] Registrar resultados sem expor dados.
- [ ] Criar testes automatizados para homônimos, normalização e entradas inválidas.

## Fase 2 — Fundação de busca local

- [x] Criar tabela \`person_records\` com fonte, referência e finalidade.
- [x] Implementar busca por nome, cidade, estado, nascimento e filiação.
- [x] Adicionar profissão e datas de nascimento dos pais como critérios opcionais.
- [x] Criar pontuação indicativa de compatibilidade.
- [x] Mascarar nomes de mãe e pai na resposta do Telegram.
- [x] Documentar o comando e as limitações da busca.
- [ ] Criar entrada administrativa autenticada para registros autorizados.
- [ ] Criar auditoria de consultas e retenção.

## Fase 3 — Desvincular o motor do Telegram

- [ ] Extrair a busca para um serviço independente do Telegram.
- [ ] Criar contrato comum de resultado: tipo, valor mascarado, fonte, data, evidência e confiança.
- [ ] Criar uma API HTTP local.
- [ ] Criar uma interface web HTML simples para o primeiro teste.
- [ ] Permitir importar um registro autorizado pela interface, sem colocar dados no repositório.
- [ ] Manter o Telegram como canal opcional durante a transição.

## Fase 4 — Fontes legítimas

- [ ] Integrar dados abertos de CNPJ.
- [ ] Avaliar provedor oficial/licenciado para CPF.
- [ ] Avaliar validação técnica de telefone e e-mail.
- [ ] Mapear somente perfis e contatos profissionais publicamente publicados.
- [ ] Registrar contrato, finalidade, origem e data de cada fonte.
- [ ] Não integrar bases vazadas, scraping de áreas privadas ou fontes sem procedência.

## Fase 5 — Produto

- [ ] Painel web autenticado.
- [ ] Multiempresa e permissões.
- [ ] Histórico de consultas e tentativas de contato.
- [ ] Exportação controlada e mascaramento de dados.
- [ ] Canal para correção, acesso e exclusão de dados.
- [ ] Empacotamento opcional para macOS e Windows.

## Fase 6 — Produção

- [ ] Revisão jurídica e de privacidade.
- [ ] DPIA/registro de tratamento quando aplicável.
- [ ] Criptografia, gestão de segredos e backups.
- [ ] Rate limiting, alertas e logs de auditoria.
- [ ] Teste de segurança independente.
- [ ] Política de retenção e resposta a incidentes.
