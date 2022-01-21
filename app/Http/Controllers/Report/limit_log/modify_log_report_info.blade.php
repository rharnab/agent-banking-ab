@extends('layouts.app')

@section('title', 'modify log')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Balance Modify Report</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Report
            </li>
            <li class="breadcrumb-item active">
                <strong>>Balance Modify</strong>
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
           
            <div class="ibox-content">

                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>SL</th>
                <th>Agent Name</th>
                <th>Agent User</th>
                <th>Old Limit</th>
                <th>New Limit</th>
               
                <th>Operation Name</th>
                <th>Operation date</th>
                 <th>Status</th>
               
            </tr>
            </thead>
            <tbody>
                @php $sl=1; @endphp
               @foreach($data as $val)
               <tr>
                   <td>{{$sl++}}</td>
                   <td>{{$val->agent_name}}</td>
                   <td>{{$val->agent_user_name}}</td>
                   <td>{{$val->old_limit}}</td>
                   <td>{{$val->new_limit}}</td>
                   <td>{{$val->crete_by}}</td>
                   <td>{{$val->create_date}}</td>
                   <td>{{$val->approve_by}}</td>
                   <td>{{$val->approve_date}}</td>
                   <td>
                    @if($val->status == '1')
                       <span class="text-info">Approved</span>
                    @else
                    <span class="text-warning">Pendding</span>
                   @endif

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
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'account_open_commission'},
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


