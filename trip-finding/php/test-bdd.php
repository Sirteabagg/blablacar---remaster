<?php


try {
   // Connexion à la base de données avec PDO
   $connexion = new PDO(
      "mysql:host=127.0.0.1;dbname=blablaomnes;charset=utf8",
      'root',
      'root'
   );


   //    // Définir le mode d'erreur PDO à exception
   //    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   //    // Données pour la mise à jour
   //    $email = 'jean.dupont@edu.ece.fr';
   //    $nouvelle_photo = '../../images/jean.jpeg'; // Chemin vers la nouvelle photo à ajouter

   //    // Requête SQL pour mettre à jour la photo pour l'email spécifié
   //    $sql = "UPDATE User SET pdp = :nouvelle_photo WHERE email = :email";

   //    // Préparation de la requête
   //    $stmt = $connexion->prepare($sql);

   //    // Liaison des paramètres
   //    $stmt->bindParam(':email', $email);
   //    $stmt->bindParam(':nouvelle_photo', $nouvelle_photo);

   //    // Exécution de la requête
   //    $stmt->execute();

   //    echo "Photo mise à jour avec succès pour l'email $email.";


   // Requête SQL préparée
   // }
   /////////////////////////////////////
   // RECUPERER L'IMAGE DEPUIS LA BDD //
   /////////////////////////////////////

   $requete = $connexion->query("SELECT * FROM User");

   while ($resultat = $requete->fetch()) {
      if ($resultat) {
         $contenu_image = $resultat['pdp'];
         $type_mime = 'image/jpeg'; // Remplacez par le type MIME de votre image si nécessaire
         $encoded_image = base64_encode($contenu_image);
         $image_data = "data:$type_mime;base64,$encoded_image";
         echo "<img src=\"$image_data\" alt=\"Image\">";
      } else {
         echo "Image introuvable.";
      }
   }
   // // Afficher l'image



   //    $chemin_image = '../../images/mamadou.jpeg';

   if ($chemin_image) {
      // Lecture du contenu de l'image en tant que données binaires
      $contenu_image = file_get_contents($chemin_image);

      $email = 'mamadou.amad@edu.ece.fr';

      // Requête SQL préparée pour insérer l'image
      $requete = $connexion->prepare("UPDATE User SET pdp = :contenu WHERE email = :email");

      // Liaison des valeurs des paramètres
      $requete->bindParam(':email', $email);
      $requete->bindParam(':contenu', $contenu, PDO::PARAM_LOB);

      // Assigner des valeurs aux paramètres
      $contenu = $contenu_image;

      // Exécution de la requête
      $requete->execute();

      echo "Image insérée avec succès !";
   } else {
      echo "proute";
   }
} catch (PDOException $e) {
   echo "Erreur : " . $e->getMessage();
}
