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