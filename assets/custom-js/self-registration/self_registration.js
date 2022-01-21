$('#error_message_show_section').hide();

function loaderStart(){
   $(".spiner_example").show();
   $(".full-conetent").css("opacity","0.3");
}


function loaderEnd(){
   $(".spiner_example").hide();
   $(".full-conetent").css("opacity","");
}

function errorMessage(message){
    $('#error_message_show_section').show();
   var error_messasge_block = $('#error_messasge_block').html(message.trim());
}

function errorMessageHide(){
    $('#error_message_show_section').hide();
}


$(document).ready(function(){
    $(".full-conetent").css("opacity","");
    $(".spiner_example").hide();
});