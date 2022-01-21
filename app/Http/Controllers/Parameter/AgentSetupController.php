<?php

namespace App\Http\Controllers\Parameter;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentGl;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AgentSetupController extends Controller
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
     * Show All Agent List
     *
     */
    public function index(){

        $agent_infos = DB::table('agents as a')
        ->select(
            'a.name',
            'a.user_id',
            'a.email',
            'a.phone',
            'a.address',
            'a.account_no',
            'a.transaction_amount_limit',
            'a.user_limit',
            'a.status',
            'd.name as division_name',
            'ds.name as district_name',
            'br.name as branch_name'
        )
        ->leftJoin('divisions as d', 'a.division_id', 'd.id')
        ->leftJoin('districts as ds', 'a.district_id', 'ds.id')
        ->leftJoin('branches as br', 'a.branch_id', 'br.id')
        ->where('a.company_id', Auth::user()->company_id)
        ->get();
        $data = [
            "agent_infos" => $agent_infos
        ];
        return view('parameter-setup.agent-setup.index', $data);
    }


     /**
     * Create new agent
     *
     */
    public function create(){
        $divisions = DB::table('divisions')->select('id', 'name')->get();
        $districts = DB::table('districts')->select('id', 'name')->get();
        $branches  = DB::table('branches')->select('id', 'name')->where('company_id', Auth::user()->company_id)->get();
        $data      = [
            "divisions" => $divisions,
            "districts" => $districts,
            "branches"  => $branches
        ];
        return view('parameter-setup.agent-setup.create', $data);
    }


    
     /**
     *Agent Store
     *
     */
    public function store(Request $request){
        $agent                                    = new Agent();
        $agent->company_id                        = Auth::user()->company_id;
        $agent->name                              = $request->input('name');
        $agent->phone                             = $request->input('phone');
        $agent->email                             = $request->input('email');
        $agent->user_id                           = $request->input('user_id');
        $agent->short_code                        = $request->input('short_code');
        $agent->address                           = $request->input('address');
        $agent->account_no                        = $request->input('account_no');
        $agent->branch_id                         = $request->input('branch_id');
        $agent->division_id                       = $request->input('division_id');
        $agent->district_id                       = $request->input('district_id');
        $agent->transaction_amount_limit          = $request->input('transaction_amount_limit');
        $agent->agent_user_limit_remaining_blance = $request->input('transaction_amount_limit');
        $agent->user_limit                        = $request->input('user_limit');
        $agent->status                            = 0;
        $agent->created_by                        = Auth::user()->id;
        try{
            $agent->save();
            Toastr::success('Agent Created Successfully','Success');
            return redirect()->route('parameter.agent.index');
        }catch(Exception $e){
            Toastr::error('Agent Created Failed','Error');
            return redirect()->route('parameter.agent.create');
        }
    }


    /** 
     * Pending Authorization Agent
     *
     */
    public function pending(){
        $agent_infos = DB::table('agents as a')
        ->select(
            'a.id',
            'a.name',
            'a.user_id',
            'a.phone',
            'a.email',
            'a.address',
            'a.account_no',
            'a.transaction_amount_limit',
            'a.user_limit',
            'a.status',
            'd.name as division_name',
            'ds.name as district_name',
            'br.name as branch_name'
        )
        ->leftJoin('divisions as d', 'a.division_id', 'd.id')
        ->leftJoin('districts as ds', 'a.district_id', 'ds.id')
        ->leftJoin('branches as br', 'a.branch_id', 'br.id')
        ->where('a.company_id', Auth::user()->company_id)
        ->where('a.status', 0)
        ->where('a.created_by', '<>', Auth::user()->id)
        ->get();
        $data = [
            "agent_infos" => $agent_infos
        ];
        return view('parameter-setup.agent-setup.pending', $data);
    }



    public function authorizeAgent(Request $request, $id){
        try{
            if($this->createAgentLoginUser($id) === true){
                // this function create agent gl
                $this->generateAgentGl($id);
                DB::table('agents')->where('company_id', Auth::user()->company_id)->where('id', $id)->update([
                    "status"             => 1,
                    "approved_by"        => Auth::user()->id,
                    "approved_timestamp" => date('Y-m-d H:i:s')
                ]);
                Toastr::success('Agent Authorize Successfully','Success');
                return redirect()->route('parameter.agent.pending');
            }else{
                Toastr::error('Agent User Failed','Error');
                return redirect()->route('parameter.agent.pending');
            }
            
        }catch(Exception $e){
            Toastr::error('Agent Authorize Failed','Error');
            return redirect()->route('parameter.agent.pending');
        }
    }



    private function createAgentLoginUser($id){
        $user_info = DB::table('agents')
        ->select(
            'id',
            'user_id',
            'name',
            'email',
            'phone',
            'company_id'
        )
        ->where('id', $id)
        ->where('company_id', Auth::user()->company_id)
        ->first();

        $user                    = new User();
        $user->user_id           = $user_info->user_id;
        $user->name              = $user_info->name;
        $user->email             = $user_info->email;
        $user->phone             = $user_info->phone;
        $user->password          = Hash::make('12345678');
        $user->is_active         = 1;
        $user->company_id        = $user_info->company_id;
        $user->company_is_active = 1;
        $user->role_id           = 3;
        $user->created_user_id   = Auth::user()->id;
        $user->agent_id          = $user_info->id;
        try{
            $user->save();
            return true;
        }catch(Exception $e){
            return false;
        }
    }


    private function generateAgentGl($agent_id){
        $gls = DB::table('accounts')
        ->where('company_id', Auth::user()->company_id)
        ->where('is_agent_access', 1)
        ->get();
        foreach($gls as $gl){
            if($this->checkGlAlreadyCreated($agent_id, $gl->acc_code) === false){
                $this->createThisAgentGl($agent_id, $gl->acc_code);
            }
        }
    }


    public function checkGlAlreadyCreated($agent_id, $account_no){
        $data = DB::table('agent_gls')
        ->where('company_id', Auth::user()->company_id)
        ->where('agent_id', $agent_id)
        ->where('gl_account_no', $account_no)
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
        $agent_gl->product_code  = $this->accountNoToProductCode($account_no);
        $agent_gl->balance       = 0;
        try{
            $agent_gl->save();
            return true;
        }catch(Exception $e){
            file_put_contents("agent_gl_create_error.txt", $e->getMessage());
            return false;
        }
    }


    private function accountNoToProductCode($account_no){
        $info = DB::table('accounts as a')
        ->select('p.code')
        ->leftJoin('gl_mappings as gm', 'a.id', 'gm.account_id')
        ->leftJoin('products as p', 'gm.product_id' , 'p.id')
        ->where('a.acc_code', $account_no)
        ->first();
        return $info->code ?? '';
    }


}
