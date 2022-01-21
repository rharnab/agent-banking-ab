@extends('layouts.app')

@push('css')
    <style>
        .add-new-button{
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
        }
    </style>
@endpush

@section('title')
    Create commission
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2> Create commission</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Commission Setup</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Commission-Setup</strong>
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
        <div class="col-md-5 ">
            <div class="ibox-content">
                <h2 class="font-bold">Commission  Setup </h2>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{route('commission_setup.commission_store')}}">

                           
                           @csrf
                           

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Commission </label>
                                <div class="col-lg-8">
                                    <select onchange="comssionType()" id="commission_type" class="select2 form-control" name="commission_type" >
                                       <option value="">--Please Select Type--</option>

                                       @foreach($data as $val)
                                        <option value="{{$val->commission_type_code}}">{{$val->commission_type_name}}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>


                            
                            <div class="form-group row" id="show_commission_type">
                                <label class="col-lg-4 col-form-label"><span id="type_title">Commission Type</span></label>
                                <div class="col-lg-8">
                                    <select  id="flag_type" class="select2 form-control" name="commission_trn_type">
                                       <option value="">--Please Select Type--</option>
                                      
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row hideClass" id="commission_wary_area">
                                <label class="col-lg-4 col-form-label"><span>Commission Way</span></label>
                                <div class="col-lg-8">
                                    <select  id="commission_way" class="select2 form-control" name="commission_way" onchange="showParentage()">
                                       <option value="">--Please Select Type--</option>
                                       <option value="f">Fixed</option>
                                       <option value="p">Parcentage</option>
                                      
                                    </select>
                                </div>
                            </div>

                           

                        
                          <div class="form-group row" id="fixed_amount">
                                <label class="col-lg-4 col-form-label">Commission Amount</label>
                                <div class="col-lg-8">
                                      <input type="text" name="commission_amount" class="form-control" placeholder="Commission Amount">
                                </div>
                            </div>

                            

                            
                            <div class="form-group row hideClass" id="percent_of_amt_for_transaction">
                                <label class="col-lg-4 col-form-label">Percentage Of Amount</label>
                                <div class="col-lg-8">
                                      <input type="text" name="per_of_amount" class="form-control"   placeholder="Percentage Of Amount">
                                </div>
                            </div>

                              <div class="form-group row hideClass " id="start_slab">
                                <label class="col-lg-4 col-form-label">Start Slab</label>
                                <div class="col-lg-8">
                                      <input type="text" name="start_slab" class="form-control" placeholder="Start Slab">
                                </div>
                            </div>

                             <div class="form-group row hideClass" id="end_slab">
                                <label class="col-lg-4 col-form-label">End Slab</label>
                                <div class="col-lg-8">
                                      <input type="text" name="end_slab" class="form-control" placeholder="Start Slab">
                                </div>
                            </div>


                          {{--  <div class="form-group row hideClass" id="per_trn_com_for_transaction">
                                <label class="col-lg-4 col-form-label">Per transaction Amount</label>
                                <div class="col-lg-8">
                                      <input type="text" name="per_of_transaction" class="form-control"  placeholder="Percentage Of Transaction">
                                </div>
                            </div>
                            

                            <div class="form-group row hideClass" id="amt_of_taka_for_billPay">
                                <label class="col-lg-4 col-form-label">Amount Of Taka</label>
                                <div class="col-lg-8">
                                      <input type="text" name="amt_of_taka" class="form-control"   placeholder="Amount Of Taka">
                                </div>
                            </div>

                             <div class="form-group row hideClass" id="com_st_for_statement">
                                <label class="col-lg-4 col-form-label">Commission For statement</label>
                                <div class="col-lg-8">
                                      <input type="text" name="com_for_statment" class="form-control"   placeholder="Amount Of Taka">
                                </div>
                            </div> --}}


                                                
                            <button type="submit" class="btn btn-primary block full-width m-b"> Setup</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>

        /*$('#show_commission_type').hide();
        $('.hideClass').hide();

       function comssionType()
       {
            var commmission_type = $('#commission_type').val();
            if(commmission_type !='')
            {   
                $('#show_commission_type').show();



                if(commmission_type == 1)
                {
                    $('#type_title').html('Account Type');
                    $('#amount_for_account').show();
                    $('#per_trn_com_for_transaction').hide();
                    $('#percent_of_amt_for_transaction').hide();
                    $('#amt_of_taka_for_billPay').hide();
                    $('#com_st_for_statement').hide();






                }else if(commmission_type == 2){
                    $('#type_title').html('Transaction Type');
                    $('#per_trn_com_for_transaction').show();
                    $('#percent_of_amt_for_transaction').show();
                    $('#amount_for_account').hide();
                    $('#amt_of_taka_for_billPay').hide();
                    $('#com_st_for_statement').hide();
                }
                else if(commmission_type == 3){
                    $('#type_title').html('Bill Collection Type');
                    $('#amt_of_taka_for_billPay').show();
                     $('#amount_for_account').hide();
                    $('#per_trn_com_for_transaction').hide();
                    $('#percent_of_amt_for_transaction').hide();
                    $('#com_st_for_statement').hide();
                }else if(commmission_type == 4){
                    $('#type_title').html('Statement Type');
                    $('#com_st_for_statement').show();
                    $('#amount_for_account').hide();
                    $('#per_trn_com_for_transaction').hide();
                    $('#percent_of_amt_for_transaction').hide();
                    $('#amt_of_taka_for_billPay').hide();
                    
                }

                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                })

                 $.ajax({
                    type: 'POST',
                    url : "{{ route('commission_setup.fetch_type') }}",
                    data: {
                        "commmission_type": commmission_type,
                        
                    },
                    success:function(data)
                    {
                        $('#flag_type').html(data);
                        console.log(data);
                    }
                    
                });
                



            }else{
                   $('#show_commission_type').hide();
                    $('#amount_for_account').hide();
                    $('#per_trn_com_for_transaction').hide();
                    $('#percent_of_amt_for_transaction').hide();
                    $('#amt_of_taka_for_billPay').hide();
                    $('#com_st_for_statement').hide();
                    
            }
        
       }*/



     $('.hideClass').hide();
     
       function comssionType()
       {
            var commmission_type = $('#commission_type').val();

             $('#percent_of_amt_for_transaction').hide();
              $('#commission_wary_area').hide();
               $('#fixed_amount').show();



            if(commmission_type !='')
            {   
                $('#show_commission_type').show();



                if(commmission_type == 1)
                {
                    $('#type_title').html('Account Type');
                    $('#start_slab').hide();
                    $('#end_slab').hide();

                }else if(commmission_type == 2){
                    $('#type_title').html('Transaction Type');
                    $('#start_slab').show();
                    $('#end_slab').show();
                    $('#commission_wary_area').show();
                   
                }
                else if(commmission_type == 3){
                    $('#type_title').html('Bill Collection Type');
                    $('#start_slab').hide();
                    $('#end_slab').hide();
                   
                }else if(commmission_type == 4){
                    $('#type_title').html('Statement Type');
                    $('#start_slab').hide();
                    $('#end_slab').hide();
                    
                    
                }


                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                })

                 $.ajax({
                    type: 'POST',
                    url : "{{ route('commission_setup.fetch_type') }}",
                    data: {
                        "commmission_type": commmission_type,
                        
                    },
                    success:function(data)
                    {
                        $('#flag_type').html(data);
                        console.log(data);
                    }
                    
                });
                



            }else{
               
               $('#start_slab').hide();
              $('#end_slab').hide();     
                    
            }
        
       }


       function showParentage()
       {
           var commission_way =$('#commission_way').val();
           if(commission_way !='' && commission_way == 'p')
           {
                $('#percent_of_amt_for_transaction').show();
                $('#fixed_amount').hide();
           }else{
                $('#percent_of_amt_for_transaction').hide();
                $('#fixed_amount').show();

           }
       }
    </script>
@endpush