<?php

require "../php/config.php";

$reponse = $bdd->query('SELECT * FROM permis');
// On affiche chaque entr´ee une `a une

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style-main-structure.css">
    <link rel="stylesheet" href="styles/style_admin.css">


    <title>Document</title>
</head>

<body class="page-type">

    <div class=" droite">
        <a href="..\admin\page_campus.php">
            <div class=" titre">Campus</div>
        </a>
        <a href="..\admin\page_utilisateur.php">
            <div class=" titre">Liste Utilisateur</div>
        </a>
        <div class=" titrechoisi">Gestion de permis</div>


    </div>


    <div class=" gauche">
        <div class="titre22 titre">Gestion de permis</div>

        <?php
        $reponse = $bdd->query('SELECT * FROM permis WHERE validation = 0');
        // On affiche chaque entr´ee une `a une
        while ($donnees = $reponse->fetch()) {
        ?>


            <form method="post" action="effacer_permis.php" class="listepermis ">

                <?php echo ' <input type="text" class="ville1 titre1 input_campus" name="email" readonly="readonly" value="' . $donnees["iduser"] . '">'; ?>
                <input type="submit" name="boutonpermis" value="information" class="selection titre1">
                <input type="submit" name="boutonpermis" value="télécharger" class="selection titre1">
                <input type="submit" name="boutonpermis" value="valider" class="selection titre1">
                <input type="submit" name="boutonpermis" value="supprimer" class="selection titre1">

            </form>
        <?php
        }
        //On termine le traitement de la requ^ete
        $reponse->closeCursor();
        ?>

</body>


</html>