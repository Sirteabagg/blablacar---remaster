<?php
require "../php/config.php";

$reponse = $bdd->query('SELECT * FROM user');
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
    <div class=" titrechoisi">Liste Utilisateur</div>

    <a href="..\admin\page_permis.php">
      <div class=" titre">Gestion de permis</div>
    </a>


  </div>


  <div class=" gauche">

        <div class="titre22 titre">Liste Utilisateur</div>
    
        <div class="liste "> 
          <div class="listeutilisateur ">
            <div class=" titre1">nom</div> 
            <div class=" titre1">prenom</div> 
            <div class=" titre1">email</div> 
            <div class=" titre1"></div> 
            <div class=" titre1"></div>

        </div>

        
        <?php
// Sous WAMP (Windows)
$bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');
try
{
$bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}

    <div class="titre22 titre">Liste Utilisateur</div>

    <div class="liste ">
      <div class="listeutilisateur ">
        <div class=" titre1">nom</div>
        <div class=" titre1">prenom</div>
        <div class=" titre1">email</div>
        <div class=" titre1"></div>

      </div>
      <?php while ($donnees = $reponse->fetch()) { ?>
        <form method="post" action="effacer_utilisateur.php" class="listeutilisateur ">

          <?php echo ' <input type="text" class="ville1 titre1 input_campus non-selectable" name="nom" readonly="readonly" value="' . $donnees["nom"] . '">
          <input type="text" class="adresse1 titre1 input_campus non-selectable" name="prenom" readonly="readonly" value="' . $donnees["prenom"] . '">
          <input type="text" class="adresse1 titre1 input_campus non-selectable" name="email" readonly="readonly" value="' . $donnees["email"] . '" >';
          ?>

          <input type="submit" value="bannir" class="selection titre1">

        </form>

      <?php
      }
      //On termine le traitement de la requ^ete
      $reponse->closeCursor();
      ?>






<form method="post" action="effacer_utilisateur.php" class="listeutilisateur ">
     
            <?php echo ' <input type="text" class="ville1 titre1 input_campus" name="nom" readonly="readonly" value="'.$donnees["nom"].'">
            <input type="text" class="adresse1 titre1 input_campus" name="prenom" readonly="readonly" value="'.$donnees["prenom"].'">
            <input type="text" class="adresse1 titre1 input_campus" name="email" readonly="readonly" value="'.$donnees["email"].'">';
            ?>
            <input type="submit" name="boutonpermis" value="information" class="selection titre1">
            <input type="submit" name="boutonpermis" value="bannir" class="selection titre1">
     
</form>




</body>


</html>