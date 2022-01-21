<?php

namespace App\Http\Controllers\Parameter;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AgentUserController extends Controller
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
     * Show All Agent User List
     *
     */
    public function index(){
        $agent_users = DB::table('agent_users as a')
        ->select(
            'a.name',
            'a.short_code',
            'a.user_id',
            'a.email',
            'a.phone',
            'a.address',
            'a.account_no',
            'a.transaction_amount_limit',
            'a.status',
            'd.name as division_name',
            'ds.name as district_name',
            'ag.name as agent_name',
        )
        ->leftJoin('agents as ag', 'a.agent_id', 'ag.id')
        ->leftJoin('divisions as d', 'a.division_id', 'd.id')
        ->leftJoin('districts as ds', 'a.district_id', 'ds.id')
        ->where('a.company_id', Auth::user()->company_id)
        ->get();
        $data = [
            "agent_users" => $agent_users
        ];
        
        return view('parameter-setup.agent-user-setup.index', $data);
    }


     /**
     * Create new agent user
     *
     */
    public function create(){
        $agents = DB::table('agents')->select('id', 'name')->where('company_id', Auth::user()->company_id)->where('status', 1)->get();
        $divisions = DB::table('divisions')->select('id', 'name')->get();
        $districts = DB::table('districts')->select('id', 'name')->get();
        $data = [
            "agents"    => $agents,
            "divisions" => $divisions,
            "districts" => $districts
        ];
        return view('parameter-setup.agent-user-setup.create', $data);
    }


    /**
     *Agent Store
     *
     */
    public function store(Request $request){
        $agent_user                           = new AgentUser();
        $agent_user->company_id               = Auth::user()->company_id;
        $agent_user->agent_id                 = $request->input('agent_id');
        $agent_user->name                     = $request->input('name');
        $agent_user->user_id                  = $request->input('user_id');
        $agent_user->short_code               = $request->input('short_code');
        $agent_user->address                  = $request->input('address');
        $agent_user->account_no               = $request->input('account_no');
        $agent_user->division_id              = $request->input('division_id');
        $agent_user->district_id              = $request->input('district_id');
        $agent_user->transaction_amount_limit = $request->input('transaction_amount_limit');
        $agent_user->email                    = $request->input('email');
        $agent_user->phone                    = $request->input('phone');
        $agent_user->password                 = Hash::make('12345678');
        $agent_user->status                   = 0;
        $agent_user->created_by               = Auth::user()->id;
        try{
            $agent_user->save();
            Toastr::success('Agent User Created Successfully','Success');
            return redirect()->route('parameter.agent.user.index');
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Failed');
            return redirect()->route('parameter.agent.user.create');
        }
    }


        /** 
     * Pending Authorization Agent
     *
     */
    public function pending(){
        $agent_users = DB::table('agent_users as a')
        ->select(
            'a.id',
            'a.user_id',
            'a.name',
            'a.email',
            'a.phone',
            'a.address',
            'a.account_no',
            'a.transaction_amount_limit',
            'a.status',
            'd.name as division_name',
            'ds.name as district_name',
            'ag.name as agent_name',
        )
        ->leftJoin('agents as ag', 'a.agent_id', 'ag.id')
        ->leftJoin('divisions as d', 'a.division_id', 'd.id')
        ->leftJoin('districts as ds', 'a.district_id', 'ds.id')
        ->where('a.company_id', Auth::user()->company_id)
        ->where('a.company_id', Auth::user()->company_id)
        ->where('a.status', 0)
        ->where('a.created_by', '<>', Auth::user()->id)
        ->get();
        $data = [
            "agent_users" => $agent_users
        ];
        return view('parameter-setup.agent-user-setup.pending', $data);
    }


    public function authorizeAgentUser(Request $request, $id){
        try{
            if($this->createUser($id) === true){
                DB::table('agent_users')->where('company_id', Auth::user()->company_id)->where('id', $id)->update([
                    "status"             => 1,
                    "approved_by"        => Auth::user()->id,
                    "approved_timestamp" => date('Y-m-d H:i:s')
                ]);
                Toastr::success('Agent User Authorize Successfully','Success');
                return redirect()->route('parameter.agent.user.pending');
            }else{
                Toastr::error('User Login ID Creation failed','Error');
                return redirect()->route('parameter.agent.user.pending');
            }
            
        }catch(Exception $e){
            Toastr::error('Agent User Authorize Failed','Error');
            return redirect()->route('parameter.agent.user.pending');
        }
    }


    private function createUser($id){
        $user_info = DB::table('agent_users')
                    ->select(
                        'name',
                        'email',
                        'phone',
                        'user_id',
                        'password',
                        'agent_id',
                        'company_id',
                        'short_code'
                    )
                    ->where('company_id', Auth::user()->company_id)
                    ->where('id', $id)
                    ->first();

        $user                    = new User();
        $user->user_id           = $user_info->user_id;
        $user->name              = $user_info->name;
        $user->email             = $user_info->email;
        $user->phone             = $user_info->phone;
        $user->password          = $user_info->password;
        $user->is_active         = 1;
        $user->company_id        = $user_info->company_id;
        $user->company_is_active = 1;
        $user->role_id           = 4;
        $user->created_user_id   = Auth::user()->id;
        $user->agent_id          = $user_info->agent_id;
        $user->agent_user_id     = $id;
        try{
            $user->save();
            return true;
        }catch(Exception $e){
            file_put_contents("hasan.txt", $e->getMessage());
            return false;
        }
    }






}
