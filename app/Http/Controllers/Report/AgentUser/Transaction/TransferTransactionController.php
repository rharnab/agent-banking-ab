<?php

namespace App\Http\Controllers\Report\AgentUser\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransferTransactionController extends Controller
{
    public function index(){
        $users = DB::table('agent_users')->select('id', 'name')->where('agent_id', Auth::user()->agent_id)->get();
        $data = [
            "users" => $users
        ];
        return view('report.agent-user.transaction.transfer.index', $data);
    }

    public function search(Request $request){
        $account_type = $request->input('account_type');
        $starting_date = date('Y-m-d', strtotime($request->input('starting_date')));
        $ending_date   = date('Y-m-d', strtotime($request->input('ending_date')));

        if($account_type == 'all'){
            $userSql = '';
        }else{
            $userSql = " and t.agent_user_id='$account_type' ";
        }

        $sql = "select
        a.name as agent_name,
        t.account_type,
        t.dr_account_no,
        t.amount,
        t.deposti_account_type,
        t.deposite_account_no,
        u2.name as operation_user,
        t.approved_timestamp 
     from
        transactions t 
        left join
           agents a 
           on t.agent_id = a.id 
        left join
           transaction_types tt 
           on t.transaction_type = tt.code 
        left join
           users u2 
           on t.approved_by = u2.id 
     where
        t.transaction_type = 5 
        and date(t.approved_timestamp) between '$starting_date' and '$ending_date' $userSql";


        $results = DB::select(DB::raw($sql));
        $data = [
            "results" => $results
        ];
        return view('report.agent-user.transaction.transfer.response', $data);
    }

}
