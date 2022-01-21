@extends('layouts.app')

@push('css')
    <style>
        .add-new-button{
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
        }
    </style>
@endpush

@section('title')
    Password Change
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Password Change</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Profile Setup</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Password Change</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@section('content')
<div class="passwordBox animated fadeInDown">
    <div class="row">

        <div class="col-md-12">
            <div class="ibox-content">

                <h2 class="font-bold">Password Change</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" id="password_change_form" role="form" method="POST" action="{{ route('password-change.update') }}">
                            @csrf
                            <div class="form-group">
                                <input type="password" name="old_password" class="form-control" placeholder="Old Password" required="">
                            </div>
                            <div class="form-group">
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" required="">
                            </div>
                            <div class="form-group">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Re-Type Password" required="">
                            </div>
                            <button type="submit" class="btn btn-primary block full-width m-b">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
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
        });

           

            $("#password_change_form").validate({
                rules: {
                    old_password: {
                        required: true,
                    },
                    new_password: {
                        required : true,
                        minlength: 8
                    },
                    confirm_password: {
                        required: true,
                        equalTo : "#new_password"
                    }
                },
                messages: {
                    old_password: {
                        required: "please enter your old-password",
                    },
                    new_password: {
                        required : "please enter new-password",
                        minlength: "password must have at-least 8 character"
                    },
                    confirm_password: {
                        required: "please re-type your new-password",
                        equalTo : "Please enter the same password. "
                    }
                }
            });

        });
    </script>
@endpush