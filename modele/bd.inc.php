<?php
class Database {
    private $conn;

    public function __construct() {
        $login = "aurelien";
        $mdp = "pierre0800";
        $bd = "Roulette";
        $server = "localhost";
        $charset = "utf8mb4";

        try {
            $this->conn = new PDO("mysql:host=$server;dbname=$bd;charset=$charset", $login, $mdp);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion PDO : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
