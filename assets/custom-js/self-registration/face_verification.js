$(document).ready(function (e) {
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });
    $('#face-image-upload').submit(function (e) {
      
       if (document.getElementById("f_image").files.length == 0) {
          $('#face_upload_error_message').html("please upload your face image");
          return false;
       } else {
          e.preventDefault();
          var formData = new FormData(this);

         loaderStart();
         errorMessageHide();
         var face_image_route = $('#face_image_route').val();

          $.ajax({
             type       : 'POST',
             url        : face_image_route,
             data       : formData,
             cache      : false,
             contentType: false,
             processData: false,
             success    : (data) => {
                 console.log(data);
                loaderEnd();
                console.log(data);
                var obj = JSON.parse(data);
                if(obj.error_code == 200){
                   $('#signature_self_request_id').val(obj.self_request_id);
                   outSideCurrentStep(4);
                   text_up4();
                }else if(obj.error_code === 400){
                   errorMessage(obj.message);
                }
             },
             error: function (data) {
                console.log(data);
                loaderEnd();
                errorMessage("Operation failed. Try Again");
             }
          });
       }
    });
 }); 