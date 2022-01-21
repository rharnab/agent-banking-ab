$(document).ready(function (e) {
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });
    $('#account_opening_information').submit(function (e) {
       e.preventDefault();
       var formData = new FormData(this);

       loaderStart();
       errorMessageHide();
       var account_opening_route = $('#account_opening_route').val();

       $.ajax({
          type       : 'POST',
          url        : account_opening_route,
          data       : formData,
          cache      : false,
          contentType: false,
          processData: false,
          success    : (data) => {
             loaderEnd();
             console.log(data);
             var obj = JSON.parse(data);
             if(obj.error_code === 200){                     
                outSideCurrentStep(7);
                text_up7();
                $('#nominee_account_opening_id').val(obj.account_opening_id);
                $('#nominee_self_request_id').val(obj.account_opening_id);
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