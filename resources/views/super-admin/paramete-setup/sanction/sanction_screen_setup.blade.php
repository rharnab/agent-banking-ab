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
    Product List
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Sanction Screening Setup</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Parameter Setup</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Sanction Screening</strong>
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
        <div class="col-lg-6">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Sanction Screening Setup</h5>
            </div>
            <div class="ibox-content">
                
                <form action="" method="">

                
                   <div class="form-group ">
                    <label for="" class=" col-form-label"><b>Name Match Percentage</b></label>
                    <div class="">
                      <input type="text" class="form-control" id="" value="" placeholder="Enter Name Match Percentage">
                    </div>
                  </div> 

                  <div class="form-group ">
                    <label for="" class=" col-form-label"><b>Father Name Match Percentage</b></label>
                    <div class="">
                      <input type="text" class="form-control" id="" value="" placeholder="Enter Father Name Match Percentage">
                    </div>
                  </div>

              

                  <div class="form-group ">
                    <label for="" class=" col-form-label"><b>Mother Name Match Percentage</b></label>
                    <div class="">
                      <input type="email" class="form-control" id="" value="" placeholder="Enter Mother Name Match Percentage">
                    </div>
                  </div>


                 



                  
                   <div class="form-group ">
                    <label for="" class=" col-form-label"><b>Country Name Percentage </b></label>
                    <div class="">
                      <input type="email" class="form-control" id="" value="" placeholder="Enter Country Name Percentage">
                    </div>
                  </div>
                 

                  <div class="form-group ">
                    <div class="">

                        <a href="" class="btn btn-primary">submit</a>
                     
                     </div>
                </div>

                </form>

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