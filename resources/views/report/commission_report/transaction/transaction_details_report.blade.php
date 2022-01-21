@extends('layouts.app')

@section('title', 'commission')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2> Transaction Details Commission</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Report
            </li>
            <li class="breadcrumb-item active">
                <strong>Transaction commission</strong>
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
                <th>Agent</th>
                <th>Agent User</th>
                <th>Account type</th>
                <th>Account  Name</th>
                <th>Account No</th>
                <th>Amount</th>
                <th>Transaction Type</th>
                <th>Commission</th>
                <th>Operation Date</th>
               
               
            </tr>
            </thead>
            <tbody>
                @php 
                $sl=1; 
                $total_amount= 0;
                $total_commission= 0;
               

                @endphp
                @foreach($data as $val)

                    @php

                    if($val->commission_amount !='')
                    {
                        $commission = (float)$val->commission_amount; 
                    }else{

                        $p_commssion =  (float)$val->percentage__amount;
                         $commission= ( $val->amount * $p_commssion )/100;
                    }

                   

                    
                   //toatal
                     $total_amount = $total_amount + $val->amount;
                     $total_commission = $total_commission + $commission;
                    

                    

                    @endphp
                    <tr>
                        <td>{{$sl++}}</td>
                        <td>{{$val->agent_name}}</td>
                        <td>{{$val->agent_user_name}}</td>
                        <td>{{$val->account_type}}</td>
                        <td>{{$val->account_name}}</td>
                        <td>{{$val->account_no}}</td>
                        <td>{{$val->amount}}</td>
                        <td>{{$val->transaction_types_name}}</td>
                        <td>{{ number_format($commission, 2)}}</td>
                        <td>{{$val->approve_date}}</td>
                    </tr>
                @endforeach


                <tr>
                    <td>{{$sl++}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td>{{number_format($total_amount, 2)}}</td>
                    <td>Toal commission</td>
                    <td>{{number_format($total_commission, 2)}}</td>
                   
                    <td></td>
                </tr>
                
            </tbody>
            
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
                    {extend: 'excel', title: 'account_open_commission'},
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


