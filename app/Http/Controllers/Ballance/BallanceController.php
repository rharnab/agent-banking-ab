<?php

namespace App\Http\Controllers\Ballance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BallanceController extends Controller
{
   function  ballance_enquiry(){
   	return view('ballance.ballance_enquiry');
   }

   public function searchBalance(Request $request){
      $agent_id = Auth::user()->agent_id;
      $account_no = $request->input('account_no');
      $sql = "select aca.balance,aca.customer_id ,aca.account_name , aca.account_no, aca.created_at , at2.name  as account_type_name , p2.name  as product_name, a2.name  as agent_name from  agent_customer_accounts aca 
      left join account_types at2 on aca.account_type_id = at2.id 
      left join products p2 on aca.product_code = p2.id
      left join agents a2 on aca.agent_id = a2.id 
      where aca.account_no='$account_no'  and aca.agent_id='$agent_id'";
      $results = DB::select(DB::raw($sql));
      $data = [
         "results" => $results
      ];
      return view('ballance.ballance_enquiry_response', $data);
   }
}
