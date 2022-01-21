<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentUser;
use App\Models\AgentUserLimitModifyLog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LimitModifyController extends Controller
{
    /**
     * Check Authencticate user
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

     /**
     * Show All Agent User List with Balance
     *
     */
    public function index(){
        $agent_users = DB::table('agent_users as a')
        ->select(
            'a.id',
            'a.name',
            'a.user_id',
            'a.account_no',
            'a.transaction_amount_limit',
            'a.status',
            'd.name as division_name',
            'ds.name as district_name',
        )
        ->leftJoin('agents as ag', 'a.agent_id', 'ag.id')
        ->leftJoin('divisions as d', 'a.division_id', 'd.id')
        ->leftJoin('districts as ds', 'a.district_id', 'ds.id')
        ->where('a.company_id', Auth::user()->company_id)
        ->where('a.agent_id', Auth::user()->agent_id)
        ->get();
        $data = [
            "agent_users" => $agent_users
        ];  
              
        return view('agent-admin.limit-modify.index', $data);
    }


    /**
     * Redirect To Edit page
     *
     */
    public function edit($id){
       $info = DB::table('agent_users')->select('name','transaction_amount_limit', 'id')
       ->where('company_id', Auth::user()->company_id)
       ->where('id', $id)->first();
       $data = [
           "info" => $info
       ];
       return view('agent-admin.limit-modify.edit', $data);
    }


    /**
     * Redirect To Edit page
     *
     */
    public function update(Request $request, $id){
        $new_limit = $request->input('new_limit');

        if($this->modifyLogCreate($new_limit, $id) === true){
            try{
                DB::table('agent_users')->where('company_id', Auth::user()->company_id)->where('id', $id)->update([
                    "transaction_amount_limit" => $new_limit
                ]);
                Toastr::success('Limit Modify Successfully','Success');
                return redirect()->route('agent.limit_modify.index');
            }catch(Exception $e){
                Toastr::error($e->getMessage(),'Error');
                return redirect()->back();
            }
        }
     }


     private function modifyLogCreate($new_limit, $id){
        $info = DB::table('agent_users')->select('agent_id' ,'name','transaction_amount_limit', 'id')
        ->where('company_id', Auth::user()->company_id)
        ->where('id', $id)->first();
        $data = [
            "info" => $info
        ];

        $agent_modify_log = new AgentUserLimitModifyLog();
        $agent_modify_log->company_id  = Auth::user()->company_id;
        $agent_modify_log->agent_id  = $info->agent_id;
        $agent_modify_log->agent_user_id  = $id;
        $agent_modify_log->old_limit  = $info->transaction_amount_limit;
        $agent_modify_log->new_limit  = $new_limit;
        $agent_modify_log->status  = 1;
        $agent_modify_log->created_by  = Auth::user()->id;

        try{
            $agent_modify_log->save();
            return true;
        }catch(Exception $e){
            file_put_contents("agent_modify_log.txt",  $e->getMessage());
            return false;
        }
     }
     


}
