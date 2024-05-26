<?php

require "../../../php/config.php";


if (isset($_GET["idTrip"])) {
    $idTrip = $_GET["idTrip"];
}

$passenger = [];

$requestPassengers = $bdd->query("SELECT * FROM Passenger p JOIN user u on u.email = p.email JOIN Car_passengers cp on cp.idPassengers = p.idPassenger JOIN TripInfo t on cp.idtrip = t.idTrip WHERE t.idTrip = $idTrip");
while ($donnees = $requestPassengers->fetch()) {
    $passenger[] = $donnees;
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../../css/style-main-structure.css">
    <link rel="stylesheet" href="../../styles/style-passengers.css">
    <link rel="stylesheet" href="../../styles/style-trip-description.css">


    <title>Document</title>
</head>

<body>
    <header>
        <div class="title-description">
            <?php echo "<a href='trip-description.php?idTrip=$idTrip'>"; ?>
            <div class="retour">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="25px" height="25px" viewBox="0 0 1280.000000 640.000000" preserveAspectRatio="xMidYMid meet" fill="#138D75">
                    <g transform="translate(0.000000,640.000000) scale(0.100000,-0.100000)" fill="#138D75" stroke="none">
                        <path d="M3310 5925 c-36 -8 -92 -28 -125 -45 -33 -16 -352 -240 -710 -498 -357 -257 -1010 -726 -1450 -1041 -536 -384 -822 -596 -866 -640 -193 -194 -210 -498 -40 -724 48 -65 2884 -2387 2978 -2439 216 -119 480 -82 655 93 111 111 164 239 162 394 -1 133 -35 235 -113 338 -22 29 -331 289 -814 685 l-778 637 5078 5 5078 5 59 22 c241 91 391 319 372 563 -18 233 -162 415 -393 498 -45 16 -369 17 -5132 22 l-5084 5 794 570 c445 319 818 594 849 625 176 177 206 470 70 678 -74 114 -185 200 -306 237 -72 23 -207 28 -284 10z" />
                    </g>
                </svg>

            </div>
            </a>
        </div>
    </header>
    <main>
        <?php
        foreach ($passenger as $pass) {

            echo "<a href='../../../profil/php/visuinfo.php?idTrip=" . $idTrip . "&idPass=" . $pass['idPassenger'] . "'>";
            echo '<div class="boxes-shadow"><div class="passenger-container">';
            $contenu_image = $pass['pdp'];
            $type_mime = 'image/jpeg';
            $encoded_image = base64_encode($contenu_image);
            $image_data = "data:$type_mime;base64,$encoded_image";
            echo "<img src=\"$image_data\" class='img-user' alt=\"Image\">";
            echo '<div><div>' . $pass["prenom"] . '</div>';
            echo '       <div>' . $pass["notegenerale"] . '</div>';
            echo ' </div>';
            echo '  <div class="fleche">&gt;</div>';
            echo '</div></div>';
            echo '</a>';
        }

        ?>
    </main>

</body>

</html>