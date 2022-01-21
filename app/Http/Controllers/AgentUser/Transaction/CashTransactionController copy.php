<?php

namespace App\Http\Controllers\AgentUser\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\AgentGl;
use App\Models\CashTransactionLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\DB;

class weqrwqwer extends Controller
{
     /**
     * Check Authencticate user
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Redirect To Transaction Create Screent
     *
     * @return void
     */
    public function create(){
        return view('agent-user.transaction.cash.create');
    }



    /**
     * Transaction Information Store
     *
     * @return void
     */
    public function store(Request $request){


        if($this->checkAccountGlHead($request->input('account_no')) === true){
           
            $gl_parent = substr($request->input('account_no'), 5,3);
            $agent_id = Auth::user()->agent_id;
            $gl_info = DB::select( DB::raw("select ag.gl_account_no , a.id as account_id, ag.id as agent_account_id from 
            (select account_id from gl_mappings gm where product_id = (select  id from products p where code ='$gl_parent')) s 
            left join accounts a on s.account_id = a.id
            left join agent_gls ag on a.acc_code  = ag.gl_account_no 
            where ag.agent_id = $agent_id") );

            $account_info = DB::table('agent_customer_accounts')->where('account_no', $request->input('account_no'))->first();

            $accounts = DB::select( DB::raw("select ag.gl_account_no , a.id as account_id, ag.id as agent_account_id from 
            (select account_id from gl_mappings gm where product_id = (select  id from products p where code ='999')) s 
            left join accounts a on s.account_id = a.id
            left join agent_gls ag on a.acc_code  = ag.gl_account_no 
            where ag.agent_id = $agent_id") );

            foreach($gl_info as $gl){
                $gl_account_no    = $gl->gl_account_no;
                $account_id       = $gl->account_id;
                $agent_account_id = $gl->agent_account_id;
            }

            foreach($accounts as $account){
                $cash_register_gl_account       = $gl->gl_account_no;
                $cash_register_gl_id            = $gl->account_id;
                $cash_register_agent_account_id = $gl->agent_account_id;
            }

            $transaction                   = new Transaction();
            $transaction->company_id       = Auth::user()->company_id;
            $transaction->agent_id         = Auth::user()->agent_id;
            $transaction->agent_user_id    = $account_info->agent_user_id;
            $transaction->transaction_type = $request->input('transaction_type');
            $transaction->dr_account_id    = $cash_register_gl_account;
            $transaction->dr_amount        = $request->input('amount');
            $transaction->cr_account_id    = $gl_account_no;
            $transaction->cr_amount        = $request->input('amount');
            $transaction->status           = 0;
            $transaction->created_by       = Auth::user()->id;


            try{
                $transaction->save();

                $trn = new Transaction();
                $trn->company_id       = Auth::user()->company_id;
                $trn->agent_id         = Auth::user()->agent_id;
                $trn->agent_user_id    = $account_info->agent_user_id;
                $trn->transaction_type = $request->input('transaction_type');
                $trn->dr_account_id    = $cash_register_gl_account;
                $trn->dr_amount        = $request->input('amount');
                $trn->cr_account_id    = $request->input('account_no');
                $trn->cr_amount        = $request->input('amount');
                $trn->status           = 0;
                $trn->created_by       = Auth::user()->id;
                $trn->save();

                $this->updateBankGl($account_id, $request->input('amount'));
                $this->agentGlBalance($agent_account_id, $request->input('amount'));
                $this->updateCustomerAccount($request->input('account_no'),$request->input('amount') );

                Toastr::success('Cash Transaction Successfully :)','Success');
                return redirect()->route('agent_user.transaction.cash.create');




            }catch(Exception $e){
                Toastr::error($e->getMessage(),'Failed');
                return redirect()->route('agent_user.transaction.cash.create');
            }





        }else{
            Toastr::error("This account gl not mapping",'Failed');
            return redirect()->route('agent_user.transaction.cash.create');
        }



    }


    private function updateBankGl($id, $amount){
        $oldInfo = DB::table('accounts')->select('current_balance', 'total_cr_balance')->where('id', $id)->first();
         DB::table('accounts')->where('id', $id)->update([
             "current_balance" => $oldInfo->current_balance + $amount,
             "total_cr_balance" => $oldInfo->total_cr_balance + $amount
         ]);
    }


    public function agentGlBalance($id, $amount){
        $info = DB::table('agent_gls')->select('balance')->where('id', $id)->first();
        DB::table('agent_gls')->where('id', $id)->update([
            "balance" => $info->balance + $amount
        ]);
    }

    public function updateCustomerAccount($account_no, $amount){
        $info = DB::table('agent_customer_accounts')->select('balance')->where('account_no', $account_no)->first();
        DB::table('agent_customer_accounts')->where('account_no', $account_no)->update([
            "balance" => $info->balance + $amount
        ]);
    }

  


    private function checkAccountGlHead($account_no){
        $gl_parent = substr($account_no, 5,3);
        $infos = DB::select( DB::raw("select count(*) as total from gl_mappings gm where product_id = (select  id from products p where code ='$gl_parent') limit 1") );
       
        foreach($infos as $info){
            $total = $info->total;
        }
        if( $total > 0){
            return true;
        }else{
            return false;
        }
    }


}
