<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use App\User;



class AccountOpeningRequestDeclineController extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Account Opening Request Decline

    public function declineAccountOpeningRequest($id){
      $request_info = DB::table('self_registrations')
        ->select(
            'company_id',
            'requested_user_id',
            'en_name'
        )
        ->where('id' , $id)
        ->where('company_id', Auth::user()->company_id)
        ->first();
        
        $user                    = User::find($request_info->requested_user_id);
        $user->user_id           = strtolower(str_replace(" ",".", $request_info->en_name));
        $user->name              = $request_info->en_name;
        $user->password          = Hash::make('12345678');
        $user->is_active         = 1;
        $user->company_is_active = 1;
        $user->created_user_id   = Auth::user()->id;
        $user_saved              = $user->save();
        if($user_saved){
            if($this->updateSelfRequestDecline($id) === true){
                if($this->sendSelfRequestDeclineMail($request_info->requested_user_id) === true){
                    Toastr::success('Account opening request decline successfully :)','Success');
                    return redirect()->back();
                }else{
                    Toastr::error('Decline confirmation mail does not sent.)','Failed');
                    return redirect()->back();
                }
            }else{
                Toastr::error('Account opening request decline faield..)','Failed');
                return redirect()->back();
            }
        }else{
            Toastr::error('Account opening request decline faield..)','Failed');
            return redirect()->back();
        }

    }



    // Update Self Account Opening Request Decline Status

    private function updateSelfRequestDecline($id){
        $updated = DB::table('self_registrations')->where('id', $id)->update([
            "status" => 3
        ]);
        if($updated === 1 || $updated === 0) {
            if($this->updateAccountOpeningRequestDecline($id) === true){
                return true;
            }else{
                return false;
            }            
        }else{
            return false;
        }
    }

    // Update  Account Opening Request Decline Status

    private function updateAccountOpeningRequestDecline($id){
        $updated = DB::table('account_openings')->where('self_registration_id', $id)->update([
            "status" => 3
        ]);
        if($updated === 1 || $updated === 0) {
            return true;           
        }else{
            return false;
        }
    }

    // Send Mail For Account Opnening Request Decline

    private function sendSelfRequestDeclineMail($user_id){
        $body = "Your account opening request has been declined.please login & resend request again"; 
        $user_info = DB::table('users')->select(
            'email',
            'name'
        )
        ->where('id', $user_id)
        ->first();
        if($this->sendMail("contact@venturenxt.com", "{$user_info->email}", "{$user_info->name}", "E-KYC Account Opening Request", $body) === true){
            return true;
        }else{
            return false;
        }
    }


}
