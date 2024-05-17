


$(".autocomplete").on('input', function(){
    let current_input = event.target;
    let myString = event.target.value;
    let newString = myString.replace(/ /g, '+');
    fetch("https://api-adresse.data.gouv.fr/search/?q="+newString)
    .then((response) => {
        // Vérifier si la réponse est correcte (status 200)
        if (!response.ok) {
            throw new Error(`Erreur HTTP ! Statut : ${response.status}`);
        }
        return response.json();
        })
        .then((data) => {
        // Vérifier si les données contiennent des résultats
        if (data.features && data.features.length > 0) {
            // Extraire l'adresse suggérée
            const suggestion = data.features[0].properties.label;
            
            
            $(".suggestions").empty();
            if (myString.length > 0) {
                suggestion.toLowerCase();
                
    
                $(current_input).next().append(
                '<div class="suggestion-item">' + suggestion + "</div>"
                );
            }
            
            console.log($($(current_input).next().children().first())[0]);
            $(current_input).next().children().first().on("click", function () {
                $(current_input).val($(this).text());
                $(current_input).next().empty();
            });
    
            $(document).click(function (event) {
            if (
                !$(event.target).closest(".autocomplete, .suggestions").length
            ) {
                $(current_input).next().empty();
            }
            });
        } else {
            console.log("Aucune suggestion trouvée.");
        }
        })
        .catch((error) => {
        // Gérer les erreurs
        console.error("Erreur lors de la requête :", error);
        });

})