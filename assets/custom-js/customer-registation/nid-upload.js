$('#front_image_show_part').hide(); // hide nid front image after upload show section
$('#back_image_show_part').hide(); // hide nid back image after upload show section

// font image upload
$("#front_image").change(function() {
    $('#front_image_show_part').show();
    frontreadURL(this);
});


// after upload front image preview function
function frontreadURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#front_image_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

// after upload back image preview function
function backreadURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#back_image_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

// back image upload
$("#back_image").change(function() {
    $('#back_image_show_part').show();
    backreadURL(this);
});


// nid image upload form validation
$(function() {

    $.validator.setDefaults({
        errorClass: 'help-block',
        highlight: function(element) {
            $(element)
                .closest('.form-group')
                .addClass('has-error');
        },
        unhighlight: function(element) {
            $(element)
                .closest('.form-group')
                .removeClass('has-error');
        },
        errorPlacement: function(error, element) {
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $.validator.addMethod('phone', function(value) {
        return /\b(88)?01[3-9][\d]{8}\b/.test(value);
    }, 'Please enter valid phone number');




    $("#customer-nid-upload").validate({
        rules: {
            front_image: {
                required: true,
                accept: "jpg,png,jpeg"
            },
            back_image: {
                required: true,
                accept: "jpg,png,jpeg"
            },
        },
        messages: {
            front_image: {
                required: "Please select customer nid front image",
                accept: "Only supprted jpg | png |jpeg"
            },
            back_image: {
                required: "Please select customer nid back image",
                accept: "Only supprted jpg | png |jpeg"
            },
        }
    });

});