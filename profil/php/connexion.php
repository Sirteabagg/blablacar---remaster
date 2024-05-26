<?php
session_start();
//detection du système d'exploitation
$systeme_exploitation = PHP_OS;

if (strpos($systeme_exploitation, 'Darwin') !== false) {
    if (!isset($_SESSION["passwordBdd"], $_SESSION["hostBdd"])) { // Défini le mot de passe de la base de données pour macOS
        $_SESSION["passwordBdd"] = "root";
        $_SESSION["hostBdd"] = "127.0.0.1";
    }//mac
} elseif (strpos($systeme_exploitation, 'WIN') !== false) {
    if (!isset($_SESSION["passwordBdd"], $_SESSION["hostBdd"])) { // Défini le mot de passe de la base de données pour windows -->localhost
        $_SESSION["passwordBdd"] = ""; 
        $_SESSION["hostBdd"] = "localhost";
    }//windows
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style-main-structure.css"> // lien du css pricipal
    <link rel="stylesheet" href="../styles/connexionstyle.css">
</head>

<body>
    <h1 class="titre">Bienvenue</h1>
    <form action="verif-connexion.php" method="post"> // methode post
        <input type="text" placeholder="Email" name="email" class="form-input">
        <input type="password" placeholder="Mot de passe" name="mdp" class="form-input">
        <input type="submit" class="button-submit" value="Se connecter">
    </form>
    <a href="create.php"><input type="submit" class="button-submit" value="Créer un compte"></a>  //lien vers créa compte
    <div class="img">
        <img src="../../images/logoblabla.png" width="275" height="320"> //logo
    </div>
</body>

</html>