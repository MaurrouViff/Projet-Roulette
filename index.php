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
session_start();

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
if (empty($classeSelectionnee)) {
    // Si aucune classe n'a été sélectionnée, utilisez une valeur par défaut ou affichez un message d'erreur.
    echo "Veuillez sélectionner une classe avant de choisir un élève.";
} else {
    try {
        // Utilisez la classe sélectionnée dans votre requête de sélection aléatoire.
        $eleve = $eleveDb->selectRandomEleveByClasse($classeSelectionnee);

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
    <title>Projet Roulette</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="assets/icon/roulette-svg.png"/>
</head>
<body>

<div class="container">
    <section class="section">
        <h1 class="red">Voici la liste des élèves :</h1>
        <form method="post">
            <select name="classe-selectionnee">
                <option value="">Sélectionnez une classe</option>
                <?php foreach ($listeClasses as $classe) { ?>
                    <option value="<?= htmlspecialchars($classe['classe']) ?>" <?php if ($classe['classe'] === $classeSelectionnee) echo 'selected'; ?>> <?= $classe['classe'] ?> </option>
                <?php } ?>
            </select>

            <button type="submit" class="first-button" name="filtrer-par-classe">Sélectionner un élève par classe</button>
        </form>
        <input type="hidden" name="classe-selectionnee-hidden" value="<?= htmlspecialchars($classeSelectionnee) ?>">


        <table>
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Classe</th>
                <th>Note</th>
                <th>Passage</th>
                <th>ID</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($listeEleve as $eleve) { ?>
                <tr>
                    <td><?= ($eleve["nomfamille"]) ?></td>
                    <td><?= ($eleve["prenom"]) ?></td>
                    <td><?= ($eleve["classe"]) ?></td>
                    <td><?= ($eleve["note"]) ?></td>
                    <td><?= ($eleve["passage"]) ?></td>
                    <td><?= $eleve["id"] ?></td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
        <p class="red">Moyenne de la classe : </p>
        <p class="orange"><?php echo $showMoyenne; ?></p>
        <hr><br /><br />

        <h3 class="red">Elève choisi : </h3>
        <?php if ($eleveChoisi) { ?>
            <p class="orange">Nom : <?= htmlspecialchars($eleveChoisi["nomfamille"] ?? "") ?>,
                Prénom : <?= htmlspecialchars($eleveChoisi["prenom"] ?? "") ?>,
                Classe : <?= htmlspecialchars($eleveChoisi["classe"] ?? "") ?>,
                Passage : <?= htmlspecialchars($eleveChoisi["passage"] ?? "") ?>,
                Note : <?= $eleveChoisi["note"] ?? "" ?>,
                ID : <?= $eleveChoisi["id"] ?? "" ?></p>
            <form method="POST">
                <input type="hidden" name="eleve-id" value="<?= $eleveChoisi["id"] ?? "" ?>">
                <input type="text" class="input-note" name="note" placeholder="Mettre une note"><br><br>
                <button type="submit" class="first-button" name="button-note">Confirmer la note</button><br><br>
                <input type="text" class="input-note" name="passage" placeholder="Indiquer s'il est passé"><br><br>
                <ul>
                    <li class="red">Oui s'il est passé !</li>
                    <li class="red">Non, s'il n'est pas passé mais est par défaut !</li>
                </ul>
                <button type="submit" class="first-button" name="button-passage">Confirmer le passage</button>
            </form>

            <br />
            <a href="?action=supprimer&id=<?= $eleveChoisi["id"] ?? "" ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?')">Supprimer</a><br><br>
        <?php } else { ?>
            <p class="orange">Aucun élève choisi pour le moment.</p>
        <?php } ?>


        <hr>
        <form method="post">
            <input type="text" class="input-note" name="set-prenom" placeholder="Écrivez le prénom de votre élève" required><br /><br>
            <input type="text" class="input-note" name="set-nom" placeholder="Écrivez le nom de votre élève" required><br /><br>
            <input type="text" class="input-note" name="set-classe" placeholder="Écrivez le nom de votre classe" required><br /><br>
            <button type="submit" class="first-button" name="submit-student">Confirmer</button>
        </form>
    </section>
</div>

<footer>
    <h4 class="red">Fait avec amour par Aurélien <3</h4>
</footer>
</body>
</html>
