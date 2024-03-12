<?php
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}
include_once "$racine/modele/EleveDatabase.php";

$eleveDb = new EleveDatabase();


// Récupérer la liste des classes depuis la base de données
$listeClasses = $eleveDb->getClasses();

// Tableau qui contiendra les élèves à afficher
$listeEleve = [];


// Vérifier si le formulaire de filtrage par classe a été soumis


// Récupérer la classe sélectionnée précédemment (si elle existe)
$classeSelectionnee = isset($_SESSION['classe-selectionnee']) ? $_SESSION['classe-selectionnee'] : "";

// ...
$eleve = $eleveDb->selectRandomEleveByClasse($classeSelectionnee);




if (isset($_POST['filtrer-par-classe'])) {
    $classeSelectionnee = $_POST['classe-selectionnee'];

    if (!empty($classeSelectionnee)) {
        try {
            $listeEleve = $eleveDb->getEleveByClasse($classeSelectionnee, 'non'); // Ajoutez 'non' pour le passage
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

if (empty($classeSelectionnee)) {
    // Si aucune classe n'a été sélectionnée, utilisez une valeur par défaut ou affichez un message d'erreur.
    echo "Veuillez sélectionner une classe avant de choisir un élève.";
} else {
    try {
        // Utilisez la classe sélectionnée dans votre requête de sélection aléatoire.
        $eleve = $eleveDb->selectRandomEleveByClasse($classeSelectionnee);

        if ($eleve && count($eleve) > 0) {
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

// Permet de reset les valeurs dans la table
if (isset($_POST['delete-value'])) {
    try {
        $deleteValue = $eleveDb->removeValue();
        if ($deleteValue) {
            header('Location: index.php');
        }
    } catch (PDOException $e) {
        echo "Erreur de base de données : " . $e->getMessage();
        die();
    }
}

// Permet d'ajouter les valeurs à la base de données
if (isset($_POST['add-value'])) {
    try {
        $addValue = $eleveDb->addValue();
        if ($addValue) {
            header('Location: index.php');
        }
    } catch (PDOException $e) {
        echo "Erreur de base de données : " . $e->getMessage();
        die();
    }
}


// appel du script de vue qui permet de gerer l'affichage des donnees
$titre = "Projet Roulette";
include "$racine/vue/vueListeEleve.php";