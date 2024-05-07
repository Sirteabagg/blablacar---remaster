<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Vérifie si des données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si le champ "nom" a été soumis
    if (isset($_POST["nom"], $_POST["prenom"], $_POST["email"],$_POST["tel"])) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"]; 
        $tel = $_POST["tel"]; 
        echo "Le nom soumis est : " . $nom;
        echo "Le prénom soumis est : " . $prenom;
        echo "L' email soumis est : " . $email;
        echo "Tel soumis est : " . $tel;
    } else {
        echo "Le champ 'nom' n'a pas été soumis.";
        echo "Le champ 'prenom' n'a pas été soumis.";
        echo "Le champ 'email' n'a pas été soumis.";
        echo "Le champ 'tel' n'a pas été soumis.";
    }
}
header("Location: profilforme.php");
exit;
?>

</body>
</html>