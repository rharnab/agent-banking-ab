@extends('layouts.app')

@section('title')
    Search Customer
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>eKYC Registration</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
           
            <li class="breadcrumb-item active">
                <strong>eKYC Registration</strong>
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

        <div class="col-lg-5">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Search Customer With Mobile & NID</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form id="customer-search-form" method="POST" action="{{ route('branch.registration.customer_search') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Mobile Number</label>
                            <div class="col-lg-8">
                                <input type="text" placeholder="Mobile Number"  name="mobile_number" value="@isset($mobile_number) {{ $mobile_number }}  @endisset" class="form-control  @error('mobile_number') is-invalid @enderror"> 
                                @if($errors->has('mobile_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">NID Number</label>
                            <div class="col-lg-8">
                                <input type="text" name="nid_number" value="@isset($nid_number) {{ $nid_number }}  @endisset" placeholder="NID Number" class="form-control @error('nid_number') is-invalid @enderror">
                                @if($errors->has('nid_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nid_number') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-8">
                                <button class="btn btn-primary" type="submit">Search Customer</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @isset($customer_search_result)
            <div class="col-lg-5">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Search Customer Result</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        @if($is_customer_found === false)
                            <p style="font-size:16px; text-transform:capitalize;">customer not found. please <a href="{{ route('customer.registation.show_registation_form',[$mobile_number, $nid_number]) }}">register</a> this customer</p>
                        @else
                            @foreach ($customerDatas as $singleCustomer)
                                <div class="dropdown-messages-box">
                                    <a class="dropdown-item float-left" href="{{ route('customer.profile',$singleCustomer->id) }}">
                                        <img alt="image" class="rounded-circle" src="{{ asset($singleCustomer->face->webcam_face_image) }}">
                                    </a>
                                    <div class="media-body ">
                                        <small class="float-right text-navy">{{$singleCustomer->created_at->diffForHumans()}}</small>
                                        <strong>{{ $singleCustomer->customer->en_name }} are registered <br></strong> NID  <strong>{{ $singleCustomer->customer->nid_number }}</strong> Mobile <strong>{{ $singleCustomer->customer->mobile_no }}</strong>. <br>
                                        <small class="text-muted">Register Time : {{ date('jS F,Y h:i s', strtotime($singleCustomer->created_at)) }}</small>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                            
                            @if($is_available_register === true)
                                
                                <a href="{{ route('customer.registation.show_registation_form',[$mobile_number, $nid_number]) }}">Register this customer</a>
                            @endif
                            
                        @endif
                    </div>
                </div>
        </div>
        @endisset


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
            errorPlacement: function (error, element) {
                if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent());
                } else {
                error.insertAfter(element);
                }
            }
            });

            $.validator.addMethod('phone', function(value) {
                return /\b(88)?01[3-9][\d]{8}\b/.test(value);
            }, 'Please enter valid phone number');


           

            $("#customer-search-form").validate({
                rules: {
                    mobile_number: {
                        required: true,
                        phone: true,
                        
                    },
                },
                messages: {
                    mobile_number: {
                        required: 'please enter customer mobile number',                        
                    },
                }
            });

        });
    </script>
@endpush

