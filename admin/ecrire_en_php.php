<?php

try {
    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');

    // Définir le mode d'erreur de PDO sur exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL préparée
    $requete = $bdd->prepare("INSERT INTO utilisateur (email, nom, prenom,numerotel) VALUES (:valeur1, :valeur2,:valeur3,:valeur4)");

    // Liaison des valeurs des paramètres
    $requete->bindParam(':valeur1', $valeur1);
    $requete->bindParam(':valeur2', $valeur2);
    $requete->bindParam(':valeur3', $valeur3);
    $requete->bindParam(':valeur4', $valeur4);
   

    // Assigner des valeurs aux paramètres
    $valeur1 = 'aaa@aaa';
    $valeur2 = 'Koci';
    $valeur3 = 'Val';
    $valeur4 = '066666';
   

    // Exécution de la requête
    $requete->execute();

    echo "Données insérées avec succès !";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fermer la connexion
$connexion = null;
?>
