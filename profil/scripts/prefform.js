$('.content').children().each(function(){
    $(this).hide();
});

$('.content2').children().each(function(){
    $(this).hide();
});



$('.fleche').click(function(){
    $('.content').children().each(function(){
        $(this).toggle();
    })
})

$('.fleche2').click(function(){
    $('.content2').children().each(function(){
        $(this).toggle();
    })
})
