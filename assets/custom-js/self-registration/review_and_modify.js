$(document).ready(function (e) {
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });
    $('#review-data-submit').submit(function (e) {
       e.preventDefault();
       var formData = new FormData(this);

       loaderStart();
       errorMessageHide();
       var review_data_route = $('#review_data_route').val();

       $.ajax({
          type       : 'POST',
          url        : review_data_route,
          data       : formData,
          cache      : false,
          contentType: false,
          processData: false,
          success    : (data) => {
             loaderEnd();
             console.log(data);
             var obj = JSON.parse(data);
             if(obj.error_code === 200){
                outSideCurrentStep(6);
                text_up6();
                $("#account_opening_id").val(obj.account_opening_id);
                $("#account_self_request_id").val(obj.self_request_id);
             }else if(obj.error_code === 400){
                errorMessage(obj.message);
             }
          },
          error: function (data) {
             console.log(data);
             loaderEnd();
             errorMessage("operation failed.please try again");
          }
       });
    });
 });   