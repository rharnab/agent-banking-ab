<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;

class CustomerRegistationController extends Controller
{
    // Redirect to the customer registation page
    
    public function showRegistationPage($bank_slug){
        $company_id = $this->findBankId($bank_slug);
        if($company_id !== false){
           $data = [
               "company_id" => $company_id
           ];
           return view("self-registration.registation.showregistationform", $data);
        }else{
            return "invalid url";
        }
        
    }




     // Get Company id
    
    public function findBankId($bank_slug){
        $bank_slug = str_replace(" ", "", $bank_slug);
        $company = DB::table('companies')->select('id')->where('slug', $bank_slug)->first();
        if(isset($company->id) && !empty($company->id) ){
            return $company->id;
        }
        return false;
    }


    
    // Register Customer
     
    public function register(Request $request){
        $company_id = $request->input('company_id');
        if($request->has('email') && !empty($request->input('email')) ){
            $email = $request->input('email'); 
            $phone = $request->input('phone');
            // check this user already requested with mobile no and email or not
            $checkUser = User::where('phone', $phone)->where('email', $email)->where('is_active', 0)->first();
        }else{
            $phone = $request->input('phone');
            // check this user already requested with only mobile no or not
            $checkUser = User::where('phone', $phone)->where('is_active', 0)->first();
        }


        if($checkUser != null){ // if user found
            $status =  $this->checkAlreadyRequested($checkUser->id, $checkUser->company_id);
            $statusArray = json_decode($status, true);
            if($status !== false && $statusArray['self_status'] != 1){
                if($statusArray['account_opening_status'] == 1){
                    Toastr::error('Your account opening request already pening.','Already Requested');
                    return redirect()->back();
                }elseif($statusArray['account_opening_status'] === 2){
                    Toastr::error('Your account opening request already approved.please login','Already Requested');
                    return redirect()->back();
                }elseif($statusArray['account_opening_status'] === 3){
                    Toastr::error('Your account opening request already decline.please login & resent request','Already Requested');
                    return redirect()->back();
                }
            }else{
               $otp = mt_rand(1000,9999);
                if($this->sendOTP($otp, $phone, $company_id, $checkUser->id) === true){
                    $opt_update = DB::table('users')->where('id', $checkUser->id)->update(['otp' => $otp]);
                    $user_id    = $checkUser->id;
                    return redirect()->route('self.registation.index', $user_id);
                }else{
                    Toastr::error('OTP Send Failed','Failed');
                    return redirect()->back();
                }
            }
        }else{ // if this in new customer 
            $validator = Validator::make($request->all(), [ 
                'phone'     => 'required|unique:users'
            ],[
                'phone.required'     => 'please enter user mobile number',
                'phone.unique'       => 'mobile number already exists',
                'email.unique'       => 'this email already use',
            ]);
    
            // if validation failed
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // if pass validation 
             $user             = new User();
             $user->user_id    = '';
             $user->company_id = $company_id;
             $user->role_id    = $this->getCustomerRole();
             $user->name       = '';
             $user->email      = $email;
             $user->phone      = $phone;
             $user->password   = '';
             $user->branch_id  = 0;
             $user_registation = $user->save();
             if($user_registation){
                $user_id = $user->id;
                $otp = mt_rand(1000,9999);
                if($this->sendOTP($otp, $phone, $company_id, $user_id) === true){
                    $opt_update = DB::table('users')->where('id', $user_id)->update(['otp' => $otp]);
                    return redirect()->route('self.registation.index', $user_id);
                }else{
                    Toastr::error('OTP Send Failed','Failed');
                    return redirect()->back();
                }                
            }else{
                Toastr::error('Registration Failed','Failed');
                return redirect()->back();
            }
        }        

    }


     //  Get Customer Role

    public function getCustomerRole(){
        return 4;
    }



    public function checkAlreadyRequested($user_id, $company_id){       

        $request_data_count = DB::table('self_registrations as sr')
                            ->leftJoin('account_openings  as ao', 'sr.id' , '=', 'ao.self_registration_id')
                            ->where('sr.company_id', $company_id)
                            ->where('sr.requested_user_id', $user_id)
                            ->count();

        
        if($request_data_count > 0){
            $request_data = DB::table('self_registrations as sr')
            ->select('sr.status as self_status', 'ao.status as account_opening_status')
            ->leftJoin('account_openings  as ao', 'sr.id' , '=', 'ao.self_registration_id')
            ->where('sr.company_id', $company_id)
            ->where('sr.requested_user_id', $user_id)
            ->first();
            return json_encode($request_data);
        }else{
            return false;
        }

    }

    // send otp into the mail 
    private function sendOTP($otp, $phone, $company_id, $user_id){
        $message = "Do not share your OTP with anyone. Your OTP is $otp";
        if($this->sendSMS($otp, $phone, $company_id, $user_id, $message) === true){
            return true;
        }else{
            return false;
        }
    }   






}

