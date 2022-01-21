@extends('layouts.app')

@section('title')
    single-account-opening-request
@endsection

@push('css')
<style>
    .img_rounded {
    	height: 100px;
    	width: 100px;
    }
    
    .spinner {
    	width: 60px;
    	height: 60px;
    	position: relative;
    	position: absolute;
    	z-index: 11;
    	margin-left: 45%;
    	margin-top: 20%;
    }
    
    .double-bounce1,
    .double-bounce2 {
    	width: 100%;
    	height: 100%;
    	border-radius: 50%;
    	background-color: #1AB394;
    	opacity: 0.6;
    	position: absolute;
    	top: 0;
    	left: 0;
    	-webkit-animation: bounce 2.0s infinite ease-in-out;
    	animation: bounce 2.0s infinite ease-in-out;
    }
    
    .double-bounce2 {
    	-webkit-animation-delay: -1.0s;
    	animation-delay: -1.0s;
    }
    
    @-webkit-keyframes bounce {
    	0%,
    	100% {
    		-webkit-transform: scale(0.0)
    	}
    	50% {
    		-webkit-transform: scale(1.0)
    	}
    }
    
    @keyframes bounce {
    	0%,
    	100% {
    		transform: scale(0.0);
    		-webkit-transform: scale(0.0);
    	}
    	50% {
    		transform: scale(1.0);
    		-webkit-transform: scale(1.0);
    	}
    }
    
    .full {
    	height: 100%;
    	width: 100%;
    	background: #ffff;
    	opacity: 0.6;
    	position: absolute;
    	z-index: 1;
    }
</style>
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Account Opening Request Details</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Account Opening</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Single Account Opening Request Details</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection


@section('content')
<div class="full" id="loader">
   <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <!-- Header Informating Section Start -->
    <div class="row m-b-lg m-t-lg">
        <div class="col-md-4">
            <div class="profile-image">
                <img src="{{ asset($request_info->webcam_face_image) }}" class="rounded-circle circle-border m-b-md" alt="profile">
            </div>
            <div class="profile-info">
                <div class="">
                    <div>
                        <h2 class="no-margins">
                            {{ $request_info->en_name }}
                        </h2>
                        <h4>{{ $request_info->mobile_number }}</h4>
                        <small>
                            {{ $request_info->present_address }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
            <h4 class="no-margins"><small>Requested On </small>{{ date('jS F,Y h:i a', strtotime($request_info->request_timestamp)) }}</h4>
            <div class="action-button mt-3">
                @if($request_info->status == 2)
                    <button type="button" disabled class="btn btn-w-m btn-primary">Account Opening Request Approved</button>               
                @elseif($request_info->status == 3)
                    <button type="button" disabled class="btn btn-w-m btn-danger">Account Opening Request Declined</button>
                @else
                    <button class="btn btn-info" onclick="ecVerification({{ $request_info->id }})" type="button"><i class="fa fa-certificate"></i>&nbsp;EC-Verification</button> 

                     <button class="btn btn-warning" id="ec_face_compare_button" onclick="ecFaceVerification({{ $request_info->id }})" type="button"><i class="fa fa-camera"></i>&nbsp;EC-Face Compare</button> 

                    <button type="button" onclick="declineAccountOpeningRequest({{ $request_info->id }})" class="btn btn-danger"> <i class="fa fa-trash"></i>&nbsp;Decline</button>
                    <form id="decline-account-opening-form-{{ $request_info->id }}" action="{{ route('admin.account_opening.decline_request',$request_info->id) }}" method="GET" style="display: none;">
                        @csrf
                    </form>
                    <button type="button" onclick="acceptAccountOpeningRequest({{ $request_info->id }})" class=" btn btn-primary"><i class="fa fa-check"></i>&nbsp;Accept</button>                       
                    <form id="accept-account-opening-form-{{ $request_info->id }}" action="{{ route('admin.account_opening.accept_request',$request_info->id) }}" method="GET" style="display: none;">
                        @csrf
                    </form>

                @endif
                
            
            </div>
        </div>


    </div>
    <!-- Header Informating Section End -->

    <p style="color: red; font: 80%; font-weight: bold;" id="error_message"></p>


    <!-- Body Informating Section Start -->
    <div class="row">

        <!-- Image Section Start -->
        <div class="col-lg-4">
            <div class="ibox" id="ec_face_image_show_section">
                <div class="ibox-content">
                    <h3 style="font-weight:bold; color:#000">EC Face Image</h3>
                    <hr>
                    <img class="img img-fluid img-responsive"  id="ec_face_image" src="" alt="">
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-content">
                    <h3 style="font-weight:bold; color:#000">NID Front Image</h3>
                    <hr>
                    <img class="img img-fluid img-responsive" src="{{ asset($request_info->nid_front_image) }}" alt="">
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-content">
                    <h3 style="font-weight:bold; color:#000">NID Back Image</h3> 
                    <hr>
                    <img class="img img-fluid img-responsive" src="{{ asset($request_info->nid_back_image) }}" alt="">
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-content">
                    <h3 style="font-weight:bold; color:#000">Signature Image</h3>
                    <hr>
                    <img class="img img-fluid img-responsive" src="{{ asset($request_info->signature_image) }}" alt="">
                </div>
            </div>
        </div>
        <!-- Image Section End -->

        <!-- Content Section Start -->
        <div class="col-lg-8">
            <div class="row">

               <!-- Face Maching Score With Webcam + Nid Image Section Start -->
                <div class="col-md-4">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h5>NID Image & Camera Face Maching Score</h5>
                            <h2>  {{ number_format($request_info->nid_and_webcam_recognize_percentage,2) }} / 100</h2>
                            <input type="hidden" id="nid_and_camera_face_maching_score" value="{{ $request_info->nid_and_webcam_recognize_percentage }}">
                            <div class="text-center">
                                <div id="nid_and_camera"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Face Maching Score With Webcam + Nid Image Section End -->

                <!-- Face Maching Score With Webcam + EC Image Section Start -->
                <div class="col-md-4">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h5>Ec & Camera Face Maching Score</h5>
                            <h2> <span id="ec_and_camera_percentage_text">0</span> / 100</h2>
                            <input type="hidden" id="ec_and_camera_face_maching_score" value="0">
                            <div class="text-center">
                                <div id="ec_and_camera"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Face Maching Score With Webcam + EC Image Section Start -->

                <!-- Text Maching Score With OCR  + EC  Section Start -->
                <div class="col-md-4">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h5>OCR & EC Text Maching Score</h5>
                            <h2> <span id="ocr_and_ec_percentage_text">0</span> / 100</h2>
                            <input type="hidden" id="ocr_and_ec_text_comparison_score" value="0">
                            <div class="text-center">
                                <div id="ocr_and_ec"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Text Maching Score With OCR  + EC  Section End -->

                

            </div>
            <div class="social-feed-box">
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 150px">NAME</th>
                            <th>OCR DATA</th>  
                            <th>EC DATA</th>                                                      
                            <th>SCORE</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Bangla Name</td>
                                <td><span id="ocr_bangla_name">{{ $request_info->bn_name }}</span></td>
                                <td><span id="ec_bangla_name"></span></td>                                
                                <td id="bangla_name_percentage"></td>
                            </tr>
                            <tr>
                                <td>English Name</td>
                                <td><span id="ocr_english_name">{{ $request_info->en_name }}</span></td>
                                <td><span id="ec_english_name"></span></td>                                
                                <td id="english_name_percentage"></td>
                            </tr>
                            <tr>
                                <td>Father Name</td>
                                <td><span id="ocr_father_name">{{ $request_info->father_name }}</span></td>
                                <td><span id="ec_father_name"></span></td>                                
                                <td  id="father_name_percentage"></td>
                            </tr>
                            <tr>
                                <td>Mother Name</td>
                                <td><span id="ocr_mother_name">{{ $request_info->mother_name }}</span></td>
                                <td><span id="ec_mother_name"></span></td>                                
                                <td  id="mother_name_percentage"></td>
                            </tr>
                            <tr>
                                <td>Date Of Birth</td>
                                <td><span id="ocr_date_of_birth">{{ $request_info->date_of_birth }}</span></td>
                                <td><span id="ec_date_of_birth"></span></td>                                
                                <td  id="date_of_birth_percentage"></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td><span id="ocr_address">{{ $request_info->present_address }}</span></td>
                                <td><span id="ec_address"></span></td>                                
                                <td id="address_percentage"></td>
                            </tr>
                            
                        </tbody>
                    </table>
                 </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="ibox">
                        <div class="ibox-content">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th colspan="2" class="text-center">Account Opening Information</th>
                                    </tr>
                                    <tr>
                                        <td><strong>Branch Name</strong></td>
                                        <td><span>{{ $request_info->branch_name }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Monthly Income</strong></td>
                                        <td><span>{{ number_format($request_info->probably_monthly_income,2) }}/=</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Monthly Diposite</strong></td>
                                        <td><span>{{ number_format($request_info->probably_monthly_deposite,2) }}/=</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Monthly Withdraw</strong></td>
                                        <td><span>{{ number_format($request_info->probably_monthly_withdraw,2) }}/=</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ibox">
                        <div class="ibox-content">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th colspan="2" class="text-center">Nominee Information</th>
                                    </tr>
                                    <tr>
                                        <td><strong>Name</strong></td>
                                        <td><span>{{ $request_info->nominee_name }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>NID No.</strong></td>
                                        <td><span>{{ $request_info->nominee_nid_number }}/=</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address</strong></td>
                                        <td><span>{{ $request_info->nominee_address }}/=</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Section End -->
    </div>
    <!-- Body Informating Section End -->




</div>
@endsection


@push('js')
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

        <script>
            $(document).ready(function(){
                $('#ec_face_image_show_section').hide();
            });
            
            // When this function call then loader will be hide
            function loaderHide(){
                $('#loader').hide();
            }
            
             // When this function call then loader will be show
            function loaderShow(){
                $('#loader').show();
            }
            
            $("#ec_face_compare_button").hide();
            
            loaderHide();
                
        </script>

        <!-- This function for NID Front Part Face Image & Camera Face Compare Section Start -->
        <script>
            var ocrAndEcTextComparison = function(percentage){
                var sparklineCharts = function(){
                    var not_match  = 100 - percentage;
                
                    $("#ocr_and_ec").sparkline([percentage, not_match ], {
                        type       : 'pie',
                        height     : '140',
                        sliceColors: ['#1ab394', '#F5F5F5']
                    });
                }; 
    
                var sparkResize;
    
                $(window).resize(function(e) {
                    clearTimeout(sparkResize);
                    sparkResize = setTimeout(sparklineCharts, 500);
                });
    
                sparklineCharts();
            }
    
            var ocr_and_ec_text_comparison_score = $('#ocr_and_ec_text_comparison_score').val();
            ocrAndEcTextComparison(ocr_and_ec_text_comparison_score);  
        </script>
        <!-- This function for NID Front Part Face Image & Camera Face Compare Section End -->
        

    <!-- This function for NID Front Part Face Image & Camera Face Compare Section Start -->
    <script>
        var nidAndCameraFaceMachingScore = function(percentage){
            var sparklineCharts = function(){
                var not_match  = 100 - percentage;
            
                $("#nid_and_camera").sparkline([percentage, not_match ], {
                    type       : 'pie',
                    height     : '140',
                    sliceColors: ['#1ab394', '#F5F5F5']
                });
            }; 

            var sparkResize;

            $(window).resize(function(e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(sparklineCharts, 500);
            });

            sparklineCharts();
        }

        var nid_and_camera_face_maching_score = $('#nid_and_camera_face_maching_score').val();
        nidAndCameraFaceMachingScore(nid_and_camera_face_maching_score);  
    </script>
    <!-- This function for NID Front Part Face Image & Camera Face Compare Section End -->




    <!-- This functioin for Ec & Camera Face machning Score Section Start -->
    <script>
        var ecAndCameraFaceMachingScore = function(percentage, ec_verify_call = false){
            var sparklineCharts = function(){
                var not_match  = 100 - percentage;
                
                if(percentage < 1 && ec_verify_call === true){
                    var unmatch_color  = '#ed5565';
                }else{
                     var unmatch_color  = '#F5F5F5';
                }
            
                $("#ec_and_camera").sparkline([percentage, not_match ], {
                    type       : 'pie',
                    height     : '140',
                    sliceColors: ['#1ab394', unmatch_color]
                });
            }; 

            var sparkResize;

            $(window).resize(function(e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(sparklineCharts, 500);
            });

            sparklineCharts();
        }

        var ec_and_camera_face_maching_score = $('#ec_and_camera_face_maching_score').val();
        ecAndCameraFaceMachingScore(ec_and_camera_face_maching_score);  
    </script>
    <!-- This functioin for Ec & Camera Face machning Score Section End -->

    <script>
        function acceptAccountOpeningRequest(id) {
            swal({
                title             : 'Are you sure?',
                text              : "You want to accept this account opening request!",
                type              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#d33',
                confirmButtonText : 'Yes, accept it!',
                cancelButtonText  : 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass : 'btn btn-danger',
                buttonsStyling    : false,
                reverseButtons    : true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('accept-account-opening-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
    <script>
        function declineAccountOpeningRequest(id) {
            swal({
                title             : 'Are you sure?',
                text              : "You want to decline this account opening request!",
                type              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#d33',
                confirmButtonText : 'Yes, decline it!',
                cancelButtonText  : 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass : 'btn btn-danger',
                buttonsStyling    : false,
                reverseButtons    : true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('decline-account-opening-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
    <script>
        function ecVerification(id){
            swal({
                title             : 'Are you sure?',
                text              : "Do you want to compare with ec-verification !",
                type              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#d33',
                confirmButtonText : 'Yes, compare it!',
                cancelButtonText  : 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass : 'btn btn-danger',
                buttonsStyling    : false,
                reverseButtons    : true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    
                    // Ajax call section start
                    var _token   = $('meta[name="csrf-token"]').attr('content'); 
                    var error_message = document.querySelector('#error_message');                  
                    if(id){
                        loaderShow();
                        $.ajax({
                            type       : 'post',
                            url        : "{{ route('admin.account_opening.ec_compare') }}",
                            data       : {
                                 "id"   : id,
                                "_token": _token
                            },
                            success    : (data) => {
                                loaderHide();
                                console.log(data);
                                var obj = JSON.parse(data);
                                if(obj.error_code === 200){
                                     $("#ec_face_compare_button").show();
                                    compareTableFillUp(obj);
                                }else if(obj.error_code === 400){
                                    $('#error_message').html("EC Verifiaction Failed");
                                }
                            },
                            error: function (data) {   
                                loaderHide();
                                $('#error_message').html("EC Verifiaction Failed");                   
                                console.log(data);
                            }
                        });
                    }else{
                        alert("Please refresh");
                    }
                    // Ajax call section end                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }

        function compareTableFillUp(obj){
            var ec_bangla_name           = document.querySelector('#ec_bangla_name');
            var bangla_name_percentage   = document.querySelector('#bangla_name_percentage');
            var ec_english_name          = document.querySelector('#ec_english_name');
            var english_name_percentage  = document.querySelector('#english_name_percentage');
            var ec_father_name           = document.querySelector('#ec_father_name');
            var father_name_percentage   = document.querySelector('#father_name_percentage');
            var ec_mother_name           = document.querySelector('#ec_mother_name');
            var mother_name_percentage   = document.querySelector('#mother_name_percentage');
            var ec_date_of_birth         = document.querySelector('#ec_date_of_birth');
            var date_of_birth_percentage = document.querySelector('#date_of_birth_percentage');
            var ec_address               = document.querySelector('#ec_address');
            var address_percentage       = document.querySelector('#address_percentage');
            var address_percentage       = document.querySelector('#address_percentage');
            var ec_face_image            = document.querySelector('#ec_face_image');

            ec_bangla_name.innerHTML           = obj.ec_bn_name.trim();
            bangla_name_percentage.innerHTML   = obj.bn_name_percentage;
            ec_english_name.innerHTML          = obj.ec_en_name.trim();
            english_name_percentage.innerHTML  = obj.en_name_percentage;
            ec_father_name.innerHTML           = obj.ec_father_name.trim();
            father_name_percentage.innerHTML   = obj.father_name_percentage;
            ec_mother_name.innerHTML           = obj.ec_mother_name.trim();
            mother_name_percentage.innerHTML   = obj.mother_name_percentage;
            ec_date_of_birth.innerHTML         = obj.ec_date_of_birth;
            date_of_birth_percentage.innerHTML = obj.date_of_birth_percentage;
            ec_address.innerHTML               = obj.ec_permanentAddress.trim();
            address_percentage.innerHTML       = obj.address_percentage;

            $('#ocr_and_ec_text_comparison_score').val(obj.average_text_matching_score);
            $('#ocr_and_ec_percentage_text').html(obj.average_text_matching_score);
            ocrAndEcTextComparison(obj.average_text_matching_score);
            $('#ec_face_image_show_section').show();
            ec_face_image.src = obj.ec_photo_src.trim();


        }

    </script>
    
      <script>
        function ecFaceVerification(id){
            swal({
                title             : 'Are you sure?',
                text              : "Do you want to compare ec-image to customer-image !",
                type              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#d33',
                confirmButtonText : 'Yes, compare it!',
                cancelButtonText  : 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass : 'btn btn-danger',
                buttonsStyling    : false,
                reverseButtons    : true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    // Ajax call section start
                    var _token   = $('meta[name="csrf-token"]').attr('content'); 
                    var error_message = document.querySelector('#error_message');                  
                    if(id){
                        loaderShow();
                        $.ajax({
                            type       : 'post',
                            url        : "{{ route('admin.account_opening.ec_image_compare') }}",
                            data       : {
                                "id"   : id,
                                "_token": _token
                            },
                            success    : (data) => {
                                loaderHide();
                                console.log(data);
                                var obj = JSON.parse(data);
                                if(obj.error_code === 200){
                                    var recognize_percentage = obj.recognize_percentage;
                                    ecAndCameraFaceMachingScore(recognize_percentage, true);
                                    $('#ec_and_camera_percentage_text').html(recognize_percentage);
                                }else if(obj.error_code === 400){
                                    $('#error_message').html("Error : " +obj.message.trim());
                                }else{
                                    $('#error_message').html("Failed to compare");
                                }
                                
                            },
                            error: function (data) {
                                loaderHide();
                                console.log(data);
                            }
                        });
                    }else{
                        alert("Please refresh");
                    }
                    // Ajax call section end                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>


@endpush



