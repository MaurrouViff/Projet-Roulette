<?php

include "getRacine.php";
include "$racine/controleur/MainController.php";


$controller = new MainController();

if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "defaut";
}

$fichier = $controller->execute($action);
include "$racine/controleur/$fichier";