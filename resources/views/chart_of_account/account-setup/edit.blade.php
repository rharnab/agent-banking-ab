@extends('layouts.app')

@section('title', 'New-Account-Create')

@push('css')
    <link href="{{ asset('assets/backend/layouts/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/backend/layouts/css/plugins/select2/select2-bootstrap4.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Edit Account Setup</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Account Setup
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Account Setup</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-4 offset-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Edit Account Setup</h5>                   
                </div>
                <div class="ibox-content">
                    <form id="account-setup-form" action="{{ route('account_setup.update', $account_info->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Account Name</label>
                            <div class="col-lg-8">
                                <input type="text" name="name" id="name" required value="{{ $account_info->name }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Account Level</label>
                            <div class="col-lg-8">
                                <select class="select2_demo_1 form-control" required onchange="findParentAccountNo()" name="acc_level" id="acc_level">
                                    <option value="">Select Account Level</option>
                                    @for($i=1; $i<=7; $i++)
                                        <option value="{{$i}}" @if($account_info->acc_level == $i) {{ "selected" }} @endif >{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Account Types</label>
                            <div class="col-lg-8">
                                <select class="select2_demo_1 form-control" required onchange="findParentAccountNo()" name="acc_types" id="acc_types">
                                    <option value="">Select Account Types</option>
                                    @foreach($account_types as $account_type)
                                        <option value="{{ $account_type->id }}" @if($account_info->acc_types == $account_type->id ) {{ "selected" }} @endif >{{ $account_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="parent_acc">
                            <label class="col-lg-4 col-form-label">Parent Account</label>
                            <div class="col-lg-8">
                                <select class="select2_demo_1 form-control" name="immidiate_parent" id="immidiate_parent">
                                    <option value="{{ $account_info->parent_id }}">{{ $account_info->parent_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-6 col-form-label">Allow Manual Transaction</label>
                            <div class="col-lg-6">
                                <div class="form-check abc-radio abc-radio-info form-check-inline">
                                    <input class="form-check-input" type="radio" id="inlineRadio1" value="no" name="allow_manual_transction" @if($account_info->allow_manual_transaction == 0) {{ "checked" }} @endif>
                                    <label class="form-check-label" for="inlineRadio1"> No </label>
                                </div>
                                <div class="form-check abc-radio form-check-inline">
                                    <input class="form-check-input" type="radio" id="inlineRadio2" value="yes" name="allow_manual_transction"  @if($account_info->allow_manual_transaction == 1) {{ "checked" }} @endif>
                                    <label class="form-check-label" for="inlineRadio2"> Yes </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-6 col-form-label">Allow Negetive Balance</label>
                            <div class="col-lg-6">
                                <div class="form-check abc-radio abc-radio-info form-check-inline">
                                    <input class="form-check-input" type="radio" id="inlineRadio3" value="no" name="allow_negetive_transction" @if($account_info->allow_negative_balance == 0) {{ "checked" }} @endif>
                                    <label class="form-check-label" for="inlineRadio1"> No </label>
                                </div>
                                <div class="form-check abc-radio form-check-inline">
                                    <input class="form-check-input" type="radio" id="inlineRadio4" value="yes" name="allow_negetive_transction" @if($account_info->allow_negative_balance == 1) {{ "checked" }} @endif>
                                    <label class="form-check-label" for="inlineRadio2"> Yes </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <button class="btn btn-sm btn-primary btn-block" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
    <!-- Select2 -->
    <script src="{{ asset('assets/backend/layouts/js/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        $(".select2_demo_1").select2({
            theme: 'bootstrap4',
        });



        /***************
        /*  Imadiet Parent Show
        ***************/
        function findParentAccountNo(){
            var acc_level = $('#acc_level').val();
            var acc_types = $('#acc_types').val();
            if(acc_level == 1){
                $('#parent_acc').hide();
                $('select#immidiate_parent').attr('required',false);
            }else{
                $('#parent_acc').show();
                $('select#immidiate_parent').attr('required',true);
            }
            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              })
            if(acc_level && acc_types){
                $.ajax({
                    type: 'POST',
                    url : "{{ route('account_setup.search.parent.account') }}",
                    data: {
                        "acc_level": acc_level,
                        "acc_types": acc_types
                    },
                    success    : (data) => {
                        console.log(data);
                        $('#immidiate_parent').empty().append(data);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        }
    </script>

<script>
    $(document).ready(function(){

        $("#account-setup-form").validate({
            rules: {
                name: {
                    required: true,
                },
                acc_level: {
                    required: true,
                },
                acc_types: {
                    required: true,
                }
            },
            messages : {
                name : {
                    required : "please enter account name"
                },
                acc_level : {
                    required : "please select account lavel"
                },
                acc_types : {
                    required : "please select account type"
                }
            }
        });
   });
</script>




@endpush
