<?php

namespace App\Http\Controllers\commission\bill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class billController extends Controller
{
    public function index()
    {
        $all_commission = DB::table('bill_commission as bc')
        				 ->select('bc.*', 'bt.code', 'bt.name')
        				->leftJoin('bill_types as bt', 'bt.code', 'bc.commission_type')
        				->orderBy('id', 'DESC')
        				  ->get();
        return view('commission-setup.bill.index', compact('all_commission', $all_commission));


    }
    public function create()
    {
    	$all_product = DB::table('bill_types')->select('name', 'code')->get();
    	return view('commission-setup.bill.create', compact('all_product', $all_product));
    }

    public function store(Request $request)
    {
    	$request->validate([
    		'commission_type' => 'required',
    		'commission_amount' => 'required',
    	]);


    	/*if($request->start_slab != '')
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
*/    	if($request->vat != '')
    	{
    		$vat = $request->vat;
    	}else{
    		$vat='';
    	}

    	$insert = DB::table('bill_commission')->insert([

    		'commission_type' => $request->commission_type,
    		'commission_amount' => $request->commission_amount,
    		//'start_slab' => $request->st_slab,
    		//'end_slav' => $request->end_slab,
    		'vat' => $request->vat,
    		'created_by' => Auth::user()->id,
    	]);

    	

    	if($insert)
    	{
    		Toastr::success('Bill commission set up successful');
    		return redirect()->route('commission_setup.bill.index');
    	}else{
    		Toastr::error("Sorry commission not set yet");
    		return redirect()->back();
    	}
    
    }

    public function edit($id)
    {
    	$edit_data = DB::table('bill_commission as sc')
        				 ->select('sc.*', 'st.code', 'st.name')
        				->leftJoin('bill_types as st', 'st.code', 'sc.commission_type')
        				->where('sc.id', $id)
        				 ->first();
        $all_product = DB::table('bill_types')->select('name', 'code')->get();  
        return view('commission-setup.bill.edit', compact('edit_data', $edit_data, 'all_product',$all_product ));
    }


    public function update(Request $request, $id)
    {

    	//echo $id;
    	/*$request->validate([
    		'commission_type' => 'required',
    		'commission_amount' => 'required',
    	]);*/


    	/*if($request->start_slab != '')
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
    	}*/
    	if($request->vat != '')
    	{
    		$vat = $request->vat;
    	}else{
    		$vat='';
    	}

    	$update = DB::table('bill_commission')
    				->where('id', $id)
    				->Update([
			    		'commission_type' => $request->commission_type,
			    		'commission_amount' => $request->commission_amount,
			    		//'start_slab' => $st_slab,
			    		//'end_slav' => $end_slab,
			    		'vat' => $request->vat,
			    		
			    	]);

    	

    	if($update)
    	{
    		Toastr::success('Bill commission Update  successful');
    		return redirect()->route('commission_setup.bill.index');
    	}else{
    		Toastr::error("Sorry commission not Update yet");
    		return redirect()->back();
    	}
    	
    }
}
