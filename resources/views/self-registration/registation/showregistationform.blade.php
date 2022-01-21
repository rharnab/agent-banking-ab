<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.9.3/login_two_columns.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Sep 2020 06:10:52 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-KYC |  SELF-REGISTRATION</title>

    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <!-- Toaster CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">

    <!-- Toastr style -->
    <link href="{{ asset('assets/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">

    <style type="text/css">
        @media only screen and (max-width: 767px){
            .text_remove p{
                display: none;
            }
            .font-bold {
                text-align: center;
            }
        }
       body{
           display: flex;
           align-items: center;
       }
       .help-block {
            color      : red;
            font-weight: bold;
            font-size  : 10px;
        }
    </style>

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6 text_remove">
                <h2 class="font-bold">Welcome to E-KYC</h2>

                <p>
                    VSL EKYC is a completely Bangladeshi developed solution. EKYC is a process where the financial institute and NBFIs need to screen their customers during onboarding to their institute.
                </p>

                <p>
                    The solution follows local law and regulations,  collects customers' identity-related information from the verified Government agencies.
                    To meet the proper guidelines, local needs, and affordability to our customers, VSL has introduced different packages to suit the needs of the target market. Our packages also include SaaS (Software as a Service) model and an on-premise model which is designed to accommodate the demanding needs and considering future enhancements also.
                </p>

               

            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
                <div class="ibox-content">
                    <form id="customer-login" class="m-t" role="form" action="{{ route('self.registation.register') }}" method="POST">
                        @csrf
                        <input type="hidden" id="company_id" name="company_id" value="{{ $company_id }}">
                        <div class="form-group">
                            <input type="text" class="form-control  @error('phone') is-invalid @enderror" value="{{ old('phone') }}" name="phone" placeholder="Mobile Number" required >
                            @if($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control  @error('email') is-invalid @enderror" value="{{ old('email') }}"   name="email" placeholder="Email">
                            @if($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>    
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block"  value="submit" >
                        </div>                     
                    </form>                    
                </div>
            </div>
        </div>
        <hr/>
        
        <div class="row">
            <div class="col-md-12">
                &copy; Venture Solution Limited &nbsp;<small> [ 2020- {{ date('Y') }} ]</small>
            </div>
        </div>
    </div>

    
 <script src="{{ asset('assets/js/jquery-3.2.1.slim.min.js') }} "></script>
 <script src="{{ asset('assets/js/jQuery-plugin-progressbar.js') }}"></script>
 <script src="{{ asset('assets/js/js.js') }}"></script> 

<!-- Mainly scripts -->
<script src="{{ asset('assets/js/jquery-3.1.1.min.js')}}"></script>


<!-- Toster Js -->
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>

{!! Toastr::message() !!}

<!-- jQuery Validator Js -->
<script src="{{ asset('assets/js/plugins/validator/validate.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/validator/additional-method.min.js') }}"></script>




    <script>
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


           

            $("#customer-login").validate({
                rules: {
                    phone: {
                        required: true,
                        phone: true,                        
                    },
                    email : {
                        email: true   
                    }
                },
                messages: {
                    phone: {
                        required: 'please enter your mobile number',                        
                    },
                    email : {
                        email: "invalid email address",      
                    }
                }
            });
        });
    </script>

</body>
</html>


