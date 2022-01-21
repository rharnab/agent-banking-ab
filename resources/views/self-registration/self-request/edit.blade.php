@extends('layouts.app')

@section('title')
    single-account-opening-request
@endsection

@push('css')
<style>
    .img_rounded{
        height: 100px;
        width: 100px;
    }
</style>
<link href="{{ asset('assets/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/css/plugins/select2/select2-bootstrap4.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Account Opening Request Details</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Account Opening</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Ammendment & Resend Account Opening Request</strong>
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
        <div class="col-lg-6 offset-md-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Account Opening Form</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('outside.customer.resend_request', $request_info->id) }}" method="POST">
                        @csrf
                        <p>Account opening request ammendment & resend request</p>
                        <div class="form-group row"><label class="col-lg-4 col-form-label">Select Branch</label>
                            <div class="col-lg-8">
                                <select name="branch_id" id="" class="form-control select2_demo_1" required>
                                    <option value="">Select Branch</option>
                                    @foreach($all_branch as $single_branch)
                                        <option value="{{ $single_branch->id }}" <?php if($single_branch->id == $request_info->branch_id){ echo "selected"; } ?> >{{ $single_branch->name }}</option>
                                    @endforeach
                                </select>                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Monthly Income</label>
                            <div class="col-lg-8">
                                <input type="number" name="probably_monthly_income" value="{{ $request_info->probably_monthly_income }}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Probably Monthly Deposite</label>
                            <div class="col-lg-8">
                                <input type="number" name="probably_monthly_deposite" value="{{ $request_info->probably_monthly_deposite }}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Probably Monthly Withdraw</label>
                            <div class="col-lg-8">
                                <input type="number" name="probably_monthly_withdraw" value="{{ $request_info->probably_monthly_withdraw }}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Nominee Name</label>
                            <div class="col-lg-8">
                                <input type="text" name="nominee_name" value="{{ $request_info->nominee_name }}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Nominee NID</label>
                            <div class="col-lg-8">
                                <input type="text" name="nominee_nid_number" value="{{ $request_info->nominee_nid_number }}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Nominee Address</label>
                            <div class="col-lg-8">
                                <textarea name="nominee_address" id="" cols="3" rows="3" class="form-control" required>{{ $request_info->nominee_address }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <button class="btn btn-sm btn-primary btn-block" type="submit">Resent Account Opening Request</button>
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
  <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
<script>
     $(".select2_demo_1").select2({
        theme: 'bootstrap4',
    });    
</script>    
@endpush