<?php

namespace App\Http\Controllers\Report\AgentUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AccountListController extends Controller
{
    public function index(){
        $account_types = DB::table('account_types')->select('id', 'name')->get();
        $products = DB::table('products')->select('id', 'name')->get();
        $data = [
            "account_types" => $account_types,
            "products"      => $products,
        ];
        return view('report.agent-user.account-list.index', $data);
    }


    public function search(Request $request){
     
        $agent_id = Auth::user()->agent_id;

        $account_type = $request->input('account_type');
        $product_type = $request->input('product_type');

        $starting_date = date('Y-m-d', strtotime($request->input('starting_date')));
        $ending_date   = date('Y-m-d', strtotime($request->input('ending_date')));

        if($request->input('account_type') == "all"){
            $account_sql = "";
        }else{
            $account_sql = " and aca.account_type_id ='$account_type' ";
        }

        if($request->input('product_type') == "all"){
            $product_sql = "";
        }else{
            $product_sql = " and aca.product_code ='$product_type' ";
        }



        $sql = "select aca.account_name as customer_account_name, aca.customer_id, a.name as agent_name,at2.name as account_name, p.name as product_name, aca.account_name as account_title , aca.account_no,aca.created_at from agent_customer_accounts aca 
        left join account_types at2 on aca.account_type_id =at2.id
        left join products p  on aca.product_code = p.id
        left join agents a on aca.agent_id = a.id
        where agent_id=$agent_id and date(aca.created_at) between '$starting_date' and '$ending_date' $account_sql $product_sql";
        
        $results = DB::select(DB::raw($sql));

        $data = [
            "results" => $results
        ];

        return view('report.agent-user.account-list.response', $data);

    }

}
