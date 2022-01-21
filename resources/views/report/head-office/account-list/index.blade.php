@extends('layouts.app')

@section('title', 'List of accounts')

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
        <h2>List of accounts</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
               Report
            </li>
            <li class="breadcrumb-item active">
                <strong>List of accounts</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{ route('report.head_office.account_list.search') }}">
        @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="ibox-content">
                <h2 class="font-bold">List of accounts</h2>
				<hr>
                <div class="row">
                    <div class="col-lg-12"> 
						<div class="form-group">
							<label>Select Agent</label>
                            <select id="agent_id" name="agent_id" class="form-control">
								<option value="all">All Agent</option>
								@foreach($agents as $agent)
									<option value="{{ $agent->id }}">{{ $agent->name }}</option>
								@endforeach
							</select>
                        </div>					
                        <div class="form-group">
							<label>Select Account Type</label>
                            <select id="account_type" name="account_type" class="form-control">
								<option value="all">All Account Type</option>
								@foreach($account_types as $account_type)
									<option value="{{ $account_type->id }}">{{ $account_type->name }}</option>
								@endforeach
							</select>
                        </div>
						<div class="form-group">
							<label>Select Product Type</label>
                            <select id="product_type" name="product_type" class="form-control">
								<option value="all">All Poduct Type</option>
								@foreach($products as $product)
									<option value="{{ $product->id }}">{{ $product->name }}</option>
								@endforeach
							</select>
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


