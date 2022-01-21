$(document).ready(function (e) {
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });
    $('#ammendment-data').submit(function (e) {
       e.preventDefault();
       var formData = new FormData(this);

       loaderStart();
       errorMessageHide();

       var ammendment_ocr_data_route = $('#ammendment_ocr_data_route').val();

       $.ajax({
          type: 'POST',
          url: ammendment_ocr_data_route,
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: (data) => {
             loaderEnd();
             var obj = JSON.parse(data);
             if(obj.error_code === 200){
                outSideCurrentStep(3);
                text_up3();  
                $('#face_self_requested_id').val(obj.self_request_id);
             }else if(obj.error_code === 400){
                errorMessage(obj.message.trim());
             }                            
          },
          error: function (data) {
             console.log(data);
             loaderEnd();
             errorMessage("Operation failed. Try Again");
          }
       });
    });
 });