<?php
require "../../php/config.php";

session_start();

// Fonction de validation de l'email
function validate_email($email) {
    $pattern = '/^[a-zA-Z0-9._%+-]+@(edu\.ece\.fr|omnesintervenant\.fr)$/';
    return preg_match($pattern, $email);
}

// Vérifie si les champs "email", "nom", "prenom" et "mdp" ont été soumis
if (isset($_POST["email"], $_POST["nom"], $_POST["prenom"], $_POST["mdp"])) {
    $email = $_POST["email"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mdp = $_POST["mdp"];

    // Vérifie si l'email est valide
    if (!validate_email($email)) {
        header("Location: create.php");
        exit;
    }
    

    $mdp_crypted = password_hash($mdp, PASSWORD_DEFAULT);

    try {
        // Vérifier si l'utilisateur existe déjà
        $requeteUser = $bdd->prepare("SELECT email FROM user WHERE email = :email");
        $requeteUser->bindParam(':email', $email);
        $requeteUser->execute();

        if ($requeteUser->rowCount() > 0) {
            header("Location: create.php");
            exit;
        }

        // Requête SQL préparée pour l'insertion
        $requete = $bdd->prepare("INSERT INTO user (email, nom, prenom, pwd) VALUES (:email, :nom, :prenom, :mdp)");

        // Liaison des valeurs des paramètres
        $requete->bindParam(':email', $email);
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':prenom', $prenom);
        $requete->bindParam(':mdp', $mdp_crypted);

        // Exécution de la requête
        $requete->execute();

        $_SESSION["current-user-name"] = $nom;
        $_SESSION["current-user-email"] = $email;
        header("Location: connexion.php");
        exit;

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        header("Location: create.php");
        exit;
    }

    // Fermer la connexion
    $bdd = null;
} else {
    echo "Les champs 'email', 'nom', 'prenom' et 'mdp' n'ont pas été soumis.";
    exit;
}
?>
