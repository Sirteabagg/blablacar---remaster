<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style-main-structure.css">
    <link rel="stylesheet" href="../styles/style-profil.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <a href="visuinfo.php">
            <div class="menup">
                <div class="item titre">Mon Profil</div>
                <div class="item ID">
                    <img src="../../images/utilisateur.png" class="img-user">
                </div>
            </div>
        </a>
        <div class="portefeuille">
            <H2></H2>Mon Portefeuille : 30€
        </div>
        <div class="menu">
            <a href="info.php">
                <div class="itemss grid-container">Mes infos personnelles<div>&gt</div>
                </div>
            </a>
            <a href="prefform.php">
                <div class="itemss grid-container">Mes infos conducteur<div>&gt</div>
                </div>
            </a>
            <a href="connexion.php">
                <div class="itemss grid-container">Déconnexion<div>&gt</div>
                </div>
            </a>
        </div>

    </div>
</body>
</head>

<?php require "../../php/footer.php"; ?>

</html>