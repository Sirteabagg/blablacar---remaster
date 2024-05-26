<?php require "../../php/config.php";

session_start();
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
    <link rel="stylesheet" href="../../css/style-main-structure.css">
    <link rel="stylesheet" href="../../trip-finding/styles/style-trip-selection.css">
    <link rel="stylesheet" href="../css/mytrip.css">
    <title>Document</title>
</head>

<body>

    <main>
        <div>

            <?php
            if ($donnees === false) {
                foreach ($trips as $trip) {
                    echo '<a href="../../trip-finding/php/trip-ressources/trip-description.php?idTrip=' . $trip["idTrip"] . '&mytrip=1"><div class="trip-container">';
                    $contenu_image = $trip['pdp'];
                    $type_mime = 'image/jpeg';
                    $encoded_image = base64_encode($contenu_image);
                    $image_data = "data:$type_mime;base64,$encoded_image";
                    echo "<img src=\"$image_data\" class='img-user' alt=\"Image\">";
                    echo '<div><span>' . $trip['prenom'] . '</span>';
                    echo '<div><div class="avis-container"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" viewBox="0 0 1208.000000 1280.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"><path d="M6036 12519 c-20 -58 -954 -3088 -1237 -4011 l-73 -238 -2123 0 c-1168 0 -2123 -3 -2122 -7 0 -5 23 -25 50 -46 28 -21 571 -438 1207 -926 636 -488 1380 -1057 1652 -1265 272 -208 501 -384 508 -390 10 -9 -123 -450 -643 -2140 -360 -1171 -654 -2130 -652 -2132 1 -1 36 23 77 54 99 74 2006 1534 2763 2115 l598 459 37 -28 c20 -15 237 -181 482 -369 363 -278 2650 -2030 2864 -2193 l59 -46 -7 30 c-4 16 -297 973 -652 2127 -355 1154 -643 2104 -641 2112 3 7 140 115 304 241 224 171 2139 1640 3036 2328 42 32 77 63 77 68 0 4 -954 8 -2120 8 l-2119 0 -45 143 c-25 78 -210 678 -411 1332 -606 1969 -857 2780 -861 2784 -2 2 -6 -2 -8 -10z" /></g></svg><span>' . $trip["notegenerale"] . '</span></div></div></div>';
                    echo '<div class="price">' . $trip['price']  . '€</div>';
                    echo '<div class="trip-info">';
                    echo '<div class="col" id="col1"><div class="dep center-item-col">' . $trip["depart"] . '</div> <div class="line-container"><div class="line-hor" id="line-color-white"></div><div class="point center-item-col"><div class="circle-bg"><div class="circle-upper"></div></div></div><div class="line-hor" id="line-color-green"></div></div><div class="hour center-item-col">' . $trip['tDeparture'] . '</div></div>';
                    echo '<div class="col-flex" id="col2"><div class="trait-horizontal"></div></div>';
                    echo '<div class="col" id="col3"><div class="arr center-item-col">' . $trip["arrive"] . '</div><div class="line-container"><div class="line-hor" id="line-color-green"></div><div class="point center-item-col"><div class="circle-bg"><div class="circle-upper"></div></div></div><div class="line-hor" id="line-color-white"></div></div><div class="hour center-item-col">' . $trip['tArrival'] . '</div></div>';
                    echo '</div></div></a>';
                }
            } ?>
        </div>
        <a href="mytrip-acceptation.php"><button>demande de trajet</button></a>
    </main>
    <?php require "../../php/footer.php" ?>
</body>

</html>