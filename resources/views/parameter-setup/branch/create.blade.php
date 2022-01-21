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
    Create Branch
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Crete New Role</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Parameter Setup</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Branch</strong>
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
                <h2 class="font-bold">Create New Branch</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{ route('parameter.branch.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="">Branch Name</label>
                                <input type="text" name="name" class="form-control"  required="">
                            </div>
                            <div class="form-group">
                                <label for="">Branch Address</label>
                                <input type="text" name="address" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="">Branch Code</label>
                                <input type="text" name="br_code" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="">BB Branch Code</label>
                                <input type="text" name="branch_code" class="form-control"  required="">
                            </div>
                            <div class="form-group">
                                <label for="">Routing No</label>
                                <input type="text" name="routing_number" class="form-control"  required="">
                            </div>                            
                            <button type="submit" class="btn btn-primary block full-width m-b">Save</button>
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