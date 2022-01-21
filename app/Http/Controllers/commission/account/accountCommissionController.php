<?php

namespace App\Http\Controllers\commission\account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class accountCommissionController extends Controller
{
    public function index()
    {
        $all_commission = DB::table('account_open_commission as aoc')
        				 ->select('aoc.*', 'p.code', 'p.name')
        				->leftJoin('products as p', 'p.code', 'aoc.commission_type')
        				  ->get();
        return view('commission-setup.account.index', compact('all_commission', $all_commission));


    }
    public function create()
    {
    	$all_product = DB::table('products')->select('name', 'code')->get();
    	return view('commission-setup.account.create', compact('all_product', $all_product));
    }

    public function store(Request $request)
    {
    	$request->validate([
    		'commission_type' => 'required',
    		'commission_amount' => 'required',
    	]);


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

    	$insert = DB::table('account_open_commission')->insert([

    		'commission_type' => $request->commission_type,
    		'commission_amount' => $request->commission_amount,
    		'start_slab' => $request->st_slab,
    		'end_slav' => $request->end_slab,
    		'vat' => $request->vat,
    		
    	]);

    	

    	if($insert)
    	{
    		Toastr::success('Account commission set up successful');
    		return redirect()->route('commission_setup.account.index');
    	}else{
    		Toastr::error("Sorry commission not set yet");
    		return redirect()->back();
    	}
    
    }

    public function edit($id)
    {
    	$edit_data = DB::table('account_open_commission as aoc')
        				 ->select('aoc.*', 'p.code', 'p.name')
        				->leftJoin('products as p', 'p.code', 'aoc.commission_type')
        				->where('aoc.id', $id)
        				 ->first();
        $all_product = DB::table('products')->select('name', 'code')->get();  
        return view('commission-setup.account.edit', compact('edit_data', $edit_data, 'all_product',$all_product ));
    }


    public function update(Request $request, $id)
    {

    	//echo $id;
    	/*$request->validate([
    		'commission_type' => 'required',
    		'commission_amount' => 'required',
    	]);*/


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

    	$update = DB::table('account_open_commission')
    				->where('id', $id)
    				->Update([
			    		'commission_type' => $request->commission_type,
			    		'commission_amount' => $request->commission_amount,
			    		'start_slab' => $st_slab,
			    		'end_slav' => $end_slab,
			    		'vat' => $request->vat,
			    		
			    	]);

    	

    	if($update)
    	{
    		Toastr::success('Account commission Update  successful');
    		return redirect()->route('commission_setup.account.index');
    	}else{
    		Toastr::error("Sorry commission not Update yet");
    		return redirect()->back();
    	}
    	
    }

}
