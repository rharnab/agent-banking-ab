<?php

namespace App\Http\Controllers\commission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Comission;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
class CommissionController extends Controller
{
    public function create()
    {
    	$data =DB::table('commission_types')->select('*')->get();

    	return view('commission-setup.create', compact('data', $data));
    }

    public function fecth_commission_type(Request $request)
    {
    	$commmission_type = $request->commmission_type;
    	if($commmission_type== 1 )
    	{
    	   $result =DB::table('account_open_types')->select('*')->get();
    	}else if($commmission_type== 2){
    		 $result =DB::table('transaction_types')->select('*')->get();
    	}
    	else if($commmission_type== 3){
    		 $result =DB::table('bill_types')->select('*')->get();
    	}
    	else if($commmission_type== 4){
    		 $result =DB::table('statement_types')->select('*')->get();
    	}

    	

    	if($result->count() > 0)
    	{
    		foreach($result as $data)
	    	{
	    		echo $output = ' <option value="'.$data->code.','.$data->name.'">'.$data->name.'</option>';
	    	}

	    	
    	}else{
    		echo $output.=' <option value="">type not found</option>';
    	}
    	
    	

	    	
    }


    function commission_store(Request $request)
    {
    	$commisssion = new Comission;
    	$user_id = Auth::user()->id;
    	$commission_type = $request->commission_type;
    	$commission_trn_type =explode(',', $request->commission_trn_type);
    	$commission_way = $request->commission_way;
    	$commission_amount = number_format($request->commission_amount, 2);
    	$per_of_amount= number_format($request->per_of_amount, 2);
    	$start_slab = number_format($request->start_slab, 2);
    	$end_slab =number_format($request->end_slab, 2);

    	$commisssion->commission_type = $commission_type;
    	$commisssion->commission_trn_type = $commission_trn_type[0];
        $commisssion->commission_trn_name = $commission_trn_type[1];
    	$commisssion->commission_amount = $commission_amount;
    	$commisssion->percentage_of_amt = $per_of_amount;
    	$commisssion->start_slab = $start_slab;
    	$commisssion->end_slav = $end_slab;
    	$commisssion->created_by = $user_id;
        $commisssion->created_by = $user_id;

    	try{
           $insert = $commisssion->save();
            Toastr::success('Commission Setup Successfully :)','Success');
          return redirect()->route('commission_setup.create');
	        }catch(\Exception $e){
	            Toastr::error($e->getMessage(),'Failed');
	            return redirect()->route('commission_setup.create');
	        }
  
  	
    		
    	
    }

    public function all_commission()
    {
    	 

    	$data = DB::select("SELECT * from comissions as c
        LEFT JOIN commission_types as ct on ct.commission_type_code = c.commission_type
        LEFT JOIN account_open_types as at on at.code = c.commission_trn_type
        LEFT JOIN transaction_types as tt on tt.code = c.commission_trn_type
        LEFT JOIN statement_types as st on st.code = c.commission_trn_type");



    	return view('commission-setup.index', compact('data', $data));
    	
    }


}
