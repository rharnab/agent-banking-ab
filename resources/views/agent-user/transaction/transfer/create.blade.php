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
   Transfer Transaction
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Transfer Transaction</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Transaction</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Transfer Transaction</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{ route('agent_user.transaction.transfer.store') }}">
        @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="ibox-content">
                <h2 class="font-bold">Withdraw Transaction</h2>
                <div class="row">
                    <div class="col-lg-12">   

                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label">Account Type</label>
                            <div class="col-lg-12">
                                <select class="select2 form-control @error('account_type') is-invalid @enderror" name="account_type" required>
                                    <option value="">Select Account Type</option>
                                    <option value="1">GL Account</option>
                                    <option value="2">Customer Account</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Account No</label>
                            <input type="text" name="account_no" id="account_no" class="form-control" required >
                        </div>
                        
                        <div class="form-group row" style="display: none">
                            <label class="col-lg-12 col-form-label">Transaction Type</label>
                            <div class="col-lg-12">
                                <select class="select2 form-control @error('transaction_type') is-invalid @enderror" name="transaction_type" id="transaction_type" required>
                                    <option value="">Select Transaction Type</option>
                                    <option value="2">Online Cash - Deposit</option>
                                    <option value="4">Online Cash - Withdraw</option>
                                    <option value="5" selected>Transfer</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="cheque_section">
                            <label for="">Cheque No</label>
                            <input type="text" name="cheque_no" id="cheque_no" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label for="">Transaction Date</label>
                            <input type="text" readonly name="transaction_date" id="transaction_date" value="{{ date('Y-m-d') }}" class="form-control" required >
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label">Currency</label>
                            <div class="col-lg-12">
                                <select class="select2 form-control @error('currency_type') is-invalid @enderror" name="currency_type" required>
                                    <option value="">Select Currency</option>
                                    <option value="USD">USD</option>
                                    <option value="EURO">EURO</option>
                                    <option value="BDT" selected>BDT</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Transaction Amount</label>
                            <input type="text" name="amount" id="amount" onkeyup="amount_in_word()" class="form-control" required >
                            <span class="form-text m-b-none" id="amount_in_word"></span>
                        </div>
                        
                       
                       
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ibox-content">
                <h2 class="font-bold">Deposit Information</h2>
                <div class="row">
                    <div class="col-lg-12">   

                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label">Account Type</label>
                            <div class="col-lg-12">
                                <select class="select2 form-control @error('deposite_account_type') is-invalid @enderror" name="deposite_account_type" required>
                                    <option value="">Select Account Type</option>
                                    <option value="1">GL Account</option>
                                    <option value="2">Customer Account</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Account No</label>
                            <input type="text" name="deposit_account_no" id="deposit_account_no" class="form-control" required >
                        </div>
                        
                    </div>

                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3" style="float: right">Save</button>
        </div>
    </div>
</form>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function(){
        $('#cheque_section').hide();
    })
    $(function() {

        $.validator.setDefaults({
            errorClass: 'help-block',
            highlight: function(element) {
                $(element)
                .closest('.form-group')
                .addClass('has-error');
            },
            unhighlight: function(element) {
                $(element)
                .closest('.form-group')
                .removeClass('has-error');
            },
        });       

        $("#branch_create_form").validate();

    });
</script>
<script>
    function amount_in_word(){
       $.ajaxSetup({
             headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
          })
       var amount = $('#amount').val();
       if(amount != ''){
          $.ajax({
             type: 'POST',
             url : "{{ route('amount.inword') }}",
             data: {
                "amount": amount,
             },
             success    : (data) => {
                $('#amount_in_word').html(data);
             },
             error: function(data) {
                console.log(data);
             }
          });
       }
    }
 </script>

 <script>
     $('#transaction_type').on('change', function(){
         var transaction_type = $('#transaction_type').val();
         if(transaction_type == "4"){
            $('#cheque_section').show();
            $("#cheque_no").attr("required", true);
         }else{
            $('#cheque_section').hide();
            $("#cheque_no").attr("required", false);
         }
     })
 </script>
@endpush