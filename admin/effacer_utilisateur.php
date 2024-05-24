<?php

$bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');
// Définir le mode d'erreur de PDO sur exception
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_POST["email"])) {
  $email = $_POST["email"];


  $reponse = $bdd->query("DELETE FROM user WHERE email = '$email'");
  // On affiche chaque entr´ee une `a une
  $donnees = $reponse->execute();

  header("Location: ../admin/page_utilisateur.php");
  exit;
}



?>