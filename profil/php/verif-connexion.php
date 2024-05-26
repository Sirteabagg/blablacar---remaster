<?php



require "../../php/config.php";

session_start();


// Vérifie si des données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les champs "nom", "prenom", "email" et "tel" ont été soumis
    if (isset($_POST["email"], $_POST["mdp"])) {
        $email = $_POST["email"];
        $password = $_POST["mdp"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {

            $request = $bdd->query("SELECT email, nom, pwd FROM User WHERE email = '$email'");
            $user = $request->fetch();

            if (!empty($user)) {
                if (password_verify($password, $user["pwd"])) {

                    $_SESSION["current-user-name"] = $user["nom"];
                    $_SESSION["current-user-email"] = $user["email"];

                    if ($user["nom"] == "admin") {
                        header("Location: ../../admin/admin_acceuil.php");
                    } else {
                        header("Location: ../../trip-finding/php/trip-ressources/trip-form.php");
                    }
                } else {
                    header("Location: connexion.php");
                }
            } else {
                header("Location: connexion.php");
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // Fermer la connexion
        $connexion = null;
        exit;
    } else {
        echo "Les champs 'nom', 'prenom', 'email', 'tel' n'ont pas été soumis.";
    }
}
