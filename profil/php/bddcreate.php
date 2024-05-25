<?php
require "../../php/config.php";

session_start();



// Vérifie si les champs "email", "nom", "prenom" et "mdp" ont été soumis
if (isset($_POST["email"], $_POST["nom"], $_POST["prenom"], $_POST["mdp"])) {
    $email = $_POST["email"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mdp = $_POST["mdp"];

    try {

        // Vérifier si l'utilisateur existe déjà
        $requeteUser = $connexion->prepare("SELECT email FROM user WHERE email = :email");
        $requeteUser->bindParam(':email', $email);
        $requeteUser->execute();


        if ($requeteUser->rowCount() > 0) {
            header("Location: create.php");
            exit;
        }

        // Requête SQL préparée pour l'insertion
        $requete = $connexion->prepare("INSERT INTO user (email, nom, prenom, pwd) VALUES (:email, :nom, :prenom, :mdp)");

        // Liaison des valeurs des paramètres
        $requete->bindParam(':email', $email);
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':prenom', $prenom);
        $requete->bindParam(':mdp', $mdp);

        // Exécution de la requête
        $requete->execute();

        $_SESSION["current-user-name"] = $donnee["nom"];
        $_SESSION["current-user-email"] = $donnee["email"];
        header("Location: connexion.php");
      
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        header("Location: create.php");
        exit;
    }

    // Fermer la connexion
    $connexion = null;
} else {
    echo "Les champs 'email', 'nom', 'prenom' et 'mdp' n'ont pas été soumis.";
    exit;
}

