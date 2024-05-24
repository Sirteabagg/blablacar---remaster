<?php

$bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');
// Définir le mode d'erreur de PDO sur exception
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_POST["boutonpermis"])) {
    $boutonpermis1 = $_POST["boutonpermis"];
   
    
    if ($boutonpermis1 == "information") {
      $email = $_POST["email"];
      
      
    }
    if ($boutonpermis1 == "télécharger") {
      $email = $_POST["email"];

      $ajoutPassTrip->execute();
    }
    if ($boutonpermis1 == "supprimer") {
        
      $reponse = $bdd->query("DELETE FROM user WHERE email = '$email'");
      $donnees = $reponse->execute();
    }

    
    
}
header('Location: page_permis.php');
    exit;
?>