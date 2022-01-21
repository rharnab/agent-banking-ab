
<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.9.3/forgot_password.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Sep 2020 06:10:52 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-KYC | Forgot password</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        body{
            display: flex;
            align-items: center;
        }
     </style>

</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2 class="font-bold">Forgot password</h2>

                    <p>
                        Enter your email address and your password will be reset and emailed to you.
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="form-group">                                    
                                    <input id="email" type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Send Password Reset Link') }}</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
               Venture Soluiton Limited
            </div>
            <div class="col-md-6 text-right">
               <small>© 2020-{{ date('Y') }}</small>
            </div>
        </div>
    </div>

</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.9.3/forgot_password.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Sep 2020 06:10:52 GMT -->
</html>
