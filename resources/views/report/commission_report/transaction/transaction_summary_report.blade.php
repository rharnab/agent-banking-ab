@extends('layouts.app')

@section('title', 'commission')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Transaction commisssion Summary</h2>
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
                <th>Agent Name</th>
                <th>Agent User</th>
                <th>Account Type</th>
                <th>Total Transaction</th>
                <th>Total Amount</th>
                <th>Total Commission</th>
               
               
            </tr>
            </thead>
            <tbody>
                @php $sl=0; $total_amount=0; $total_commission=0; @endphp
               @foreach($data as $val)
               @php 
               $total_amount= $total_amount + $val->t_amount;

              /* $total_commission= $total_commission + $val->t_commmison_amt;
               $total_par_commission= $total_par_commission + $val->t_parcentage;
*/
                 $p_commission = ($val->t_amount * $val->t_parcentage) / 100;
                 $commission = $p_commission + $val->t_commmison_amt;

                 $total_commission = $total_commission + $commission;



               @endphp
               
                <tr>
                    <td>{{$sl++}}</td>
                    <td>{{$val->agent_name}}</td>
                    <td>{{$val->agent_user_name}}</td>
                    <td>{{$val->transaction_type_name}}</td>
                    <td>{{$val->t_transaction}}</td>
                    <td>{{number_format($val->t_amount,2)}}</td>
                    <td>{{number_format($commission, 2)}}</td>
                   
                </tr>
               @endforeach

               <tr>
                   <td>{{$sl++}}</td>
                   <td></td>
                   <td></td>
                   <td></td>
                  
                   <td>Total</td>
                   <td>{{number_format($total_amount, 2)}}</td>
                   <td>{{number_format($total_commission, 2)}}</td>
                  
                   
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


