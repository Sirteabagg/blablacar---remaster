<?php
require "../../../connexion.php";


if (isset($_POST["action"], $_POST["idpass"], $_POST["idTrip"])) {
    $action = $_POST["action"];
    $trip = $_POST["idTrip"];
    $passenger = $_POST["idpass"];
    if ($action == "Accepter") {
        $ajoutPassTrip = $bdd->prepare("INSERT INTO Car_passengers (idtrip, idPassengers) VALUES (:trip, :passenger)");
        $ajoutPassTrip->bindParam(":trip", $trip);
        $ajoutPassTrip->bindParam(":passenger", $passenger);
        $ajoutPassTrip->execute();
    }

    $bookingPassed = $bdd->prepare("UPDATE Booking SET passed = 1 WHERE idTrip = $trip AND idPassenger = $passenger");
    $bookingPassed->execute();
    header('Location: mytrip-acceptation.php');
    exit;
}
