<?php
include_once "Database.php";
class EleveDatabase extends Database {

    public function getEleve() {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("SELECT * FROM eleve");
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur !: " . $e->getMessage());
        }
    }

    public function getClasses() {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("SELECT DISTINCT classe FROM eleve");
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur !: " . $e->getMessage());
        }
    }

    public function addEleve($prenom, $nom, $classe) {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("INSERT INTO eleve (classe, nomfamille, prenom, note, passage) VALUES (:classe, :nom, :prenom, 0, 'non')");
            $req->bindParam(":prenom", $prenom, PDO::PARAM_STR);
            $req->bindParam(":nom", $nom, PDO::PARAM_STR);
            $req->bindParam(":classe", $classe, PDO::PARAM_STR);
            $req->execute();
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function getEleveByClasse($classe, $passage = 'non') {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("SELECT * FROM eleve WHERE classe = :classe AND passage = :passage");
            $req->bindParam(":classe", $classe, PDO::PARAM_STR);
            $req->bindParam(":passage", $passage, PDO::PARAM_STR);
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function selectRandomEleveByClasse($classe) {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("SELECT * FROM eleve WHERE classe = :classe AND passage = 'non' ORDER BY RAND() LIMIT 1");
            $req->bindParam(":classe", $classe, PDO::PARAM_STR);
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function checkIfStudentExists($id) {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("SELECT COUNT(*) AS count FROM eleve WHERE id = :id");
            $req->bindParam(":id", $id, PDO::PARAM_INT);
            $req->execute();

            $result = $req->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            return false; // Gérer l'erreur de base de données ici
        }
    }

    public function selectRandomEleve() {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("SELECT * FROM eleve WHERE passage = 'non' ORDER BY RAND() LIMIT 1;");
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function deleteStudentById($id) {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("DELETE FROM eleve WHERE id = :id");
            $req->bindParam(":id", $id, PDO::PARAM_INT);
            $req->execute();

            if ($req->rowCount() > 0) {
                return "Suppression réussie";
            } else {
                return "Élève introuvable dans la base de données ou erreur de suppression.";
            }
        } catch (PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        }
    }

    public function setNoteById($id, $note) {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("UPDATE eleve SET note = :note WHERE id = :id");
            $req->bindParam(":note", $note, PDO::PARAM_INT);
            $req->bindParam(":id", $id, PDO::PARAM_INT);
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        }
    }

    public function setPassageById($id, $passage) {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("UPDATE eleve SET passage = :passage WHERE id = :id");
            $req->bindParam(":passage", $passage, PDO::PARAM_STR);
            $req->bindParam(":id", $id, PDO::PARAM_INT);
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        }
    }

    public function getMoyenneNote() {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("SELECT AVG(note) AS moyenne_notes FROM eleve");
            $req->execute();

            return $req->fetchColumn();
        } catch (PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        }
    }

    public function removeValue() {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("DELETE FROM eleve;");
            $req->execute();

        } catch (PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        }
    }

    public function addValue() {
        try {
            $cnx = $this->getConnection();
            $req = $cnx->prepare("INSERT INTO eleve (id, classe, nomfamille, prenom, note, passage) VALUES
                                                (1, 'SIO2', 'AUBRIET', 'Aurélien', 0, 'non'),
                                                (2, 'SIO1', 'BARIAL', 'Benjamin', 0, 'non'),
                                                 (3, 'SIO1', 'GUILLAUME', 'Corentin', 0, 'non'),
                                                 (4, 'SIO2', 'BON', 'Jean', 0, 'non'),
                                                 (5, 'SIO2', 'NEYMAR', 'Jean', 0, 'non'),
                                                 (6, 'SIO2', 'DE LANGE', 'Aymeric', 0, 'non'),
                                                 (7, 'SIO2', 'Gadroy', 'Léo', 0, 'non'),
                                                 (8, 'SIO2', 'TURQUIER', 'Victor', 0, 'non'),
                                                 (9, 'SIO2', 'LHERME', 'Hugo', 0, 'non'),
                                                 (10, 'SIO2', 'CORDIER', 'Eugène', 0, 'non'),
                                                 (11, 'SIO2', 'NOËL', 'Père', 0, 'non'),
                                                 (12, 'SIO3', 'MORTEL', 'Lee', 0, 'non'),
                                                 (13, 'SIO3', 'LAMOUREUX', 'Antonin', 0, 'non')

");
            $req->execute();
            return True;
        } catch (PDOException $e) {
            return "Erreur PDO : " .$e->getMessage();
        }
    }
}

