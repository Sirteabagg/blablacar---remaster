<?php require "../../php/config.php";

$email = $_SESSION["current-user-email"];

$requestTrip = $bdd->query("SELECT idTrip, t.idDriver, t.time, t.dates, price, passed, d.ville as depart, d.latitude as latDep, d.longitude as longDep, d2.ville as arrive, d2.latitude as latArr, d2.longitude as longArr, u.pdp as pdp,
u.prenom as prenom, u.notegenerale as notegenerale, CONCAT(SUBSTRING(timeDepart, 1, 2), ':', SUBSTRING(timeDepart, 4, 2)) AS tDeparture,
CONCAT(SUBSTRING(ADDTIME(timeDepart, time), 1, 2), ':', SUBSTRING(ADDTIME(timeDepart, time), 4, 2)) as tArrival
FROM TripInfo t JOIN Destination d on t.idDep = d.idDestination JOIN Destination d2 on t.idArr = d2.idDestination JOIN Driver d3 on t.idDriver = d3.idDriver JOIN `User` u on d3.email = u.email WHERE d3.email = '$email' AND t.passed = 0");

while ($donnees = $requestTrip->fetch()) {

    $trips[] = $donnees;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="title-description">
            <a href="trip-selection.php">
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
        echo '<a href="trip-description.php?idTrip=' . $trip["idTrip"] . '&nbPass=' . $_POST["passengers"] . '"><div class="trip-container">';
        $contenu_image = $trip['pdp'];
        $type_mime = 'image/jpeg';
        $encoded_image = base64_encode($contenu_image);
        $image_data = "data:$type_mime;base64,$encoded_image";
        echo "<img src=\"$image_data\" class='img-user' alt=\"Image\">";
        echo '<div><span>' . $trip['prenom'] . '</span>';
        echo '<div><div class="avis-container"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" viewBox="0 0 1208.000000 1280.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"><path d="M6036 12519 c-20 -58 -954 -3088 -1237 -4011 l-73 -238 -2123 0 c-1168 0 -2123 -3 -2122 -7 0 -5 23 -25 50 -46 28 -21 571 -438 1207 -926 636 -488 1380 -1057 1652 -1265 272 -208 501 -384 508 -390 10 -9 -123 -450 -643 -2140 -360 -1171 -654 -2130 -652 -2132 1 -1 36 23 77 54 99 74 2006 1534 2763 2115 l598 459 37 -28 c20 -15 237 -181 482 -369 363 -278 2650 -2030 2864 -2193 l59 -46 -7 30 c-4 16 -297 973 -652 2127 -355 1154 -643 2104 -641 2112 3 7 140 115 304 241 224 171 2139 1640 3036 2328 42 32 77 63 77 68 0 4 -954 8 -2120 8 l-2119 0 -45 143 c-25 78 -210 678 -411 1332 -606 1969 -857 2780 -861 2784 -2 2 -6 -2 -8 -10z" /></g></svg><span>' . $trip["notegenerale"] . '</span></div></div></div>';
        echo '<div class="price">' . $trip['price'] *  $_POST["passengers"] . '€</div>';
        echo '<div class="trip-info">';
        echo '<div class="col" id="col1"><div class="dep center-item-col">' . $trip["depart"] . '</div> <div class="line-container"><div class="line-hor" id="line-color-white"></div><div class="point center-item-col"><div class="circle-bg"><div class="circle-upper"></div></div></div><div class="line-hor" id="line-color-green"></div></div><div class="hour center-item-col">' . $trip['tDeparture'] . '</div></div>';
        echo '<div class="col-flex" id="col2"><div class="trait-horizontal"></div></div>';
        echo '<div class="col" id="col3"><div class="arr center-item-col">' . $trip["arrive"] . '</div><div class="line-container"><div class="line-hor" id="line-color-green"></div><div class="point center-item-col"><div class="circle-bg"><div class="circle-upper"></div></div></div><div class="line-hor" id="line-color-white"></div></div><div class="hour center-item-col">' . $trip['tArrival'] . '</div></div>';
        echo '</div></div></a>';
        ?>
    </main>
</body>

</html>