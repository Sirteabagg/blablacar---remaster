<?php
// Sous WAMP (Windows)
$bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');
try
{
$bdd = new PDO('mysql:host=localhost;dbname=blablaomnes;
charset=utf8', 'root', '');
}
catch (Exception $e)
{
die('Erreur : ' . $e->getMessage());
}

$reponse = $bdd->query('SELECT * FROM utilisateur');
// On affiche chaque entr´ee une `a une
while ($donnees = $reponse->fetch())
{
?>
<p>
Nom : <?php echo $donnees['nom']; ?>,<br>
Prenom : <?php echo $donnees['prenom']; ?>,<br>
email : <?php echo $donnees['email']; ?>
</p>
<?php
}
//On termine le traitement de la requ^ete
$reponse->closeCursor();
93/96 
?>
