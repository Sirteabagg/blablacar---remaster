<?php
session_start();

// Récupérer les informations de la session
if (isset($_SESSION["hostBdd"], $_SESSION["passwordBdd"], $_SESSION["current-user-email"])) {
    $host = $_SESSION["hostBdd"];
    $password = $_SESSION["passwordBdd"];
    $email = $_SESSION["current-user-email"];
} else {
    die("Session variables not set.");
}

try {
    // Connexion à la base de données
    $bdd = new PDO(
        "mysql:host=$host;dbname=blablaomnes;charset=utf8",
        'root',
        $password
    );
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer la photo de profil de l'utilisateur
    $stmt = $bdd->prepare("SELECT pdp FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le formulaire est soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Upload, modification et suppression de la photo de profil
        if (isset($_FILES['pdp']) && $_FILES['pdp']['error'] == UPLOAD_ERR_OK) {
            // Upload de la photo
            $fileTmpPath = $_FILES['pdp']['tmp_name'];
            $content = file_get_contents($fileTmpPath);

            if ($content === false) {
                die("Failed to read file content.");
            }

            if ($user) {
                // Mettre à jour la photo de profil de l'utilisateur existant
                $stmt = $bdd->prepare("UPDATE user SET pdp = :pdp WHERE email = :email");
            } else {
                // Insérer une nouvelle ligne pour l'utilisateur
                $stmt = $bdd->prepare("INSERT INTO user (email, pdp) VALUES (:email, :pdp)");
            }

            $stmt->bindParam(':pdp', $content, PDO::PARAM_LOB);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            header("Location: profilforme.php");
            exit();
        } elseif (isset($_POST['delete'])) {
            // Supprimer la photo
            $stmt = $bdd->prepare("UPDATE user SET pdp = NULL WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            header("Location: profilforme.php");
            exit();
        }
    }
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style-main-structure.css">
    <link rel="stylesheet" href="../styles/style-profil.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <a href="visuinfo.php">
            <div class="menup">
                <div class="item titre">Mon Profil</div>
            </a>
            <div class="item ID">
                <?php
                if ($user && !empty($user['pdp'])) {
                    // Convertir les données BLOB en base64 pour les afficher dans une balise img
                    $base64 = base64_encode($user['pdp']);
                    $mime = finfo_buffer(finfo_open(), $user['pdp'], FILEINFO_MIME_TYPE);
                    echo '<img src="data:' . $mime . ';base64,' . $base64 . '" class="img-user">';
                } else {
                    echo '<img src="../../images/utilisateur.png" class="img-user">';
                }
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="pdp">
                    <input type="submit" name="upload" value="Uploader">
                    <input type="submit" name="delete" value="Supprimer">
                </form>
            </div>
        </div>
        
        <div class="portefeuille">
            <h4>Mon Portefeuille : 30€</h4>
        </div>
        <div class="menu">
            <a href="info.php">
                <div class="itemss grid-container">Mes infos personnelles<div>&gt</div></div>
            </a>
            <a href="prefform.php">
                <div class="itemss grid-container">Mes infos conducteur<div>&gt</div></div>
            </a>
            <a href="connexion.php">
                <div class="itemss grid-container">Déconnexion<div>&gt</div></div>
            </a>
        </div>
    </div>
</body>
<footer>
    <nav>
        <div class="nav-container">
            <div class="nav-item">
                <a href="../../trip-finding/php/trip-ressources/trip-form.php">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 50 50" style="fill: white;">
                        <path d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"></path>
                    </svg>
                </a>
            </div>
            <div class="nav-item">
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 50 50" style="fill: white;">
                        <path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z"></path>
                    </svg>
                </a>
            </div>
            <div class="nav-item">
                <a href="#">
                    <svg fill="#000000" height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 202.77 202.77" xml:space="preserve" style="fill: white;">
                        <path d="M202.732,60.803c-0.007-0.063-0.021-0.124-0.028-0.187c-0.023-0.184-0.047-0.367-0.084-0.548
                        c-0.019-0.094-0.047-0.183-0.068-0.275c-0.036-0.148-0.069-0.297-0.114-0.442c-0.025-0.082-0.058-0.16-0.086-0.241
                        c-0.053-0.153-0.105-0.306-0.167-0.456c-0.018-0.044-0.041-0.085-0.061-0.129c-0.371-0.838-0.89-1.612-1.55-2.273L148.536,4.213
                        c-1.407-1.407-3.314-2.197-5.304-2.197H36.85c-4.143,0-7.5,3.358-7.5,7.5V130.38H7.5c-4.142,0-7.5,3.358-7.5,7.5v29.349
                        c0,18.485,13.78,33.523,30.719,33.523h141.334c16.938,0,30.717-15.039,30.717-33.523V61.556
                        C202.77,61.303,202.756,61.052,202.732,60.803z M150.732,27.624l26.439,26.44h-26.439V27.624z M15,167.229V145.38h126.336v21.849
                        c0,6.844,1.893,13.213,5.131,18.523H30.719C22.052,185.753,15,177.443,15,167.229z M172.053,185.753
                        c-8.666,0-15.717-8.31-15.717-18.523V137.88c0-4.142-3.357-7.5-7.5-7.5H44.35V17.017h91.383v44.547c0,4.142,3.357,7.5,7.5,7.5
                        h44.537v98.166C187.77,177.443,180.719,185.753,172.053,185.753z" />
                    </svg>
                </a>
            </div>
            <div class="nav-item">
                <a href="profilforme.php">
                    <svg class="svg-icon" style="width: 25; height: 25;vertical-align: middle;fill: white;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 1024v-72.874521c0-149.917478 93.497315-353.841814 241.330575-402.948929l9.031614-2.998349 4.497524 8.117483a316.618401 316.618401 0 0 0 33.201237 48.485506l10.567354 12.688138-16.088705 4.387828c-118.178851 32.579628-201.986378 215.917734-206.88612 332.341454h872.519723c-4.899742-116.387154-99.457449-299.834957-217.6363-332.341454l-16.088705-4.387828 10.457658-12.578442a316.874358 316.874358 0 0 0 33.201237-48.485507l4.497524-8.117483 8.921918 2.888654c147.979521 49.107115 252.300146 252.994886 252.300147 402.948929V1024H0z m511.91334-365.652386a246.888491 246.888491 0 0 1-255.95667-255.95667V256.129989a246.888491 246.888491 0 0 1 255.95667-255.95667 246.888491 246.888491 0 0 1 255.956671 255.95667v146.260955a246.888491 246.888491 0 0 1-255.956671 255.95667z m182.826193-402.217625A182.826193 182.826193 0 1 0 329.087147 256.129989v146.260955a182.826193 182.826193 0 1 0 365.652386 0V256.129989z" />
                    </svg>
                </a>
            </div>
        </div>
    </nav>
</footer>
</html>
 