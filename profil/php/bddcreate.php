<?php
session_start();
$host = $_SESSION["hostBdd"];
$passwordBdd = $_SESSION["passwordBdd"];

// Vérifie si les champs "nom", "prenom", "email" et "tel" ont été soumis
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

        // Requête SQL préparée
        $requete = $connexion->prepare("INSERT INTO user (email, nom, prenom, pwd) VALUES ( :email, :nom, :prenom, :mdp)");
        $requeteUser = $connexion->query("SELECT email FROM user");

        while ($donnee = $requeteUser->fetch()) {
            if ($donnee["email"] == $email) {
                header("Location: create.php");
                exit;
            }
        }

        // Liaison des valeurs des paramètres
        $requete->bindParam(':email', $email);
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':prenom', $prenom);
        $requete->bindParam(':mdp', $mdp);
        // Exécution de la requête
        $requete->execute();

        $_SESSION["current-user-name"] = $donnee["nom"];
        $_SESSION["current-user-email"] = $donnee["email"];
        header("Location: info.php");
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        header("Location: create.php");
    }

    // Fermer la connexion
    $connexion = null;
} else {
    echo "Les champs 'nom' n'ont pas été soumis.";
}
exit;
