
<!DOCTYPE html>
<html><head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agent Banking | Login </title>

    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
    <link rel="shortcut icon" sizes="16x16" type="image/jpg" href="{{ asset('assets/img/favicon-32x32.png') }}"/>

    <style>
       body{
           display: flex;
           align-items: center;
       }
    </style>

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6" style="text-align: center; margin-top: 60px;">
                <h3 class="font-bold" >Welcome To AGENT-BANKING</h3>
               
                <p>
                    <img style="height: 140px" src="{{ asset('assets/img/h.png') }}" alt="">
                </p>
            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form method="POST" action="{{ route('login') }}" class="m-t" role="form">
                        @csrf
                        <div class="form-group">
                            <input type="text" autocomplete="off" class="form-control @error('user_id') is-invalid @enderror" placeholder="user id" name="user_id" value="{{ old('user_id') }}" required autocomplete="user_id" autofocus>
                            @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" autocomplete="off" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                        @if (Route::has('password.request'))          
                            <a href="{{ route('password.request') }}">
                                <small>Forgot password?</small>
                            </a>
                        @endif
                    </form>
                    <p class="m-t">
                        <small>&copy; Venture Solution Limited  2020 - {{  date('Y')  }}</small>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Venture Solution Limited
            </div>
            <div class="col-md-6 text-right">
               <small>© 2020- {{ date('Y') }} </small>
            </div>
        </div>
    </div>

</body>
</html>
