DROP DATABASE IF EXISTS Roulette;
CREATE DATABASE Roulette;
USE Roulette;

CREATE TABLE eleve (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        classe VARCHAR(255) NOT NULL,
                        nomfamille VARCHAR(255) NOT NULL,
                        prenom VARCHAR(255) NOT NULL,
                        note INT NOT NULL,
                        passage VARCHAR(255) NOT NULL,
                        temps VARCHAR(255) NOT NULL
);

INSERT INTO eleve (id, classe, nomfamille, prenom, note, passage, temps) VALUES
                             (1, 'SIO2', 'AUBRIET', 'Aurélien', 0, 'non', '0s'),
                             (2, 'SIO1', 'BARIAL', 'Benjamin', 0, 'non', '0s'),
                             (3, 'SIO1', 'GUILLAUME', 'Corentin', 0, 'non', '0s'),
                             (4, 'SIO2', 'BON', 'Jean', 0, 'non', '0s'),
                             (5, 'SIO2', 'NEYMAR', 'Jean', 0, 'non', '0s'),
                             (6, 'SIO2', 'DE LANGE', 'Aymeric', 0, 'non', '0s'),
                             (7, 'SIO2', 'Gadroy', 'Léo', 0, 'non', '0s'),
                             (8, 'SIO2', 'TURQUIER', 'Victor', 0, 'non', '0s'),
                             (9, 'SIO2', 'LHERME', 'Hugo', 0, 'non', '0s'),
                             (10, 'SIO2', 'CORDIER', 'Eugène', 0, 'non', '0s'),
                             (11, 'SIO2', 'NOËL', 'Père', 0, 'non', '0s'),
                             (12, 'SIO3', 'MORTEL', 'Lee', 0, 'non', '0s'),
                             (13, 'SIO3', 'LAMOUREUX', 'Antonin', 0, 'non', '0s')

