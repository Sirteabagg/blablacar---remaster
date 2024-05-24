<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style-main-structure.css">
    <link rel="stylesheet" href="../styles/create.css">
</head>

<body>
<div class="header-container">
        <a href="connexion.php"><div class="arrow">&lt;</div></a>
        <h1 class="titre">Création</h1>
<div class="grid"> 
    <form action="bddcreate.php" method="post">
        <div class="case">
        <input type="text" placeholder="Nom" name="nom" class="form-input">
        </div>
        <div class="case">
        <input type="text" placeholder="Prénom" name="prenom" class="form-input">
        </div>
        <div class="case">
            <input type="text" placeholder="Email" name="email" class="form-input">
        </div>
        <div class="case">
            <input type="password" placeholder="Mot de passe" name="mdp" class="form-input">
        </div>
        <input type="submit" class="button-submit" value="Créer">
    </form>
</div>  
</body>

</html>