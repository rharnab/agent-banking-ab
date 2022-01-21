<?php

namespace App\Http\Controllers\FundTransfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FundTransfer;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{

	public function __construct(){

        $this->middleware('auth');
    }

    public function index(){

        $fund_transfers = FundTransfer::all();
    	return view('agent-admin.agent-user.transaction.transfer.index',['fund_transfers'=>$fund_transfers]);
    }


    public function create(){
        
        return view('agent-admin.agent-user.transaction.transfer.create');
    }

    public function store(Request $request){
        
        $fund_transfer             = new FundTransfer();
        $fund_transfer->acc_option = $request->input('accorgl');
        $fund_transfer->debit_ac   = $request->input('frmactogl');
        $fund_transfer->txn_type   = $request->input('txnType');
        $fund_transfer->credit_ac  = $request->input('toacgl');
        $fund_transfer->amount     = $request->input('amount');
        $fund_transfer->currency   = $request->input('currency');
        $fund_transfer->cheaque_no = $request->input('cheaqueNo');
        $fund_transfer->is_approve = 0;
        $fund_transfer->created_by = Auth::user()->id;

        try{
            $fund_transfer->save();
            Toastr::success('Transaction Created Successfully','Success');
            return redirect()->route('transfer.fund.create');
        }catch(Exception $e){
            Toastr::error('Transaction Created Failed','Error');
            return redirect()->route('transfer.fund.create');
        }
    }

    public function update($update_id){

        $fund_transfer = FundTransfer::find($update_id);



        
        $fund_transfer->is_approve   = 1;
        $fund_transfer->approve_by   = Auth::user()->id;
        $fund_transfer->approve_date = date('Y-m-d H:i:s');
        try{
            $fund_transfer->save();
            Toastr::success('Transaction update Successfully','Success');
            return redirect()->route('transfer.fund.index');
        }catch(Exception $e){
            Toastr::error('Transaction update Failed','Error');
            return redirect()->route('transfer.fund.index');
        }
        
    }
}
