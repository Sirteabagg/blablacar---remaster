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
        <form action="">
            <nav class="modele-container">
                <p class="text1">Départ</p>
                <span class="text2"></span>
                <span class="text3 centrerhorizontalement">    
                    <label class="switch">
	                    <input type="checkbox" />
	                    <span></span>
                    </label>
                    campus OMNES
                </span>
                <div class="select">
                    <input type="text" name="depart" placeholder="Départ" class="form-input ">           
                </div>  
            </nav>
            <br><br>
            <nav class="modele-container">
                <p class="text1">Arrivée</p>
                <span class="text2"></span>
                <span class="text3"></span>
                <div class="select">
                    <input type="text" name="arriver" placeholder="Arrivée" class="form-input ml-2">           
                </div>  
            </nav>
            <br><br>
            <nav class="modele-container">
                <p class="text1">Date</p>
                <span class="text2"></span>
                <span class="text3"></span>
                <div class="select">
                    <input type="text" name="date" id="datepicker" placeholder="Date" class="form-input ml-2">           
                </div>  
            </nav>
            <br><br>
            <nav class="modele-container">
                <p class="text1">Heure de départ</p>
                <span class="text2"></span>
                <span class="text3"></span>
                <div class="select">
                    <input type="text" name="heure" placeholder="Heure de départ" class="form-input ml-2">           
                </div>  
            </nav>
            <br><br>
            <button class="styled" type="button">Validé</button>
        </form>
</main>

</body>
</html>