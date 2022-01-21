<?php

namespace App\Http\Controllers\report\user_and_security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class UserAndSecurityController extends Controller
{
    public function user_report()
    { $all_agents =DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
    	return view('report.user_and_security.user_report', compact('all_agents'));
    }
    public function user_report_details(Request $request)
    {

	$agent_id =$request->agent_id;

	if($agent_id !='')
	{
		$agent_id = " where a.id= '$agent_id' ";
	}else{
		$agent_id = '';
	}

	$data = DB::select("SELECT  a.name as agent_name, b.name as branch_name, b.routing_number, au.name as agent_user_name, au.email, au.phone, au.account_no,
		au.transaction_amount_limit, au.status 
		from agents a 
		left join agent_users au on au.agent_id = a.id 
		left join branches b on b.id = a.branch_id  $agent_id
		 ");

	return view('report.user_and_security.user_report_details', compact('data'));
    }
}
