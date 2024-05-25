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

    // Si le formulaire est soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mise à jour des préférences de voyage de l'utilisateur
        if (isset($_POST['pref1'])) {
            $pref1 = $_POST['pref1'];
            $pref2 = $_POST['pref2'];
            $pref3 = $_POST['pref3'];
            $pref4 = $_POST['pref4'];

            // Vérifiez si une ligne existe pour cet email dans les préférences
            $stmt = $bdd->prepare("SELECT idPref FROM preferences WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Mettre à jour les préférences de l'utilisateur existant
                $stmt = $bdd->prepare("UPDATE preferences SET pref1 = :pref1, pref2 = :pref2, pref3 = :pref3, pref4 = :pref4 WHERE email = :email");
            } else {
                // Insérer une nouvelle ligne pour l'utilisateur
                $stmt = $bdd->prepare("INSERT INTO preferences (email, pref1, pref2, pref3, pref4) VALUES (:email, :pref1, :pref2, :pref3, :pref4)");
            }

            $stmt->bindParam(':pref1', $pref1);
            $stmt->bindParam(':pref2', $pref2);
            $stmt->bindParam(':pref3', $pref3);
            $stmt->bindParam(':pref4', $pref4);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Rediriger vers la page prefform.php après la mise à jour
            header("Location: prefform.php");
            exit();
        }

        // Mise à jour des informations du véhicule
        if (isset($_POST['brand'])) {
            $brand = $_POST['brand'];
            $model = $_POST['model'];
            $color = $_POST['color'];
            $registration = $_POST['registration'];
            $places = $_POST['places'];

            // Vérifiez si une ligne existe pour cet email dans les véhicules
            $stmt = $bdd->prepare("SELECT email FROM car WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $car = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($car) {
                // Mettre à jour les informations du véhicule existant
                $stmt = $bdd->prepare("UPDATE car SET brand = :brand, model = :model, color = :color, registration = :registration, places = :places WHERE email = :email");
            } else {
                // Insérer une nouvelle ligne pour le véhicule
                $stmt = $bdd->prepare("INSERT INTO car (email, brand, model, color, registration, places) VALUES (:email, :brand, :model, :color, :registration, :places)");
            }

            $stmt->bindParam(':brand', $brand);
            $stmt->bindParam(':model', $model);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':registration', $registration);
            $stmt->bindParam(':places', $places);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Rediriger vers la page prefform.php après la mise à jour
            header("Location: prefform.php");
            exit();
        }

        if (isset($_POST['idpermis'])) {
            $idpermis = $_POST['idpermis'];
           
            // Vérifiez si une ligne existe pour cet email dans les permis
            $stmt = $bdd->prepare("SELECT idpermis FROM permis WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $permis = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($permis) {
                // Mettre à jour le permis existant
                $stmt = $bdd->prepare("UPDATE permis SET idpermis = :idpermis WHERE email = :email");
            } else {
                // Insérer une nouvelle ligne pour le permis
                $stmt = $bdd->prepare("INSERT INTO permis (email, idpermis) VALUES (:email, :idpermis)");
            }

            $stmt->bindParam(':idpermis', $idpermis);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Rediriger vers la page prefform.php après la mise à jour
            header("Location: prefform.php");
            exit();
        }

        if (isset($_FILES['photopermis']) && $_FILES['photopermis']['error'] === UPLOAD_ERR_OK) {
            // Chemin temporaire du fichier téléchargé
            $tmpFilePath = $_FILES['photopermis']['tmp_name'];

            // Lire le contenu du fichier
            $permisContent = file_get_contents($tmpFilePath);

            // Vérifiez si une ligne existe pour cet email dans la table permis
            $stmt = $bdd->prepare("SELECT email FROM permis WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $permis = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($permis) {
                // Mettre à jour la photo de permis existante
                $stmt = $bdd->prepare("UPDATE permis SET photopermis = :photopermis WHERE email = :email");
            } else {
                // Insérer une nouvelle ligne pour la photo de permis
                $stmt = $bdd->prepare("INSERT INTO permis (email, photopermis) VALUES (:email, :photopermis)");
            }

            $stmt->bindParam(':photopermis', $permisContent, PDO::PARAM_LOB);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Redirection après l'envoi réussi
            header("Location: prefform.php");
            exit();
        }
    }

    // Récupération des préférences de voyage de l'utilisateur
    $stmt = $bdd->prepare("SELECT pref1, pref2, pref3, pref4 FROM preferences WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $preferences = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$preferences) {
        // Si l'utilisateur n'a pas encore de préférences, définir des valeurs par défaut
        $preferences = [
            'pref1' => '',
            'pref2' => '',
            'pref3' => '',
            'pref4' => ''
        ];
    }

    // Récupération des informations du véhicule de l'utilisateur
    $stmt = $bdd->prepare("SELECT brand, model, color, registration, places FROM car WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$car) {
        // Si l'utilisateur n'a pas encore d'informations de véhicule, définir des valeurs par défaut
        $car = [
            'brand' => '',
            'model' => '',
            'color' => '',
            'registration' => '',
            'places' => ''
        ];
    }

    // Récupération du numéro de permis de l'utilisateur
    $stmt = $bdd->prepare("SELECT idpermis FROM permis WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $permis = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$permis) {
        // Si l'utilisateur n'a pas encore de numéro de permis, définir une valeur par défaut
        $permis = ['idpermis' => ''];
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style-main-structure.css">
    <link rel="stylesheet" href="../styles/prefform.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../scripts/prefform.js" defer></script>
    <title>Document</title>
</head>

<body>
    <div class="header-container">
        <a href="profilforme.php">
            <div class="arrow">&lt;</div>
        </a>
        <h1 class="titre">Conducteur</h1>
    </div>
    <div class="menu">
        <div class="itemss">Infos véhicule
            <div class="fleche">&#9660;</div>
            <div class="content">
                <form action="" method="post">
                    <div class="grid">
                        <div class="case"><label for="brand">Marque :</label><input type="text" placeholder="Peugeot" name="brand" class="form-input" value="<?php echo htmlspecialchars($car['brand'] ?? ''); ?>"></div>
                        <div class="case"><label for="model">Modèle :</label><input type="text" placeholder="3008" name="model" class="form-input" value="<?php echo htmlspecialchars($car['model'] ?? ''); ?>"></div>
                        <div class="case"><label for="color">Couleur :</label><input type="text" placeholder="Blanc" name="color" class="form-input" value="<?php echo htmlspecialchars($car['color'] ?? ''); ?>"></div>
                        <div class="case"><label for="registration">Immatriculation :</label><input type="text" placeholder="FN-911-HK" name="registration" class="form-input" value="<?php echo htmlspecialchars($car['registration'] ?? ''); ?>"></div>
                        <div class="case"><label for="places">Places :</label><input type="number" inputmode="numeric" placeholder="1" name="places" class="form-input" value="<?php echo htmlspecialchars($car['places'] ?? ''); ?>"></div>
                        <input type="submit" class="button-submit" value="Sauvegarder">
                    </div>
                </form>
            </div>
        </div>
        <div class="itemss">Préférences de voyage
            <div class="fleche2">&#9660;</div>
            <div class="content2">
                <form action="" method="post">
                    <div class="grid">
                        <div class="case"><label for="pref1">Discussion :</label><input type="text" placeholder="Je suis discret" name="pref1" value="<?php echo htmlspecialchars($preferences['pref1'] ?? ''); ?>"></div>
                        <div class="case"><label for="pref2">Cigarette :</label><input type="text" placeholder="Non" name="pref2" value="<?php echo htmlspecialchars($preferences['pref2'] ?? ''); ?>"></div>
                        <div class="case"><label for="pref3">Musique :</label><input type="text" placeholder="Oui" name="pref3" value="<?php echo htmlspecialchars($preferences['pref3'] ?? ''); ?>"></div>
                        <div class="case"><label for="pref4">Animaux :</label><input type="text" placeholder="Non" name="pref4" value="<?php echo htmlspecialchars($preferences['pref4'] ?? ''); ?>"></div>
                        <input type="submit" class="button-submit" value="Sauvegarder">
                    </div>
                </form>
            </div>
        </div>
        <div class="itemss">
            <form action="" method="post">
                <div>N°Permis</div>
                <div>&gt;</div>
                <div class="case"><label for="idpermis">N° :</label><input type="text" placeholder="12345678" name="idpermis" value="<?php echo htmlspecialchars($permis['idpermis'] ?? ''); ?>"></div>
                <input type="submit" class="button-submit" value="Sauvegarder">
            </form>
        </div>
        <div class="itemss">
            <form action="" method="post" enctype="multipart/form-data">
                <label for="photopermis">Photo permis de conduire :</label>
                <input type="file" name="photopermis">
                <input type="submit" name="upload" value="Uploader">
            </form>
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
