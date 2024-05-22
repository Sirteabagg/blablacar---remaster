<?php
session_start();

$host = $_SESSION["hostBdd"];
$password = $_SESSION["passwordBdd"];


$bdd = new PDO(
    "mysql:host=$host;dbname=blablaomnes;charset=utf8",
    'root',
    $password
);

$requestTrip = $bdd->query("SELECT idTrip, t.idDriver, t.time, t.date, price, passed, d.ville as depart, d.latitude as latDep, d.longitude as longDep, d2.ville as arrive, d2.latitude as latArr, d2.longitude as longArr, u.pdp as pdp,
u.prenom as prenom, u.notegenerale as notegenerale, CONCAT(SUBSTRING(timeDepart, 1, 2), ':', SUBSTRING(timeDepart, 4, 2)) AS tDeparture,
CONCAT(SUBSTRING(ADDTIME(timeDepart, time), 1, 2), ':', SUBSTRING(ADDTIME(timeDepart, time), 4, 2)) as tArrival
FROM TripInfo t JOIN Destination d on t.idDep = d.idDestination JOIN Destination d2 on t.idArr = d2.idDestination JOIN Driver d3 on t.idDriver = d3.idDriver JOIN `User` u on d3.email = u.email");


$trips = array();
$driver = array();
$times = array();
while ($donnees = $requestTrip->fetch()) {
    if ($donnees["passed"] == 0) {
        $trips[] = $donnees;
    }
}


if (isset($_POST["departure"], $_POST["arrival"], $_POST["date"], $_POST["passengers"])) {
    $depart = $_POST["departure"];
    $arrivee = $_POST["arrival"];
    $date = $_POST["date"];
    $nbPassagers = $_POST["passengers"];
} else {
    echo "rien";
}

$depart = str_replace(' ', '+', $depart);
$arrivee = str_replace(' ', '+', $arrivee);

$depart = strtr($depart, ' ', '+');
$arrivee = strtr($arrivee, ' ', '+');


$url_api_adresse_dep = "https://api-adresse.data.gouv.fr/search/?q=$depart&limit=1";
$url_api_adresse_arr = "https://api-adresse.data.gouv.fr/search/?q=$arrivee&limit=1";

// Initialisation de CURL
$curl_dep = curl_init();
$curl_arr = curl_init();

// Configuration de la requête CURL
curl_setopt($curl_dep, CURLOPT_URL, $url_api_adresse_dep);
curl_setopt($curl_dep, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl_arr, CURLOPT_URL, $url_api_adresse_arr);
curl_setopt($curl_arr, CURLOPT_RETURNTRANSFER, true);

// Exécution de la requête CURL
$response_dep = curl_exec($curl_dep);
$response_arr = curl_exec($curl_arr);



// Vérification des erreurs CURL
if (curl_errno($curl_dep) && curl_errno($curl_arr)) {
    echo 'Erreur CURL : ' . curl_error($curl_dep);
    echo 'Erreur CURL : ' . curl_error($curl_arr);
} else {
    // Décoder la réponse JSON en un tableau associatif PHP
    $donnees_dep = json_decode($response_dep, true);
    $donnees_arr = json_decode($response_arr, true);
    // Vérifier si la réponse contient des données
    if (isset($donnees_dep['features'], $donnees_arr['features']) && !empty($donnees_dep['features']) && !empty($donnees_arr['features'])) {

        $depcity = $donnees_dep["features"][0]["properties"]["city"];
        $arrcity = $donnees_arr["features"][0]["properties"]["city"];
        $geometry = $donnees_dep['features'][0]['geometry'];
        $latitude_dep = $geometry['coordinates'][1];
        $longitude_dep = $geometry['coordinates'][0];
        $geometry = $donnees_arr['features'][0]['geometry'];
        $latitude_arr = $geometry['coordinates'][1];
        $longitude_arr = $geometry['coordinates'][0];
        $tab_coord = [[$longitude_dep, $latitude_dep], [$longitude_arr, $latitude_arr]];
    } else {
        echo "Aucune adresse trouvée.";
    }
}

// Fermer la session CURL
curl_close($curl_dep);
curl_close($curl_arr);

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/style-main-structure.css">
    <link rel="stylesheet" href="../../styles/style-trip-finding.css">
    <link rel="stylesheet" href="../../styles/style-trip-selection.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Document</title>
</head>

<body>

    <header>
        <div class="title title-grid">
            <a href="trip-form.php">
                <div class="retour">&lt;</div>
            </a>
            <div>
                <h2><?php echo $depcity . " --&gt; " . $arrcity ?></h2>
            </div>
        </div>
    </header>
    <main>
        <?php
        $tab = [["longDep", "latDep"], ["longArr", "latArr"]];
        foreach ($trips as $trip) {
            $i = 0;
            $tab_distance = [];

            foreach ($tab as $index) {
                $longitude_trip = $trip[$index[0]];
                $latitude_trip = $trip[$index[1]];

                $longitude_user = $tab_coord[$i][0];
                $latitude_user = $tab_coord[$i][1];

                $url_api_adresse = "https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf6248734c41a8117a44f6839360a0e5bbe9f9&start=$longitude_user,$latitude_user&end=$longitude_trip,$latitude_trip";
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $url_api_adresse);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($curl);

                if (curl_errno($curl)) {
                    echo 'Erreur CURL : ' . curl_error($curl);
                } else {
                    // Décoder la réponse JSON en un tableau associatif PHP
                    $donnees = json_decode($response, true);
                    if (isset($donnees["features"]) && !empty($donnees["features"])) {
                        $distance = $donnees["features"][0]["properties"]["segments"][0]["distance"];
                        $tab_distance[] = $distance;
                    }
                }

                curl_close($curl);
                $i = $i + 1;
            }

            if ($tab_distance[0] <= 30000 && $tab_distance[1] <= 30000 && $trip["date"] == $date) {
                echo '<a href="trip-description.php?idTrip=' . $trip["idTrip"] . '"><div class="trip-container">';
                $contenu_image = $trip['pdp'];
                $type_mime = 'image/jpeg';
                $encoded_image = base64_encode($contenu_image);
                $image_data = "data:$type_mime;base64,$encoded_image";
                echo "<img src=\"$image_data\" class='img-user' alt=\"Image\">";
                echo '<div><span>' . $trip['prenom'] . '</span>';
                echo '<div><div class="avis-container"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" viewBox="0 0 1208.000000 1280.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"><path d="M6036 12519 c-20 -58 -954 -3088 -1237 -4011 l-73 -238 -2123 0 c-1168 0 -2123 -3 -2122 -7 0 -5 23 -25 50 -46 28 -21 571 -438 1207 -926 636 -488 1380 -1057 1652 -1265 272 -208 501 -384 508 -390 10 -9 -123 -450 -643 -2140 -360 -1171 -654 -2130 -652 -2132 1 -1 36 23 77 54 99 74 2006 1534 2763 2115 l598 459 37 -28 c20 -15 237 -181 482 -369 363 -278 2650 -2030 2864 -2193 l59 -46 -7 30 c-4 16 -297 973 -652 2127 -355 1154 -643 2104 -641 2112 3 7 140 115 304 241 224 171 2139 1640 3036 2328 42 32 77 63 77 68 0 4 -954 8 -2120 8 l-2119 0 -45 143 c-25 78 -210 678 -411 1332 -606 1969 -857 2780 -861 2784 -2 2 -6 -2 -8 -10z" /></g></svg><span>' . $trip["notegenerale"] . '</span></div></div></div>';
                echo '<div class="price">' . $trip['price'] . '€</div>';
                echo '<div class="trip-info">';
                echo '<div class="col" id="col1"><div class="dep center-item-col">' . $trip["depart"] . '</div> <div class="line-container"><div class="line-hor" id="line-color-white"></div><div class="point center-item-col"><div class="circle-bg"><div class="circle-upper"></div></div></div><div class="line-hor" id="line-color-green"></div></div><div class="hour center-item-col">' . $trip['tDeparture'] . '</div></div>';
                echo '<div class="col-flex" id="col2"><div class="trait-horizontal"></div></div>';
                echo '<div class="col" id="col3"><div class="arr center-item-col">' . $trip["arrive"] . '</div><div class="line-container"><div class="line-hor" id="line-color-green"></div><div class="point center-item-col"><div class="circle-bg"><div class="circle-upper"></div></div></div><div class="line-hor" id="line-color-white"></div></div><div class="hour center-item-col">' . $trip['tArrival'] . '</div></div>';
                echo '</div></div></a>';
            }
        }

        ?>



    </main>
</body>

</html>