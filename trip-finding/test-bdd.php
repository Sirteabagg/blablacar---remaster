<?php



$connexion = new PDO(
   "mysql:host=127.0.0.1;dbname=blablaomnes;charset=utf8",
   'root',
   'root'
);

// $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $reponse = $connexion->query('SELECT * FROM User');
// $donne = $reponse->fetch();

// echo $donne["email"];
// $reponse->closeCursor();

// $reponse = $connexion->query('SELECT * FROM Trip');
// $donne = $reponse->fetch();

// echo $donne["idTrip"];
// $reponse->closeCursor();

// $reponse = $connexion->query('SELECT * FROM User');
// $donne = $reponse->fetch();

// echo $donne["email"];
// $reponse->closeCursor();


// Requête SQL préparée
// $chemin_image = '../images/utilisateur.png';

// if ($chemin_image) {
//    // Lecture du contenu de l'image en tant que données binaires
//    $contenu_image = file_get_contents($chemin_image);

//    // Requête SQL préparée pour insérer l'image
//    $requete = $connexion->prepare("INSERT INTO User (email, nom, prenom,pdp) VALUES (:email,:nom, :prenom,:contenu)");

//    // Liaison des valeurs des paramètres
//    $requete->bindParam(':email', $email);
//    $requete->bindParam(':nom', $nom);
//    $requete->bindParam(':prenom', $prenom);
//    $requete->bindParam(':contenu', $contenu, PDO::PARAM_LOB);

//    // Assigner des valeurs aux paramètres
//    $email = 'azdazd';
//    $nom = 'zdadaz';
//    $prenom = 'azdazd';
//    $contenu = $contenu_image;

//    // Exécution de la requête
//    $requete->execute();

//    echo "Image insérée avec succès !";
// }


$requete = $connexion->query("SELECT * FROM User");
$resultat = $requete->fetch();

// // Afficher l'image
if ($resultat) {
   $contenu_image = $resultat['pdp'];
   $type_mime = 'image/jpeg'; // Remplacez par le type MIME de votre image si nécessaire
   $encoded_image = base64_encode($contenu_image);
   $image_data = "data:$type_mime;base64,$encoded_image";
   echo "<img src=\"$image_data\" alt=\"Image\">";
} else {
   echo "Image introuvable.";
}
