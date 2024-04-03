<?php

class Database {
    private $login = "aurelien";
    private $mdp = "pierre0800";
    private $bd = "Roulette";
    private $serveur = "localhost";
    private $charset = "UTF8mb4";
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->conn = new PDO("mysql:host={$this->serveur};dbname={$this->bd};charset={$this->charset}", $this->login, $this->mdp);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "Erreur de connexion PDO : " . $e->getMessage();
            die();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

function connexionPDO() {
    $db = new Database();
    return $db->getConnection();
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    // Programmation de test
    header('Content-Type:text/plain');

    echo "connexionPDO() : \n";
    print_r(connexionPDO());
}

