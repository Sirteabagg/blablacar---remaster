
<!-- Cette pages récupère les donnée des différents boutons de la page permis  -->

<?php

require "../php/config.php";


if (isset($_POST["boutonpermis"])) {
  $boutonpermis1 = $_POST["boutonpermis"];

// cette partie permet de lire les info de l'utilisateur
  if ($boutonpermis1 == "information") {
    $email = $_POST["email"];
    // Requête SQL pour mettre à jour la photo pour l'email spécifié

    $sql = "SELECT * FROM user WHERE email =  :email";

    // Préparation de la requête
    $stmt = $bdd->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':email', $email);


    // Exécution de la requête
    $stmt->execute();
    // On affiche chaque entr´ee une `a une
    while ($donnees = $stmt->fetch()) {


?>
      <p>
        Nom : <?php echo  $donnees['nom']; ?>,<br>
        Prenom : <?php echo $donnees['prenom']; ?>,<br>
        email : <?php echo $donnees['email']; ?><br>
        numerotel : <?php echo  $donnees['numerotel']; ?>,<br>
        notegenerale : <?php echo $donnees['notegenerale']; ?>,<br>
        caption : <?php echo $donnees['caption']; ?><br>
      </p>
    <?php
    $contenu_image = $donnees['pdp'];
    $type_mime = 'image/jpeg'; // Remplacez par le type MIME de votre image si nécessaire
    $encoded_image = base64_encode($contenu_image);
    $image_data = "data:$type_mime;base64,$encoded_image";
    echo "<img src=\"$image_data\" class='img-user' alt=\"Image\">";
    }
    ?>
    <form method="post" action="page_permis.php" class="listepermis ">

      <input type="submit" name="boutonpermis" value="retour" class="selection titre1">


    </form>
  <?php
  }


// cette partie permet de lire les le permis du conducteur
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

    // Exécution de la requête
    // $stmt->execute();
    while ($donnees = $stmt->fetch()) {

      $trip = $donnees;
    }
    // code pour mettre le photo 
    $imageData = array();
    $contenu_image = $trip['photopermis'];
    $type_mime = 'image/jpeg'; // Remplacez par le type MIME de votre image si nécessaire
    $encoded_image = base64_encode($contenu_image);
    $imageData = "data:$type_mime;base64,$encoded_image";

    echo "<img src=\"$imageData\" class='img-user' alt=\"Image\">";

  ?>
    <form method="post" action="page_permis.php" class="listepermis ">

      <input type="submit" name="boutonpermis" value="retour" class="selection titre1">


    </form>
<?php


  }
  // cette partie permet de valider le permis du conducteur
  if ($boutonpermis1 == "valider") {

    $email = $_POST["email"];
    $reponse = $bdd->query("UPDATE permis SET validation = 1 WHERE iduser = '$email'");
    $donnees = $reponse->execute();
    $permis = 1;
    $null = NULL;

    $requete = $bdd->prepare("INSERT INTO driver ( permis,iban,registration,email) VALUES ( :valeur2,:valeur3, :valeur4,:valeur5)");

    // Liaison des valeurs des paramètres
    $requete->bindParam(':valeur2', $permis);
    $requete->bindParam(':valeur3', $null);
    $requete->bindParam(':valeur4', $null);
    $requete->bindParam(':valeur5', $email);
  
 

    // Exécution de la requête
    $requete->execute();

    header("Location: ../admin/page_permis.php");
    exit;
  }

  // cette partie permet de supprimer les données du conducteur
  if ($boutonpermis1 == "supprimer") {

    $email = $_POST["email"];
    $reponse = $bdd->query("DELETE FROM premis WHERE email = '$email'");
    $donnees = $reponse->execute();
    

    header("Location: ../admin/php/page_permis.php");
    exit;
  }
}
?>