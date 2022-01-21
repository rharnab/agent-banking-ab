$(document).ready(function (e) {
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });
    $('#nid-upload').submit(function (e) {
       if(document.getElementById("front_image").files.length == 0){
          $("#nid_front_image_error_message").html("please select nid front-side image");
          return false;
       }else if(document.getElementById("back_image").files.length == 0){
          $("#nid_front_image_error_message").html("");
          $("#nid_back_image_error_message").html("please select nid back-side image");
          return false;
       }else {
          $("#nid_front_image_error_message").html("");
          $("#nid_back_image_error_message").html("");
          e.preventDefault();
          var formData = new FormData(this);

          loaderStart();
          errorMessageHide();

          var nid_upload_and_ocr_route = $('#nid_upload_and_ocr_route').val();

          $.ajax({
             type       : 'POST',
             url        : nid_upload_and_ocr_route,
             data       : formData,
             cache      : false,
             contentType: false,
             processData: false,
             success    : function(data) {
                console.log(data);
                loaderEnd();
                let obj = JSON.parse(data);
                if(obj.error_code === 200){
                   outSideCurrentStep(2);
                   text_up2();    
                   $('#self_request_id').val(obj.self_registration_id);
                   $('#english_name').val(obj.en_name);
                   $('#nid_number').val(obj.nid_number);
                   $('#date_of_birth').val(obj.date_of_birth);
                }else if(obj.error_code === 400){
                   errorMessage(obj.message);
                }               
             },
             error: function (data) {
                console.log(data);
                loaderEnd();
                errorMessage("nid-ocr failed");
             }
          });
       }
    });
 });