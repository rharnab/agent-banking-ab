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
                <a>Parameter Setup</a>
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
                                <label class="col-lg-4 col-form-label">Commission Type</label>
                                <div class="col-lg-8">
                                    <select onchange="comssionType()" id="commission_type" class="select2 form-control" name="commission_type" >
                                       <option value="">--Please Select Type--</option>
                                       <option value="1">Account Open Commission</option>
                                       <option value="2">Transaction Commission</option>
                                       <option value="3">Bill collection Commission</option>
                                       <option value="4">Statement Commission</option>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group row hideClass" id="show_commission_type">
                                <label class="col-lg-4 col-form-label"><span id="type_title">Account Type</span></label>
                                <div class="col-lg-8">
                                    <select  id="flag_type" class="select2 form-control" name="flag_type">
                                       <option value="">--Please Select Type--</option>
                                      
                                    </select>
                                </div>
                            </div>

                          
                          <div class="form-group row hideClass" id="amount_for_account">
                                <label class="col-lg-4 col-form-label">Amount</label>
                                <div class="col-lg-8">
                                      <input type="text" name="amount" class="form-control" placeholder="Amount">
                                </div>
                            </div>

                            

                            <div class="form-group row hideClass" id="per_trn_com_for_transaction">
                                <label class="col-lg-4 col-form-label">Per transaction Amount</label>
                                <div class="col-lg-8">
                                      <input type="text" name="per_of_transaction" class="form-control"  placeholder="Percentage Of Transaction">
                                </div>
                            </div>
                            <div class="form-group row hideClass" id="percent_of_amt_for_transaction">
                                <label class="col-lg-4 col-form-label">Percentage Of Amount</label>
                                <div class="col-lg-8">
                                      <input type="text" name="per_of_amount" class="form-control"   placeholder="Percentage Of Amount">
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
                            </div>


                                                
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

        $('#show_commission_type').hide();
        $('.hideClass').hide();

       function comssionType()
       {
            var commmission_type = $('#commission_type').val();
            if(commmission_type !='')
            {   //show
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
        
       }
    </script>
@endpush