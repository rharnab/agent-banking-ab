@extends('layouts.app')

@section('title', 'commission')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Transaction open commisssion</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Report
            </li>
            <li class="breadcrumb-item active">
                <strong>Transaction Open Commission</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
           
            <div class="ibox-content">

                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>SL</th>
                <th>Commission trnsaction Type</th>
                <th>Commission Amount</th>
                <th>Parcentage Amount of Commission</th>
                <th>Start Slab</th>
                <th>End Slab</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $sl = 1;
                    $t_commission_amt = 0; 
                    $t_parcent_amt = 0; 
                    $per_commission_amount = 0;
                    $per_percent_amt = 0;

                @endphp
                @foreach($data as $val)
                    @php 

                    $t_commission_amt = $t_commission_amt + $val->commission_amount;
                    $t_parcent_amt = $t_parcent_amt + $val->percentage_of_amt;
                    $per_commission_amount= $val->commission_amount * $sl;
                    $per_percent_amt= $val->percentage_of_amt * $sl;
                    @endphp
                    <tr class="gradeX">
                        <td>{{ $sl++ }}</td>
                        <td>{{$val->name}}</td>
                        <td>{{ $per_commission_amount }}</td>
                        <td>{{ $per_percent_amt }}</td>
                        <td>{{ $val->start_slab }}</td>
                        <td>{{ $val->end_slav }}</td>
                       
                    </tr>
                @endforeach
            </tbody>
            <tr>
                <td colspan="2">Total</td>
                <td>
                    {{ $t_commission_amt}}
                    
                </td>
                <td>
                    {{ $t_parcent_amt}}
                    
                </td>
                <td>
                    
                </td>
            </tr>
            </table>
                </div>

            </div>
        </div>
    </div>
    </div>
</div>
@endsection


@push('js')
    <script src="{{ asset('assets/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });
    </script>
@endpush


