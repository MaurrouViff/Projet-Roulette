DROP DATABASE IF EXISTS Roulette;
CREATE DATABASE Roulette;
USE Roulette;

CREATE TABLE eleves (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        nom VARCHAR(255) NOT NULL
);

INSERT INTO eleves (nom) VALUES
                             ('Élève 1'),
                             ('Élève 2'),
                             ('Élève 3'),
                             ('Élève 4'),
                             ('Élève 5'),
                             ('Élève 6'),
                             ('Élève 7'),
                             ('Élève 8'),
                             ('Élève 9'),
                             ('Élève 10');
