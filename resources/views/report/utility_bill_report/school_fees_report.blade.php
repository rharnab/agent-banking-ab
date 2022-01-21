@extends('layouts.app')

@push('css')
    <link href="{{ asset('assets/backend/layouts/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Tables</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Tables</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Data Tables</strong>
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
                        <h5>Basic Data Tables example with responsive plugin</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>School Name</th>
                        <th>Roll No</th>
                        <th>Payment Type</th>
                        <th>Amount</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Agent Name</th>
                        <th>Agent User Name</th>
                        <th>Paid Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    	@php
                  			 $sl = 1;   
               			 @endphp

               		  @foreach($data as $single_data)

                    <tr class="">

                        <td>{{$sl++}}</td>
                        <td>{{$single_data->school}}</td>
                        <td>{{$single_data->roll_no}}</td>
                        <td class="center">{{$single_data->payment_type}}</td>
                        <td class="center">{{$single_data->amount}}</td>
                        <td class="center">{{$single_data->class}}</td>
                        <td>{{$single_data->section}}</td>
                        <td>{{$single_data->agent_name}}</td>
                        <td>{{$single_data->agent_user_name}}</td>
                        <td>{{$single_data->date}}</td>

                    </tr>
                  
                  @endforeach
                
                    </tbody>
                    <tfoot>
                    <tr>
                         <th>SL</th>
                        <th>School Name</th>
                        <th>Roll No</th>
                        <th>Payment Type</th>
                        <th>Amount</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Agent Name</th>
                        <th>Agent User Name</th>
                        <th>Paid Date</th>
                    </tr>
                    </tfoot>
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


        
       

    </script>
@endpush