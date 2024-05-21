<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les champs "nom", "prenom", "email" et "tel" ont été soumis
    if (isset($_POST["email"], $_POST["mdp"])) {
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];
        

        try {
            // Connexion à la base de données
            $connexion = new PDO('mysql:host=' . $host . ';dbname=blablaomnes; charset=utf8', 'root', $password);

            // Définir le mode d'erreur de PDO sur exception
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête SQL préparée
            $requete = $connexion->prepare("INSERT INTO utilisateur (email, mdp) VALUES ( :email, :mdp)");

            // Liaison des valeurs des paramètres
            $requete->bindParam(':email', $email);
            $requete->bindParam(':mdp', $mdp);
            // Exécution de la requête
            $requete->execute();

            echo "Données insérées avec succès !";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // Fermer la connexion
        $connexion = null;
    } else {
        echo "Les champs 'nom' n'ont pas été soumis.";
    }
}

header("Location: info.php");
exit;
