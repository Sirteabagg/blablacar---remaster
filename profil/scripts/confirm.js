$(".confirmButton").click(function(){
    if(confirm("Êtes-vous sûr de vouloir supprimer votre compte ?")){
        window.location.href = 'suppr-compte.php';
    }
})