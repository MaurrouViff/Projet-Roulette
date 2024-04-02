<?php error_reporting(0);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $titre; ?></title>
    <style>
        @import url("css/style.css");
    </style>
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
                    <option value="<?php echo htmlspecialchars($classe['classe']); ?>" <?php if ($classe['classe'] === $classeSelectionnee) echo 'selected'; ?>><?php echo $classe['classe']; ?></option>
                <?php } ?>
            </select>
            <button type="submit" class="first-button" name="filtrer-par-classe">Sélectionner un élève par classe</button>
        </form>
        <input type="hidden" name="classe-selectionnee-hidden" value="<?php echo htmlspecialchars($classeSelectionnee); ?>">

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
                    <td><?php echo htmlspecialchars($eleve["nomfamille"]); ?></td>
                    <td><?php echo htmlspecialchars($eleve["prenom"]); ?></td>
                    <td><?php echo htmlspecialchars($eleve["classe"]); ?></td>
                    <td><?php echo htmlspecialchars($eleve["note"]); ?></td>
                    <td><?php echo htmlspecialchars($eleve["passage"]); ?></td>
                    <td><?php echo $eleve["id"]; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <hr><br /><br />

        <h3 class="red">Elève choisi :</h3>
        <?php if ($eleveChoisi) { ?>
            <p style="color: red">Nom : <?php echo htmlspecialchars($eleveChoisi["nomfamille"]); ?></p>
            <p style="color: red">Prénom : <?php echo htmlspecialchars($eleveChoisi["prenom"]); ?></p>
            <p style="color: red">Classe : <?php echo htmlspecialchars($eleveChoisi["classe"]); ?></p>
            <p style="color: red">Note : <?php echo htmlspecialchars($eleveChoisi["note"]); ?></p>
            <p style="color: red">Passage : <?php echo htmlspecialchars($eleveChoisi["passage"]); ?></p>


            <form method="POST">
                <input type="hidden" name="eleve-id" value="<?php echo $eleveChoisi['id']; ?>">
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
            <a href="?action=supprimer&id=" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?')">Supprimer</a><br><br>
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
        <hr><br>
        <h3 class="red">Réinitialiser la roulette</h3>
        <form method="POST">
            <button type="submit" class="first-button" name="delete-value">Supprimer les classes & élèves</button><br><br>
        </form>
        <form method="POST">
            <button type="submit" class="first-button" name="add-value">Ajouter les valeurs</button><br><br>
        </form>
        <form method="post">
            <button type="submit" class="first-button" name="reset-passage">Reset les passages</button><br><br>
        </form>
        <form method="post">
            <button type="submit" class="first-button" name="reset-note">Reset les notes</button>
        </form>
    </section>
</div>

<footer>
    <h4 class="red">Fait avec amour par Aurélien <3</h4>
</footer>
</body>
</html>
