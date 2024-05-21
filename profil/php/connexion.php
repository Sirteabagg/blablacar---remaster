<?php
session_start();

$systeme_exploitation = PHP_OS;

if (strpos($systeme_exploitation, 'Darwin') !== false) {
    if (!isset($_SESSION["passwordBdd"], $_SESSION["hostBdd"])) {
        $_SESSION["passwordBdd"] = "root";
        $_SESSION["hostBdd"] = "127.0.0.1";
    }
} elseif (strpos($systeme_exploitation, 'WIN') !== false) {
    if (!isset($_SESSION["passwordBdd"], $_SESSION["hostBdd"])) {
        $_SESSION["passwordBdd"] = "";
        $_SESSION["hostBdd"] = "localhost";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    
    try {
        // Connexion à la base de données avec PDO
        $connexion = new PDO('mysql:host=' . $host . ';dbname=blablaomnes; charset=utf8', 'root', $password);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer et exécuter la requête SQL
        $stmt = $connexion->prepare("SELECT mdp FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);

        // Vérifier si l'utilisateur existe
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['mdp'];

            // Vérifier le mot de passe
            if (password_verify($mdp, $hashed_password)) {
                $_SESSION['email'] = $email;
                header("Location: trip-description.php");
                exit();
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Utilisateur non trouvé.";
        }

    } catch (PDOException $e) {
        die("Échec de la connexion : " . $e->getMessage());
    }
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style-main-structure.css">
    <link rel="stylesheet" href="../styles/connexionstyle.css">
</head>

<body>
    <h1 class="titre">Bienvenue</h1>
    <form action="connexion.php" method="post">
        <input type="text" placeholder="Email" name="email" class="form-input">
        <input type="password" placeholder="Mot de passe" name="mdp" class="form-input">
        <input type="submit" class="button-submit" value="Se connecter">
    </form>
    <a href="create.php"><input type="submit" class="button-submit" value="Créer un compte"></a>
    <div class="img">
        <img src="../../images/logoblabla.png" width="275" height="320">
    </div>
</body>
</html>