<?php
include_once("modele/bd.eleve.inc.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$eleveDb = new EleveDatabase();

// Récupérer la liste des classes depuis la base de données
$listeClasses = $eleveDb->getClasses();

// Tableau qui contiendra les élèves à afficher
$listeEleve = [];

// Vérifier si le formulaire de filtrage par classe a été soumis
if (isset($_POST['filtrer-par-classe'])) {
    $classeSelectionnee = $_POST['classe-selectionnee'];

    if (!empty($classeSelectionnee)) {
        try {
            $listeEleve = $eleveDb->getEleveByClasse($classeSelectionnee);
        } catch (PDOException $e) {
            // Gestion de l'erreur de base de données
            echo "Erreur de base de données : " . $e->getMessage();
            die();
        }
    }
}

// Affiche la moyenne de la classe
$showMoyenne = $eleveDb->getMoyenneNote();

// Permet de choisir un élève
$eleveChoisi = null;

if (isset($_POST['select-student'])) {
    try {
        $eleve = $eleveDb->selectRandomEleve();
        if ($eleve) {
            $eleveChoisi = $eleve[0];
        }
    } catch (PDOException $e) {
        // Gestion de l'erreur de base de données
        echo "Erreur de base de données : " . $e->getMessage();
        die();
    }
}
// Permet de mettre le passage
if (isset($_POST['passage']) && isset($_POST['button-passage'])) {
    $id = $_POST['eleve-id'];
    $passage = $_POST['passage'];

    try {
        $eleve = $eleveDb->setPassageById($id, $passage);
        if ($eleve) {
            $eleveChoisi = $eleve[0];
            header("Location: index.php");
        }
    } catch (PDOException $e) {
        echo "Erreur de base de données : " . $e->getMessage();
        die();
    }
}
// Permet de rentrer un élève dans une classe
if (isset($_POST['submit-student'])) {
    $prenom = $_POST['set-prenom'];
    $nom = $_POST['set-nom'];
    $classe = $_POST['set-classe'];

    // Appelez la méthode addEleve pour ajouter l'élève
    $result = $eleveDb->addEleve($prenom, $nom, $classe);

    if ($result === true) {
        // L'élève a été ajouté avec succès
        header("Location: index.php");
    } else {
        // Une erreur s'est produite lors de l'ajout de l'élève, vous pouvez afficher un message d'erreur ici
        echo "Erreur lors de l'ajout de l'élève : " . $result;
    }
}

// Permet de mettre une note
if (isset($_POST['note']) && isset($_POST['button-note'])) {
    $id = $_POST['eleve-id']; // Récupérer l'ID de l'élève depuis le formulaire
    $note = $_POST['note'];   // Récupérer la note depuis le formulaire

    try {
        $eleve = $eleveDb->setNoteById($id, $note);
        if ($eleve) {
            $eleveChoisi = $eleve[0];
            header("Location : index.php");
        }
    } catch (PDOException $e) {
        echo "Erreur de base de données : " . $e->getMessage();
        die();
    }
}

// Permet de supprimer un élève de la base de données
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $idASupprimer = $_GET['id'];
    $eleveExiste = $eleveDb->checkIfStudentExists($idASupprimer);
    if ($eleveExiste) {
        $messageSuppression = $eleveDb->deleteStudentById($idASupprimer);
        if ($messageSuppression === "Suppression réussie") {
            header("Location: index.php");
            $eleveChoisi = null;
        } else {
            echo $messageSuppression;
        }
    } else {
        echo "Élève introuvable dans la base de données.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paramètre - Projet Roulette</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="assets/icon/roulette-svg.png">
</head>
<body>
<div class="container">

    <section class="second-section">
        <a href="index.php" class="blue-btn">Retour à l'accueil</a>
    </section>
</div>
</body>
</html>