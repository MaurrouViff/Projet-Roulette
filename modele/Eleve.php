<?php
include_once "bd.inc.php";
class Eleve extends Database {
    public function getEleve() {
        $resultat = array();
        try {
          $req = $this->connexion->prepare("SELECT * FROM eleves");
          $req->execute();
          $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

}