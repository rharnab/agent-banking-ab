<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 

class UtilitybillControllerReport extends Controller
{
   public function schoolfees(){
   	


   	 $sql           = "SELECT  sf.school,sf.roll_no, sf.payment_type, sf.section, sf.amount, sf.date,sf.class, agents.name as agent_name,agent_users.name as agent_user_name  FROM `school_fees` sf LEFT JOIN agents on sf.agent_id = agents.id LEFT JOIN agent_users on sf.agent_user_id = agent_users.id";


        $data = DB::select(DB::RAW($sql));
   		
   		//$data = DB::table('school_fees')->get();
   		// echo "<pre>";
   		// print_r($data);
   		// die;
   		return view('report.utility_bill_report.school_fees_report', compact('data'));

   }
}
