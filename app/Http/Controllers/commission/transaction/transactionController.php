<?php

namespace App\Http\Controllers\commission\transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class transactionController extends Controller
{
    public function index()
    {
        $all_commission = DB::table('transaction_commission as tc')
        				 ->select('tc.*', 'tt.code', 'tt.name')
        				->leftJoin('transaction_types as tt', 'tt.code', 'tc.commission_type')
        				->orderBy('id', 'DESC')
        				  ->get();
        return view('commission-setup.transaction.index', compact('all_commission', $all_commission));


    }
    public function create()
    {
    	$all_product = DB::table('transaction_types')->select('name', 'code')->get();
    	return view('commission-setup.transaction.create', compact('all_product', $all_product));
    }

    public function store(Request $request)
    {
    	$request->validate([
    		'commission_type' => 'required',
    		
    	]);

        if($request->per_of_amount !='' && $request->commission_amount !='')
        {
          
           Toastr::error("Sorry you can give one commission way");
           return redirect()->back();
        }

        

    	if($request->per_of_amount !='')
    	{
    		$per_of_amount = $request->per_of_amount;
    	}else{
    		$per_of_amount='';
    	}

    	if($request->commission_amount !='')
    	{
    		$commission_amount = $request->commission_amount;
    	}else{
    		$commission_amount='';
    	}

    	if($request->start_slab != '')
    	{
    		$st_slab = $request->start_slab;
    	}else{
    		$st_slab='';
    	}
    	if($request->end_slab != '')
    	{
    		$end_slab = $request->end_slab;
    	}else{
    		$end_slab='';
    	}
    	if($request->vat != '')
    	{
    		$vat = $request->vat;
    	}else{
    		$vat='';
    	}

    	$insert = DB::table('transaction_commission')->insert([

    		'commission_type' => $request->commission_type,
    		'commission_amount' => $commission_amount,
    		'start_slab' =>$st_slab,
    		'end_slav' => $end_slab,
    		'vat' => $vat,
    		'percentage__amount' => $per_of_amount,
    		'created_by' => Auth::user()->id
    		
    	]);

    	

    	if($insert)
    	{
    		Toastr::success('Transaction commission set up successful');
    		return redirect()->route('commission_setup.transaction.index');
    	}else{
    		Toastr::error("Sorry commission not set yet");
    		return redirect()->back();
    	}
    
    }

    public function edit($id)
    {
    	$edit_data = DB::table('transaction_commission as tc')
        				 ->select('tc.*', 'tt.code', 'tt.name')
        				->leftJoin('transaction_types as tt', 'tt.code', 'tc.commission_type')
        				->where('tc.id', $id)
        				 ->first();
        $all_product = DB::table('transaction_types')->select('name', 'code')->get();  
        return view('commission-setup.transaction.edit', compact('edit_data', $edit_data, 'all_product',$all_product ));
    }


    public function update(Request $request, $id)
    {

    	//echo $id;
    	$request->validate([
    		'commission_type' => 'required',
    		
    	]);

        if($request->per_of_amount !='' && $request->commission_amount !='')
        {
          
           Toastr::error("Sorry you can give one commission way");
           return redirect()->back();
        }


    	if($request->per_of_amount !='')
    	{
    		$per_of_amount = $request->per_of_amount;
    	}else{
    		$per_of_amount='';
    	}

    	if($request->commission_amount !='')
    	{
    		$commission_amount = $request->commission_amount;
    	}else{
    		$commission_amount='';
    	}

    	if($request->start_slab != '')
    	{
    		$st_slab = $request->start_slab;
    	}else{
    		$st_slab='';
    	}
    	if($request->end_slab != '')
    	{
    		$end_slab = $request->end_slab;
    	}else{
    		$end_slab='';
    	}
    	if($request->vat != '')
    	{
    		$vat = $request->vat;
    	}else{
    		$vat='';
    	}


    	$update = DB::table('transaction_commission')
    				->where('id', $id)
    				->Update([
			    		'commission_type' => $request->commission_type,
			    		'commission_amount' => $request->commission_amount,
			    		'start_slab' => $st_slab,
			    		'end_slav' => $end_slab,
			    		'vat' => $vat,
			    		'percentage__amount' => $per_of_amount,
			    		
			    	]);

    	

    	if($update)
    	{
    		Toastr::success('Statement commission Update  successful');
    		return redirect()->route('commission_setup.transaction.index');
    	}else{
    		Toastr::error("Sorry commission not Update yet");
    		return redirect()->back();
    	}
    	
    }
}
