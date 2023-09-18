<?php
include_once("modele/bd.eleve.inc.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$eleveDb = new EleveDatabase();

// Affiche la liste des élèves
try {
    $listeEleve = $eleveDb->getEleve();
} catch (PDOException $e) {
    // Gestion de l'erreur de base de données
    echo "Erreur de base de données : " . $e->getMessage();
    die();
}

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
                    <td><?= htmlspecialchars($eleve["nomfamille"]) ?></td>
                    <td><?= htmlspecialchars($eleve["prenom"]) ?></td>
                    <td><?= htmlspecialchars($eleve["classe"]) ?></td>
                    <td><?= htmlspecialchars($eleve["note"]) ?></td>
                    <td><?= htmlspecialchars($eleve["passage"]) ?></td>
                    <td><?= $eleve["id"] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <hr>
        <h3 class="red">Elève choisi : </h3>
        <?php if ($eleveChoisi) { ?>
            <p class="orange">Nom : <?= htmlspecialchars($eleveChoisi["nomfamille"]) ?>, Prénom : <?= htmlspecialchars($eleveChoisi["prenom"]) ?>, Classe : <?= htmlspecialchars($eleveChoisi["classe"]) ?>, ID : <?= $eleveChoisi["id"] ?>, Passage : <?= $eleveChoisi["passage"] ?>, Note : <?= $eleveChoisi["note"] ?></p>
            <form method="POST">
                <input class="input-note" name="set-note" placeholder="Mettez une note"><br>
                <button type="submit" class="first-button" name="button-note">Confirmer la note</button>
            </form>
            <br />
            <a href="?action=supprimer&id=<?= $eleveChoisi["id"] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?')">Supprimer</a>
        <?php } else { ?>
            <p class="orange">Aucun élève choisi pour le moment.</p>
        <?php } ?>

        <form method="post">
            <button type="submit" class="first-button" name="select-student">Sélectionner un élève</button>
        </form>
        <hr>
    </section>
</div>

<footer>
    <h4 class="red">Fait avec amour par Aurélien <3</h4>
</footer>
</body>
</html>
