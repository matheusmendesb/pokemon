CREATE DATABASE IF NOT EXISTS pokemon_bd
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE pokemon_bd;

CREATE TABLE IF NOT EXISTS comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pokemon VARCHAR(100) NOT NULL,
    nota DECIMAL(3,1) NOT NULL,
    comentario TEXT NOT NULL
);
