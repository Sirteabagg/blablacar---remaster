<?php

require "../../php/config.php";

session_start();
$email = $_SESSION["current-user-email"];

try {
    $reponseDr = $bdd->query("SELECT idDriver FROM Driver WHERE email='$email'");
    $userDriver = $reponseDr->fetch();
    $userDriver = $userDriver["idDriver"];

    if ($userDriver) {
        $deleteTrip = $bdd->prepare("DELETE FROM Trip WHERE idDriver = $userDriver");
        $deleteTrip->execute();
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

    header("Location: connexion.php");
    exit;
} catch (\Throwable $th) {
    header("Location: info.php");
}
