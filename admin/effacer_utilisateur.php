<?php

$bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');
// Définir le mode d'erreur de PDO sur exception
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



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
while ($donnees = $stmt->fetch()){
    
    
      ?>
      <p>
      Nom : <?php echo  $donnees['nom'] ; ?>,<br>
      Prenom : <?php echo $donnees['prenom']; ?>,<br>
      email : <?php echo $donnees['email']; ?><br>
      numerotel : <?php echo  $donnees['numerotel'] ; ?>,<br>
      notegenerale : <?php echo $donnees['notegenerale']; ?>,<br>
      caption : <?php echo $donnees['caption']; ?><br>
      </p>
      <?php
  }
  ?>
  <form method="post" action="page_utilisateur.php" class="listepermis ">
   
         <input type="submit" name="boutonpermis" value="retour" class="selection titre1">
        
   
  </form>
  <?php
  }



  
  if ($boutonpermis1 == "bannir") {
      
    if (isset($_POST["email"])) {
      $email = $_POST["email"];
    
    
      $reponse = $bdd->query("DELETE FROM user WHERE email = '$email'");
      // On affiche chaque entr´ee une `a une
      $donnees = $reponse->execute();
    
      header("Location: ../admin/page_utilisateur.php");
      exit;
    }
  }

  
  
}

?>

