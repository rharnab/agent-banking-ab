
<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.9.3/forgot_password.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Sep 2020 06:10:52 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-KYC | OTP</title>

    
    <link rel="shortcut icon" sizes="16x16" type="image/jpg" href="{{ asset('assets/img/favicon-32x32.png') }}"/>


    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="passwordBox animated fadeInDown">
        <div class="row" >
           <div class="col-md-12" id="loader">
              <div class="ibox-content">

                <div class="sk-spinner sk-spinner-double-bounce">
                    <div class="sk-double-bounce1"></div>
                    <div class="sk-double-bounce2"></div>
                </div>


                 <h2 class="font-bold">OTP</h2>
                 <p>
                    Enter your OTP for your verification
                 </p>
                 <div style="visibility: hidden; padding:0px;" id="alert-success" class="alert alert-dismissable">
                    <button aria-hidden="true" class="btn btn-sm btn-primary btn-block" data-dismiss="alert" class="close" type="button">
                    <span  id="resend_otp_message"></span> &nbsp; &nbsp; &nbsp;×
                    </button>                        
                 </div>
                 <div style="visibility: hidden; padding:0px;" id="alert-error" class="alert alert-dismissable">
                    <button aria-hidden="true" class="btn btn-sm btn-danger btn-block" data-dismiss="alert" class="close" type="button">
                    <span  id="resend_otp_error_message"></span> &nbsp; &nbsp; &nbsp;×
                    </button>                        
                 </div>
                 <div class="row">
                    <div class="col-lg-12">
                       <form id="otp_verification" class="m-t" role="form" method="POST"  action="{{ route('self.registation.otp.verification') }}">
                          @csrf
                          <div class="form-group">
                             <input type="hidden" name="user_id" value="{{ $user_id }}">
                             <input type="text" name="otp" required placeholder="O - T - P" pattern="[0-9]{1}[0-9]{3}" class="form-control">
                          </div>
                          @if(isset($error) && !empty($error))
                          <p id="error_message" style="font-weight: bold; color:red;">{{ $message }}</p>
                          @endif
                          <button type="submit" class="btn btn-sm btn-primary btn-block">CONFIRM</button>
                       </form>
                       <br>
                       <p class="text-muted text-center"><small>Did Not Receive OTP ?</small></p>
                       <form id="resend_otp" class="m-t" role="form" method="POST" action="javascript:void(0)">
                          @csrf
                          <div class="form-group">
                             <input type="hidden" name="user_id" value="{{ $user_id }}">
                          </div>
                          <button type="submit" class="btn btn-sm btn-white btn-block">Re-send OTP</button>
                       </form>
                    </div>
                 </div>
              </div>
           </div>
        </div>
        <hr/>
        <div class="row">
           <div class="col-md-6">
             &copy; Venture Solution Limited &nbsp;&nbsp; [ 2020-{{ date('Y') }} ]</small>
           </div>
           <div class="col-md-6 text-right">
              
           </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>

    <script>
        $(document).ready(function (e) {
            $('#alert-success').hide();
            $('#alert-error').hide();

            
           $.ajaxSetup({
              headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
           });
           $('#resend_otp').submit(function (e) {
                $('#loader').children('.ibox-content').addClass('sk-loading');
                e.preventDefault();
                var formData = new FormData(this);  
                $.ajax({
                    type       : 'POST',
                    url        : "{{ route('self.registation.resend.otp') }}",
                    data       : formData,
                    cache      : false,
                    contentType: false,
                    processData: false,
                    success    : (data) => {
                        $('#error_message').html('');
                        $('#loader').children('.ibox-content').removeClass('sk-loading');
                       
                        console.log(data);      
                        var obj = JSON.parse(data);
                        if(obj.error == false){
                            $('#alert-success').show(); 
                            $("#alert-success").css("visibility", "visible");                            
                            $('#resend_otp_message').html(obj.message.trim());
                        }else{
                            $('#alert-error').show();
                            $("#alert-error").css("visibility", "visible");
                            $('#resend_otp_error_message').html(obj.message.trim());
                        }         
                    },
                    error: function (data) {
                        $('#loader').children('.ibox-content').removeClass('sk-loading');
                        console.log(data);
                    }
                });
           });

        });
     </script>


</body>
</html>
