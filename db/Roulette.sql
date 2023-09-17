DROP DATABASE IF EXISTS Roulette;
CREATE DATABASE Roulette;
USE Roulette;

CREATE TABLE eleve (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        classe VARCHAR(255) NOT NULL,
                        nomfamille VARCHAR(255) NOT NULL,
                        prenom VARCHAR(255) NOT NULL
);

INSERT INTO eleve (id, classe, nomfamille, prenom) VALUES
                             (1, 'SIO2', 'AUBRIET', 'Aurélien'),
                             (2, 'SIO2', 'BARIAL', 'Benjamin'),
                             (3, 'SIO2', 'GUILLAUME', 'Corentin'),
                             (4, 'SIO2', 'BON', 'Jean'),
                             (5, 'SIO2', 'NEYMAR', 'Jean'),
                             (6, 'SIO2', 'DE LANGE', 'Aymeric'),
                             (7, 'SIO2', 'Gadroy', 'Léo'),
                             (8, 'SIO2', 'TURQUIER', 'Victor'),
                             (9, 'SIO2', 'LHERME', 'Hugo'),
                             (10, 'SIO2', 'CORDIER', 'Eugène'),
                             (11, 'SIO2', 'NOËL', 'Père')

