<?php

require "../php/config.php";


if (isset($_POST["boutonpermis"])) {
  $boutonpermis1 = $_POST["boutonpermis"];


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
    }
    ?>
    <form method="post" action="page_permis.php" class="listepermis ">

      <input type="submit" name="boutonpermis" value="retour" class="selection titre1">


    </form>
<?php
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