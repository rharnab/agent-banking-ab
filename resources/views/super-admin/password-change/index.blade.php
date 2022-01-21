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
    Password Reset
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2> Password Reset</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>User & Security</a>
            </li>
            <li class="breadcrumb-item active">
                <strong> Password Reset</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{ route('super_admin.password_reset.reset') }}">
        @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="ibox-content">
                <h2 class="font-bold"> Password Reset</h2>
                <hr>
                <div class="row">
                    <div class="col-lg-12">                        
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label">Select User</label>
                            <div class="col-lg-12">
                                <select class="select2 form-control @error('agent_user_id') is-invalid @enderror" name="agent_user_id" required>
                                    <option value="">Select User</option>
                                   @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>               
                            <button type="submit" class="btn btn-primary ">Reset</button>
                       
                    </div>
                    <div class="col-lg-6"> 
                       

                        
                </div>

                </div>
            </div>
        </div>
    </div>
</form>
</div>
@endsection

@push('js')
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

           

            $("#branch_create_form").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    branch_code: {
                        required: true,
                    },
                    routing_number: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "please write branch name",
                    },
                    branch_code: {
                        required: "please write bb branch code",
                    },
                    routing_number: {
                        required: "please write branch routing number",
                    },
                }
            });

        });
    </script>
@endpush