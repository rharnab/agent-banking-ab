@extends('layouts.app')

@section('title', 'report')

@push('css')
    <link href="{{ asset('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Agent User report</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Report
            </li>
            <li class="breadcrumb-item active">
                <strong>Agent User</strong>
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

               

                     <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{route('agent_user.user_report_details')}}">

                           
                           @csrf
                           

                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label"><span id="type_title">Agent Name</span></label>
                                <div class="col-lg-8">
                                    <select  id="flag_type" class="select2 form-control" name="agent_id" >
                                       <option value="">All</option>
                                       @foreach($all_agents as $agent)
                                       <option value="{{$agent->id}}">{{$agent->name}}</option>
                                       @endforeach

                                        
                                    </select>
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


