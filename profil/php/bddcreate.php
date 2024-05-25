<?php
session_start();
$host = $_SESSION["hostBdd"];
$passwordBdd = $_SESSION["passwordBdd"];

// Vérifie si les champs "email", "nom", "prenom" et "mdp" ont été soumis
if (isset($_POST["email"], $_POST["nom"], $_POST["prenom"], $_POST["mdp"])) {
    $email = $_POST["email"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mdp = $_POST["mdp"];

    try {
        // Connexion à la base de données
        $connexion = new PDO('mysql:host=' . $host . ';dbname=blablaomnes; charset=utf8', 'root', $passwordBdd);

        // Définir le mode d'erreur de PDO sur exception
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

        // Redirection vers la page de connexion après succès
        header("Location: connexion.php");
        exit;
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

