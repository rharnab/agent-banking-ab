<?php

namespace App\Http\Controllers\SuperAdmin;

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

class PasswordResetController extends Controller
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
        $users = DB::table('users')->select('id', 'name')->where('company_id', Auth::user()->company_id)->get();
        $data = [
            "users" => $users
        ];
        
        return view('super-admin.password-change.index', $data);
    }


    
    /**
     * User password reset
     *
     */
    public function reset(Request $request){
        $agent_user_id = $request->input('agent_user_id');
        try{    
            DB::table('users')->where('company_id', Auth::user()->company_id)->where('id', $agent_user_id)->where('agent_id', Auth::user()->agent_id)->update([
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
