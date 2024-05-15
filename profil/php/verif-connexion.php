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
            $requete = $connexion->query("SELECT u.email, u.password FROM `User` u");
            while ($donnee = $requete->fetch()) {
                if ($email == $donnee["email"]) {
                    if ($password == $donnee["password"]) {
                        header("Location: ../../trip-finding/trip-form.php");
                        exit;
                    } else {
                        header("Location: connexion.php");
                        exit;
                    }
                }
            }
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