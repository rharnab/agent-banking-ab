$(function(){
    $('#upload_face_image_show_part').hide();

    // font image upload
    $("#upload_face_image").change(function() {
        $('#face_image_taken_show_section').hide();
        $('#upload_face_image_show_part').show();

        readURL(this);
    });


    // after upload front image preview function
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#upload_face_imge_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
});


$(document).ready(function(e) {               
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#upload-face-image-form').submit(function(e) {
        if( document.getElementById("upload_face_image").files.length == 0 ){
           errorMessage("please upload customer image for face comparison");
           return false;
        }else{
            $('#loader4').children('.ibox-content').addClass('sk-loading'); //add loading
            e.preventDefault();
            var formData = new FormData(this);
            var upload_face_compare_route = $('#upload_face_compare_route').val();
            $.ajax({
                type       : 'POST',
                url        : upload_face_compare_route,
                data       : formData,
                cache      : false,
                contentType: false,
                processData: false,
                success    : (data) => {  
                 errorMessageHide();
                    $('#loader4').children('.ibox-content').removeClass('sk-loading'); //remove loading
                    console.log(data);
                    var obj = JSON.parse(data);
                    if(obj.error_code === 200){
                        currentStep(5);  
                        faceCompareScoreShow(obj);                        
                    }else if(obj.error_code === 400){
                        errorMessage(obj.message.trim());
                    }
                },
                error: function(data) {
                    $('#loader4').children('.ibox-content').removeClass('sk-loading'); //remove loading
                    console.log(data);
                }
            });
        }                
    });
});

function faceCompareScoreShow(obj){
    $('#verified_customer_ec_face_image').attr('src', obj.ec_image_path.trim());
    $('#verified_customer_image').attr('src', obj.webcam_face_image.trim());
    if(obj.is_pass_percentage === true){
        var account_opening_route = $('#account_opening_route').val() + "/"+obj.registration_id;
        $('#verify_success').show();
        $('#face_verified_message').html(`Customer E-KYC Verified.Please fillup <a href=${account_opening_route}>account opening form</a>`);
        showFaceMatchingScore(obj.recognize_percentage, obj.pass_color);
    }else{
        errorMessage("Face match percetage does not fill up our required percentage. Pleae go back and take selfi again");
        showFaceMatchingScore(obj.recognize_percentage, obj.pass_color);
    }
}