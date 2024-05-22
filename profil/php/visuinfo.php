<?php
session_start();

$host = $_SESSION["hostBdd"];
$passwordBdd = $_SESSION["passwordBdd"];

$bdd = new PDO(
    "mysql:host=$host;dbname=blablaomnes;charset=utf8",
    'root',
    $passwordBdd
);


if (isset($_GET["idDriver"], $_GET["idTrip"])) {
    $idDriver = $_GET["idDriver"];
    $idTrip = $_GET["idTrip"];
    $request = $bdd->query("SELECT d.idDriver, u.email, u.pwd, u.prenom, u.pdp, u.notegenerale AS note FROM Driver d JOIN `User` u on d.email = u.email");
} else {
    $request = $bdd->query("SELECT u.email, u.pwd, u.prenom, u.pdp, u.notegenerale AS note FROM `User` u");
}

while ($donnee = $request->fetch()) {
    if (isset($_GET["idDriver"])) {
        if ($donnee["idDriver"] == $idDriver) {
            $user = $donnee;
        }
    } else {
        if ($donnee["email"] == $_SESSION["current-user-email"]) {
            $user = $donnee;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style-main-structure.css">
    <link rel="stylesheet" href="../../trip-finding/styles/style-trip-description.css">

    <link rel="stylesheet" href="../styles/visuinfo.css">
</head>

<body>
    <header>
        <div class="title-description">
            <?php if (isset($_GET["idDriver"], $_GET["idTrip"])) {
                echo "<a href=../../trip-finding/php/trip-ressources/trip-description.php?idTrip=" . $idTrip;
            } else {
                echo "<a href=profilforme.php";
            }
            ?>
            <div class="retour">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="25px" height="25px" viewBox="0 0 1280.000000 640.000000" preserveAspectRatio="xMidYMid meet" fill="#138D75">
                    <g transform="translate(0.000000,640.000000) scale(0.100000,-0.100000)" fill="#138D75" stroke="none">
                        <path d="M3310 5925 c-36 -8 -92 -28 -125 -45 -33 -16 -352 -240 -710 -498 -357 -257 -1010 -726 -1450 -1041 -536 -384 -822 -596 -866 -640 -193 -194 -210 -498 -40 -724 48 -65 2884 -2387 2978 -2439 216 -119 480 -82 655 93 111 111 164 239 162 394 -1 133 -35 235 -113 338 -22 29 -331 289 -814 685 l-778 637 5078 5 5078 5 59 22 c241 91 391 319 372 563 -18 233 -162 415 -393 498 -45 16 -369 17 -5132 22 l-5084 5 794 570 c445 319 818 594 849 625 176 177 206 470 70 678 -74 114 -185 200 -306 237 -72 23 -207 28 -284 10z" />
                    </g>
                </svg>

            </div>
            <?php echo "</a>"; ?>
        </div>
    </header>
    <div class="container">
        <div class="menup">
            <div class="item titre">Bonjour, <?php echo $user["prenom"] ?> !</div>
            <div class="item ID">
                <?php $contenu_image = $user['pdp'];
                $type_mime = 'image/jpeg'; // Remplacez par le type MIME de votre image si nécessaire
                $encoded_image = base64_encode($contenu_image);
                $image_data = "data:$type_mime;base64,$encoded_image";
                echo "<img src=\"$image_data\" class='img-user' alt=\"Image\">"; ?>
            </div>
        </div>

        <div class="forme">
            <div class="s1">Niveau d'experience: Confirmé</div>
            <div class="s2"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 1208.000000 1280.000000" preserveAspectRatio="xMidYMid meet">
                    <metadata>
                        Created by potrace 1.15, written by Peter Selinger 2001-2017
                    </metadata>
                    <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)" fill="#D9D9D9" stroke="none">
                        <path d="M6036 12519 c-20 -58 -954 -3088 -1237 -4011 l-73 -238 -2123 0
c-1168 0 -2123 -3 -2122 -7 0 -5 23 -25 50 -46 28 -21 571 -438 1207 -926 636
-488 1380 -1057 1652 -1265 272 -208 501 -384 508 -390 10 -9 -123 -450 -643
-2140 -360 -1171 -654 -2130 -652 -2132 1 -1 36 23 77 54 99 74 2006 1534
2763 2115 l598 459 37 -28 c20 -15 237 -181 482 -369 363 -278 2650 -2030
2864 -2193 l59 -46 -7 30 c-4 16 -297 973 -652 2127 -355 1154 -643 2104 -641
2112 3 7 140 115 304 241 224 171 2139 1640 3036 2328 42 32 77 63 77 68 0 4
-954 8 -2120 8 l-2119 0 -45 143 c-25 78 -210 678 -411 1332 -606 1969 -857
2780 -861 2784 -2 2 -6 -2 -8 -10z" />
                    </g>
                </svg><?php echo $user["note"] ?>/5 Avis</div>
            <div class="s3">3/3 Bonne conduite</div>
        </div>

        <div class="veri">
            <div class="fi1">Piece d'identité vérifiée</div>
            <div class="fi2">Adresse mail vérifiée</div>
            <div class="fi3">Numéro de tél vérifié</div>
        </div>
    </div>

</body>

</html>