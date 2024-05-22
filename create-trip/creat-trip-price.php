<?php
    if (isset($_POST["date"], $_POST["heure"],$_POST["depart"], $_POST["arriver"], $_POST["nbpassager"])) {
        $date = $_POST["date"];
        $heure = $_POST["heure"];
        $adressdep = $_POST["depart"];
        $adressarr = $_POST["arriver"];
        $nbpassager = $_POST["nbpassager"];
    }
    else {
        echo "Les champs 'date', 'heure', 'arriver', 'depart', 'nbpassager' n'ont pas été soumis.";
    }
?>

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
    <form action="create-trip-donnee.php" method="post" >
    <nav class="centrer modele-container">
        <span class="text1"></span>
        <h3 class="text2" >Prix (en €): <output id="respondprix"><output></h3>
        <span class="text3"></span>
        <div class="select">
            <input type="range" name="prix" id="Prix" placeholder="Prix" class="form-input ml-2" required="required" min="0" max="100" step="0.5">           
        </div>  
    </nav>
    <input type="hidden" name="date" value="<?php echo $date;?>" >
    <input type="hidden" name="heure" value="<?php echo $heure;?>" >
    <input type="hidden" name="arriver" value="<?php echo $adressarr;?>" >
    <input type="hidden" name="depart" value="<?php echo $adressdep;?>" >
    <input type="hidden" name="nbpassager" value="<?php echo $nbpassager;?>" >
    <br><br>
        <input class="styled" type="submit" value="Validé" id="valideprix"></input>
    </form>
    <main>
</body>
</html>