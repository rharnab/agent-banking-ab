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

class UserPasswordChangeController extends Controller
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

        if(Auth::user()->role_id == 3){
            $agent_users = DB::table('agent_users as a')
            ->select(
                'a.name',
                'a.user_id'
            )
            ->where('a.company_id', Auth::user()->company_id)
            ->where('a.agent_id', Auth::user()->agent_id)
            ->get();
        }else{
            $agent_users = DB::table('agent_users as a')
            ->select(
                'a.name',
                'a.user_id'
            )
            ->where('a.company_id', Auth::user()->company_id)
            ->get(); 
        }

        
        $data = [
            "agent_users" => $agent_users
        ];
        
        return view('agent-admin.agent-user.password-reset.index', $data);
    }


    
    /**
     * User password reset
     *
     */
    public function reset(Request $request){
        $agent_user_id = $request->input('agent_user_id');
        try{    
            DB::table('users')
            ->where('company_id', Auth::user()->company_id)
            ->where('user_id', $agent_user_id)
            ->update([
                "password" => Hash::make('12345678')
            ]);
            Toastr::success('User Password Reseted Successfully','Success');
            return redirect()->back();
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Error');
            return redirect()->back();
        }
    }



}
