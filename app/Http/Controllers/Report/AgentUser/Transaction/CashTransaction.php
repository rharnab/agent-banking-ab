<?php

namespace App\Http\Controllers\Report\AgentUser\Transaction;

use App\Http\Controllers\Controller;
use App\Models\AccountOpening;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Exception;

class CashTransaction extends Controller
{
    public function index(){
        $users = DB::table('agent_users')->select('id', 'name')->where('agent_id', Auth::user()->agent_id)->get();
        $data = [
            "users" => $users
        ];
        return view('report.agent-user.transaction.cash.index', $data);
    }



    public function search(Request $request){
        $account_type = $request->input('account_type');
        $starting_date = date('Y-m-d', strtotime($request->input('starting_date')));
        $ending_date   = date('Y-m-d', strtotime($request->input('ending_date')));

        if($account_type == 'all'){
            $userSql = '';
        }else{
            $userSql = " and tr.agent_user_id='$account_type' ";
        }

        $sql = "select tr.approved_timestamp, tr.amount,a.name  as agent_name,au.name as agent_user_name,p2.name as account_type,aca.account_name ,aca.account_no, tt.name  as transaction_types_name,tr.transaction_type from (select *,
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
        where date(tr.approved_timestamp) between '$starting_date' and '$ending_date'
        and tr.transaction_type in (1,3) $userSql";
        $results = DB::select(DB::raw($sql));
        $data = [
            "results" => $results
        ];

        return view('report.agent-user.transaction.cash.response', $data);


    }       


}
