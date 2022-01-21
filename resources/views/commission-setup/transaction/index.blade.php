@extends('layouts.app')

@section('title', 'account open commission')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Transaction Commission</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Commission
            </li>
            <li class="breadcrumb-item active">
                <strong>Transaction Commission</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')

<div class="wrapper wrapper-content" style="margin-bottom: -30px;">
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary btn-facebook text-white" href="{{ route('commission_setup.transaction.create') }}">
                <i class="fa fa-plus-circle"> </i> Add New
            </a>
        </div>
    </div>
</div>


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
                <th>Product Name</th>
                <th>Commission Amount (TK)</th>
                <th>Parcentage Amount (%)</th>
                <th>Start Slab</th>
                <th>End Slab</th>
                <th>Vat</th>
                <th>Option</th>
               
            </tr>
            </thead>
            <tbody>
                @php
                    $sl = 1;
                @endphp
                @foreach($all_commission as $commission)
                @php
                    $commission_amount = $commission->commission_amount;
                    $commission_amount = (float)$commission_amount;

                    $percentage__amount = $commission->percentage__amount;
                    $percentage__amount = (float)$percentage__amount;
                    
                    $start_slab = $commission->start_slab;
                    $start_slab = (float)$start_slab;

                    $end_slav = $commission->end_slav;
                    $end_slav = (float)$end_slav;

                    $vat = $commission->vat;
                    $vat = (float)$vat;

                @endphp
                    <tr class="gradeX">
                        <td>{{ $sl++}}</td>
                        <td>{{$commission->name}}</td>
                        <td>{{ number_format($commission_amount, 2)}}</td>
                        <td>{{ number_format($percentage__amount, 2)}}</td>
                        <td>{{ number_format($start_slab, 2)}}</td>
                        <td>{{ number_format($end_slav, 2)}}</td>
                        <td>{{ number_format($vat, 2)}}</td>
                        <td>
	                        <a class="btn btn-primary btn-facebook text-white" href="{{ route('commission_setup.transaction.edit', $commission->id ) }}">
				                <i class="fa fa-pencil"> </i> Edit
				            </a>
                        </td>
                        
                       
                    </tr>
                @endforeach
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
            });

        });
    </script>
@endpush


