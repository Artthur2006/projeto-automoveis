CREATE DATABASE IF NOT EXISTS cadastro_automoveis;
USE cadastro_automoveis;

CREATE TABLE montadoras (
    codigo INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

INSERT INTO montadoras (nome) VALUES
    ('Volkswagen'),
    ('Ford'),
    ('Fiat'),
    ('Chevrolet');

CREATE TABLE automoveis (
    codigo INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    placa VARCHAR(10) NOT NULL,
    chassi VARCHAR(50) NOT NULL,
    montadora INT,
    UNIQUE (placa),
    UNIQUE (chassi),
    CONSTRAINT fk_montadora FOREIGN KEY (montadora) REFERENCES montadoras(codigo)
);

INSERT INTO automoveis (nome, placa, chassi, montadora) VALUES
('Gol', 'ABC-1234', '1234567890', 1),
('Fiesta', 'DEF-5678', '0987654321', 2);

SELECT * FROM montadoras;
SELECT * FROM automoveis;