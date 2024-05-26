<?php
require "../php/config.php";

$reponse = $bdd->query("SELECT * FROM campus");

?>

<!DOCTYPE html>
<html lang="fr">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../css/style-main-structure.css">
      <link rel="stylesheet" href="styles/style_admin.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

      <script src="../trip-finding/scripts/autocompletion.js" defer></script>

      <title>Document</title>
</head>

<body class="page-type">

      <div class=" droite">
            <div class=" titrechoisi">Campus</div>
            <a href="..\admin\page_utilisateur.php">
                  <div class=" titre ">Liste Utilisateur</div>
            </a>
            <a href="..\admin\page_permis.php">
                  <div class=" titre ">Gestion de permis</div>
            </a>

      </div>


      <div class=" gauche">
            <div class="titre22 titre">Campus</div>
            <form method="post" action="ecrire_en_php.php">
                  <div class="">
                        <input type="text" name="Ville" placeholder="Ville" class="truc1 selection">
                  </div>
                  <div class="">
                        <input type="text" name="Adresse" placeholder="Adresse" class="truc2 selection autocomplete">
                        <div class="suggestions"></div>
                  </div>
                  <div class="">
                        <input type="submit" name="quelquechose" value="Ajouter" class="bouton button-submit">

            </form>
      </div>
      <div class="liste">
            <div class="liste titre1">Liste des campus</div>
            <div class="listecampus ">
                  <div class="ville titre1">Ville</div>
                  <div class="adresse titre1">Adresse</div>
                  <div class="adresse titre1"></div>
            </div>





            <?php while ($donnees = $reponse->fetch()) { ?>

                  <form method="post" action="effacer_donne.php" class="listecampus ">

                        <?php echo ' <input type="text" class="ville1 titre1 input_campus" name="Ville" readonly="readonly" value="' . $donnees["city"] . '">
            <input type="text" class="adresse1 titre1 input_campus" name="Adresse" readonly="readonly" value="' . $donnees["address"] . '">'; ?>

                        <input type="submit" value="supprimer" class="selection titre1">

                  </form>


            <?php
            }
            //On termine le traitement de la requ^ete
            $reponse->closeCursor();
            ?>


      </div>
      </div>



</body>


</html>