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
    	return view('commission-setup.create');
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
	    		echo $output = ' <option value="'.$data->code.'">'.$data->name.'</option>';
	    	}

	    	
    	}else{
    		echo $output.=' <option value="">type not found</option>';
    	}
    	
    	

	    	
    }


    function commission_store(Request $request)
    {
    	$commisssion = new Comission;
    	$user_id = Auth::user()->id;

    	 $com_type = $request->commission_type;
    	 $flag_type = $request->flag_type;
    	 $amount = number_format($request->amount,2);
    	 $per_of_transaction = number_format( $request->per_of_transaction, 2);
    	 $per_of_amount = number_format( $request->per_of_amount, 2);
    	 $amt_of_taka = number_format($request->amt_of_taka, 2);
    	 $com_for_statment = number_format($request->com_for_statment, 2);

    	 $commisssion->commission_type = $com_type;
    	 $commisssion->commission_trn_type = $flag_type;
    	 $commisssion->created_by = $user_id;


    	if(($com_type != '') && ($flag_type !=''))
    	{
    		if($com_type ==1 )
    		{
    			$commisssion->commission_amount=$amount;
    			//$insert = $commisssion->save();
    		}else if($com_type ==2){
    			$commisssion->percentage_of_amt=$per_of_amount;
    			$commisssion->commission_amount=$per_of_transaction;
    			//$insert = $commisssion->save();
    		}
    		else if($com_type ==3){
    			$commisssion->commission_amount=$amt_of_taka;
    			//$insert = $commisssion->save();
    			
    		}
    		else if($com_type ==4){
    			$commisssion->commission_amount=$com_for_statment;
    			//$insert = $commisssion->save();
    			
    		}

    		try{
		           $insert = $commisssion->save();
		            Toastr::success('Commission Setup Successfully :)','Success');
	            return redirect()->route('commission_setup.index');
	        }catch(\Exception $e){
	            Toastr::error($e->getMessage(),'Failed');
	            return redirect()->route('commission_setup.index');
	        }
    	}
    }

    public function all_commission()
    {
    	$data = DB::table('comissions as com')
    			->select('*')
    			->get();
    	echo "<pre>";
    	print_r($data);

    	//return view('commission-setup.all_commission', compact('commisssion', $commisssion));
    	
    }


}
