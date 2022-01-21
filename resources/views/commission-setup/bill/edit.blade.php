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
    Update commission
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2> Update Bill commission</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Commission</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Bill commission</strong>
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
                <h2 class="font-bold"> Update Bill Commission </h2>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" id="branch_create_form" role="form" method="POST" action="{{route('commission_setup.bill.update', $edit_data->id) }}">

                           
                           @csrf


                            
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label"><span id="type_title">Commission Type</span></label>
                                <div class="col-lg-8">
                                    <select  id="flag_type" class="select2 form-control" name="commission_type" required="">
                                       <option value="">--Please Select Type--</option>
                                       @foreach($all_product as $product)
                                       
                                       <option 
                                       <?php
                                       if($product->code == $edit_data->commission_type)
                                       {
                                       	echo "selected";
                                       }

                                        ?>

                                       value="{{$product->code}}">{{$product->name}}
                                      </option>
                                       @endforeach
                                        
                                    </select>
                                </div>
                            </div>


                      
                           

                        
                          <div class="form-group row" id="fixed_amount">
                                <label class="col-lg-4 col-form-label">Commission Amount</label>
                                <div class="col-lg-8">
                                      <input type="text" required="" name="commission_amount" class="form-control" placeholder="Commission Amount" value="{{$edit_data->commission_amount}}">
                                </div>
                            </div>

                            

                            
                    

                             {{--  <div class="form-group row hideClass " id="start_slab">
                                <label class="col-lg-4 col-form-label">Start Slab</label>
                                <div class="col-lg-8">
                                      <input type="text" name="start_slab" class="form-control" placeholder="Start Slab" value="{{$edit_data->start_slab}}">
                                </div>
                            </div>

                             <div class="form-group row hideClass" id="end_slab">
                                <label class="col-lg-4 col-form-label">End Slab</label>
                                <div class="col-lg-8">
                                      <input type="text" name="end_slab" class="form-control" placeholder="End Slab" value="{{$edit_data->end_slav}}">
                                </div>
                            </div> --}}

                             {{-- <div class="form-group row hideClass" id="end_slab">
                                <label class="col-lg-4 col-form-label">Vat</label>
                                <div class="col-lg-8">
                                      <input type="text" name="vat" class="form-control" placeholder="Vat" value="{{$edit_data->vat}}">
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