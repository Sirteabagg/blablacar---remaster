<?php
// Vérifie si des données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les champs "nom", "prenom", "email" et "tel" ont été soumis
    var_dump($_POST);
    if (isset($_POST["date"], $_POST["heure"],$_POST["depart"], $_POST["arriver"], $_POST["nbpassager"], $_POST["prix"])) {
        $date = $_POST["date"];
        $heure = $_POST["heure"];
        $adressdep = $_POST["depart"];
        $adressarr = $_POST["arriver"];
        $nbpassager = $_POST["nbpassager"];
        $prix = $_POST["prix"];
 
            try {
            // Connexion à la base de données
            $connexion = new PDO('mysql:host=localhost;dbname=blablaomnes; charset=utf8', 'root', '');

            // Définir le mode d'erreur de PDO sur exception
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête SQL préparée
            $requete = $connexion->prepare("INSERT INTO TripInfo (dates, time, idDep, idArr, nbpasseger, nbplacedis, prix) VALUES (:dates, :heure, :adressdep, :adressarr, :nbplace, :nbplacedis, :prix)");

            // Liaison des valeurs des paramètres
            $requete->bindParam(':dates', $date);
            $requete->bindParam(':heure', $heure);
            $requete->bindParam(':adressdep', $adressdep);
            $requete->bindParam(':adressarr', $adressarr);
            $requete->bindParam(':nbplace', $nbpassager);
            $requete->bindParam(':nbplacedis', $nbpassager);
            $requete->bindParam(':prix', $prix);

            // Exécution de la requête
            $requete->execute();

            echo "Données insérées avec succès !";
            } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            }

        // Fermer la connexion
        $connexion = null;
        
        header("Location: congrat-page.php");
        exit;
    }
     else {
        echo "Les champs 'date', 'heure', 'arriver', 'depart', 'nbpassager' n'ont pas été soumis.";
    }
}


?>