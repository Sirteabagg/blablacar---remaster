<?php

require "../php/config.php";


if (isset($_POST["email"])) {
  $email = $_POST["email"];

  $reponseDr = $bdd->query("SELECT idDriver FROM Driver WHERE email='$email'");
  $userDriver = $reponseDr->fetch();
  $userDriver = $userDriver["idDriver"];

  if ($userDriver) {
    $deleteDriver = $bdd->prepare("DELETE FROM Driver WHERE idDriver = $userDriver");
    $deleteDriver->execute();
  }

  $reponsePa = $bdd->query("SELECT idPassenger FROM Passenger WHERE email='$email'");
  $userPass = $reponseDr->fetch();
  $userPass = $userPass["idPassenger"];
  if ($userPass) {
    $deletePass = $bdd->prepare("DELETE FROM Passenger WHERE idDriver = $userDriver");
    $deletePass->execute();
  }

  $reponse = $bdd->prepare("DELETE FROM user WHERE email = '$email'");
  // On affiche chaque entr´ee une `a une
  $reponse->execute();

  header("Location: ../admin/page_utilisateur.php");
  exit;
}
