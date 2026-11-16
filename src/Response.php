<?php
declare(strict_types=1);

/**
 * Padroniza as respostas JSON da API, incluindo o status HTTP.
 */
function jsonResponse(array $dados, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

/**
 * Atalho para respostas de erro, sempre no formato {"erro": "..."}
 * combinado no enunciado do desafio.
 */
function errorResponse(string $mensagem, int $statusCode): void
{
    jsonResponse(['erro' => $mensagem], $statusCode);
}
