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
                </div>
            </div>
        </a>
        <div class="portefeuille">
            <h4>Mon Portefeuille : 30€</h4>
        </div>
        <div class="menu">
            <a href="info.php">
                <div class="itemss grid-container">Mes infos personnelles<div>&gt</div>
                </div>
            </a>
            <a href="prefform.php">
                <div class="itemss grid-container">Mes infos conducteur<div>&gt</div>
                </div>
            </a>
            <a href="connexion.php">
                <div class="itemss grid-container">Déconnexion<div>&gt</div>
                </div>
            </a>
        </div>
    </div>
    <?php
    require "../../php/footer.php";
    ?>
</body>