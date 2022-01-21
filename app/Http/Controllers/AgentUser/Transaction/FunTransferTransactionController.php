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

class FunTransferTransactionController extends Controller
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
     * Redirect To Transaction Create Screen
     *
     * @return void
     */
    public function create(){
        return view('agent-user.transaction.transfer.create');
    }


      /**
     * Transaction Information Store
     *
     * @return void
     */
    public function store(Request $request){

        $agent_user_limit = $this->currentAgentUserLimit();

        if($request->input('amount') > $agent_user_limit){
            Toastr::error("Your maximum transaction limit is {$agent_user_limit} TK",'Failed');
            return redirect()->route('agent_user.transaction.transfer.create');
        }


        // check account no is exists or not

        if($request->input('account_type') == '1'){
            $count = DB::table('agent_gls')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('gl_account_no', $request->input('account_no'))->count();
            if($count == 0){
                Toastr::error("GL account no not found",'Failed');
                return redirect()->route('agent_user.transaction.cash.create');
            }
        }elseif($request->input('account_type') == '2'){
            $count = DB::table('agent_customer_accounts')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $request->input('account_no'))->count();
            if($count == 0){
                Toastr::error("Customer account no not found",'Failed');
                return redirect()->route('agent_user.transaction.cash.create');
            }
        }


        // check deposit account no is exists or not
        if($request->input('deposite_account_type') == '1'){
            $count = DB::table('agent_gls')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('gl_account_no', $request->input('deposit_account_no'))->count();
            if($count == 0){
                Toastr::error("Deposit GL account no not found",'Failed');
                return redirect()->route('agent_user.transaction.transfer.create');
            }
        }elseif($request->input('deposite_account_type') == '2'){
            $count = DB::table('agent_customer_accounts')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $request->input('deposit_account_no'))->count();
            if($count == 0){
                Toastr::error("Deposit Customer account no not found",'Failed');
                return redirect()->route('agent_user.transaction.transfer.create');
            }
        }


        if($request->input('transaction_type') == '4'){ // online cash withdraw
            $cheque_no = $request->input('cheque_no');
        }else{
            $cheque_no = '';
        }

        $cash_register_account_info = DB::table('agent_gls')->select('gl_account_no')->where('product_code', 999)->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->first();
        $cash_register_gl = $cash_register_account_info->gl_account_no;




        $transaction                       = new Transaction();
        $transaction->company_id           = Auth::user()->company_id;
        $transaction->agent_id             = Auth::user()->agent_id;
        $transaction->agent_user_id        = Auth::user()->agent_user_id;
        $transaction->account_type         = $request->input('account_type');
        $transaction->dr_account_no        = $request->input('account_no');
        $transaction->cr_account_no        = $cash_register_gl;
        $transaction->transaction_type     = $request->input('transaction_type');
        $transaction->transaction_date     = date('Y-m-d', strtotime($request->input('transaction_date')) );
        $transaction->currency             = $request->input('currency_type');
        $transaction->amount               = $request->input('amount');
        $transaction->operation_type       = 2;
        $transaction->cheque_no            = $cheque_no;
        $transaction->deposti_account_type = $request->input('deposite_account_type');
        $transaction->deposite_account_no  = $request->input('deposit_account_no') ?? '';
        $transaction->status               = 0;
        $transaction->created_by           = Auth::user()->id;
        try{
            $transaction->save();
            Toastr::success('Transaction Successfully. waiting for authorization :)','Success');
            return redirect()->route('agent_user.transaction.transfer.create');
        }catch(Exception $e){
            Toastr::error('Transaction Failed :)','Failed');
            return redirect()->back();
        }
    }


    public function currentAgentUserLimit(){
        $info = DB::table('agent_users')->select('transaction_amount_limit')->where('company_id', Auth::user()->company_id)->where('id', Auth::user()->agent_user_id)->where('agent_id', Auth::user()->agent_id)->first();
        return $info->transaction_amount_limit;
    }



    public function pendingList(){
        $infos = DB::table('transactions as t')
        ->select(
            't.id',
            't.account_type',
            't.dr_account_no',
            't.transaction_type',
            't.transaction_date',
            't.transaction_date',
            't.currency',
            't.amount',
            't.operation_type',
            't.cheque_no',
            't.deposite_account_no',
            't.deposti_account_type',
            'u.name as user_name',
            'tt.name as transaction_type_name'
        )
        ->leftJoin('users as u', 't.created_by', 'u.id')
        ->leftJoin('transaction_types as tt', 'tt.code', 't.transaction_type')
        ->where('t.company_id', Auth::user()->company_id)
        ->where('t.agent_id', Auth::user()->agent_id)
        ->where('t.status', 0)
        ->where('t.operation_type', 2)
        ->where('t.created_by', '<>', Auth::user()->id)
        ->orderBy('t.id')
        ->get();
        $data = [
            "infos" => $infos
        ];
        return view('agent-user.transaction.transfer.pending', $data);
    }




    public function authorizeTransaction(Request $request, $id){
        if($this->cashRegisterLogData($id) === true){
            try{
                DB::table('transactions')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('id', $id)->update([
                    "status"             => 1,
                    "approved_by"        => Auth::user()->id,
                    "approved_timestamp" => date('Y-m-d H:i:s')
                ]);
                Toastr::success('Transaction Authorization Successfully','Success');
                return redirect()->route('agent_user.transaction.transfer.pending');
            }catch(Exception $e){
                Toastr::error($e->getMessage(),'Failed');
                return redirect()->route('agent_user.transaction.transfer.pending');
            }
        }else{
            Toastr::error("Transasction Authorization Failed",'Failed');
            return redirect()->route('agent_user.transaction.transfer.pending');
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

        if($transaction->transaction_type == 5){ //Transfer Transaction
            if($this->fundTransaferAuthorize($id,  $transaction) === true){
                return true;
            }else{
                return false;
            }
        }

    }



    private function fundTransaferAuthorize($id,  $transaction){
        if($transaction->account_type == 1 && $transaction->deposti_account_type == 1){ // gl to gl fund transfer
            return $this->glToGlFundTransfer($id, $transaction);
        }elseif($transaction->account_type == 1 && $transaction->deposti_account_type == 2){ // gl to customer account transfer
            return $this->glToCustomerAccountFundTransfer($id, $transaction);
        }elseif($transaction->account_type == 2 && $transaction->deposti_account_type == 1){ // customer account to gl
            return $this->customerAccountToGlTransfer($id, $transaction);
        }elseif($transaction->account_type == 2 && $transaction->deposti_account_type == 2){ // customer gl to gl
            return $this->customerToCustomerFundTransfer($id, $transaction);
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


    /**
     * Customer Account To Account Fund Transfer
     *
     * @return void
     */
    private function customerToCustomerFundTransfer($id, $transaction){
        $cash_register = new CashRegister();
        $cash_register->company_id       = Auth::user()->company_id;
        $cash_register->agent_id         = Auth::user()->agent_id;
        $cash_register->agent_user_id    = Auth::user()->agent_user_id;
        $cash_register->transaction_id   = $transaction->id;
        $cash_register->transaction_type = $transaction->transaction_type;
        $cash_register->dr_account_no    = $transaction->dr_account_no;
        $cash_register->dr_amount        = $transaction->amount;
        $cash_register->cr_account_no    = $transaction->cr_account_no;
        $cash_register->cr_amount        = $transaction->amount;
        $cash_register->remarks          = "Fund Transafer Substract Transaction";
        try{
            $cash_register->save();
            if($transaction->account_type == 2){
                $old_customer_balance = $this->customerBalance($transaction->dr_account_no);
                DB::table('agent_customer_accounts')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $transaction->dr_account_no)->update([
                    "balance"    => $old_customer_balance - $transaction->amount,
                    "updated_at" => date("Y-m-d H:i:s")
                ]);
            }


            $cash_register = new CashRegister();
            $cash_register->company_id       = Auth::user()->company_id;
            $cash_register->agent_id         = Auth::user()->agent_id;
            $cash_register->agent_user_id    = Auth::user()->agent_user_id;
            $cash_register->transaction_id   = $transaction->id;
            $cash_register->transaction_type = $transaction->transaction_type;
            $cash_register->dr_account_no    = $transaction->cr_account_no;
            $cash_register->dr_amount        = $transaction->amount;
            $cash_register->cr_account_no    = $transaction->deposite_account_no;
            $cash_register->cr_amount        = $transaction->amount;
            $cash_register->remarks          = "Fund Transafer Summation Transaction";

            try{
                $cash_register->save();
                if($transaction->deposti_account_type == 2){
                    $old_customer_balance = $this->customerBalance($transaction->deposite_account_no);
                    DB::table('agent_customer_accounts')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $transaction->deposite_account_no)->update([
                        "balance"    => $old_customer_balance + $transaction->amount,
                        "updated_at" => date("Y-m-d H:i:s")
                    ]);
                }
                return true;
            }catch(Exception $e){
                return false;
            }

        }catch(Exception $e){
            return false;
        }
    }




    public function glToGlFundTransfer($id, $transaction){
        $cash_register = new CashRegister();
        $cash_register->company_id       = Auth::user()->company_id;
        $cash_register->agent_id         = Auth::user()->agent_id;
        $cash_register->agent_user_id    = Auth::user()->agent_user_id;
        $cash_register->transaction_id   = $transaction->id;
        $cash_register->transaction_type = $transaction->transaction_type;
        $cash_register->dr_account_no    = $transaction->dr_account_no;
        $cash_register->dr_amount        = $transaction->amount;
        $cash_register->cr_account_no    = $transaction->cr_account_no;
        $cash_register->cr_amount        = $transaction->amount;
        $cash_register->remarks          = "Fund Transafer Substract Transaction Gl To Cash Register";
        try{
            $cash_register->save();
            $old_agent_gl_balance = $this->getGLBalance($transaction->dr_account_no);
            DB::table('agent_gls')->where('agent_id', Auth::user()->agent_id)->where('company_id', Auth::user()->company_id)->where('gl_account_no', $transaction->dr_account_no)->update([
                "balance"    => $old_agent_gl_balance -  $transaction->amount,
                "updated_at" => date("Y-m-d H:i:s")
            ]);
           


            $cash_register = new CashRegister();
            $cash_register->company_id       = Auth::user()->company_id;
            $cash_register->agent_id         = Auth::user()->agent_id;
            $cash_register->agent_user_id    = Auth::user()->agent_user_id;
            $cash_register->transaction_id   = $transaction->id;
            $cash_register->transaction_type = $transaction->transaction_type;
            $cash_register->dr_account_no    = $transaction->cr_account_no;
            $cash_register->dr_amount        = $transaction->amount;
            $cash_register->cr_account_no    = $transaction->deposite_account_no;
            $cash_register->cr_amount        = $transaction->amount;
            $cash_register->remarks          = "Fund Transafer Summation Transaction";

            try{
                $cash_register->save();
           
                $old_agent_gl_balance = $this->getGLBalance($transaction->deposite_account_no);
                DB::table('agent_gls')->where('agent_id', Auth::user()->agent_id)->where('company_id', Auth::user()->company_id)->where('gl_account_no', $transaction->deposite_account_no)->update([
                    "balance"    => $old_agent_gl_balance +  $transaction->amount,
                    "updated_at" => date("Y-m-d H:i:s")
                ]);


                return true;
            }catch(Exception $e){
                return false;
            }

        }catch(Exception $e){
            return false;
        }
        
    }



    private function glToCustomerAccountFundTransfer($id, $transaction){
        $cash_register = new CashRegister();
        $cash_register->company_id       = Auth::user()->company_id;
        $cash_register->agent_id         = Auth::user()->agent_id;
        $cash_register->agent_user_id    = Auth::user()->agent_user_id;
        $cash_register->transaction_id   = $transaction->id;
        $cash_register->transaction_type = $transaction->transaction_type;
        $cash_register->dr_account_no    = $transaction->dr_account_no;
        $cash_register->dr_amount        = $transaction->amount;
        $cash_register->cr_account_no    = $transaction->cr_account_no;
        $cash_register->cr_amount        = $transaction->amount;
        $cash_register->remarks          = "Fund Transafer Substract Transaction Gl To Cash Register";
        try{
            $cash_register->save();
            $old_agent_gl_balance = $this->getGLBalance($transaction->dr_account_no);
            DB::table('agent_gls')->where('agent_id', Auth::user()->agent_id)->where('company_id', Auth::user()->company_id)->where('gl_account_no', $transaction->dr_account_no)->update([
                "balance"    => $old_agent_gl_balance -  $transaction->amount,
                "updated_at" => date("Y-m-d H:i:s")
            ]);
           


            $cash_register = new CashRegister();
            $cash_register->company_id       = Auth::user()->company_id;
            $cash_register->agent_id         = Auth::user()->agent_id;
            $cash_register->agent_user_id    = Auth::user()->agent_user_id;
            $cash_register->transaction_id   = $transaction->id;
            $cash_register->transaction_type = $transaction->transaction_type;
            $cash_register->dr_account_no    = $transaction->cr_account_no;
            $cash_register->dr_amount        = $transaction->amount;
            $cash_register->cr_account_no    = $transaction->deposite_account_no;
            $cash_register->cr_amount        = $transaction->amount;
            $cash_register->remarks          = "Fund Transafer Summation Transaction Cash Register to Customer Account";

            try{
                $cash_register->save();

                $old_customer_balance = $this->customerBalance($transaction->deposite_account_no);
                DB::table('agent_customer_accounts')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $transaction->deposite_account_no)->update([
                    "balance"    => $old_customer_balance + $transaction->amount,
                    "updated_at" => date("Y-m-d H:i:s")
                ]);
                return true;
            }catch(Exception $e){
                return false;
            }

        }catch(Exception $e){
            return false;
        }
    }



    private function customerAccountToGlTransfer($id, $transaction){
        $cash_register = new CashRegister();
        $cash_register->company_id       = Auth::user()->company_id;
        $cash_register->agent_id         = Auth::user()->agent_id;
        $cash_register->agent_user_id    = Auth::user()->agent_user_id;
        $cash_register->transaction_id   = $transaction->id;
        $cash_register->transaction_type = $transaction->transaction_type;
        $cash_register->dr_account_no    = $transaction->dr_account_no;
        $cash_register->dr_amount        = $transaction->amount;
        $cash_register->cr_account_no    = $transaction->cr_account_no;
        $cash_register->cr_amount        = $transaction->amount;
        $cash_register->remarks          = "Fund Transafer Substract Transaction Customer Account To Cash Register";
        try{

            $cash_register->save();
            $old_customer_balance = $this->customerBalance($transaction->dr_account_no);
            DB::table('agent_customer_accounts')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('account_no', $transaction->dr_account_no)->update([
                "balance"    => $old_customer_balance - $transaction->amount,
                "updated_at" => date("Y-m-d H:i:s")
            ]);

            
            $cash_register = new CashRegister();
            $cash_register->company_id       = Auth::user()->company_id;
            $cash_register->agent_id         = Auth::user()->agent_id;
            $cash_register->agent_user_id    = Auth::user()->agent_user_id;
            $cash_register->transaction_id   = $transaction->id;
            $cash_register->transaction_type = $transaction->transaction_type;
            $cash_register->dr_account_no    = $transaction->cr_account_no;
            $cash_register->dr_amount        = $transaction->amount;
            $cash_register->cr_account_no    = $transaction->deposite_account_no;
            $cash_register->cr_amount        = $transaction->amount;
            $cash_register->remarks          = "Fund Transafer Summation Transaction Cash Register to Gl Account";

            try{
                $cash_register->save();
                $old_agent_gl_balance = $this->getGLBalance($transaction->deposite_account_no);
                DB::table('agent_gls')->where('agent_id', Auth::user()->agent_id)->where('company_id', Auth::user()->company_id)->where('gl_account_no', $transaction->deposite_account_no)->update([
                    "balance"    => $old_agent_gl_balance +  $transaction->amount,
                    "updated_at" => date("Y-m-d H:i:s")
                ]);
                return true;
            }catch(Exception $e){
                return false;
            }


        }catch(Exception $e){
            return false;
        }
    
    }


    
    private function getGLBalance($account_no){
        $info = DB::table('agent_gls')->select('balance')->where('company_id', Auth::user()->company_id)->where('agent_id', Auth::user()->agent_id)->where('gl_account_no', $account_no)->first();
        return $info->balance;
    }








}
