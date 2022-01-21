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
        <h2>Agent User Setup</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Parameter Setup</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Agent User Setup</strong>
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
                <h5>Agent User List</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Agent</th>
                                <th>Name</th>                                
                                <th>User ID</th>                                
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Short Code</th>
                                <th>Account No</th>
                                <th>Trans. Limit</th>
                                <th>District,Division</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sl = 1;  
                          @endphp
                          @foreach($agent_users as $agent_user)
                              <tr>
                                  <td>{{ $sl++ }}</td>
                                  <td>{{ $agent_user->agent_name }}</td>
                                  <td>{{ $agent_user->name }}</td>
                                  <td>{{ $agent_user->user_id }}</td>                                 
                                  <td>{{ $agent_user->email }}</td>
                                  <td>{{ $agent_user->phone }}</td>
                                  <td>{{ $agent_user->short_code }}</td>
                                  <td>{{ $agent_user->account_no }}</td>
                                  <td>{{ number_format($agent_user->transaction_amount_limit,2) }}</td>
                                  <td>{{ $agent_user->district_name }},{{ $agent_user->division_name }}</td>
                                  <td>{{ $agent_user->address }}</td>
                                  <td>
                                      @if($agent_user->status == 0)
                                          <p><span class="badge badge-danger">Pending</span></p>
                                      @elseif($agent_user->status == 1)
                                          <p><span class="badge badge-primary">Approved</span></p>
                                      @endif
                                  </td>
                                  <td>
                                      <a class="btn btn-primary btn-bitbucket" href="">
                                          <i class="fa fa-pencil"></i> 
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


        
        function deleteBranch(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
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