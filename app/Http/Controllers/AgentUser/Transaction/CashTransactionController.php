<?php

namespace App\Http\Controllers\AgentUser\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\AgentGl;
use App\Models\CashRegister;
use App\Models\CashTransactionLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\DB;

class CashTransactionController extends Controller
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

        if($request->input('account_type') == '1'){
            $count = DB::table('agent_gls')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('gl_account_no', $request->input('account_no'))->count();
            if($count == 0){
                Toastr::error("GL account no not found",'Failed');
                return redirect()->route('agent_user.transaction.cash.create');
            }
        }else{
            $count = DB::table('agent_customer_accounts')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $request->input('account_no'))->count();
            if($count == 0){
                Toastr::error("Customer account no not found",'Failed');
                return redirect()->route('agent_user.transaction.cash.create');
            }
        }

        $agent_user_limit = $this->currentAgentUserLimit();

        if($request->input('amount') > $agent_user_limit){
            Toastr::error("Your maximum transaction limit is {$agent_user_limit} TK",'Failed');
            return redirect()->route('agent_user.transaction.cash.create');
        }

        if($request->input('transaction_type') == '3'){ // cash withdraw
            if($request->input('account_type') == '1'){
                $balance = $this->getGLBalance($request->input('account_no'));
            }else{
                $balance = $this->getCustomerBalance($request->input('account_no'));
            }

            if($request->input('amount') > $balance){
                Toastr::error("Insufficient Balance in the account no. Account no is {$request->input('account_no')}",'Failed');
                return redirect()->route('agent_user.transaction.cash.create');
            }
        }


        $cash_register_account_info = DB::table('agent_gls')->select('gl_account_no')->where('product_code', 999)->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->first();
        $account_no = $cash_register_account_info->gl_account_no;





        if($request->input('transaction_type') == '1'){ // cash deposit
            $cheque_no = '';
            $deposite_account_no = '';
            $dr_account_no = $account_no;
            $cr_account_no = $request->input('account_no');
        }else{
            $cheque_no = $request->input('cheque_no'); // cash withdraw
            $deposite_account_no = '';
            $dr_account_no = $request->input('account_no');
            $cr_account_no = $account_no;
        }       
       

        $transaction                      = new Transaction();
        $transaction->company_id          = Auth::user()->company_id;
        $transaction->agent_id            = Auth::user()->agent_id;
        $transaction->agent_user_id       = Auth::user()->agent_user_id;
        $transaction->account_type        = $request->input('account_type');
        $transaction->dr_account_no       = $dr_account_no ;
        $transaction->cr_account_no       = $cr_account_no;
        $transaction->transaction_type    = $request->input('transaction_type');
        $transaction->transaction_date    = date('Y-m-d', strtotime($request->input('transaction_date')) );
        $transaction->currency            = $request->input('currency_type');
        $transaction->amount              = $request->input('amount');
        $transaction->operation_type      = 1;
        $transaction->cheque_no           = $cheque_no;
        $transaction->deposite_account_no = '';
        $transaction->deposite_account_no = $deposite_account_no;
        $transaction->status              = 0;
        $transaction->created_by          = Auth::user()->id;

        try{
            $transaction->save();
            Toastr::success('Transaction Successfully. waiting for authorization :)','Success');
            return redirect()->route('agent_user.transaction.cash.create');
        }catch(Exception $e){
            Toastr::error('Transaction Failed :)','Failed');
            return redirect()->back();
        }

    }



    /**
     * Cash Transaction
     *
     */
    public function authorizeList(){
        $infos = DB::table('transactions as t')
        ->select(
            't.id',
            't.account_type',
            't.dr_account_no',
            't.cr_account_no',
            't.transaction_type',
            't.transaction_date',
            't.transaction_date',
            't.currency',
            't.amount',
            't.operation_type',
            't.cheque_no',
            't.deposite_account_no',
            't.created_at',
            'u.name as user_name',
            'tt.name as transaction_type_name'
        )
        ->leftJoin('users as u', 't.created_by', 'u.id')
        ->leftJoin('transaction_types as tt', 'tt.code', 't.transaction_type')
        ->where('t.company_id', Auth::user()->company_id)
        ->where('t.agent_id', Auth::user()->agent_id)
        ->where('t.status', 0)
        ->where('t.operation_type', 1)
        ->where('t.created_by', '<>', Auth::user()->id)
        ->get();
        $data = [
            "infos" => $infos
        ];
        return view('agent-user.transaction.cash.authorize-list', $data);
    }

    /**
     * Cash Transaction Authorization
     *
     */
    public function authorizeTransaction(Request $request, $id){

        if($this->cashRegisterLogData($id) === true){
            try{
                DB::table('transactions')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('id', $id)->update([
                    "status"             => 1,
                    "approved_by"        => Auth::user()->id,
                    "approved_timestamp" => date('Y-m-d H:i:s')
                ]);
                Toastr::success('Transaction Authorization Successfully','Success');
                return redirect()->route('agent_user.transaction.cash.authorize_list');
            }catch(Exception $e){
                Toastr::error($e->getMessage(),'Failed');
                return redirect()->route('agent_user.transaction.cash.authorize_list');
            }
        }else{
            Toastr::error("Transasction Authorization Failed",'Failed');
            return redirect()->route('agent_user.transaction.cash.authorize_list');
        }
    }

    /**
     * Cash Transaction Information Store into the cash register table
     *
     */
    private function cashRegisterLogData($id){  

        $transaction = DB::table('transactions')
        ->where('company_id', Auth::user()->company_id)
        ->where('agent_id', Auth::user()->agent_id)
        ->where('id', $id)
        ->first();

        if($transaction->account_type == 1){ // gl tranasaction 
            if($transaction->transaction_type == "1"){ // gl cash deposit
                if($this->cashGlDepositeCashResigerLog($id,  $transaction) === true){
                    return true;
                }else{
                    return false;
                }
            }elseif($transaction->transaction_type == "3"){ // gl cash withdraw
                if($this->cashGLWithdrawCashRegister($id, $transaction) === true){
                    return true;
                }else{
                    return false;
                }
            }
        }else{ // customer acccount transasction
            if($transaction->transaction_type == "1"){ // cash diposit
                if($this->cashDepositeCashResigerLog($id, $transaction) === true){
                    return true;
                }else{
                    return false;
                }
            }elseif($transaction->transaction_type == "3"){ // cash withdraw
                if($this->customerWithdrawCashRegister($id, $transaction) === true){
                    return true;
                }else{
                    return false;
                }
            }
        }

        
    }



    private function cashDepositeCashResigerLog($id, $transaction){
        $cash_register                   = new CashRegister();
        $cash_register->company_id       = Auth::user()->company_id;
        $cash_register->agent_id         = Auth::user()->agent_id;
        $cash_register->agent_user_id    = Auth::user()->agent_user_id;
        $cash_register->transaction_id   = $transaction->id;
        $cash_register->transaction_type = $transaction->transaction_type;
        $cash_register->dr_account_no    = $transaction->dr_account_no;
        $cash_register->dr_amount        = $transaction->amount;
        $cash_register->cr_account_no    = $transaction->cr_account_no;
        $cash_register->cr_amount        = $transaction->amount;
        $cash_register->remarks          = "Cash Deposite Transaction";

        try{
            $cash_register->save();
            if($transaction->account_type == 2){
                $old_customer_balance = $this->customerBalance($transaction->cr_account_no);

                try{
                    DB::table('agent_customer_accounts')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $transaction->cr_account_no)->update([
                        "balance"    => $old_customer_balance + $transaction->amount,
                        "updated_at" => date("Y-m-d H:i:s")
                    ]);

                    return true;
                }catch(Exception $e){
                    Toastr::error($e->getMessage(),'Failed');
                    return redirect()->route('agent_user.transaction.cash.authorize_list');
                }

            }
            
        }catch(Exception $e){
            return false;
        }
    }



    private function oldAgentGlBalance($account_no){
        $info = DB::table('agent_gls')->select('balance')->where('agent_id', Auth::user()->agent_id)->where('company_id', Auth::user()->company_id)->where('gl_account_no', $account_no)->first();
        return $info->balance;
    }

    private function customerBalance($account_no){
        $info =  DB::table('agent_customer_accounts')->select('balance')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $account_no)->first();
        return $info->balance;
    }


    private function customerWithdrawCashRegister($id, $transaction){
        $cash_register                   = new CashRegister();
        $cash_register->company_id       = Auth::user()->company_id;
        $cash_register->agent_id         = Auth::user()->agent_id;
        $cash_register->agent_user_id    = Auth::user()->agent_user_id;
        $cash_register->transaction_id   = $transaction->id;
        $cash_register->transaction_type = $transaction->transaction_type;
        $cash_register->dr_account_no    = $transaction->dr_account_no;
        $cash_register->dr_amount        = $transaction->amount;
        $cash_register->cr_account_no    = $transaction->cr_account_no;
        $cash_register->cr_amount        = $transaction->amount;
        $cash_register->remarks          = "Cash Withdraw Transaction";
        try{

            if($transaction->account_type == 2){
                $old_customer_balance = $this->customerBalance($transaction->dr_account_no);
                DB::table('agent_customer_accounts')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $transaction->dr_account_no)->update([
                    "balance"    => $old_customer_balance - $transaction->amount,
                    "updated_at" => date("Y-m-d H:i:s")
                ]);
            }

            return true;
        }catch(Exception $e){
            return false;
        }
    }



    private function cashGlDepositeCashResigerLog($id, $transaction){
        $cash_register                   = new CashRegister();
        $cash_register->company_id       = Auth::user()->company_id;
        $cash_register->agent_id         = Auth::user()->agent_id;
        $cash_register->agent_user_id    = Auth::user()->agent_user_id;
        $cash_register->transaction_id   = $transaction->id;
        $cash_register->transaction_type = $transaction->transaction_type;
        $cash_register->dr_account_no    = $transaction->dr_account_no;
        $cash_register->dr_amount        = $transaction->amount;
        $cash_register->cr_account_no    = $transaction->cr_account_no;
        $cash_register->cr_amount        = $transaction->amount;
        $cash_register->remarks          = "GL Cash Deposite Transaction";
        
        try{
            $cash_register->save();
            $old_agent_gl_balance = $this->oldAgentGlBalance($transaction->cr_account_no);
            DB::table('agent_gls')
            ->where('agent_id', Auth::user()->agent_id)
            ->where('company_id', Auth::user()->company_id)
            ->where('gl_account_no', $transaction->cr_account_no)
            ->update([
                "balance"    => $old_agent_gl_balance +  $transaction->amount,
                "updated_at" => date("Y-m-d H:i:s")
            ]);

            return true;
        }catch(Exception $e){
            return false;
        }
    }


    private function cashGLWithdrawCashRegister($id,  $transaction){
        $cash_register                   = new CashRegister();
        $cash_register->company_id       = Auth::user()->company_id;
        $cash_register->agent_id         = Auth::user()->agent_id;
        $cash_register->agent_user_id    = Auth::user()->agent_user_id;
        $cash_register->transaction_id   = $transaction->id;
        $cash_register->transaction_type = $transaction->transaction_type;
        $cash_register->dr_account_no    = $transaction->dr_account_no;
        $cash_register->dr_amount        = $transaction->amount;
        $cash_register->cr_account_no    = $transaction->cr_account_no;
        $cash_register->cr_amount        = $transaction->amount;
        $cash_register->remarks          = "GL Cash Withdraw Transaction";
        try{
            $cash_register->save();
            $old_agent_gl_balance = $this->oldAgentGlBalance($transaction->dr_account_no);
            DB::table('agent_gls')->where('agent_id', Auth::user()->agent_id)->where('company_id', Auth::user()->company_id)->where('gl_account_no', $transaction->dr_account_no)->update([
                "balance"    => $old_agent_gl_balance -  $transaction->amount,
                "updated_at" => date("Y-m-d H:i:s")
            ]);

            return true;
        }catch(Exception $e){
            return false;
        }
    }


    public function currentAgentUserLimit(){
        $info = DB::table('agent_users')->select('transaction_amount_limit')->where('company_id', Auth::user()->company_id)->where('id', Auth::user()->agent_user_id)->where('agent_id', Auth::user()->agent_id)->first();
        return $info->transaction_amount_limit;
    }


    private function getGLBalance($account_no){
        $info = DB::table('agent_gls')->select('balance')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('gl_account_no', $account_no)->first();
        return $info->balance;
    }


    private function getCustomerBalance($account_no){
        $info = DB::table('agent_customer_accounts')->select('balance')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $account_no)->first();
        return $info->balance;
    }



}