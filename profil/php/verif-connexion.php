<?php

session_start();
$host = $_SESSION["hostBdd"];
$passwordBdd = $_SESSION["passwordBdd"];

// Vérifie si des données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les champs "nom", "prenom", "email" et "tel" ont été soumis
    if (isset($_POST["email"], $_POST["mdp"])) {
        $email = $_POST["email"];
        $password = $_POST["mdp"];
        try {
            // Connexion à la base de données
            $connexion = new PDO('mysql:host=' . $host . ';dbname=blablaomnes; charset=utf8', 'root', $passwordBdd);

            // Définir le mode d'erreur de PDO sur exception
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête SQL préparée
            $requete = $connexion->query("SELECT u.email AS email, u.pwd as pwd, u.nom as nom FROM `User` u");
            echo $password;
            while ($donnee = $requete->fetch()) {
                echo $donnee["pwd"];
                echo "<br>";
                echo $donnee["email"];
                if ($email == $donnee["email"]) {
                    if ($password == $donnee["pwd"]) {
                        $_SESSION["current-user-name"] = $donnee["nom"];
                        $_SESSION["current-user-email"] = $donnee["email"];
                        header("Location: ../../trip-finding/php/trip-ressources/trip-form.php");
                        exit;
                    } else {
                        header("Location: connexion.php");
                        exit;
                    }
                }
            }
            header("Location: connexion.php");
            exit;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // Fermer la connexion
        $connexion = null;
    } else {
        echo "Les champs 'nom', 'prenom', 'email', 'tel' n'ont pas été soumis.";
    }
}


?>

<p>test</p>