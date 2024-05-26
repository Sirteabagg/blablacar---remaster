<?php
require "../../../php/config.php";

session_start();

$email = $_SESSION["current-user-email"];
// prepare la requete pour ajoute les information pour pouvoir afficher la vignette pour accepter les trajets
$request = $bdd->prepare("INSERT INTO Booking (idDriver, idPassenger, idTrip, passed) VALUES (:driver, :passenger, :trip, :pass)");

if (isset($_GET["idDriver"], $_GET["idPassenger"], $_GET["idTrip"])) {
    $passenger = $_GET["idPassenger"];
    $driver = $_GET["idDriver"];
    $trip = $_GET["idTrip"];
}
// on verfifie si ce qu'on a recuperer n'est pas vide pour plus de securité
if (!empty($_GET["idPassenger"]) && !empty($_GET["idDriver"]) && !empty($_GET["idTrip"])) {

    $passed = 0;


    $request->bindParam(':driver', $driver);
    $request->bindParam(':passenger', $passenger);
    $request->bindParam(':trip', $trip);
    $request->bindParam(':pass', $passed);

    $request->execute();

    header('Location: trip-form.php');
} else {
    // on vient ici si l'utilisateur n'etait pas passager
    if (empty($_GET["idPassenger"])) {
        // on l'enregistre dnas la table passager pour pouvoir l'ajouter a des futurs trajets
        $ajoutPassenger = $bdd->prepare("INSERT INTO Passenger (email) VALUES (:email)");

        $ajoutPassenger->bindParam(':email', $email);

        $ajoutPassenger->execute();

        $requestIdPas = $bdd->query("SELECT idPassenger as passager FROM Passenger WHERE email = '$email'");
        $passenger = $requestIdPas->fetch()["passenger"];
        // on recupere son id qui a ete creer avant pour ainsi refaire la manip du debut de cette page pour l'ajouter dans un file d'attente
        header('Location: trip-reservation-traitement.php?idPassenger=' . $passenger . '&idTrip=' . $trip . '&idDriver=' . $driver . '');
        exit;
    }
}
