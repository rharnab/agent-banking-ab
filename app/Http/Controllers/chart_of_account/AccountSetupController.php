<?php

namespace App\Http\Controllers\chart_of_account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\AgentGl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\DB;

class AccountSetupController extends Controller
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
     * Show All Setup Account
     *
     * @return void
     */
    public function index(){

        $accounts = DB::table('accounts as a')
                ->select('a.*','aa.name as parent_accont_name','at.name as account_type_name')
                ->leftJoin('accounts as aa', 'a.immediate_parent', 'aa.id')
                ->leftJoin('gl_account_types as at', 'a.acc_types', 'at.id')
                ->where('a.company_id', Auth::user()->company_id)
                ->orderBy('a.id','desc')
                ->get();     
        $data = [
            "accounts" => $accounts
        ];
        return view('chart_of_account.account-setup.index' , $data);
    }

    /**
     * Redirect To account setup page
     *
     * @return void
     */
    public function create(){
        $account_types = DB::table('gl_account_types')->where('company_id', Auth::user()->company_id)->get();
        $data = [
            "account_types" => $account_types
        ];
        return view('chart_of_account.account-setup.create', $data);
    }


    /**
     * Store Account Setup information
     *
     * @return void
     */
    public function store(Request $request){

        if(!empty($request->input('immidiate_parent')) ){
            $immidiate_parent = $request->input('immidiate_parent');
        }else{
            $immidiate_parent = 0;
        }

        if($request->input('allow_manual_transction') === 'yes'){
            $allow_manual_transction = true;
        }elseif($request->input('allow_manual_transction') === 'no'){
            $allow_manual_transction = false;
        }

        if($request->input('allow_negetive_transction') === 'yes'){
            $allow_negetive_transction = true;
        }elseif($request->input('allow_negetive_transction') === 'no'){
            $allow_negetive_transction = false;
        }

        if($request->input('is_default') === 'yes'){
            $is_default = 1;
        }elseif($request->input('is_default') === 'no'){
            $is_default = 0;
        }

        if($request->input('is_agent_access') === 'yes'){
            $is_agent_access = 1;
        }elseif($request->input('is_agent_access') === 'no'){
            $is_agent_access = 0;
        }



        $account = new Account();

        $account->company_id               = Auth::user()->company_id;
        $account->name                     = $request->input('name');
        $account->acc_code                 = $this->maximumAccountCode();
        $account->acc_level                = $request->input('acc_level');
        $account->acc_types                = $request->input('acc_types');
        $account->immediate_parent         = $immidiate_parent;
        $account->allow_manual_transaction = $allow_manual_transction;
        $account->allow_negative_balance   = $allow_negetive_transction;
        $account->is_agent_access          = $is_agent_access;
        $account->is_default               = $is_default;
        $account->created_by               = Auth::id();
        $account->status                   = 0;

        try{
            $save_account = $account->save();
            Toastr::success('Account Setup Successfully :)','Success');
            return redirect()->route('account_setup.index');
        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Failed');
            return redirect()->route('account_setup.create');
        }
    }


    private function maximumAccountCode(){
        $company_id   = Auth::user()->company_id;
        $max_acc_code = DB::table('accounts')->select('acc_code')->where('acc_code', DB::raw("(select max(`acc_code`) from accounts where company_id='$company_id' limit 1)"))->first();
     
        $account_code = $max_acc_code->acc_code ?? 100000;
        return $account_code + 1;
    }
    

    /**
     * Search Parent Account
     *
     * @return void
     */
    public function searchParentAccount(Request $request){
        $acc_level = $request->input('acc_level') - 1;
        $acc_types = $request->input('acc_types');
        $datas = DB::table('accounts')->select('id', 'name')->where('company_id',Auth::user()->company_id)->where('acc_level', $acc_level)->where('acc_types', $acc_types)->where('status', 1)->get();
        $output = "<option value=''>Select Parent Account</option>";
        if($datas->count() > 0){
            foreach($datas as $data){
                $output .= "<option value='{$data->id}'>{$data->name}</option>";
            }
        }else{
            $output .= "<option value=''>Parent Account Not Found</option>";          
        }

        return $output;
    }

    /**
     * Pending Account Request Autorization
     *
     * @return void
     */
    public function pendingAccountSetup(){
        $accounts = DB::table('accounts as a')
                ->select('a.*','aa.name as parent_accont_name','at.name as account_type_name')
                ->leftJoin('accounts as aa', 'a.immediate_parent', 'aa.id')
                ->leftJoin('gl_account_types as at', 'a.acc_types', 'at.id')
                ->where('a.company_id', Auth::user()->company_id)
                ->where('a.created_by', '<>', Auth::user()->id)
                ->where('a.status', 0)
                ->orderBy('a.id','desc')
                ->get();     
        $data = [
            "accounts" => $accounts
        ];
        return view('chart_of_account.account-setup.pending' , $data);
    }


    public function authorizeAccountSetup($id){
        try{
            $this->createAgentGl($id);
            DB::table('accounts')->where('id', $id)->update([
                "approved_by"        => Auth::user()->id,
                "approved_timestamp" => date('Y-m-d H:i:s'),
                "status"             => 1
            ]); 
            Toastr::success('Account Authorize Successfully :)','Success');
            return redirect()->route('account_setup.pending');
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Failed');
            return redirect()->route('account_setup.pending');
        }
    }


    private function createAgentGl($id){
        $account_info = DB::table('accounts')->select('acc_code', 'is_agent_access')->where('id',$id)->where('company_id', Auth::user()->company_id)->first();
        $acc_code     = $account_info->acc_code;
        if($account_info->is_agent_access == 1){
            $agents       = DB::table('agents')->select('id')->where('company_id', Auth::user()->company_id)->get();
            foreach($agents as $agent){
                if($this->checkAlreadyExits($agent->id, $acc_code) === false){
                    $this->createThisAgentGl($agent->id, $acc_code);
                }
            }
        }
        
    }

    private function checkAlreadyExits($agent_id, $acc_code){
        $data = DB::table('agent_gls')
        ->where('company_id', Auth::user()->company_id)
        ->where('agent_id', $agent_id)
        ->where('gl_account_no', $acc_code)
        ->count();
        if($data > 0){
            return true;
        }else{
            return false;
        }
    }

    private function createThisAgentGl($agent_id, $account_no){
        $agent_gl                = new AgentGl();
        $agent_gl->company_id    = Auth::user()->company_id;
        $agent_gl->agent_id      = $agent_id;
        $agent_gl->gl_account_no = $account_no;
        $agent_gl->balance       = 0;
        try{
            $agent_gl->save();
            return true;
        }catch(Exception $e){
            file_put_contents("agent_gl_create_error.txt", $e->getMessage());
            return false;
        }
    }



    public function treeView(){
        return view('chart_of_account.account-setup.tree');
    }



    public function edit($id){
        $account_info = DB::table('accounts as a')
        ->select(
            'a.id',
            'a.name',
            'a.acc_level',
            'a.acc_types',
            'a.immediate_parent',
            'a.allow_manual_transaction',
            'a.allow_negative_balance',
            'b.name as parent_name',
            'b.id as parent_id'
        )
        ->leftJoin('accounts as b','a.immediate_parent','b.id')
        ->where('a.id', $id)
        ->first();
        $account_types = DB::table('gl_account_types')->where('company_id', Auth::user()->company_id)->get();
        $data = [
            "account_info"  => $account_info,
            "account_types" => $account_types
        ];
        return view('chart_of_account.account-setup.edit', $data);
    }


    public function update($id, Request $request){
        if($this->checkEditable($id) === false){
            Toastr::warning('This account number child already exists :)','Warning');
            return redirect()->route('account_setup.index');
        }

        if(!empty($request->input('immidiate_parent')) ){
            $immidiate_parent = $request->input('immidiate_parent');
        }else{
            $immidiate_parent = 0;
        }

        if($request->input('allow_manual_transction') === 'yes'){
            $allow_manual_transction = true;
        }elseif($request->input('allow_manual_transction') === 'no'){
            $allow_manual_transction = false;
        }

        if($request->input('allow_negetive_transction') === 'yes'){
            $allow_negetive_transction = true;
        }elseif($request->input('allow_negetive_transction') === 'no'){
            $allow_negetive_transction = false;
        }

        $account = Account::find($id);
        $account->name                     = $request->input('name');
        $account->acc_level                = $request->input('acc_level');
        $account->acc_types                = $request->input('acc_types');
        $account->immediate_parent         = $immidiate_parent;
        $account->allow_manual_transaction = $allow_manual_transction;
        $account->allow_negative_balance   = $allow_negetive_transction;
        $account->updated_by               = Auth::id();
        $account->updated_at               = date('Y-m-d H:i:s');
        $account->status                   = 0;

        try{
            $save_account = $account->save();
            Toastr::success('Account Update Successfully :)','Success');
            return redirect()->route('account_setup.index');
        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Failed');
            return redirect()->route('account_setup.edit', $id);
        }
    }



    private function checkEditable($id){
        $rowCount  = DB::table('accounts')->where('immediate_parent', $id)->count();
        if($rowCount > 0){
            return false;
        }else{
            return true;
        }
    }


    public function deleteAccount($id){
        if($this->checkEditable($id) === false){
            Toastr::warning('This account number child already exists :)','Warning');
            return redirect()->route('account_setup.pending');
        }

        if($this->checkAlreadyDoTransaction($id) === false){
            Toastr::warning('This account has been transacted :)','Warning');
            return redirect()->route('account_setup.pending');
        }


        try{
            $delete = Account::destroy($id);
            Toastr::success('Account  Delete Successfully :)','Success');
            return redirect()->route('account_setup.pending');
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Failed');
            return redirect()->route('account_setup.pending');
        }

    }


    private function checkAlreadyDoTransaction($id){
        $rowCount  = DB::table('transactions')
        ->where('company_id', Auth::user()->company_id)
        ->where('dr_account_id', $id)
        ->orWhere('cr_account_id', $id)
        ->count();
        if($rowCount > 0){
            return false;
        }else{
            return true;
        }
    }










}
