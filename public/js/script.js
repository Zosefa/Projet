new WOW().init();
$(document).ready(function(){
    $('.btn-suivant').click(function(){
        $('.user').css({"display":'flex'});
        $('.client').css({"display":'none'});
        $('.vendeur').css({"display":'none'});
        $('.precedent-envoyer').css({"display":'flex'});
        $('.suivant').css({"display":'none'});
    });
    $('.btn-precedent').click(function(){
        $('.user').css({"display":'none'});
        $('.client').css({"display":'flex'});
        $('.vendeur').css({"display":'flex'});
        $('.precedent-envoyer').css({"display":'none'});
        $('.suivant').css({"display":'flex'});
    });
});
