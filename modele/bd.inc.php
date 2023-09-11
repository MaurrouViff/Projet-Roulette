<?php

class Database {
    protected string $login = "root";
    protected string $mdp = "root";
    protected string $bd = "roulette";
    protected string $serveur = "localhost";
    protected PDO $connexion;

    public function __construct() {
        try {
            $this->connexion = new PDO("mysql:host=$this->serveur;dbname=$this->bd;charset=UTF8", $this->login, $this->mdp);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException) {
            print "Erreur de connexion PDO ";
            die();
        }
    }

    public function getConnexion() {
        return $this->connexion;
    }
}