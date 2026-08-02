# Modelo inicial de busca por nome

A primeira implementação é deliberadamente local. Ela consulta apenas a tabela `person_records`, alimentada pelo operador em ambiente autorizado. Ainda não consulta cartórios, redes sociais, bases de terceiros ou fontes públicas em massa.

## Comando

Após configurar o banco, a busca pode ser feita no Telegram:

`/buscar nome="Ana Souza" cidade=Botucatu estado=SP nascimento=1980-01-01 mae="Maria Souza"`

Campos aceitos: `nome`, `cidade`, `estado`, `nascimento`, `mae` e `pai`. A consulta exige pelo menos nome ou cidade. A filiação é usada para filtrar e desambiguar, e aparece mascarada no resultado. A pontuação é indicativa; não afirma que dois registros pertencem à mesma pessoa.

## Fonte dos registros

Cada registro deve identificar fonte, referência da fonte, data de inclusão e finalidade autorizada no ambiente do operador.

Não coloque registros reais, CPFs, telefones, e-mails ou endereços residenciais no repositório. A entrada administrativa será implementada depois, com autenticação, finalidade documentada e auditoria.
