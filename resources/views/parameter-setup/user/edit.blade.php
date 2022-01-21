@extends('layouts.app')

@push('css')
    <link href="{{ asset('assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .add-new-button{
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
        }
    </style>
@endpush

@section('title')
    Edit User
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Edit User</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Parameter Setup</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit User</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="ibox-content">
                <h2 class="font-bold">Create New User</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <form  id="user-create-form" method="POST" enctype="multipart/form-data" action="{{  route('parameter.user.update', $user->id) }}">
                            @csrf
                            @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">User ID</label>
                                <div class="col-lg-9">
                                    <input type="text" name="user_id"  class="form-control @error('user_id') is-invalid @enderror" value="{{ $user->user_id }}">
                                    @if($errors->has('user_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Name</label>
                                <div class="col-lg-9">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}"> 
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif                                   
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Email</label>
                                <div class="col-lg-9">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">
                                    @if($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Mobile</label>
                                <div class="col-lg-9">
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $user->phone }}">
                                    @if($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Role</label>
                                <div class="col-lg-9">
                                    <select class="select2 form-control @error('role_id') is-invalid @enderror" name="role_id" >
                                        <option value="">Select User Role</option>
                                       @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @if($role->id == $user->role_id) {{ "selected" }} @endif>{{ $role->name }}</option>
                                       @endforeach
                                    </select>
                                    @if($errors->has('role_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('role_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Branch</label>
                                <div class="col-lg-9">
                                    <select class="select2 form-control @error('branch_id') is-invalid @enderror" name="branch_id">
                                        <option value="">Select Branch</option>
                                       @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}"  @if($branch->id == $user->branch_id) {{ "selected" }} @endif>{{ $branch->name }}</option>
                                       @endforeach
                                    </select>
                                    @if($errors->has('branch_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('branch_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            

                            <div class="form-group row">
                                <div class="col-lg-offset-4 col-lg-8">
                                    <button class="btn btn-sm btn-primary" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <!-- Select2 -->
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(".select2").select2({
            theme: 'bootstrap4'
        });
    </script>
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

           

            $("#user-create-form").validate({
                rules: {
                    user_id: {
                        required: true                        
                    },
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email : true,
                    },
                    phone: {
                        required: true
                    },
                    role_id: {
                        required: true
                    },
                    branch_id: {
                        required: true,
                    }
                },
                messages: {
                    user_id: {
                        required: "please write user id"                        
                    },
                    name: {
                        required: "please write user name"
                    },
                    email: {
                        required: "please write user email",
                        email : "please enter valid email",
                    },
                    phone: {
                        required: "please enter user mobile number"
                    },
                    role_id: {
                        required: "please select user role"
                    },
                    branch_id: {
                        required: "please select user branch",
                    }
                }
            });

        });
    </script>
@endpush