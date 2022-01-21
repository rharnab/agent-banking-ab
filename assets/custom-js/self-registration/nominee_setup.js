$(document).ready(function (e) {
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });
    $('#nominee_setup').submit(function (e) {
       e.preventDefault();
       errorMessageHide();
       var formData            = new FormData(this);
       var nominee_setup_route = $('#nominee_setup_route').val();
       $.ajax({
          type       : 'POST',
          url        : nominee_setup_route.trim(),
          data       : formData,
          cache      : false,
          contentType: false,
          processData: false,
          success    : (data) => {
             loaderEnd();
             var obj = JSON.parse(data);
             if(obj.error_code === 200){
                document.getElementById("text_up").innerHTML = "Confirmation Message";
                outSideCurrentStep(8);
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