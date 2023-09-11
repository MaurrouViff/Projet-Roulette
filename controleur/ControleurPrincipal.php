<?php

class Controller {

    private array $actions;

    public function __construct() {
        $this->actions = array(
            "defaut" => "indexRoulette.php",
            "accueil" => "indexRoulette.php"
        );
    }

    public function execute($action) {
        if (array_key_exists($action, $this->actions)) {
            return $this->actions[$action];
        } else {
            return $this->actions["defaut"];
        }
    }
}

// Exemple d'utilisation
$controller = new Controller();
$action = "detail";
$page = $controller->execute($action);

