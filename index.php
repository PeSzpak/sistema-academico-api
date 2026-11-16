<?php
declare(strict_types=1);

/**
 * Ponto de entrada da API REST de alunos.
 *
 * Rotas (tudo via query string, sem depender de .htaccess/mod_rewrite):
 *   GET    index.php              -> lista todos os alunos
 *   GET    index.php?id=1         -> busca um aluno específico
 *   GET    index.php?curso=ADS    -> lista alunos de um curso (desafio extra)
 *   POST   index.php              -> cadastra um novo aluno (corpo em JSON)
 *   PUT    index.php?id=1         -> atualiza um aluno (corpo em JSON)
 *   DELETE index.php?id=1         -> exclui um aluno
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Response.php';
require_once __DIR__ . '/src/Aluno.php';

// Permite chamar a API a partir de outras origens/sistemas
// (ligado direto com o motivo do desafio: integrar sistemas diferentes).
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$pdo   = Database::getConnection();
$aluno = new Aluno($pdo);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $encontrado = $aluno->find((int) $_GET['id']);
            if ($encontrado === null) {
                errorResponse('Aluno não encontrado', 404);
            }
            jsonResponse($encontrado);
        }

        $curso = isset($_GET['curso']) ? (string) $_GET['curso'] : null;
        jsonResponse($aluno->all($curso));
        break;

    case 'POST':
        $dados = lerCorpoJson();
        $erro  = validarAluno($dados);
        if ($erro !== null) {
            errorResponse($erro, 400);
        }

        try {
            $novo = $aluno->create($dados);
            jsonResponse($novo, 201);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                errorResponse('Já existe um aluno cadastrado com esse e-mail', 409);
            }
            errorResponse('Erro ao cadastrar aluno', 500);
        }
        break;

    case 'PUT':
        if (!isset($_GET['id'])) {
            errorResponse('Informe o id do aluno na URL, ex: index.php?id=1', 400);
        }

        $id = (int) $_GET['id'];
        if ($aluno->find($id) === null) {
            errorResponse('Aluno não encontrado', 404);
        }

        $dados = lerCorpoJson();
        $erro  = validarAluno($dados);
        if ($erro !== null) {
            errorResponse($erro, 400);
        }

        try {
            $atualizado = $aluno->update($id, $dados);
            jsonResponse($atualizado);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                errorResponse('Já existe um aluno cadastrado com esse e-mail', 409);
            }
            errorResponse('Erro ao atualizar aluno', 500);
        }
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            errorResponse('Informe o id do aluno na URL, ex: index.php?id=1', 400);
        }

        $id = (int) $_GET['id'];
        if ($aluno->find($id) === null) {
            errorResponse('Aluno não encontrado', 404);
        }

        $aluno->delete($id);
        jsonResponse(['mensagem' => 'Aluno excluído com sucesso']);
        break;

    default:
        errorResponse('Método não suportado', 405);
}

/**
 * Lê e decodifica o corpo da requisição (POST/PUT) como JSON.
 * Responde 400 automaticamente se o JSON vier inválido.
 */
function lerCorpoJson(): array
{
    $corpo = file_get_contents('php://input');
    $dados = json_decode((string) $corpo, true);

    if (json_last_error() !== JSON_ERROR_NONE || !is_array($dados)) {
        errorResponse('JSON inválido no corpo da requisição', 400);
    }

    return $dados;
}

/**
 * Valida os campos obrigatórios de um aluno.
 * Retorna a mensagem de erro (para devolver como {"erro": "..."})
 * ou null se estiver tudo certo.
 */
function validarAluno(array $dados): ?string
{
    if (empty($dados['nome'])) {
        return 'O campo nome é obrigatório';
    }

    if (empty($dados['email'])) {
        return 'O campo email é obrigatório';
    }

    if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
        return 'O campo email é inválido';
    }

    if (empty($dados['curso'])) {
        return 'O campo curso é obrigatório';
    }

    return null;
}
