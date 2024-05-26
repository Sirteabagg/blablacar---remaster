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
            $requetedriver = $bdd->prepare("SELECT idDriver, registration FROM driver WHERE email = :email");
            $requetedriver->bindParam(':email', $email);
            $requetedriver->execute();
            $donnee = $requetedriver->fetch(PDO::FETCH_ASSOC);

            if($donnee){
                $driver=$donnee['idDriver'];
                $car=$donnee['registration'];                
                if(!$car){
                    $stmt = $bdd->prepare("INSERT INTO car (registration, color, model, brand, places) VALUES (:registration, :color, :model, :brand, :places)");
                    $stmt->bindParam(':brand', $brand);
                    $stmt->bindParam(':model', $model);
                    $stmt->bindParam(':color', $color);
                    $stmt->bindParam(':registration', $registration);
                    $stmt->bindParam(':places', $places);
                    $stmt->execute();
                    $ajoutvoiture=$bdd->prepare("UPDATE driver SET registration='$registration' WHERE idDriver=$driver");
                    $ajoutvoiture->execute();
                    
                } 
                header("Location: prefform.php");
                exit();                    
            }            
        }

        if (isset($_POST['idpermis'])) {
            $idpermis = $_POST['idpermis'];
           
            // Vérifiez si une ligne existe pour cet email dans les permis
            $stmt = $bdd->prepare("SELECT idpermis FROM permis WHERE iduser = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $permis = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($permis) {
                // Mettre à jour le permis existant
                $stmt = $bdd->prepare("UPDATE permis SET idpermis = :idpermis WHERE iduser = :email");
            } else {
                // Insérer une nouvelle ligne pour le permis
                $stmt = $bdd->prepare("INSERT INTO permis (iduser, idpermis) VALUES (:email, :idpermis)");
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
            $stmt = $bdd->prepare("SELECT idpermis FROM permis WHERE iduser = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $permis = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($permis) {
                // Mettre à jour la photo de permis existante
                $stmt = $bdd->prepare("UPDATE permis SET photopermis = :photopermis WHERE iduser = :email");
            } else {
                // Insérer une nouvelle ligne pour la photo de permis
                $stmt = $bdd->prepare("INSERT INTO permis (iduser, photopermis) VALUES (:email, :photopermis)");
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
    $stmt = $bdd->prepare("SELECT brand, model, color, c.registration, places FROM car c JOIN driver d ON c.registration=d.registration WHERE idDriver = :idDriver");
    $stmt->bindParam(':idDriver', $idDriver);
    $stmt->execute();
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupération du numéro de permis de l'utilisateur
    $stmt = $bdd->prepare("SELECT idpermis FROM permis WHERE iduser = :email");
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

</html>
