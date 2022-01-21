$(document).ready(function(e) {               
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#customer-nid-upload').submit(function(e) {
        if( document.getElementById("front_image").files.length == 0  || document.getElementById("back_image").files.length == 0 ){
            return false;
        }else{
            $('#loader1').children('.ibox-content').addClass('sk-loading'); //add loading
            var nid_ocr_route = $('#nid_ocr_route').val();
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type       : 'POST',
                url        : nid_ocr_route,
                data       : formData,
                cache      : false,
                contentType: false,
                processData: false,
                success    : (data) => {  
                   errorMessageHide(); 
                    $('#loader1').children('.ibox-content').removeClass('sk-loading'); // remove loading
                    currentStep(2); 
                    console.log(data);
                    var obj = JSON.parse(data);
                    if(obj.error_code === 200){
                        fillupOcrAmmendmentForm(obj);
                    }else if(obj.error_code === 400){
                        errorMessage(obj.message.trim());
                    }
                },
                error: function(data) {
                   console.log(data);
                }
            });
        }                
    });
});

function fillupOcrAmmendmentForm(obj){
  $('#mobile_number').val(obj.mobile_number);
  $('#front_data').val(obj.front_data);
  $('#nid_number').val(obj.nid_number);
  $('#bangla_name').val(obj.bangla_name);
  $('#english_name').val(obj.english_name);
  $('#father_name').val(obj.father_name);
  $('#mother_name').val(obj.mother_name);
  $('#date_of_birth').val(obj.date_of_birth);
  $('#back_data').val(obj.back_data);
  $('#address').val(obj.address);
  $('#blood_group').val(obj.blood_group);
  $('#place_of_birth').val(obj.place_of_birth);
  $('#issue_date').val(obj.issue_date);
  $('#registration_id').val(obj.registration_id);
}