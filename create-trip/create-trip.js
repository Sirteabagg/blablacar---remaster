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

var paris = document.createElement("option");
paris.value = "43 Quai de Grenelle, 75015 Paris";
paris.textContent="Campus de Paris";
var lyon = document.createElement("option");
lyon.value = "25 Rue de l'Université, 69007 Lyon";
lyon.textContent="Campus de Lyon";
var bordeau = document.createElement("option");
bordeau.value = "30 Rue Joseph Bonnet, 33100 Bordeaux";
bordeau.textContent="Campus de Bordeaux";
var beaune = document.createElement("option");
beaune.value = "1 Bd Maréchal Foch, 21200 Beaune";
beaune.textContent="Campus de Beaune";
var chambery = document.createElement("option");
chambery.value = "12 Av. du Lac d'Annecy, 73381 Le Bourget-du-LCedex";
chambery.textContent="Campus de Chambrey";
var rennes = document.createElement("option");
rennes.value = "31 Rue Mgr Duchesne, 35000 Rennes";
rennes.textContent="Campus de Rennes";
var marseille = document.createElement("option");
marseille.value = "105 Bd de Paris, 13002 Marseille";
marseille.textContent="Campus de Marseille";

document.getElementById('Campus').addEventListener('click', (event) => {
    var check = document.getElementById("Campus");
    var select = document.getElementById("depart");

    if (check.checked == false) {
        select.remove();
        var input = document.createElement("input");
        input.type = "text";
        input.name = "depart";
        input.id = "depart";
        input.placeholder="Départ";
        input.classList.add("form-input");
        input.required = "required";

        document.querySelector('div').appendChild(input);
    }else{
        select.remove();
        var selecter = document.createElement("select");
        selecter.name = "depart";
        selecter.classList.add("form-input");
        selecter.id = "depart";
        selecter.required = "required";

        selecter.appendChild(paris);
        selecter.appendChild(lyon);
        selecter.appendChild(bordeau);
        selecter.appendChild(beaune);
        selecter.appendChild(rennes);
        selecter.appendChild(marseille);

        document.querySelector('div').appendChild(selecter);
    }
})

document.getElementById('Campus').addEventListener('click', (event) => {
    var check = document.getElementById("Campus");
    var select1 = document.getElementById("arriver");

    if (check.checked == true) {
        select1.remove();
        var input = document.createElement("input");
        input.type = "text";
        input.name = "arriver";
        input.id = "arriver";
        input.placeholder="Arriver";
        input.classList.add("form-input");
        input.required = "required";

        document.querySelectorAll('div')[1].appendChild(input);
        console.log(document.querySelector('div'));
    }else{
        select1.remove();
        var selecter1 = document.createElement("select");
        selecter1.name = "arriver";
        selecter1.classList.add("form-input");
        selecter1.id = "arriver";
        selecter1.required = "required";
        
        selecter1.appendChild(paris);
        selecter1.appendChild(lyon);
        selecter1.appendChild(bordeau);
        selecter1.appendChild(beaune);
        selecter1.appendChild(rennes);
        selecter1.appendChild(marseille);

        document.querySelectorAll('div')[1].appendChild(selecter1);
    }

})