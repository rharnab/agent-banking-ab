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
        <h2>WASA Bill</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Utility Bill Collection</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>WASA Bill</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
@endsection

@section('content')





<div class="wrapper wrapper-content animated fadeInRight">
    
     <form accept="" method="">
        <div class="row">
        <div class="col-lg-6">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>WASA Bill</h5>
            </div>
            <div class="ibox-content">
                
               

                  <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Water Bill</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="" name="bill_no" value="2760">
                    </div>
                  </div>


                   <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Sewer Bill</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id=""  name="bill_no" value="2000">
                    </div>
                  </div> 

                  <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Fixed Charge</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id=""  name="bill_no" value="0">
                    </div>
                  </div>

                   <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">VAT</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id=""  name="bill_no" value="600">
                    </div>
                  </div> 

                   <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Total Bill</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id=""  name="bill_no" value="5360">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Now Pay</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id=""  name="bill_no" value="">
                    </div>
                  </div>

               

                  <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">

                      <input type="submit" name="submit" value="Submit" class=" btn btn-primary">
                     </div>
                </div>

             
            </div>
        </div>

    </div> <!-- col-lg-12 -->
     </div>


       </form>

   
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