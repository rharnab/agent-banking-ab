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
    Fund Transfer
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Create New Transaction</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Transaction</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Transfer</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{ route('transfer.fund.store') }}">
        @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">
                <h2 class="font-bold">Create New Transaction</h2>
                <div class="row">
                    <div class="col-lg-6">                        
                        <div class="form-group">
                            <label for="">A/C Type</label>
                            <select name="accorgl" id="accorgl" class="form-control select2">
                                <option value="">--Please select A/C No or GL No--</option>
                                <option value="1">Account</option>
                                <option value="2">GL</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Transaction Type</label>
                            <select name="txnType" id="txnType" class="form-control select2">
                                <option value="">--Please select transaction type--</option>
                                <option value="1">Cash Deposit</option>
                                <option value="2">Cash Withdraw</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Currency</label>
                            <select name="currency" id="currency" class="form-control select2">
                                <option value="">--Please select a currency--</option>
                                <option value="1">BDT</option>
                                <option value="2">USD</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">To A/C - GL</label>
                            <input type="number" name="toacgl" id="toacgl" class="form-control"  required="">
                        </div>
                       
                    </div>

                    <div class="col-lg-6">                        
                            
                        <div class="form-group">
                            <label for="">From A/C - GL</label>
                            <input type="number" name="frmactogl" id="frmactogl" class="form-control"  required="">
                        </div>

                        <div class="form-group" id="cheaque">
                            <label for="">Cheaque No</label>
                            <input type="text" name="cheaqueNo" id="cheaqueNo" class="form-control"  required="">
                        </div>

                        <div class="form-group">
                            <label for="">Transaction Date</label>
                            <input type="text" name="amount" id="amount" class="form-control" value="{{ date('Y-m-d') }}"  readonly="">
                        </div>

                        <div class="form-group">
                            <label for="">Transaction Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control"  required="">
                        </div>
                                            
                        <button type="submit" class="btn btn-primary pull-right">Create</button>
                       
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
</div>
@endsection

@push('js')

<script>
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
    $('#accorgl').on('change', function(e){
        var idValue = document.getElementById('accorgl').value;
        if(idValue==1){
            $('#cheaque').css('display','block');
        }else{
            $('#cheaque').css('display','none');
        }
    });

    $('#txnType').on('change', function(e){
        var idValue = document.getElementById('accorgl').value;
        var txnType = document.getElementById('txnType').value;
        
        if(idValue==1 && txnType==2){
            $('#cheaque').css('display','block');
        }else{
            $('#cheaque').css('display','none');
        }
    });
</script>
@endpush