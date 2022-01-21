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
    <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{ route('parameter.agent.user.store') }}">
        @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">
                <h2 class="font-bold">Create New Agent User</h2>
                <div class="row">
                    <div class="col-lg-6">                        

                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Agent</label>
                                <div class="col-lg-12">
                                    <select class="select2 form-control @error('agent_id') is-invalid @enderror" name="agent_id" required>
                                        <option value="">Select Agent</option>
                                       @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" id="name" class="form-control"  required="">
                            </div>
                            <div class="form-group">
                                <label for="">User ID</label>
                                <input type="text" name="user_id" id="user_id" class="form-control"  required="">
                            </div>
                            <div class="form-group">
                                <label for="">Short Code</label>
                                <input type="text" name="short_code" id="short_code" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="">Account No</label>
                                <input type="text" name="account_no" id="account_no" class="form-control" required >
                            </div> 
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" id="email" class="form-control"  email="" required>
                            </div>   
                            <button type="submit" class="btn btn-primary m-b">Save</button>
                       
                    </div>
                    <div class="col-lg-6">      
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>                    
                        <div class="form-group">
                            <label for="">Transaction Amount Limit</label>
                            <input type="number" name="transaction_amount_limit" class="form-control"  required="">
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label">Division</label>
                            <div class="col-lg-12">
                                <select class="select2 form-control @error('division_id') is-invalid @enderror" name="division_id" required>
                                    <option value="">Select Division</option>
                                   @foreach($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label">Districts</label>
                            <div class="col-lg-12">
                                <select class="select2 form-control @error('division_id') is-invalid @enderror" name="district_id" required>
                                    <option value="">Select Division</option>
                                   @foreach($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea name="address" id="address" cols="3" rows="5" class="form-control" required></textarea>
                        </div>                              
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