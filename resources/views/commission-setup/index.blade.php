@extends('layouts.app')

@section('title', 'Commission list')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Commission Set up list</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                commission set up
            </li>
            <li class="breadcrumb-item active">
                <strong>All commission</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')

{{-- <div class="wrapper wrapper-content" style="margin-bottom: -30px;">
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary btn-facebook text-white" href="{{ route('account_setup.create') }}">
                <i class="fa fa-plus-circle"> </i> Add New
            </a>

            <a class="btn btn-primary btn-facebook text-white" href="{{ route('account_setup.tree_view') }}">
                <i class="fa fa-tree"> </i> Tree View
            </a>
        </div>
    </div>
</div> --}}


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Commission Set up list</h5>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>SL</th>
                <th>Commission Type</th>
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
                @endphp
                @foreach($data as $val)
                    <tr class="gradeX">
                        <td>{{ $sl++ }}</td>
                        <td>{{ $val->commission_type_name }}</td>
                        <td>{{$val->commission_trn_name}}</td>
                        <td>{{ $val->commission_amount }}</td>
                        <td>{{ $val->percentage_of_amt }}</td>
                        <td>{{ $val->start_slab }}</td>
                        <td>{{ $val->end_slav }}</td>
                       
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


