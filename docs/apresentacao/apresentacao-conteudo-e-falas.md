# Sistema Acadêmico — Conteúdo da Apresentação

Dividido em duas partes, uma pra cada integrante. Primeiro vem o conteúdo pra colocar nos slides (tópicos e textos curtos), depois as falas completas de cada parte.

---

## PARTE 1 — CONTEÚDO DOS SLIDES

### Slide 1 — Capa
- Sistema Acadêmico
- API REST em PHP + MySQL para consulta e gestão de alunos
- Desafio de Frameworks and APIs — Faculdade Senac PR
- Equipe: [nomes]

### Slide 2 — Agenda (como a apresentação está dividida)
**Parte 1 (Integrante 1):**
- O problema que motivou o desafio
- O que foi pedido no enunciado
- Banco de dados
- Arquitetura da API
- Endpoints implementados

**Parte 2 (Integrante 2):**
- Tratamento de erros
- Desafio extra (filtro por curso)
- O que fizemos além do pedido
- Demonstração ao vivo
- Divisão da equipe e conclusão

### Slide 3 — O Problema
- Dados dos alunos espalhados em sistemas e planilhas diferentes
- Informações duplicadas e desatualizadas
- Dificuldade da secretaria pra consultar os alunos
- Processos manuais e demorados, sem integração entre sistemas

### Slide 4 — O Que Foi Pedido
- API REST em PHP conectada a um banco MySQL
- Comunicação usando JSON
- Consultar todos os alunos e um aluno específico por ID
- Cadastrar, alterar e excluir aluno
- Tratar pelo menos 2 tipos de erro
- Desafio extra: filtrar alunos por curso

### Slide 5 — Banco de Dados
Tabela `alunos` (banco `sistema_academico`, MySQL/InnoDB):

| Campo | Tipo | Regra |
|---|---|---|
| id | INT | chave primária, auto incremento |
| nome | VARCHAR(150) | obrigatório |
| email | VARCHAR(150) | obrigatório e único |
| curso | VARCHAR(100) | obrigatório |

Destaque: e-mail único evita cadastro duplicado (é a base do erro 409, mostrado mais adiante).

### Slide 6 — Arquitetura da API
- PHP puro (sem framework) + PDO para conectar no MySQL
- Código dividido em camadas, cada uma com uma responsabilidade só
- Facilita dividir o trabalho entre os integrantes da equipe

Fluxo: `index.php` (recebe a requisição e decide o que fazer) → `Aluno.php` (monta e executa as queries SQL) → `database.php` (abre a conexão com o MySQL)

### Slide 7 — Endpoints Implementados

| Método | Rota | Função |
|---|---|---|
| GET | index.php | Lista todos os alunos |
| GET | index.php?id=1 | Busca um aluno específico |
| GET | index.php?curso=ADS | Filtra alunos por curso (desafio extra) |
| POST | index.php | Cadastra um novo aluno (corpo em JSON) |
| PUT | index.php?id=1 | Atualiza um aluno (corpo em JSON) |
| DELETE | index.php?id=1 | Exclui um aluno |

---

## PARTE 2 — CONTEÚDO DOS SLIDES

### Slide 8 — Tratamento de Erros
*O enunciado pedia pelo menos 2 tratamentos de erro. Implementamos 5.*

| Código | Situação |
|---|---|
| 400 | Campo obrigatório faltando ou e-mail inválido |
| 404 | Aluno não encontrado |
| 409 | E-mail já cadastrado em outro aluno |
| 405 | Método HTTP não suportado |
| 500 | Falha de conexão com o banco de dados |

Respostas sempre em JSON, no formato `{ "erro": "..." }`

### Slide 9 — Desafio Extra: Filtro por Curso
`GET /index.php?curso=ADS`

- Nenhuma rota nova foi criada
- A mesma query de listagem ganha um `WHERE curso = :curso`, só quando o parâmetro vem preenchido
- Sem o parâmetro, continua listando todo mundo normalmente

### Slide 10 — O Que Fizemos a Mais
- **Painel visual de testes** — cadastra, edita, exclui e filtra aluno pelo navegador, sem precisar de Postman
- **Log de requisições ao vivo** — mostra cada chamada e resposta da API na tela, em verde (sucesso) ou vermelho (erro)
- **Botões de teste de erro** — disparam os erros 404, 400, 409 e 405 com um clique
- **Documentação completa** — README com as decisões de arquitetura e o passo a passo pra rodar no XAMPP

### Slide 11 — Demonstração ao Vivo (roteiro)
1. Abrir o painel de testes no navegador
2. Mostrar a listagem de alunos
3. Cadastrar um aluno novo
4. Editar e depois excluir um aluno
5. Rodar os testes de erro (404, 400, 409, 405)
6. Filtrar os alunos por curso

### Slide 12 — Divisão da Equipe

| Papel | Responsável | Arquivos principais |
|---|---|---|
| Desenvolvedor PHP | [nome] | index.php |
| Desenvolvedor de Banco de Dados | [nome] | schema.sql, database.php |
| Analista / Validador | [nome] | testes e checagem dos requisitos |
| Documentador | [nome] | README e apresentação |

*Uma mesma pessoa pode acumular mais de um papel.*

### Slide 13 — Conclusão
- Todos os requisitos do desafio foram atendidos
- GET, POST, PUT e DELETE funcionando com JSON
- 5 tratamentos de erro implementados (o mínimo pedido era 2)
- Desafio extra do filtro por curso concluído
- Fomos além: painel de testes visual e documentação completa

Obrigado! Perguntas?

---

## FALAS DA APRESENTAÇÃO

### Parte 1 (Integrante 1)

**Slide 1 — Capa**
"Bom dia/boa tarde a todos. Vamos apresentar o sistema acadêmico que desenvolvemos para o desafio da disciplina: uma API REST em PHP conectada a um banco MySQL, que permite a secretaria consultar, cadastrar, alterar e excluir alunos. A apresentação vai ser dividida entre nós dois, cada um cobrindo uma parte do que foi feito."

**Slide 2 — Agenda**
"A apresentação está dividida em duas partes. Na primeira parte eu vou falar sobre o contexto do desafio, o que foi pedido, o banco de dados, a arquitetura e os endpoints da API. Depois meu colega continua com o tratamento de erros, o desafio extra, o que fizemos a mais além do pedido, a demonstração ao vivo e a conclusão."

**Slide 3 — O Problema**
"A Faculdade Senac estava passando por um processo de modernização dos sistemas acadêmicos. Durante anos, as informações dos alunos ficaram espalhadas em sistemas e planilhas diferentes, o que causava dados duplicados, desatualizados e dificultava tanto a consulta pela secretaria quanto a integração com outros sistemas da faculdade. Foi esse cenário que motivou a criação de uma API REST centralizada."

**Slide 4 — O Que Foi Pedido**
"Esses foram os requisitos oficiais do desafio: construir uma API REST em PHP, conectada a um banco MySQL, usando JSON pra receber e devolver dados. A API precisava permitir consultar todos os alunos ou um aluno específico, cadastrar, alterar e excluir, além de tratar pelo menos dois tipos de erro. Como desafio extra, a faculdade pediu a possibilidade de filtrar os alunos por curso. Vamos mostrar em seguida como atendemos cada um desses pontos."

**Slide 5 — Banco de Dados**
"Criamos o banco sistema_academico com a tabela alunos seguindo exatamente a estrutura que a faculdade forneceu: id, nome, email e curso. Além do que foi pedido, adicionamos duas regras de banco: nome, email e curso são obrigatórios, e o e-mail é único, pra impedir que a secretaria cadastre o mesmo aluno duas vezes sem perceber. É essa regra de e-mail único que usamos mais pra frente pra gerar um dos erros tratados pela API."

**Slide 6 — Arquitetura da API**
"Optamos por PHP puro, sem framework, usando PDO pra falar com o MySQL. A ideia principal foi separar responsabilidades: o index.php só cuida de receber a requisição HTTP e decidir o que fazer; o Aluno.php concentra todas as queries SQL da tabela alunos; e o database.php só sabe abrir a conexão com o banco. Essa divisão em camadas ajudou bastante a trabalhar em equipe, porque cada um conseguia mexer em uma parte sem esbarrar no trabalho dos outros."

**Slide 7 — Endpoints Implementados**
"Todas as rotas passam por index.php, usando o método HTTP junto com a query string. Isso cobre exatamente o que foi pedido: GET pra listar todos ou buscar um aluno específico, POST pra cadastrar, PUT pra atualizar e DELETE pra excluir. O GET com o parâmetro curso é o desafio extra, que vamos detalhar na segunda parte da apresentação."

### Parte 2 (Integrante 2)

**Slide 8 — Tratamento de Erros**
"A API nunca devolve um erro genérico do PHP: toda falha vira uma resposta JSON clara, no formato erro e uma mensagem, junto com o status HTTP correto. Implementamos cinco situações: campo obrigatório faltando ou e-mail com formato inválido, que dá 400; aluno não encontrado, que dá 404; e-mail duplicado, aproveitando a regra única do banco, que dá 409; método HTTP não suportado, que dá 405; e falha de conexão com o banco, que dá 500. Isso deixa a API bem mais robusta do que só os dois erros mínimos pedidos."

**Slide 9 — Desafio Extra**
"A direção pediu a possibilidade de consultar só os alunos de um determinado curso, por exemplo GET alunos com curso igual ADS. Resolvemos isso sem criar nenhuma rota nova: o mesmo método que lista os alunos verifica se veio um parâmetro curso na URL, e se veio, a query SQL ganha uma cláusula WHERE filtrando por aquele curso. Se o parâmetro não vier, a listagem continua normal, com todos os alunos."

**Slide 10 — O Que Fizemos a Mais**
"Além dos requisitos, construímos alguns extras pra facilitar tanto o nosso teste quanto o entendimento de quem for avaliar o projeto. Criamos um painel visual que consome a própria API pra cadastrar, editar, excluir e filtrar alunos direto do navegador, com um log em tempo real mostrando cada requisição e resposta, incluindo os erros. Também deixamos botões prontos pra simular cada tipo de erro com um clique, e documentamos todas as decisões de arquitetura e o passo a passo de instalação no XAMPP."

**Slide 11 — Demonstração ao Vivo**
"Agora vamos mostrar a API funcionando de verdade. Vamos abrir o painel de testes, mostrar a listagem completa de alunos, cadastrar um aluno novo, editar e depois excluir esse mesmo aluno, disparar os quatro testes de erro prontos, e por fim filtrar a lista por um curso específico pra mostrar o desafio extra funcionando."
*(Aqui é a hora de fazer a demonstração ao vivo na tela, seguindo esses passos.)*

**Slide 12 — Divisão da Equipe**
"Dividimos o trabalho seguindo a sugestão de papéis do próprio enunciado: um desenvolvedor PHP focado no index.php, um desenvolvedor de banco de dados cuidando do schema e da conexão, um analista/validador conferindo se todos os requisitos foram atendidos, e um documentador responsável pelo README e por esta apresentação."
*(Ajustar aqui com os nomes de cada um.)*

**Slide 13 — Conclusão**
"Pra fechar: atendemos todos os requisitos do desafio, com a API completa em PHP e MySQL, usando JSON, com os quatro métodos HTTP funcionando e cinco tratamentos de erro diferentes, bem mais que o mínimo pedido. Também entregamos o desafio extra do filtro por curso, e fomos além construindo um painel de testes visual e uma documentação completa do projeto. Obrigado, ficamos à disposição para perguntas."
