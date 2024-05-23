<?php
include 'connexion.php';

if (isset($_POST["Ville"], $_POST["Adresse"])) {
  $Ville = $_POST["Ville"];
  $Adresse = $_POST["Adresse"];
}

$reponse = $bdd->query('DELETE FROM campus WHERE city = $Ville AND address = $Adresse');
// On affiche chaque entr´ee une `a une
$donnees = $reponse->execute()

header("Location: ../admin/page_campus.php");
exit;
?>