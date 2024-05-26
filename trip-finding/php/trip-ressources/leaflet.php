<?php
require "../../../php/config.php";
require "../../../php/url.php";

if (isset($_GET["longdep"], $_GET["latdep"], $_GET["longarr"], $_GET["latarr"], $_GET["idTrip"])) {
    $longdep = $_GET["longdep"];
    $latdep = $_GET["latdep"];
    $longarr = $_GET["longarr"];
    $latarr = $_GET["latarr"];
    $id = $_GET["idTrip"];
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>Geolocation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style-main-structure.css">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/trip-finding/styles/style-trip-description.css">


    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            width: 375px;
            height: 667px;
        }

        .leaflet-touch .leaflet-control-layers,
        .leaflet-touch .leaflet-bar {
            display: none;
        }
    </style>

</head>

<body>
    <!-- header qui revient vers la page trip-description.php -->
    <header>
        <div class="title-description">
            <?php echo "<a href='trip-description.php?idTrip=$id'>"; ?>
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
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

    <!-- script permettant d'ajouter la carte avec leaflet -->
    <?php
    echo "<script>
    var map = L.map('map').setView([$longdep, $latdep], 0);
    mapLink = \"<a href='http://openstreetmap.org'>OpenStreetMap</a>\";
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: 'Leaflet &copy; ' + mapLink + ', contribution',
        maxZoom: 18
    }).addTo(map);

    // Créer l'itinéraire dès que la carte est prête
    L.Routing.control({
        waypoints: [
            L.latLng($latdep, $longdep),
            L.latLng($latarr, $longarr) // Définissez ici vos coordonnées de destination
        ]
        
    }).addTo(map);
</script>";
    ?>

</body>

</html>