$(document).ready(function() {
    var today = new Date();
  // Formatage de la date en format ISO (YYYY-MM-DD)
    var formattedDate = today.toISOString().slice(0,10);
  // Remplir le champ de date avec la date d'aujourd'hui
    $('#datepicker').val(formattedDate);
    $.datepicker.setDefaults({
        dateFormat: 'dd MM yy' // Définir le format de date (jour mois année)
      });
    // Sélectionner l'élément d'entrée de texte pour la date
    $('#datepicker').datepicker({
        // Options de positionnement
        
        position: {
            my: 'left top', // Position du coin supérieur gauche du calendrier
            at: 'left bottom', // Position du coin inférieur gauche de l'élément d'entrée de texte
            of: $('#datepicker') // Élément auquel le calendrier est aligné
        }
    });
    $('#datepicker').datepicker($.datepicker.regional["fr"]);
});

