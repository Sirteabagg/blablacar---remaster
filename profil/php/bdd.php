<?php
// Vérifie si des données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les champs "nom", "prenom", "email" et "tel" ont été soumis
    if (isset($_POST["nom"], $_POST["prenom"],$_POST["email"], $_POST["tel"])) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $tel = $_POST["tel"];

        try {
            // Connexion à la base de données
            $connexion = new PDO('mysql:host=localhost;dbname=blablaomnes; charset=utf8', 'root', '');

            // Définir le mode d'erreur de PDO sur exception
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête SQL préparée
            $requete = $connexion->prepare("INSERT INTO utilisateur (email, nom,  prenom, numerotel) VALUES ( :email, :nom, :prenom, :tel)");

            // Liaison des valeurs des paramètres
            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':email', $email);
            $requete->bindParam(':tel', $tel);

            // Exécution de la requête
            $requete->execute();

            echo "Données insérées avec succès !";
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // Fermer la connexion
        $connexion = null;
    } else {
        echo "Les champs 'nom', 'prenom', 'email', 'tel' n'ont pas été soumis.";
    }
}

header("Location: profilforme.php");
exit;
?>
