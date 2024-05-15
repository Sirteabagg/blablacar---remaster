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
        <div class=" titre">Campus</div> 
        <div class=" titre">Liste Utilisateur</div>
        <div class=" titre">Gestion de permis</div>
        
                    
  </div>

    
  <div class=" gauche">
        <div class="titre22 titre">Gestion de permis</div>
    
        <div class="liste "> 
        <div class="listepermis ">
        <div class=" titre1">nom</div> 
        <div class=" titre1">prenom</div> 
        <div class=" titre1">email</div> 
        <div class=" titre1">permis</div> 
        <div class=" titre1"></div> 

        
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

$reponse = $bdd->query('SELECT * FROM utilisateur');
// On affiche chaque entr´ee une `a une
while ($donnees = $reponse->fetch())
{
?>
<div class="ville1 titre1"><?php echo $donnees['nom']; ?></div> 
<div class="adresse1 titre1"><?php echo $donnees['prenom']; ?></div>
<div class="adresse1 titre1"><?php echo $donnees['email']; ?></div>
<div class="selection"> télécharger</div> 
<div class="selection"> supprimer</div> 

<?php
}
//On termine le traitement de la requ^ete
$reponse->closeCursor();
93/96 
?>

   
  </div>
 
   
  

</body>


</html>