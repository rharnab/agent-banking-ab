<?php

namespace App\Http\Controllers\Report\AgentUser\Searching;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerSearchController extends Controller
{
    public function index(){
        return view('report.agent-user.searching.custome-name.index');
    }


    public function search(Request $request){
        $customer_name = $request->input('customer_name');
        $agent_id      = Auth::user()->agent_id;
        $company_id    = Auth::user()->company_id;
        $sql           = "select aca.customer_id ,aca.account_name , aca.account_no, aca.created_at , at2.name  as account_type_name , p2.name  as product_name, a2.name  as agent_name from  agent_customer_accounts aca 
        left join account_types at2 on aca.account_type_id = at2.id 
        left join products p2 on aca.product_code = p2.id
        left join agents a2 on aca.agent_id = a2.id 
        where aca.account_name like '%$customer_name%' and aca.agent_id=$agent_id and aca.company_id=$company_id";
        $results = DB::select(DB::RAW($sql));
        $data = [
            "results" => $results,
            "customer_name" => $customer_name
        ];
        return view('report.agent-user.searching.custome-name.response', $data);
    }

}
