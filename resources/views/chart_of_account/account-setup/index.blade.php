@extends('layouts.app')

@section('title', 'Account-Setup')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>New GL Creation</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
               GL Create
            </li>
            <li class="breadcrumb-item active">
                <strong>New GL Creation</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')

<div class="wrapper wrapper-content" style="margin-bottom: -30px;">
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-primary btn-facebook text-white" href="{{ route('account_setup.create') }}">
                <i class="fa fa-plus-circle"> </i> Add New
            </a>

            <a class="btn btn-primary btn-facebook text-white" href="{{ route('account_setup.tree_view') }}">
                <i class="fa fa-tree"> </i> Tree View
            </a>

            <a class="btn btn-warning  text-white" href="{{ route('account_setup.pending') }}">
                <i class="fa fa-clock-o"> </i> Pending Authorization
            </a>
        </div>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>New GL Creation</h5>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>SL</th>
                <th>Account Name</th>
                <th>Account Code</th>
                <th>Account Level</th>
                <th>Account Types</th>
                <th>Immediate Parent</th>
                <th>Allow Manual Transaction</th>
                <th>Allow Negative Balance</th>
                <th>Is Default</th>
                <th>Access</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $sl = 1;   
                @endphp
                @foreach($accounts as $account)
                    <tr class="gradeX">
                        <td>{{ $sl++ }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->acc_code }}</td>
                        <td>{{ $account->acc_level }}</td>
                        <td>
                            {{ $account->account_type_name }}
                        </td>
                        <td>
                            @if($account->immediate_parent == 0)
                                Root Account
                            @else 
                                {{ $account->parent_accont_name }}
                            @endif
                            
                        </td>
                        <td>
                            @if($account->allow_manual_transaction == 1)
                                Yes
                            @elseif($account->allow_manual_transaction == 0)
                                No
                            @endif
                        </td>
                        <td>
                            @if($account->allow_negative_balance == 1)
                                Yes
                            @elseif($account->allow_negative_balance == 0)
                                No
                            @endif
                        </td>
                        <td>
                            @if($account->is_default == 1)
                                Yes
                            @elseif($account->is_default == 0)
                                No
                            @endif
                        </td>
                        <td>
                            @if($account->is_agent_access == 1)
                                Ho/Agent
                            @elseif($account->is_agent_access == 0)
                                Ho
                            @endif
                        </td>
                        <td>
                            @if($account->status == 0)
                                <p><span class="badge badge-danger">Pending</span></p>
                            @elseif($account->status == 1)
                                <p><span class="badge badge-primary">Approved</span></p>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('account_setup.edit', $account->id) }}" class="btn btn-primary">
                                <i class="fa fa-pencil"> </i> 
                            </a>
                            <a href="#" class="btn btn-danger">
                                <i class="fa fa-trash"> </i>                             </a>
                        </td>
                    </tr>
                @endforeach
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


