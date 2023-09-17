<?php
include_once("bd.inc.php");

function getEleve() {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM eleve");
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur : " . $e->getMessage();
        die();
    }
    return $resultat;
}
function selectRandomEleve() {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM eleve ORDER BY RAND() LIMIT 1;");
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur : " . $e->getMessage();
        die();
    }
    return $resultat;
}
function deleteStudentById($id) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("DELETE FROM eleve WHERE id = :id");
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur : " . $e->getMessage();
        die();
    }
    return $resultat;
}
