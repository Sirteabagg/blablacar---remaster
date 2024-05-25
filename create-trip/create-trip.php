<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="create-trip.js" defer></script>
    <link rel="stylesheet" href="create-trip.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <title>Creer un trajet</title>
</head>
<body>
    <header class="">
        <h1>Créer un trajet</h1>
    </header>
    <main>
        <form method="post" action="creat-trip-price.php">
            <nav class="modele-container">
                <p class="text1">Départ</p>
                <span class="text2"></span>
                <span class="text3 centrerhorizontalement">    
                    <label class="switch">
	                    <input type="checkbox" id="Campus"/>
	                    <span></span>
                    </label>
                    campus OMNES
                </span>
                <div class="select">
                    <input type="text" name="depart" id="depart" placeholder="Départ" class="form-input " required="required">           
                </div>  
            </nav>
            <br><br>
            <nav class="modele-container">
                <p class="text1">Arrivée</p>
                <span class="text2"></span>
                <span class="text3"></span>
                <div class="select">
                    <select name="arriver" id="arriver" required="required" class="form-input ml-2">
                        <option value="43 Quai de Grenelle, 75015 Paris">Campus Paris</option>
                        <option value="25 Rue de l'Université, 69007 Lyon">Campus Lyon</option>
                        <option value="30 Rue Joseph Bonnet, 33100 Bordeaux">Campus Bordeaux</option>
                        <option value="12 Av. du Lac d'Annecy, 73381 Le Bourget-du-Lac Cedex">Campus Chambéry</option>
                        <option value="1 Bd Maréchal Foch, 21200 Beaune">Campus Beaune</option>
                        <option value="31 Rue Mgr Duchesne, 35000 Rennes">Campus Rennes</option>
                        <option value="105 Bd de Paris, 13002 Marseille">Campus Marseille</option>
                    </select>           
                </div>  
            </nav>
            <br><br>
            <nav class="modele-container">
                <p class="text1">Date</p>
                <span class="text2"></span>
                <span class="text3"></span>
                <div class="select">
                    <input type="text" name="date" id="datepicker" placeholder="Date" class="form-input ml-2" required="required">           
                </div>  
            </nav>
            <br><br>
            <nav class="modele-container">
                <p class="text1">Heure de départ</p>
                <span class="text2"></span>
                <span class="text3"></span>
                <div class="select">
                    <input type="time" name="heure" placeholder="Heure de départ" class="form-input ml-2" required="required">           
                </div>  
            </nav>
            <br><br>
            <nav class="modele-container">
                <p class="text1">Nombre de passager</p>
                <span class="text2"></span>
                <span class="text3"></span>
                <div class="select">
                    <input type="number" name="nbpassager" placeholder="Nombre de passager" class="form-input ml-2" required="required" min="1">           
                </div>  
            </nav>
            <br><br>
            <input class="styled" type="submit" value="Validé" id="valide"></input>
        </form>
</main>

</body>
</html>