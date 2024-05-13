<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datepicker jQuery</title>
    <!-- Inclure jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Inclure jQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        // Attendre que le DOM soit prêt
        $(document).ready(function() {
            // Sélectionner l'élément d'entrée de texte pour la date
            $('#datepicker').datepicker({
                // Options de positionnement
                position: {
                    my: 'left top', // Position du coin supérieur gauche du calendrier
                    at: 'left bottom', // Position du coin inférieur gauche de l'élément d'entrée de texte
                    of: $('#datepicker') // Élément auquel le calendrier est aligné
                }
            });
        });
    </script>
    <style>
        /* Optionnel : style pour le widget */
        .ui-datepicker {
            font-size: 12px;
            position: absolute;
        }
    </style>
</head>

<body>

    <!-- Input pour sélectionner la date -->
    <label for="datepicker">Sélectionner une date :</label>
    <input type="text" id="datepicker">
    <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit quis dolorum neque autem doloribus dignissimos incidunt nesciunt harum in quaerat et, maiores esse sequi hic voluptate placeat explicabo nostrum. Quia ex laudantium voluptatem sequi fugiat laborum, odio aspernatur quod, dignissimos hic provident vero beatae assumenda? Vitae quaerat maxime veritatis illo!</div>

</body>

</html>