@extends('layouts.app')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <style>
        .add-new-button{
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
        }
    </style>
@endpush

@section('title')
   Agent User Setup
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Transfer Transaction List</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Transaction</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Transaction List</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@section('content')
<div class="row mt-3">
    <div class="col-md-12 add-new-button">
        <a href="{{ route('parameter.agent.user.create') }}" class="btn btn-primary dim" ><i class="fa fa-plus"></i> Add New</a>
    </div>    
</div> 


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Transfer Transaction List</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>SL</th>                              
                                <th>Account Type</th>                                
                                <th>Debit A/C</th>
                                <th>Transaction Type</th>
                                <th>Credit A/C</th>
                                <th>Amount</th>
                                <th>Currency</th>
                                <th>Cheaque No</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sl = 1;  
                          @endphp
                          @foreach($fund_transfers as $fund_transfer)
                              <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>
                                        @if($fund_transfer->acc_option == 1)
                                            <p><span class="badge badge-danger">Customer A/C</span></p>
                                        @elseif($fund_transfer->acc_option == 2)
                                            <p><span class="badge badge-primary">GL</span></p>
                                        @endif
                                    </td>
                                    <td>{{ $fund_transfer->debit_ac }}</td>

                                    <td>
                                        @if($fund_transfer->txn_type == 1)
                                            <p><span class="badge badge-danger">Cash Deposit A/C</span></p>
                                        @elseif($fund_transfer->txn_type == 2)
                                            <p><span class="badge badge-primary">Cash Withdraw</span></p>
                                        @endif
                                    </td>                                 
                                    <td>{{ $fund_transfer->credit_ac }}</td>
                                    <td>{{ $fund_transfer->amount }}</td>
                                    <td>
                                        @if($fund_transfer->currency == 1)
                                            <p><span class="badge badge-danger">BDT</span></p>
                                        @elseif($fund_transfer->currency == 2)
                                            <p><span class="badge badge-primary">USD</span></p>
                                        @endif
                                    </td>
                                    <td>{{ $fund_transfer->cheaque_no }}</td>
                                  <td>
                                      @if($fund_transfer->is_approve == 0)
                                          <p><span class="badge badge-danger">Pending</span></p>
                                      @elseif($fund_transfer->is_approve == 1)
                                          <p><span class="badge badge-primary">Approved</span></p>
                                      @endif
                                  </td>
                                  <td>
                                        <form action="{{ route('transfer.fund.update',['id'=>$fund_transfer->id]) }}" method="post" id="update-id-{{ $fund_transfer->id }}">
                                            @csrf
                                            @method('PUT')

                                        </form>
                                        <button class="btn btn-primary btn-bitbucket" id="update-btn-id-{{ $fund_transfer->id }}" onclick="authFundTransfer('{{ $fund_transfer->id }}')">
                                            <i class="fa fa-check"></i> 
                                        </button>
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
    <script src="{{ asset('assets/js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
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

        function authFundTransfer(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Approve it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('update-id-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }

    </script>
@endpush