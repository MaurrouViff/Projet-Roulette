<?php
function connexionPDO() {
    $login = "root";
    $mdp = "root";
    $bd = "roulette";
    $server = "localhost";
    $charset = "utf8mb4";

    try {
        $conn = new PDO("mysql:host=$server;dbname=$bd;charset=$charset", $login, $mdp);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        print "Erreur de connexion PDO : " . $e->getMessage();
        die();
    }
}

