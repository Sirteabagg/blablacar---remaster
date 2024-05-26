
<!-- cette page permet d'effacer les données d'un utilisateur -->
<?php

require "../php/config.php";




if (isset($_POST["boutonpermis"])) {
  $boutonpermis = $_POST["boutonpermis"];

  // si le bouton est banni alors,  d'effacer les données d'un utilisateur 
  if ($boutonpermis == "bannir") {

    if (isset($_POST["email"])) {
      $email = $_POST["email"];

      $reponseDr = $bdd->query("SELECT idDriver FROM Driver WHERE email='$email'");
      $userDriver = $reponseDr->fetch();
      $userDriver = $userDriver["idDriver"];

      if ($userDriver) {
        $deleteTrip = $bdd->prepare("DELETE FROM Trip WHERE idDriver = $userDriver");
        $deleteTrip->execute();
        $deleteDriver = $bdd->prepare("DELETE FROM Driver WHERE idDriver = $userDriver");
        $deleteDriver->execute();
      }

      $reponsePa = $bdd->query("SELECT idPassenger FROM Passenger WHERE email='$email'");
      $userPass = $reponseDr->fetch();
      $userPass = $userPass["idPassenger"];
      if ($userPass) {
        $deletePass = $bdd->prepare("DELETE FROM Passenger WHERE idDriver = $userDriver");
        $deletePass->execute();
      }

      $reponse = $bdd->prepare("DELETE FROM user WHERE email = '$email'");
      // On affiche chaque entr´ee une `a une
      $reponse->execute();

      header("Location: ../admin/page_utilisateur.php");
      exit;
    }
  }
  // si l'admin veut voir les info de la personne 
  if ($boutonpermis == "information") {
    $email = $_POST["email"];
    // Requête SQL pour mettre à jour la photo pour l'email spécifié

    $sql = "SELECT * FROM user WHERE email =  :email";

    // Préparation de la requête
    $stmt = $bdd->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':email', $email);


    // Exécution de la requête
    $stmt->execute();
  }
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

// code pour mettre le photo 
    $contenu_image = $donnees['pdp'];
    $type_mime = 'image/jpeg'; // Remplacez par le type MIME de votre image si nécessaire
    $encoded_image = base64_encode($contenu_image);
    $image_data = "data:$type_mime;base64,$encoded_image";
    echo "<img src=\"$image_data\" class='img-user' alt=\"Image\">";
  }
}


              


?>







<form method="post" action="page_utilisateur.php" class="listepermis ">

  <input type="submit" name="boutonpermis" value="retour" class="selection titre1">


</form>