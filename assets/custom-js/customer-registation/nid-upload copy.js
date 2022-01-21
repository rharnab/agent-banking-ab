
        $('.ocr-data-show-section-start').hide(); // hide ocr data section
        // front image preview section 
        $('#front_image_show_part').hide();
        $('#back_image_show_part').hide();
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                $('#front_image_preview').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#front_image").change(function() {
            $('#front_image_show_part').show();
            readURL(this);
        });

        // back image privew section
       
        function backreadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                $('#back_image_preview').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

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
            errorPlacement: function (error, element) {
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
                        accept:"jpg,png,jpeg"                        
                    },
                    back_image: {
                        required: true,
                        accept:"jpg,png,jpeg"                        
                    },
                },
                messages: {
                    front_image: {
                        required: "Please select customer nid front image",
                        accept:"Only supprted jpg | png |jpeg"                        
                    },
                    back_image: {
                        required: "Please select customer nid back image",
                        accept:"Only supprted jpg | png |jpeg"                     
                    },
                }
            });

        });


        $(document).ready(function(e) {               
            $('#ibox1').children('.ibox-content').removeClass('sk-loading'); //remove loading
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#customer-nid-upload').submit(function(e) {
                if( document.getElementById("front_image").files.length == 0  || document.getElementById("back_image").files.length == 0 ){
                    return false;
                }else{
                    $('#ibox1').children('.ibox-content').addClass('sk-loading'); // show loading
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type       : 'POST',
                        url        : "{{ route('customer.registation.upload.nid') }}",
                        data       : formData,
                        cache      : false,
                        contentType: false,
                        processData: false,
                        success    : (data) => {
                            $('.nid-upload-section').hide(); // hide nid upload section
                            $('.ocr-data-show-section-start').show(); // show ocr data preview section
                            $('#nid_upload_step').addClass('active'); // active nid upload step
                            $('#nid_upload_bullet_step').addClass('active'); // active calss added into the nid bullet step
                            $('#ibox1').children('.ibox-content').removeClass('sk-loading'); // remove loading
                            var obj = JSON.parse(data);
                            // data fillup from ajax start
                            $('#customer_id').val(obj.id);
                            $('#front_data').val(obj.front_data.trim());
                            $('#nid_number').val(obj.nid_number.trim());
                            $('#bangla_name').val(obj.bn_name.trim());
                            $('#english_name').val(obj.en_name.trim());
                            $('#father_name').val(obj.father_name.trim());
                            $('#mother_name').val(obj.mother_name.trim());
                            $('#nid_unique_data').val(obj.nid_unique_data.trim());
                            $('#date_of_birth').val(obj.date_of_birth.trim());
                            $('#back_data').val(obj.back_data.trim());
                            $('#address').val(obj.address.trim());
                            $('#blood_group').val(obj.blood_group.trim());
                            $('#place_of_birth').val(obj.place_of_birth.trim());
                            $('#issue_date').val(obj.issue_date.trim());
                        },
                        error: function(data) {
                            $('#ibox1').children('.ibox-content').removeClass('sk-loading');
                            console.log(data);
                        }
                    });
                }                
            });
        });




