<?php

namespace App\Http\Controllers\Report\AgentUser\Searching;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ChequeRequisionStatusController extends Controller
{
    public function index(){
        return view('report.agent-user.searching.cheque_requisition_status.index');
    }

    public function search(Request $request){
        
        $company_id = Auth::user()->company_id;
        $agent_id = Auth::user()->agent_id;
        $account_no = $request->input('account_no');

        $sql = "select
        aca.account_name,
        aca.account_no,
        p2.name as product_name,
        a2.name as agent_name,
        tt.name as transaction_type_name,
        t.amount,
        t.transaction_date,
        t.cheque_no,
        t.approved_timestamp
     from
        transactions t 
        left join
           agent_customer_accounts aca 
           on t.dr_account_no = aca.account_no 
        left join
           products p2 
           on aca.product_code = p2.id 
        left join
           agents a2 
           on aca.agent_id = a2.id 
        left join
           transaction_types tt 
           on t.transaction_type = tt.code 
     where
        t.transaction_type = '3' 
        and t.company_id = '$company_id' 
        and t.agent_id = '$agent_id' 
        and t.dr_account_no = '$account_no'";

        $result = DB::select(DB::RAW($sql));


        $data = [
            "results" => $result,
            "account_no" => $account_no
        ];

        return view('report.agent-user.searching.cheque_requisition_status.response', $data);
    }

}
