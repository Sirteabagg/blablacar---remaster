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
    
        <div class="">
        <input type="text" name="departure" placeholder="Ville" class="truc1 selection">
        </div>
        <div class="">
            <input type="text" name="departure" placeholder="Adresse" class="truc2 selection">
      </div> 
        <div class="">
        <input type="submit" value="Ajouter" class="bouton button-submit">
        </div> 
        <div class="liste ">
        <div class="liste titre1">Liste des campus</div> 
        <div class="listecampus ">
        <div class="ville titre1">Ville</div> 
        <div class="adresse titre1">Adresse</div> 
        <div class="adresse titre1"></div> 

        
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

$reponse = $bdd->query('SELECT * FROM campus');
// On affiche chaque entr´ee une `a une
while ($donnees = $reponse->fetch())
{
?>
<div class="ville1 titre1"><?php echo $donnees['city']; ?></div> 
<div class="adresse1 titre1"><?php echo $donnees['address']; ?></div>
<div class="selection"> supprimer</div> 

<?php
}
//On termine le traitement de la requ^ete
$reponse->closeCursor();
93/96 
?>

        </div> 
        </div> 
  </div>
 
   
  

</body>


</html>