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
    Limit Modify
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Limit Modify</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>User & Security</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Limit Modify</strong>
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

                <h2 class="font-bold">Limit Modify</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" id="role_create_form" role="form" method="POST" action="{{ route('agent.limit_modify.update',$info->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="">Agent user name</label>
                                <input type="text" disabled name="name" class="form-control"  value="{{ $info->name }}"  required="">
                            </div>

                            <div class="form-group">
                                <label for="">Old Limit</label>
                                <input type="text" disabled  class="form-control"  value="{{ $info->transaction_amount_limit }}"  required="">
                            </div>

                            <div class="form-group">
                                <label for="">New Limit</label>
                                <input type="text" name="new_limit"  class="form-control"  value=""  required="" min="0" max="{{ $info->transaction_amount_limit }}">
                            </div>

                            <button type="submit" class="btn btn-primary block full-width m-b">Update Limit</button>
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