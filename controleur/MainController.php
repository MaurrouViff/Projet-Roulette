<?php

class MainController {

    private $actions;

    public function __construct() {
        $this->actions = array(
            "defaut" => "listeEleve.php",
            "liste" => "listeEleve.php",
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

$controller = new MainController();
$action = "detail";
$page = $controller->execute($action);