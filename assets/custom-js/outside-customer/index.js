$(document).ready(function() {
    outSideCurrentStep(1);
});

function outSideCurrentStep(step_id){
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


// font image upload
$("#front_image").change(function() {
    $('#front_image_show_part').show();
    frontreadURL(this);
});


// after upload front image preview function
function frontreadURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#front_image_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}



// after upload back image preview function
function backreadURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#back_image_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

// back image upload
$("#back_image").change(function() {
    $('#back_image_show_part').show();
    backreadURL(this);
});

$("#signature_image").change(function() {
    $('#signature_image_show_part').show();
    sreadURL(this);
});


// after upload front image preview function
function sreadURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#signature_image_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}


$("#f_image").change(function() {
    $('#f_image_show_part').show();
    readURL(this);
});


// after upload front image preview function
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#f_image_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}



function text_up1() {
    document.getElementById("text_up").innerHTML = "NID Image Upload";
}

function text_up2() {
    document.getElementById("text_up").innerHTML = "Amendment Data";
}

function text_up3() {
    document.getElementById("text_up").innerHTML = "Face Image";
}

function text_up4() {
    document.getElementById("text_up").innerHTML = "Signature Upload";
}

function text_up5() {
    document.getElementById("text_up").innerHTML = "Review Data";
}

function text_up6() {
    document.getElementById("text_up").innerHTML = "Account Opening";
}

function text_up7() {
    document.getElementById("text_up").innerHTML = "Nominee Setup";
}

// function text_up8() {
//     document.getElementById("text_up").innerHTML = "Result";
// }