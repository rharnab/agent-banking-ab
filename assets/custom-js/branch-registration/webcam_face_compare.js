$('#startbutton').on('click', function(){
    $('#face_image_taken_show_section').show();
    $('#upload_face_image_show_part').hide();
});

function faceCompare(){
    var registration_id   = $("#face_compare_registration_id").val();
    var ec_face_image     = $('#ec_face_image_prview').attr('src');
    var webcam_face_image = $('.webcam_face_image').attr('src');
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if(registration_id != '' && ec_face_image != '' && webcam_face_image !=''){
        $('#loader4').children('.ibox-content').addClass('sk-loading'); //add loading
        var webcam_face_compare = $('#webcam_face_compare').val();
        $.ajax({
            type: 'POST',
            url : webcam_face_compare,
            data: {
                "_token"           : $('#token').val(),
                "registration_id"  : registration_id,
                "ec_face_image"    : ec_face_image,
                "webcam_face_image": webcam_face_image,
            },
            success    : (data) => {
             errorMessageHide();
             $('#loader4').children('.ibox-content').removeClass('sk-loading'); //add loading
                console.log(data);
                var obj = JSON.parse(data);
                if(obj.error_code === 200){
                    var account_opening_route = $('#account_opening_route').val() + "/"+obj.registration_id; 
                    currentStep(5);                           
                    if(obj.is_pass_percentage === true){
                         $('#verify_success').show();
                         $('#face_verified_message').html(`Customer E-KYC Verified.Please fillup <a href=${account_opening_route}>account opening form</a>`);
                         showFaceMatchingScore(obj.recognize_percentage, obj.pass_color);
                      }else{
                        $('#verify_success').hide();
                         errorMessage("Face match percetage does not fill up our required percentage. Pleae go back and take selfi again");
                         showFaceMatchingScore(obj.recognize_percentage, obj.pass_color);
                      }
                    $('#verified_customer_ec_face_image').attr('src', obj.ec_image_path.trim());
                    $('#verified_customer_image').attr('src', obj.webcam_face_image.trim());
                }else if(obj.error_code === 400){
                    errorMessage(obj.message.trim());
                }
            },
            error: function(data) {
             $('#loader4').children('.ibox-content').removeClass('sk-loading'); //add loading
                console.log(data);
            }
        });
    }else{
        alert('please take photo from webcam');
    }             
      
}