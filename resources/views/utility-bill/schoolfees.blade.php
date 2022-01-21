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
        <h2>School Fees</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Utility Bill Collection</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>School Fees</strong>
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
                <h5>School Fees</h5>
            </div>
            <div class="ibox-content">
                
                <form action="" method="">

                   <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Select School</label>

                    <div class="col-sm-10">
                      
                      <select class="form-control custom-select" id="inputGroupSelect01">
                        <option selected>Choose...</option>
                        <option value="1">Ideal School and College</option>
                        <option value="2">Rajuk Uttara Model School & College</option>
                        <option value="3">Bir Shreshtha Noor Mohammad Public College</option>
                        <option value="4">Holy Cross Girls’ High School</option>
                        <option value="5">Monipur High School</option>
                        <option value="6">Dhanmondi Government Boys’ High School</option>
                        <option value="7">Cambrian School & college</option>
                        <option value="7">Dhaka City School</option>
                        <option value="7">Agrani School & College</option>
                        <option value="7">Radiant international School</option>
                        <option value="7">The Schoolars School & College</option>
                      </select>

                    </div>

                    </div>

               


                   <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Roll No</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="" value="" placeholder="Enter Student Roll">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Payment Type</label>

                    <div class="col-sm-10">
                      
                      <select class="form-control custom-select" id="inputGroupSelect01">
                        <option selected>Choose...</option>
                        <option value="1">Fees</option>
                        <option value="2">Admission</option>
                        <option value="3">Library Fees</option>
                        
                      </select>

                    </div>

                    </div>

                  <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Class</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="" value="" placeholder="Enter class">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Section</label>
                    <div class="col-sm-10">
                     
                      <select class="form-control custom-select" id="inputGroupSelect01">
                        <option selected>Choose...</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                        <option value="2">C</option>
                        <option value="2">D</option>
                       
                        
                      </select>

                    </div>
                  </div>

                   <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Date</label>
                    <div class="col-sm-10">
                     
                      <input type="date" name="date" class="form-control">

                    </div>
                  </div>

                 

                  <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">

                        <a href="{{route('Utilitybill.descoaction') }}" class="btn btn-primary">submit</a>
                     
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