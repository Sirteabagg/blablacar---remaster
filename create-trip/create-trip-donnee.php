<!-- page qui permet de transmettre les donnees de la page create trip à la base de donnee  -->

<?php
require "../php/config.php";
session_start();
$email = $_SESSION["current-user-email"];
// Vérifie si des données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les champs "nom", "prenom", "email" et "tel" ont été soumis

    if (isset($_POST["date"], $_POST["heure"], $_POST["depart"], $_POST["arriver"], $_POST["nbpassager"], $_POST["prix"], $_POST["depCamp"], $_POST["temps"])) {
        $date = $_POST["date"];
        $heure = $_POST["heure"];
        $adressdep = $_POST["depart"];
        $adressarr = $_POST["arriver"];
        $nbpassager = $_POST["nbpassager"];
        $prix = $_POST["prix"];
        $passed = 0;
        $temps = $_POST["temps"];



        $requeteIdDriver = $bdd->query("SELECT idDriver FROM Driver d JOIN user u on u.email = d.email WHERE d.email = '$email'");
        $idDriver = $requeteIdDriver->fetch()["idDriver"];

        try {
            // $ajoutDep =
            // Requête SQL préparée
            $requete = $bdd->prepare("INSERT INTO TripInfo (dates, timeDepart, idDep, idArr, idDriver, passed, price) VALUES (:dates, :heure, :adressdep, :adressarr, :idDriver, :passed, :prix)");

            // Liaison des valeurs des paramètres
            $requete->bindParam(':dates', $date, PDO::PARAM_STR);
            $requete->bindParam(':heure', $heure);
            $requete->bindParam(':adressdep', $adressdep);
            $requete->bindParam(':adressarr', $adressarr);
            //$requete->bindParam(':nbplace', $nbpassager);
            $requete->bindParam(':prix', $prix);
            $requete->bindParam(':idDriver', $idDriver);
            $requete->bindParam(':passed', $passed);

            // Exécution de la requête
            $requete->execute();

            echo "Données insérées avec succès !";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        // Fermer la connexion
        $bdd = null;

        header("Location: congrat-page.php");
        exit;
    } else {
        echo "Les champs 'date', 'heure', 'arriver', 'depart', 'nbpassager' n'ont pas été soumis.";
    }
}
