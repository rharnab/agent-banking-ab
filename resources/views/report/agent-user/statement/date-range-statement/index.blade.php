@extends('layouts.app')

@section('title', 'Date Rangewise Statement')

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
        <h2>Date Rangewise Statement</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
               Statement
            </li>
            <li class="breadcrumb-item active">
                <strong>Date Rangewise Statement</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{ route('report.agent_user.statement.date_range_statement.search') }}">
        @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="ibox-content">
                <h2 class="font-bold">Date Rangewise Statement By Customer Account No</h2>
				<hr>
                <div class="row">
                    <div class="col-lg-12">   
                        <div class="form-group">
							<label>Account No</label>
                            <input type="text" name="account_no" id="account_no" class="form-control" required >
                        </div>
						<div class="form-group">
							<label>Starting Date</label>
                            <input type="date" name="starting_date" id="starting_date" value="{{ date('Y-m-d') }}" class="form-control" required >
                        </div>
						<div class="form-group">
							<label>Ending Date</label>
                            <input type="date" name="ending_date" id="ending_date"  value="{{ date('Y-m-d') }}" class="form-control" required >
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

