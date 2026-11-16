<?php
declare(strict_types=1);

/**
 * Camada de conexão com o banco de dados.
 *
 * Ajustem $host / $porta / $user / $senha se o MySQL de vocês no XAMPP
 * tiver configuração diferente da padrão (padrão do XAMPP:
 * usuário "root" e senha em branco, porta 3306).
 *
 * Também dá para trocar sem editar o arquivo, pelas variáveis de ambiente
 * DB_HOST, DB_PORT, DB_NAME, DB_USER e DB_PASS (útil quando outro MySQL,
 * como o do Homebrew, já ocupa a porta 3306).
 */
class Database
{

    private static ?PDO $conexao = null;

    public static function getConnection(): PDO
    {
        if (self::$conexao === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                getenv('DB_HOST') ?: '127.0.0.1',
                getenv('DB_PORT') ?: '3306',
                getenv('DB_NAME') ?: 'sistema_academico'
            );

            try {
                self::$conexao = new PDO(
                    $dsn,
                    getenv('DB_USER') ?: 'root',
                    getenv('DB_PASS') ?: '',
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES    => false,
                    ]
                );
            } catch (PDOException $e) {
                // Se a conexão falhar, a API já responde em JSON
                // em vez de estourar um erro feio do PHP na tela.
                http_response_code(500);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode([
                    'erro' => 'Falha ao conectar com o banco de dados. Verifique se o MySQL do XAMPP está rodando.',
                ]);
                exit;
            }
        }

        return self::$conexao;
    }
}
