@extends('layouts.app')

@section('title')
    Search Customer
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Customer Profile</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Customer</a>
            </li>
            <li class="breadcrumb-item">
                <a>Customer Search</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Customer Profile</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-lg m-t-lg">
        <div class="col-md-6">
            <div class="profile-image">
                <img src="{{ asset($customer->face->webcam_face_image) }}" class="rounded-circle circle-border m-b-md" alt="profile">
            </div>
            <div class="profile-info">
                <div class="">
                    <div>
                        <h2 class="no-margins">
                            {{ $customer->customer->en_name }}
                        </h2>
                        <h4>{{ $customer->customer->mobile_no }}</h4>
                        <small>
                            {{ $customer->ec->present_address }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <table class="table small m-b-xs">
                
            </table>
        </div>
        <div class="col-md-3">
            <small>Registatin on {{ $customer->created_at->diffForHumans() }}</small>
            <h4 class="no-margins">{{ date('jS F,Y h:i s', strtotime($customer->created_at)) }}</h4>
            <div id="sparkline1"></div>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>NID Front Image</h3>
                    <img class="img img-fluid img-responsive" src="{{ asset($customer->customer->front_image) }}" alt="">
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-content">
                    <h3>NID Back Image</h3>
                    <img class="img img-fluid img-responsive" src="{{ asset($customer->customer->back_image) }}" alt="">
                </div>
            </div>


        </div>

        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h5>NID Image Matching Score With EC</h5>
                            @php
                                $text_matching_score = ($customer->score->bn_name_percentage +  $customer->score->en_name_percentage +    $customer->score->father_name_percentage +  $customer->score->mother_name_percentage + $customer->score->address_percentage + $customer->score->date_of_birth_percentage + $customer->score->blood_group_percentage) / 7;
                            @endphp
                            <h2> 100 / {{ number_format($text_matching_score,2) }} </h2>
                            <input type="hidden" id="text_matching_score" value="{{ $text_matching_score }}">
                            <div class="text-center">
                                <div id="sparkline6"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h5>Face Matching Score</h5>
                            <h2> 100 / {{ number_format($customer->face->recognize_percentage,2) }}</h2>
                            <input type="hidden" id="recognize_percentage" value="{{ $customer->face->recognize_percentage }}">
                            <div class="text-center">
                                <div id="sparkline7"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social-feed-box">
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 150px">NAME</th>
                            <th>EC DATA</th>
                            <th>OCR DATA</th>                            
                            <th>SCORE</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Bangla Name</td>
                                <td><span id="ec_bangla_name">{{ $customer->ec->bn_name }}</span></td>
                                <td><span id="ocr_bangla_name">{{ $customer->customer->bn_name }}</span></td>
                                <td id="bangla_name_percentage">{{ $customer->score->bn_name_percentage }}% </td>
                            </tr>
                            <tr>
                                <td>English Name</td>
                                <td><span id="ec_english_name">{{ $customer->ec->en_name }}</span></td>
                                <td><span id="ocr_english_name">{{ $customer->customer->en_name }}</span></td>
                                <td id="english_name_percentage">{{ $customer->score->en_name_percentage }}%</td>
                            </tr>
                            <tr>
                                <td>Father Name</td>
                                <td><span id="ec_father_name">{{ $customer->ec->father_name }}</span></td>
                                <td><span id="ocr_father_name">{{ $customer->customer->father_name }}</span></td>
                                <td  id="father_name_percentage">{{ $customer->score->father_name_percentage }}% </td>
                            </tr>
                            <tr>
                                <td>Mother Name</td>
                                <td><span id="ec_mother_name">{{ $customer->ec->mother_name }}</span></td>
                                <td><span id="ocr_mother_name">{{ $customer->customer->mother_name }}</span></td>
                                <td  id="mother_name_percentage">{{ $customer->score->mother_name_percentage }}% </td>
                            </tr>
                            <tr>
                                <td>Date Of Birth</td>
                                <td><span id="ec_date_of_birth">{{ $customer->ec->date_of_birth }}</span></td>
                                <td><span id="ocr_date_of_birth">{{ $customer->customer->date_of_birth }}</span></td>
                                <td  id="date_of_birth_percentage">{{ $customer->score->date_of_birth_percentage }}% </td>
                            </tr>
                            <tr>
                                <td>Blood Group</td>
                                <td><span id="ec_blood_group">{{ $customer->ec->blood_group }}</span></td>
                                <td><span id="ocr_blood_group">{{ $customer->customer->blood_group }}</span></td>
                                <td  id="blood_group_percentage">{{ $customer->score->blood_group_percentage }}% </td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td><span id="ec_address">{{ $customer->ec->present_address }}</span></td>
                                <td><span id="ocr_address">{{ $customer->customer->address }}</span></td>
                                <td id="address_percentage">{{ $customer->score->address_percentage }}% </td>
                            </tr>

                        </tbody>
                    </table>
                 </div>

            </div>
        </div>

    </div>

</div>

@endsection


@push('js')
       <!-- Sparkline -->
       <script src="{{ asset('assets/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
       <script>
        $(document).ready(function() {

            function textMatchPercentage(percentage){
                var sparklineCharts = function(){
                    var not_match  = 100 - percentage;
                
                    $("#sparkline6").sparkline([percentage, not_match ], {
                        type: 'pie',
                        height: '140',
                        sliceColors: ['#1ab394', '#F5F5F5']
                    });
                }; 

                var sparkResize;

                $(window).resize(function(e) {
                    clearTimeout(sparkResize);
                    sparkResize = setTimeout(sparklineCharts, 500);
                });

                sparklineCharts();
            }

            function faceMatchingScore(percentage){
                var sparklineCharts = function(){
                    var not_match  = 100 - percentage;
                
                    $("#sparkline7").sparkline([percentage, not_match ], {
                        type: 'pie',
                        height: '140',
                        sliceColors: ['#1ab394', '#F5F5F5']
                    });
                }; 

                var sparkResize;

                $(window).resize(function(e) {
                    clearTimeout(sparkResize);
                    sparkResize = setTimeout(sparklineCharts, 500);
                });

                sparklineCharts();
            }

            var text_matching_score = $('#text_matching_score').val();
            textMatchPercentage(text_matching_score);

            var recognize_percentage = $('#recognize_percentage').val();
            faceMatchingScore(recognize_percentage);

            


        });
    </script>
@endpush



