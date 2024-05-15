<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="create-price.js" defer></script>
    <link rel="stylesheet" href="create-trip.css">
    <title>Définir un prix</title>
</head>
<body>
    <header class="">
        <h1>Saisie du prix</h1>
    </header>
    <br><br>
    <main>
    <form action="" method="post" >
    <nav class="centrer modele-container">
        <span class="text1"></span>
        <h3 class="text2" >Prix (en €): <output id="respondprix"><output></h3>
        <span class="text3"></span>
        <div class="select">
            <input type="range" name="prix" id="Prix" placeholder="Prix" class="form-input ml-2" required="required" min="0" max="100" step="0.5">           
        </div>  
    </nav>
    <br><br>
        <input class="styled" type="submit" value="Validé" id="valideprix"></input>
    </form>
    <main>
</body>
</html>