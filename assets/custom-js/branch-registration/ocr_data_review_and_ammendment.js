$(document).ready(function(e) {   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#ocr-data-save-form').submit(function(e) {
        $('#loader2').children('.ibox-content').addClass('sk-loading'); //add loading
        e.preventDefault();
        var formData = new FormData(this);
        var ocr_data_review_and_ammendment_route = $('#ocr_data_review_and_ammendment_route').val();
        $.ajax({
            type       : 'POST',
            url        : ocr_data_review_and_ammendment_route,
            data       : formData,
            cache      : false,
            contentType: false,
            processData: false,
            success    : (data) => {
             errorMessageHide();
                $('#loader2').children('.ibox-content').removeClass('sk-loading'); //add loading
                currentStep(3);
                console.log(data);
                var obj = JSON.parse(data);
                if(obj.error_code === 200){
                    showPercentageIntoCompare(obj);
                }else if(obj.error_code === 400){
                    errorMessage(obj.message.trim());
                }
               
            },
            error: function(data) {
                $('#loader2').children('.ibox-content').removeClass('sk-loading'); //add loading
                currentStep(3);
                console.log(data);
            }
        });           
    });
});

function showPercentageIntoCompare(obj){
    $('#ec_bangla_name').html(obj.ec_bn_name);
    $('#ocr_bangla_name').html(obj.ocr_bn_name);
    $('#bangla_name_percentage').html(obj.bn_name_percentage + "%");

    $('#ec_english_name').html(obj.ec_en_name);
    $('#ocr_english_name').html(obj.ocr_en_name);
    $('#english_name_percentage').html(obj.en_name_percentage + "%");

    $('#ec_father_name').html(obj.ec_father_name);
    $('#ocr_father_name').html(obj.ocr_father_name);
    $('#father_name_percentage').html(obj.father_name_percentage + "%");

    $('#ec_mother_name').html(obj.ec_mother_name);
    $('#ocr_mother_name').html(obj.ocr_mother_name);
    $('#mother_name_percentage').html(obj.mother_name_percentage + "%");

    $('#ec_date_of_birth').html(obj.ec_date_of_birth);
    $('#ocr_date_of_birth').html(obj.ocr_date_of_birth_name);
    $('#date_of_birth_percentage').html(obj.date_of_birth_percentage + "%");

    $('#ec_address').html(obj.ec_permanentAddress);
    $('#ocr_address').html(obj.ocr_address_name);
    $('#address_percentage').html(obj.address_percentage + "%");
    if(obj.is_passed_matching_score === true){
       textMachingGraph(obj.average_text_matching_score, obj.percentage_color);
       $('#text-compare-next-button').attr("disabled", false);
    }else{
       textMachingGraph(obj.average_text_matching_score, obj.percentage_color);
       errorMessage('Overall percetage does not fillup our required percetage.Please reammendment & compare again');
       $('#text-compare-next-button').attr("disabled", true);
    }
    

    $("#face_compare_registration_id").val(obj.registration_id);
    $("#face_customer_nid").val(obj.nid_number);
    $("#face_customer_mobile_number").val(obj.mobile_number);
    $("#face_customer_english_name").val(obj.ocr_en_name);
    $("#face_customer_date_of_birth").val(obj.ocr_date_of_birth_name);

    $('#ec_face_image_prview').attr("src", obj.ec_photo_src);
}

function textMachingGraph(score, color){
var total_score   = 100;
var match_score   = score;
var unmatch_score = total_score - match_score;
$('#overallmatcingtext').html(total_score + " / " + match_score);
var sparklineCharts = function(){        
    $("#overallspacleCircle").sparkline([match_score, unmatch_score], {
        type       : 'pie',
        height     : '140',
        sliceColors: [ color, '#F5F5F5']
    });
};

var sparkResize;

$(window).resize(function(e) {
    clearTimeout(sparkResize);
    sparkResize = setTimeout(sparklineCharts, 500);
});

sparklineCharts();
}