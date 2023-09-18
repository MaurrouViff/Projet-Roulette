<?php
include_once("bd.inc.php");

class EleveDatabase {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getEleve() {
        try {
            $req = $this->conn->prepare("SELECT * FROM eleve");
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function addEleve($prenom, $nom, $classe) {
        try {
            $req = $this->conn->prepare("INSERT INTO eleve (classe, nomfamille, prenom, note, passage) VALUES (:classe, :nom, :prenom, 0, 'non')");
            $req->bindParam(":prenom", $prenom, PDO::PARAM_STR);
            $req->bindParam(":nom", $nom, PDO::PARAM_STR);
            $req->bindParam(":classe", $classe, PDO::PARAM_STR);
            $req->execute();
            return true;
        } catch (PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        }
    }
    public function getClasses() {
        try {
            $req = $this->conn->prepare("SELECT DISTINCT classe FROM eleve");
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        }
    }
    public function getEleveByClasse($classe, $passage = 'non') {
        try {
            $req = $this->conn->prepare("SELECT * FROM eleve WHERE classe = :classe AND passage = :passage");
            $req->bindParam(":classe", $classe, PDO::PARAM_STR);
            $req->bindParam(":passage", $passage, PDO::PARAM_STR);
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }



    public function selectRandomEleve() {
        try {
            $req = $this->conn->prepare("SELECT * FROM eleve WHERE passage = 'non' ORDER BY RAND() LIMIT 1;");
            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    public function deleteStudentById($id) {
        try {
            $req = $this->conn->prepare("DELETE FROM eleve WHERE id = :id");
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
            $req = $this->conn->prepare("UPDATE eleve SET note = :note WHERE id = :id");
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
            $req = $this->conn->prepare("UPDATE eleve SET passage = :passage WHERE id = :id");
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
            $req = $this->conn->prepare("SELECT AVG(note) AS moyenne_notes FROM eleve");
            $req->execute();

            // Utilisez fetchColumn pour récupérer la moyenne sous forme de valeur unique
            return $req->fetchColumn();
        } catch (PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        }
    }

}

