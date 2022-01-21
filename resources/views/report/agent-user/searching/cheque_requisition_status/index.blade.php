@extends('layouts.app')

@section('title', 'Cheque Requisition Status')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

    <style type="text/css">
        label{
            margin-left: 20px;
        }
      
    </style>
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Cheque Requisition Status</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
               Searching
            </li>
            <li class="breadcrumb-item active">
                <strong>Cheque Requisition Status</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{ route('report.agent_user.searching.cheque_requisition_status.search') }}">
        @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="ibox-content">
                <h2 class="font-bold">Cheque Requisition Status By Account No</h2>
                <div class="row">
                    <div class="col-lg-12">   
                        <div class="form-group">
                            <label for="">Account No</label>
                            <input type="text" name="account_no" id="account_no" class="form-control" required >
                        </div>
                        <button type="submit" class="btn btn-primary ">Search</button>                       
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
</div>







@endsection

