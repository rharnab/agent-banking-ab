<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PercentageSetup;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class PasswordChangeController extends Controller
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
     * Redirect to password change page
     *
     */
    public function index(){
        return view("password-change.index");        
    }


    public function updatePassword(Request $request){
       $old_password     = $request->input('old_password');
       $new_password     = $request->input('new_password');
       $confirm_password = $request->input('confirm_password');
        
       if(Hash::check($old_password, auth()->user()->password)){
            if($new_password === $confirm_password){
                if(User::find(auth()->user()->id)->update(['password'=> Hash::make($new_password)])){
                    Toastr::success('Password update successfully','Success');
                    return redirect()->route('password-change.index');
                }else{
                    Toastr::error('Password update failed.','Failed');
                    return redirect()->route('password-change.index');
                }
            }else{
                Toastr::error('Please enter the same password.','Failed');
                return redirect()->route('password-change.index');
            }
       }else{
            Toastr::error('Incorrect old passowrd','Failed');
            return redirect()->route('password-change.index');
       }
    }

}
