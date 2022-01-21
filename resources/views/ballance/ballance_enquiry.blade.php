@extends('layouts.app')

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Balance Inquery</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Searching</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Balance Inquery</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection



@section('content')
<form id="form"  action="{{ route('balance.search') }}" class="wizard-big" method="POST">
   @csrf
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
       <div class="col-lg-4">
          <div class="ibox">
             <div class="ibox-title">
                <h5>Balance Inquery</h5>
             </div>
             <div class="ibox-content">

               <div class="row">
                  <div class="col-md-12">
                     <div class="from-row">
                        <label for="">Customer Account No</label>
                        <input type="text" name="account_no" id="account_no" class="form-control">
                     </div>

                     <div class="from-group mt-3">
                        <button type="button" class="btn btn-block btn-primary" id="verification">Balance Inquery</button>
                     </div>
                     
                  </div>
               </div>
             </div>
          </div>
       </div>

        <div class="col-lg-8"  style="display: none" id="verification_section">
          <div class="ibox">
             <div class="ibox-title">
                <h5>Customer Verification</h5>
             </div>
             <div class="ibox-content">
                 <div class="row">
                    <div class="col-md-6">
                     <fieldset style="height: 170px;">                   
                        <div class="text-center">                                 
                           <img src="{{asset('public/ballance_enquiry/8173aZ-dFhL.png')}}" width="100" height="120" >
                           <br>
                           <br>  
                           <button type="button" class="btn btn-primary btn-lg" onclick="showfinger()">Press Finger Print</button>
                        </div>     
                     </fieldset>
                    </div>
                    <div class="col-md-6">
                       <div class="form-gorup">
                           <label for="">Customer Secret Pin</label>
                           <input type="text" name="pin" id="pin" class="form-control">
                       </div>
                       <br>
                       <br>
                       <div class="form-gorup">
                           <input type="submit" value="Click For Verification" class="btn btn-primary">
                        </div>                      
                    </div>
                 </div>    
             </div>
          </div>
       </div>
    </div>
    
 </div>
</form>
@endsection


@push('js')

<script type="text/javascript">
	$('#verification_section').hide();
   $('#verification').on('click', function(){
      $('#verification_section').show();
   });
</script>

@endpush