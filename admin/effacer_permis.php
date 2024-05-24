<?php

$bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');
// Définir le mode d'erreur de PDO sur exception
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_POST["boutonpermis"])) {
    $boutonpermis1 = $_POST["boutonpermis"];
   
    
    if ($boutonpermis1 == "information") {
      $email = $_POST["email"];
     
      $nouvelle_photo = '../../images/petit_singe.jpg'; // Chemin vers la nouvelle photo à ajouter

      // Requête SQL pour mettre à jour la photo pour l'email spécifié
      $sql = "UPDATE permis SET photopermis = :nouvelle_photo WHERE iduser = :email";

      // Préparation de la requête
      $stmt = $bdd->prepare($sql);

      // Liaison des paramètres
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':nouvelle_photo', $nouvelle_photo);

      // Exécution de la requête
      $stmt->execute();

      echo "Photo mise à jour avec succès pour l'email $email.";
      
    }
    if ($boutonpermis1 == "télécharger") {
      $email = $_POST["email"];
     
     

      // Requête SQL pour mettre à jour la photo pour l'email spécifié
      $sql = "SELECT photopermis FROM permis WHERE iduser = :email";

      // Préparation de la requête
      $stmt = $bdd->prepare($sql);

      // Liaison des paramètres
      $stmt->bindParam(':email', $email);
    

      // Exécution de la requête
      $stmt->execute();
      $imageData = array();
      while ($donnees = $stmt->fetch()) {
        
            $trip = $donnees;
        
      }
      $contenu_image = $trip['photopermis'];
      $type_mime = 'image/jpeg'; // Remplacez par le type MIME de votre image si nécessaire
      $encoded_image = base64_encode($contenu_image);
      $imageData = "data:$type_mime;base64,$encoded_image";
      
      echo "<img src=\"$imageData\" class='img-user' alt=\"Image\">";
    

    
    }
    if ($boutonpermis1 == "supprimer") {
        
      $email = $_POST["email"];
      $reponse = $bdd->query("DELETE FROM permis WHERE iduser = '$email'");
      $donnees = $reponse->execute();
    }

    
    
}

?>