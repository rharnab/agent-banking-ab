$(document).ready(function() {
    currentStep(1);
});

function currentStep(step_id){
    // all div hide
    for( var i=1; i<10; i++){
        $('.step_'+i).hide();
    }
    // click div section show
    $('.step_'+step_id).show();

    // all step remove active class
    for( var i=1; i<10; i++){
        $('.step_text_'+i).removeClass('active');
        $('.step_bullet_'+i).removeClass('active');
    }

    for(var i=1; i<=step_id; i++){
        // add current step active class
        $('.step_text_'+i).addClass('active');
        $('.step_bullet_'+i).addClass('active');
    }

  

}