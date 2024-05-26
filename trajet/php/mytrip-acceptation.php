<?php
require "../../../connexion.php";

session_start();


$email = $_SESSION["current-user-email"];


$checkUser = $bdd->query("SELECT COUNT(*) as here FROM Driver d JOIN `User` u on d.email = u.email WHERE u.email = '$email'");
$emailHere = $checkUser->fetch()["here"];
if ($emailHere == 0) {
    echo "vous n'etes pas enregistrer comme conducteur";
} else {
    $requestUser = $bdd->query("SELECT d.idDriver as driver FROM Driver d JOIN `User` u on d.email = u.email WHERE u.email = '$email'");
    $idDriver = $requestUser->fetch()["driver"];
    $requestidDriver = $bdd->query("SELECT * FROM Booking b WHERE b.idDriver = $idDriver");





?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../styles/accept-trip.css">
        <link rel="stylesheet" href="../../../css/style-main-structure.css">
        <title>Document</title>
    </head>

    <body>
    <?php
    while ($donnee = $requestidDriver->fetch()) {
        $idPassenger = $donnee["idPassenger"];
        $requestPassenger = $bdd->query("SELECT u.prenom as passager FROM Passenger p  JOIN `User` u on p.email = u.email WHERE p.idPassenger = $idPassenger");
        $nom = $requestPassenger->fetch()["passager"];
        if ($donnee["passed"] == 0) {
            echo '<div class="container">
            <form action="mytrip-traitement.php" method="post">
                <input type="numeric" name="idpass" value="' . $idPassenger . '" class="notvisible">
                <input type="numeric" name="idTrip" value="' . $donnee["idTrip"] . '" class="notvisible">
                <div class="accept-container">
                    <a href="../../../profil/php/visuinfo.php?idPassenger=' . $idPassenger . '"
                    <div>
                        <!-- image pdp -->
                        <div>' . $nom . '</div>
                    </div>
                    </a>
                    <div>
        
                    </div>
                    <div class="choose-container">
                        <input type="submit" name="action" value="Accepter">
                        <input type="submit" name="action" value="Refuser">
                    </div>
                </div>
            </form>
            </div>';
        }
    }
}
    ?>



    </body>

    </html>

    <!--quand user accepte envoie ajoute passed = 1 dans la table booking
    et ajout l'idpassager dans la table car_passengers
    si refus mettre passed = 1 et ne pas ajouter l'idPassager -->