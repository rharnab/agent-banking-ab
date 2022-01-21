@extends('layouts.app')

@section('title')
    all-pending-account
@endsection

@push('css')
<style>
    .img_rounded{
        height: 100px;
        width: 100px;
    }
</style>
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Account Opening Authorization</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>A/C Open</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Pending A/C Open</strong>
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
        @foreach($request_list as $single_request)
            <div class="col-lg-4">
                <div class="contact-box">
                    <a class="row" href="{{ route('pending.request.view_single_request',$single_request->id) }}">
                    <div class="col-4">
                        <div class="text-center">
                            <img alt="image"  class="rounded-circle m-t-xs img-fluid img_rounded" src="{{ asset($single_request->webcam_face_image) }}">
                            <div class="m-t-xs mt-3 font-bold">
                                <strong>Request Date</strong><br>
                                <small>{{  date('jS F, Y h:i a', strtotime($single_request->request_timestamp)) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <h3><strong>{{ $single_request->en_name }}</strong></h3>
                        <p><i class="fa fa-phone"></i> &nbsp;&nbsp; {{ $single_request->mobile_number }}</p>
                        <address>
                            <strong>Address.</strong><br>
                            {{ $single_request->present_address }}
                        </address>
                    </div>
                        </a>
                </div>
            </div>
        @endforeach        
    </div>
</div>
@endsection