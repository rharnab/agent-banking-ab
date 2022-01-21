@extends('layouts.app')

@section('title', 'Pending Employee')

@push('css')
    <link href="{{ asset('assets/backend/layouts/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Employee</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Employee
            </li>
            <li class="breadcrumb-item active">
                <strong>Pending Employee</strong>
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
            <div class="ibox-title">
                <h5>All Pending Employee List</h5>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Designation</th>
                <th>Join Date</th>
                <th>Resume</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $sl = 1;   
                @endphp
                @foreach ($employees as $employee)
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->personal_email }}</td>
                    <td>{{ $employee->personal_phone }}</td>
                    <td>{{ $employee->designation_name }}</td>
                    <td>{{ date('jS F,Y', strtotime($employee->join_date)) }}</td>
                    <td>
                        <a href="{{ asset($employee->resume) }}" download>
                            <i class="fa fa-download"></i>
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-bitbucket" type="button" onclick="authorizeEmployee({{ $employee->id }})">
                            <i class="fa fa-check-square"></i>
                        </button>
                        <form id="authorize-form-{{ $employee->id }}" action="{{ route('employee_setup.authorize',$employee->id) }}" method="POST" style="display: none;">
                            @csrf
                        </form>
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
    <script src="{{ asset('assets/backend/layouts/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{ asset('assets/backend/layouts/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
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
    </script>
    <script>
        function authorizeEmployee(id){
            swal({
                title: 'Are you sure?',
                text: "You won't be authorize this account!",
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
