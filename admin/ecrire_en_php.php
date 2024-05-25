<?php


if (isset($_POST["Ville"], $_POST["Adresse"])) {
    $Ville = $_POST["Ville"];
    $Adresse = $_POST["Adresse"];
}

try {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');

    // Définir le mode d'erreur de PDO sur exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL préparée
    $requete = $bdd->prepare("INSERT INTO campus (city, address) VALUES (:valeur1, :valeur2)");

    // Liaison des valeurs des paramètres
    $requete->bindParam(':valeur1', $Ville);
    $requete->bindParam(':valeur2', $Adresse);
 

    // Exécution de la requête
    $requete->execute();


} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fermer la connexion
$connexion = null;

header("Location: ../admin/page_campus.php");
exit;
?>
