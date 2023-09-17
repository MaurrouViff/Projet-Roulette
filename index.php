<?php
include_once("modele/bd.eleve.inc.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Affiche la liste des élèves
try {
    $listeEleve = getEleve();
} catch (PDOException $e) {
    // Gestion de l'erreur de base de données
    echo "Erreur de base de données : " . $e->getMessage();
    die();
}
// Permet de choisir un élève
$eleveChoisi = null;

if (isset($_POST['select-student'])) {
    try {
        $eleve = selectRandomEleve();
        if ($eleve) {
            $eleveChoisi = $eleve[0];
        }
    } catch (PDOException $e) {
        // Gestion de l'erreur de base de données
        echo "Erreur de base de données : " . $e->getMessage();
        die();
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
            <th>ID</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($listeEleve as $eleve) { ?>
            <tr>
                <td><?= htmlspecialchars($eleve["nomfamille"]) ?></td>
                <td><?= htmlspecialchars($eleve["prenom"]) ?></td>
                <td><?= htmlspecialchars($eleve["classe"]) ?></td>
                <td><?= $eleve["id"] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <hr>
        <h3 class="red">Elève choisi : </h3>
        <?php if ($eleveChoisi) { ?>
            <p class="orange">Nom : <?= htmlspecialchars($eleveChoisi["nomfamille"]) ?>, Prénom : <?= htmlspecialchars($eleveChoisi["prenom"]) ?>, Classe : <?= htmlspecialchars($eleveChoisi["classe"]) ?>, ID : <?= $eleveChoisi["id"] ?></p>
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
