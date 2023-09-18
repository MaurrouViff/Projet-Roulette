<?php
include_once("bd.inc.php");

class EleveDatabase {
    private PDO $conn;

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

    public function selectRandomEleve() {
        try {
            $req = $this->conn->prepare("SELECT * FROM eleve ORDER BY RAND() LIMIT 1;");
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
}

