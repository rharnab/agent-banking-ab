@extends('layouts.app')

@section('title', 'modify limit')

@push('css')
    <link href="{{ asset('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Modify Limit Report</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Report
            </li>
            <li class="breadcrumb-item active">
                <strong>Limit Report</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
        <div class="ibox ">
           
            <div class="ibox-content">

               

                     <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{route('modify.limit_report')}}">

             
                           @csrf
                           
                        
                          <div class="form-group row" id="fixed_amount">
                                <label class="col-lg-4 col-form-label">Start Date</label>
                                <div class="col-lg-8">
                                      <input type="text" required="" value="<?php echo date('Y-m-d') ?>" name="frm_date" id="frm_date" class="form-control" placeholder="Start date">
                                </div>
                            </div>

                            

                              <div class="form-group row hideClass " id="start_slab">
                                <label class="col-lg-4 col-form-label">End date</label>
                                <div class="col-lg-8">
                                      <input type="text" value="<?php echo  date('Y-m-d') ?>" name="to_date"  class="form-control" id="to_date" placeholder="End Date">
                                </div>
                            </div>


                            <div class="form-group row text-center " id="start_slab">
                               
                                <div class="col-lg-4 offset-4">
                                     <button type="submit" class="btn btn-primary block full-width m-b"> Create Report</button>
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
    <script src="{{ asset('assets/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
    <script>
        $('#frm_date').datepicker({
           format: 'yyyy/mm/dd',
            
         });

         $('#to_date').datepicker({
           format: 'yyyy/mm/dd',
            
         });

    </script>
    
@endpush


