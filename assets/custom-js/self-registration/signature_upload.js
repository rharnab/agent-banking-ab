$(document).ready(function(e) {               
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });
    $('#signature-upload').submit(function(e) {
       if( document.getElementById("signature_image").files.length == 0){
          $('#signature_error_message').html("please select signature image");
          return false;
       }else{
          $('#signature_error_message').html("");
          e.preventDefault();
          var formData = new FormData(this);

          loaderStart();
          errorMessageHide();
          
          var signature_upload_route = $('#signature_upload_route').val();

          $.ajax({
                type       : 'POST',
                url        : signature_upload_route,
                data       : formData,
                cache      : false,
                contentType: false,
                processData: false,
                success    : (data) => { 
                   console.log(data);
                   loaderEnd();
                   var obj = JSON.parse(data);
                   if(obj.error_code === 200){
                      outSideCurrentStep(5);
                      text_up5();
                      $('#review_account_opening_self_request_id').val(obj.self_request_id);                        
                      $('#review_account_opeing_id').val(obj.account_opening_id);                        
                      $('#review_english_name').val(obj.en_name);                        
                      $('#review_bangla_name').val(obj.bn_name);                         
                      $('#review_blood_group').val(obj.blood_group);                         
                      $('#review_date_of_birth').val(obj.date_of_birth);                         
                      $('#review_father_name').val(obj.father_name);                        
                      $('#review_mother_name').val(obj.mother_name);                        
                      $('#review_address').val(obj.present_address); 
                   }else if(obj.error_code === 400){
                      errorMessage(obj.message);
                   }           
                },
                error: function(data) {
                   console.log(data);
                   loaderEnd();
                   errorMessage("operation failed.please try again");
                }
          });
       }                
    });
 });      