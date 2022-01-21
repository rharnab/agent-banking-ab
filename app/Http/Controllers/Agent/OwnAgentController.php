<?php

namespace App\Http\Controllers\Agent;

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

class OwnAgentController extends Controller
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
        ->where('a.agent_id', Auth::user()->agent_id)
        ->get();
        $data = [
            "agent_users" => $agent_users
        ];
        
        return view('agent-admin.agent.index', $data);
    }

}
