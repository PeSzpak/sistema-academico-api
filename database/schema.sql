-- ============================================================
-- Sistema Acadêmico - Banco de Dados
-- Faculdade Senac - Desafio API REST (Equipe de 3 integrantes)
-- PEDRO SZPAK | ADEMIR JUNIOR | CHRISTIAN FERREIRA
-- ============================================================


SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS sistema_academico
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE sistema_academico;

CREATE TABLE IF NOT EXISTS alunos (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(150)  NOT NULL,
    email      VARCHAR(150)  NOT NULL,
    curso      VARCHAR(100)  NOT NULL,
    criado_em  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_alunos_email (email)
) ENGINE=InnoDB;

-- Dados de exemplo, só pra facilitar os testes da equipe.
-- Pode apagar ou comentar essas linhas se preferirem começar vazio.
INSERT INTO alunos (nome, email, curso) VALUES
    ('João Oliveira', 'joao@email.com', 'Engenharia de Software'),
    ('Maria Souza', 'maria.souza@email.com', 'ADS'),
    ('Pedro Lima', 'pedro.lima@email.com', 'ADS');
