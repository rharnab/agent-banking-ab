<?php

namespace App\Http\Controllers\Report\AgentUser\Statement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DateRangeStatementController extends Controller
{
    public function index(){
        return view('report.agent-user.statement.date-range-statement.index');
    }

    public function search(Request $request){
        $account_no    = $request->input('account_no');
        $starting_date = date('Y-m-d', strtotime($request->input('starting_date')));
        $ending_date   = date('Y-m-d', strtotime($request->input('ending_date')));


        $sql = "select tr.approved_timestamp,tr.cheque_no,tr.amount,a.name  as agent_name,au.name as agent_user_name,p2.name as account_type,aca.account_name ,aca.account_no, tt.name  as transaction_types_name,tr.transaction_type from (select *,
        if(account_type=2 and transaction_type =1, cr_account_no , 
            if(account_type =2 and transaction_type = 3, dr_account_no, 
                if(account_type = 2 and transaction_type = 5, dr_account_no, '')
            )
        ) as account_no 
        
        from transactions t ) as tr
        left join agent_customer_accounts aca on tr.account_no=aca.account_no 
        left join products p2 on aca.product_code = p2.id 
        left join agents a on tr.agent_id = a.id
        left join agent_users au on tr.agent_user_id = au.id
        left join transaction_types tt on tr.transaction_type=tt.code 
        where  tr.account_no='$account_no' and  date(tr.approved_timestamp) between '$starting_date' and '$ending_date'";

        $results = DB::select(DB::raw($sql));
        $data = [
            "results"       => $results,
            "starting_date" => $starting_date,
            "ending_date"   => $ending_date,
        ];
        return view('report.agent-user.statement.date-range-statement.response', $data);


    }

}
