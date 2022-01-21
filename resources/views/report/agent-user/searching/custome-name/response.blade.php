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
    Cash Searching Response
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Cash Searching Response</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item"> 
                <a>Searching</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Cash Searching Response</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
@endsection

@section('content')



<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Cash Searching Response by {{ $customer_name }} </h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>SL</th>
								<th>Agent Name</th>
                                <th>Account Type</th>
                                <th>Product Type</th>
                                <th>Account Name</th>     
                                <th>Account No</th>                                
                                <th>Account Opening Timestamp</th>
								<th>Customer Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;  
                            @endphp

                            @foreach($results as $result)
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $result->agent_name }}</td>
									<td>{{ $result->account_type_name }} Account</td>
									<td>{{ $result->product_name }}</td>
									<td>{{ $result->account_name }}</td>
									<td>{{ $result->account_no }}</td>
									<td>{{ date('jS F,Y h:i a', strtotime($result->created_at)) }}</td>
									<td>
                                        <a href="{{ route('verified.customer.customer_view', $result->customer_id) }}">
											<i class="fa fa-file-text-o"></i> &nbsp; customer details
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


        
        function authorizeTransaction(id) {
            swal({
                title: 'Are you sure?',
                text: "You wan't to authorize this transaction!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, authorize it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('authorize-form-'+id).submit();
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