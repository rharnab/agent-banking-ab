@extends('layouts.app')

@section('title', 'account open commission')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Statement  Commission</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Commission
            </li>
            <li class="breadcrumb-item active">
                <strong>Statement Commission</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')

<div class="wrapper wrapper-content" style="margin-bottom: -30px;">
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary btn-facebook text-white" href="{{ route('commission_setup.statement.create') }}">
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
                <th>Commission Amount</th>
               {{--  <th>Start Slab</th>
                <th>End Slab</th> --}}
                {{-- <th>Vat</th> --}}
                <th>Option</th>
               
            </tr>
            </thead>
            <tbody>
                @php
                    $sl = 1;   
                @endphp
                @foreach($all_commission as $commission)
                    <tr class="gradeX">
                        <td>{{ $sl++}}</td>
                        <td>{{$commission->name}}</td>
                        <td>{{number_format($commission->commission_amount, 2)}}</td>
                        {{-- <td>{{$commission->start_slab}}</td>
                        <td>{{$commission->end_slav}}</td> --}}
                        {{-- <td>{{$commission->vat}}</td> --}}
                        <td>
	                        <a class="btn btn-primary btn-facebook text-white" href="{{ route('commission_setup.statement.edit', $commission->id ) }}">
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


