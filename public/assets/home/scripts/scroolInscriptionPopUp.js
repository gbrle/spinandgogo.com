$("#popUpInscription").hide();

$(window).scroll(function () {

    if ($(this).scrollTop() < 800 )
    {
        $('#popUpInscription').fadeOut(500); // on cache ( i.e on vient de remonté trop haut)
    } else {
        $('#popUpInscription').fadeIn(500);
    }
})