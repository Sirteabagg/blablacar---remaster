<?php
require "../../../connexion.php";

session_start();

$email = $_SESSION["current-user-email"];

$request = $bdd->prepare("INSERT INTO Booking (idDriver, idPassenger, idTrip, passed) VALUES (:driver, :passenger, :trip, :pass)");

if (isset($_GET["idDriver"], $_GET["idPassenger"], $_GET["idTrip"])) {
    $passenger = $_GET["idPassenger"];
    $driver = $_GET["idDriver"];
    $trip = $_GET["idTrip"];
}

if (!empty($_GET["idPassenger"]) && !empty($_GET["idDriver"]) && !empty($_GET["idTrip"])) {

    $passed = 0;


    $request->bindParam(':driver', $driver);
    $request->bindParam(':passenger', $passenger);
    $request->bindParam(':trip', $trip);
    $request->bindParam(':pass', $passed);

    $request->execute();

    header('Location: trip-form.php');
} else {
    if (empty($_GET["idPassenger"])) {
        $ajoutPassenger = $bdd->prepare("INSERT INTO Passenger (email) VALUES (:email)");

        $ajoutPassenger->bindParam(':email', $email);

        $ajoutPassenger->execute();

        $requestIdPas = $bdd->query("SELECT idPassenger as passager FROM Passenger WHERE email = '$email'");
        $passenger = $requestIdPas->fetch()["passenger"];

        header('Location: trip-reservation-traitement.php?idPassenger=' . $passenger . '&idTrip=' . $trip . '&idDriver=' . $driver . '');
        exit;
    }
}
