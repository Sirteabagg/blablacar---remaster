
<!-- cette page permet d'écrire les campus dans le base de donnee pour les admin  -->


<?php


if (isset($_POST["Ville"], $_POST["Adresse"])) {
    $Ville = $_POST["Ville"];
    $Adresse = $_POST["Adresse"];
}

try {
    require "../php/config.php";

    $AdresseModif = strtr($Adresse, ' ', '+');

    $url_api_adresse_dep = "https://api-adresse.data.gouv.fr/search/?q=$AdresseModif&limit=1";

    // Initialisation de CURL
    $curl_dep = curl_init();

    // Configuration de la requête CURL
    curl_setopt($curl_dep, CURLOPT_URL, $url_api_adresse_dep);
    curl_setopt($curl_dep, CURLOPT_RETURNTRANSFER, true);

    // Exécution de la requête CURL
    $response_dep = curl_exec($curl_dep);

    // Vérification des erreurs CURL
    if (curl_errno($curl_dep)) {
        echo 'Erreur CURL : ' . curl_error($curl_dep);
    } else {
        // Décoder la réponse JSON en un tableau associatif PHP
        $donnees_dep = json_decode($response_dep, true);
        // Vérifier si la réponse contient des données
        if (isset($donnees_dep['features']) && !empty($donnees_dep['features'])) {
            $depcity = $donnees_dep["features"][0]["properties"]["city"];
            $geometry = $donnees_dep['features'][0]['geometry'];
            $latitude = $geometry['coordinates'][1];
            $longitude = $geometry['coordinates'][0];
        } else {
            echo "Aucune adresse trouvée.";
        }
    }

    // Fermer la session CURL
    curl_close($curl_dep);

    // Définir le mode d'erreur de PDO sur exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL préparée
    $requete = $bdd->prepare("INSERT INTO campus (city, address, longitude, latitude) VALUES (:valeur1, :valeur2, :longitude, :latitude)");

    // Liaison des valeurs des paramètres
    $requete->bindParam(':valeur1', $Ville);
    $requete->bindParam(':valeur2', $Adresse);
    $requete->bindParam(':longitude', $longitude);
    $requete->bindParam(':latitude', $latitude);


    // Exécution de la requête
    $requete->execute();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fermer la connexion
$bdd = null;

header("Location: ../admin/page_campus.php");
exit;
