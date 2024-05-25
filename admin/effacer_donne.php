<?php

$bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');
// Définir le mode d'erreur de PDO sur exception
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_POST["Ville"], $_POST["Adresse"])) {
  $Ville = $_POST["Ville"];
  $Adresse = $_POST["Adresse"];

  $reponse = $bdd->query("DELETE FROM campus WHERE city = '$Ville'");
  // On affiche chaque entr´ee une `a une
  $donnees = $reponse->execute();

  header("Location: ../admin/page_campus.php");
  exit;
}



?>