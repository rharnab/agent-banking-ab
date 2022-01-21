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
    Edit Role
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Edit Role</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>User & Security</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Role</strong>
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

                <h2 class="font-bold">Edit Role</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" id="role_create_form" role="form" method="POST" action="{{ route('role.update',$role->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="">Role Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $role->name }}"  required="">
                            </div>
                            <div class="form-group">
                                <label for="">Role Hierarchy</label>
                                <input type="number" name="status" id="status" class="form-control" value="{{ $role->status }}"  required="">
                            </div>
                            <button type="submit" class="btn btn-primary block full-width m-b">Update Role</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

           

            $("#role_create_form").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    status: {
                        required : true
                    }
                },
                messages: {
                    name: {
                        required: "please write new role name",
                    },
                    status: {
                        required : "please write role hierarchy"
                    }
                }
            });

        });
    </script>
@endpush