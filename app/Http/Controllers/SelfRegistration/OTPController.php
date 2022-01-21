<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Branch;
use App\User;

class OTPController extends Controller
{

    public function index($user_id){
        $data = [
            "user_id" => $user_id
        ];
        return view('self-registration.verification.otp', $data);
    }
    // OTP Varification 
  
    public function otpVerification(Request $request){
        if( $request->has('user_id') && !empty($request->input('user_id')) && $request->has('otp') && !empty($request->input('otp')) ){
            $user_id = $request->input('user_id');
            $otp   = $request->input('otp');

            $user = User::find($user_id);
            
            if($user->otp == $otp){
                $allBranch = Branch::where('company_id' , $user->company_id)->get();

                $data = [
                    "allBranch"  => $allBranch,
                    "user_id"    => $user->id,
                    "company_id" => $user->company_id,
                    "phone"      => $user->phone
                ];
                return view('self-registration.verification.index', $data);             
            }else{
                $data = [
                    "error"   => true,
                    "message" => "Invalid OTP",
                    "user_id" => $user->id
                ];
                return view('self-registration.verification.otp', $data);               

            }
        }
    }


    
    // This function doing resend OTP
 
    public function resendOTP(Request $request){
        if($request->has('user_id')){
            $user_id    = $request->input('user_id');
            $user       = DB::table('users')->select('email', 'phone', 'company_id')->where('id', $user_id)->first();
            $otp        = mt_rand(1000,9999);
            $phone      = $user->phone;
            $email      = $user->email;
            $company_id = $user->company_id;

            if($this->sendOTP($otp, $phone, $company_id, $user_id) == true){
                $opt_update = DB::table('users')->where('id', $user_id)->update(['otp' => $otp]);
                $data = [
                    "error"   => false,
                    "message" => "OTP Send Sucessfully"
                ];
                return json_encode($data);
            }else{
                $data = [
                    "error"   => true,
                    "message" => "OTP Send Failed"
                ];
                return json_encode($data);
            }
        }
    }


    
    /**
     * Send OTP with Mail
     *
     */  
    private function sendOTP($otp, $phone, $company_id, $user_id){
        $message = "Do not share your OTP with anyone. Your OTP resemt is $otp";
        if($this->sendSMS($otp, $phone, $company_id, $user_id, $message) === true){
            return true;
        }else{
            return false;
        }
    }





}
