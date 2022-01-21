@extends('layouts.app')

@section('title')
   All Verified Customer
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Verified Customer</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>All Verified Customer</a>
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
        @foreach($customerList as $customer)
            <div class="col-lg-4">
                <div class="contact-box">
                    <a class="row" href="{{ route('verified.customer.customer_view', $customer->id) }}">
                    <div class="col-4">
                        <div class="text-center">
                            <img alt="image" class="rounded-circle m-t-xs img-fluid" style="height: 80px; width:80px" src="{{ asset($customer->webcam_face_image) }}">
                            
                            <div class="m-t-xs font-bold">NID NUMBER</div>
                            <div class="m-t-xs font-bold">{{ $customer->nid_number }}</div>
                        </div>
                    </div>
                    <div class="col-8">
                        <h3><strong>{{ $customer->en_name }}</strong></h3>
                        <p><i class="fa fa-phone"></i> {{ $customer->mobile_number }}</p>
                        <address>
                            <strong>Address</strong><br>
                            {{ $customer->present_address }}
                            <br>
                        </address>
                    </div>
                        </a>
                </div>
            </div>
        @endforeach        
    </div>
</div>
@endsection

