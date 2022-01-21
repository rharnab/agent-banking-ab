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
    Add Agent User
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Add New Agent  User</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Parameter Setup</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add Agent User</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{ route('product.parament_setup.store') }}">
        @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="ibox-content">
                <h2 class="font-bold">Create New Agent User</h2>
                <div class="row">
                    <div class="col-lg-12">    
                        
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label">Account Type</label>
                            <div class="col-lg-12">
                                <select class="select2 form-control @error('account_type_id') is-invalid @enderror" name="account_type_id" required>
                                    <option value="">Select Account Type</option>
                                   @foreach($account_types as $account_type)
                                        <option value="{{ $account_type->id }}">{{ $account_type->name }}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>

                           


                            <div class="form-group">
                                <label for="">Code</label>
                                <input type="text" name="code" id="code" class="form-control"  required="">
                            </div>
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" id="name" class="form-control"  required="">
                            </div>
                                                  
                             
                            <button type="submit" class="btn btn-primary m-b">Save</button>
                       
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