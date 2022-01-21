<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
/**
* Customer Registration
* 
* @authenticated
* 
* @bodyParam  phone numeric required phone number must be numberic,unique Example: 01712345678
* @bodyParam  email string optional  phone number must be numberic,unique Example: example@ekyc.com
* @response 200 {
    "status" : 200,
    "success": true,
    "message": "registation success",
    "data"   : {
        "customer_id": 107
    }
}
* @response 400 {
    "status" : 400,
    "success": false,
    "message": "please give your mobile_number"
}
*/
    public function registration(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => ['required','numeric','regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
        ],[
            'phone.required' => 'please give your mobile_number',
            'phone.numeric'  => 'phone number must be numeric',
            'phone.regex'    => 'invalid mobile number'
        ]);
         
        if ($validator->fails()) {
            $validation_error = [
                "status"  => 400,
                "success" => false,
                "message" => $validator->messages()->first()
            ];
            return response()->json($validation_error);
        }

        $phone = $request->input('phone');
        $email = $request->input('email');

        $company_id =  $request->user()->id;

        if($this->checkUserNotFound($company_id, $phone, $email) === true){ // if this user not found
            $user             = new User();
            $user->phone      = $phone;
            $user->email      = $email;
            $user->company_id = $company_id;
            $user->role_id    = 4;
            $user->name       = '';
            $user->password   = '';
            $user->branch_id  = 0;
            try{
                $user->save();
                $data = [
                    "status"  => 200,
                    "success" => true,
                    "message" => "registation success",
                    "data"    => [
                        "customer_id" => $user->id
                    ]
                ];
                return response()->json($data);
            }catch(Exception $e){
                $data =  [
                    "status"  => 500,
                    "success" => false,
                    "message" => $e->getMessage()
                ];
                return response()->json($data);
            }
        }else{ // user found
            $user_info = DB::table('users')->where('company_id', $company_id)->where('phone', $phone)->first();
            $user_id   = $user_info->id;

            // check self registration table data
            if($this->alreadyAccountOpeningDataFound($company_id, $user_id) === true){ 

                // check account opening requst status
                $account_opening_status_check = $this->userSelfRequestStatus($company_id, $user_id);
                
                if($account_opening_status_check === false){
                    $data = [
                        "status"  => 200,
                        "success" => true,
                        "message" => "registation success",
                        "data"    => [
                            "customer_id" => $user_id
                        ]
                    ];
                    return response()->json($data);
                }else{
                    return $account_opening_status_check;
                }
            }else{
                $data = [
                    "status"  => 200,
                    "success" => true,
                    "message" => "registation success",
                    "data"    => [
                        "customer_id" => $user_id
                    ]
                ];
                return response()->json($data);
            }
            
        }
            
        



    }



    private function checkUserNotFound($company_id, $phone){
        $user_count = DB::table('users')->select('id')->where('company_id', $company_id)->where('phone', $phone)->count();
        if($user_count > 0){
            return false;
        }else{
            return true;
        }
    }


    private function alreadyAccountOpeningDataFound($company_id, $user_id){
        $user_count = DB::table('self_registrations')
        ->select('status')
        ->where('company_id', $company_id)
        ->where('requested_user_id', $user_id)
        ->count();
        if($user_count > 0){
            return true;
        }else{
            return false;
        }
    }


    


















}
