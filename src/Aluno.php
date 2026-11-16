<?php
declare(strict_types=1);

/**
 * Model do Aluno: concentra todas as queries que tocam a tabela `alunos`.
 * Quem estiver com o papel de "Desenvolvedor de Banco de Dados" mexe
 * principalmente aqui e no database/schema.sql.
 */
class Aluno
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Lista todos os alunos. Se $curso for informado, filtra por curso
     * (é o desafio extra: GET /alunos?curso=ADS).
     */
    public function all(?string $curso = null): array
    {
        if ($curso !== null && $curso !== '') {
            $stmt = $this->pdo->prepare(
                'SELECT id, nome, email, curso FROM alunos WHERE curso = :curso ORDER BY id'
            );
            $stmt->execute(['curso' => $curso]);
        } else {
            $stmt = $this->pdo->query(
                'SELECT id, nome, email, curso FROM alunos ORDER BY id'
            );
        }

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, nome, email, curso FROM alunos WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $aluno = $stmt->fetch();

        return $aluno !== false ? $aluno : null;
    }

    /**
     * @throws PDOException se o e-mail já existir (violação da UNIQUE KEY)
     */
    public function create(array $dados): array
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO alunos (nome, email, curso) VALUES (:nome, :email, :curso)'
        );
        $stmt->execute([
            'nome'  => $dados['nome'],
            'email' => $dados['email'],
            'curso' => $dados['curso'],
        ]);

        $id = (int) $this->pdo->lastInsertId();

        return $this->find($id);
    }

    /**
     * @throws PDOException se o e-mail já existir (violação da UNIQUE KEY)
     */
    public function update(int $id, array $dados): ?array
    {
        $stmt = $this->pdo->prepare(
            'UPDATE alunos SET nome = :nome, email = :email, curso = :curso WHERE id = :id'
        );
        $stmt->execute([
            'nome'  => $dados['nome'],
            'email' => $dados['email'],
            'curso' => $dados['curso'],
            'id'    => $id,
        ]);

        return $this->find($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM alunos WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
