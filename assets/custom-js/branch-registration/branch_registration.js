function errorMessage(message){
    $('#error_message_show_section').show();
    $('#error_message').html(message);
}

function errorMessageHide(){
    $('#error_message_show_section').hide();
}
errorMessageHide();
$('#verify_success').hide();

function showFaceMatchingScore(score, color){
    var total_score   = 100;
    var match_score   = score;
    var unmatch_score = total_score - match_score;
    $('#overallFaceMachingtext').html(total_score + " / " + match_score);
    var sparklineCharts = function(){        
        $("#facematchingscore").sparkline([match_score, unmatch_score], {
            type       : 'pie',
            height     : '140',
            sliceColors: [color, '#F5F5F5']
        });
    };

    var sparkResize;

    $(window).resize(function(e) {
        clearTimeout(sparkResize);
        sparkResize = setTimeout(sparklineCharts, 500);
    });

    sparklineCharts();
}