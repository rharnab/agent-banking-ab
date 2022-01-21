<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AccountOpeningController extends Controller
{
     /**
    * Account Opening Requst Form
    * 
    * @authenticated
    * 
    * @bodyParam  customer_id integer required customer_id for slef varification into the E-KYC Example                   : 1
    * @bodyParam  branch_code integer required  branch_code for which branch customer send account opening request Example: 1
    * @bodyParam  account_type integer required  account_type for which type account you want to create Example: 1
    * @bodyParam  monthly_income numeric required  monthly_income for customer  account opening request Example           : 10000
    * @bodyParam  monthly_deposit numeric required  monthly_deposit for customer  account opening request Example         : 10000
    * @bodyParam  monthly_withdraw numeric required  monthly_withdraw for customer  account opening request Example       : 10000
    * @bodyParam  nominee_name string required  nominee_name for customer  account opening request Example                : Rabiul Hasan
    * @bodyParam  nominee_nid_number string required  nominee_nid_number for customer  account opening request Example    : 123 456 7890
    * @bodyParam  nominee_address string required  nominee_address for customer  account opening request Example          : Dhaka, Bangladesh
    * @response 200 {
        "status" : 200,
        "success": true,
        "message": "account opening request successfully"
    }

    * @response 400 {
        "status" : 400,
        "success": false,
        "message": "please give branch code"
    }
 * @response 400 {
    "status" : 400,
    "success": false,
    "message": "already account opening request",
    "data"   : {
        "message": "your account opening request has been pending.Bank authority will contact as soon as possible"
    }
}
    */
    public function accountOpen(Request $request){
        $company_id = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'customer_id'        => ['required','integer'],
            'branch_code'        => ['required','integer'],
            'account_type'        => ['required','integer'],
            'monthly_income'     => ['required', 'numeric'],
            'monthly_deposit'    => ['required', 'numeric'],
            'monthly_withdraw'   => ['required', 'numeric'],
            'nominee_name'       => ['required'],
            'nominee_nid_number' => ['required'],
            'nominee_address'    => ['required'],
        ],[
            'customer_id.required'   => 'customer_id must be needed',
            'customer_id.integer'    => 'customer_id field must be integer',
            'branch_code.required'   => 'please give branch code',
        ]);

        if ($validator->fails()) {
            $validation_error = [
                "status"   => 400,
                "success" => false,
                "message"  => $validator->messages()->first()
            ];
            return response()->json($validation_error);
        }

        $customer_id        = $request->input('customer_id');
        $branch_code        = $request->input('branch_code');
        $account_type       = $request->input('account_type');
        $monthly_income     = $request->input('monthly_income');
        $monthly_deposit    = $request->input('monthly_deposit');
        $monthly_withdraw   = $request->input('monthly_withdraw');
        $nominee_name       = $request->input('nominee_name');
        $nominee_nid_number = $request->input('nominee_nid_number');
        $nominee_address    = $request->input('nominee_address');

        if($this->checkValidCustomer($customer_id) === true){ // valid user

            // check account opening requst status
            $account_opening_status_check = $this->userSelfRequestStatus($company_id, $customer_id);
            if($account_opening_status_check === false){
                if($this->validBranchCode($company_id, $branch_code) === true){ // valid branch code

                    if($this->validAccountType($company_id, $account_type) === true){
                        
                        $self_info            = DB::table('self_registrations as sr')
                        ->select('sr.id as self_id', 'ao.id as account_opening_id')
                        ->leftJoin('account_openings  as ao', 'sr.id' , '=', 'ao.self_registration_id')                  
                        ->where('sr.company_id', $company_id)->where('sr.requested_user_id', $customer_id)->where('sr.status', 0)->first();
                        $self_id            = $self_info->self_id;
                        $account_opening_id = $self_info->account_opening_id;
                        try{
                            DB::table('account_openings')->where('id', $account_opening_id)->update([
                                "branch_id"                 => $branch_code,
                                "account_type_code"         => $account_type,
                                "probably_monthly_income"   => $monthly_income,
                                "probably_monthly_deposite" => $monthly_deposit,
                                "probably_monthly_withdraw" => $monthly_withdraw,
                                "nominee_name"              => $nominee_name,
                                "nominee_nid_number"        => $nominee_nid_number,
                                "nominee_address"           => $nominee_address,
                                "status"                    => 1,
                                "request_timestamp"         => date('Y-m-d H:i:s')
                            ]);
                            
                            try{
                                DB::table('self_registrations')->where('id', $self_id)->update([
                                    "step_compleate_status" => 8,
                                    "status"                => 1
                                ]);
    
                                $data =  [
                                    "status"  => 200,
                                    "success" => true,
                                    "message" => "account opening request successfully"
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
    
                        }catch(Exception $e){
                            $data =  [
                                "status"  => 500,
                                "success" => false,
                                "message" => $e->getMessage()
                            ];
                            return response()->json($data);
                        }
                    }else{
                        $customer_not_found = [
                            "status"  => 404,
                            "success" => false,
                            "message" => "account type not found"
                        ];
                        return response()->json($customer_not_found);
                    }
    
    
                }else{
                    $customer_not_found = [
                        "status"  => 404,
                        "success" => false,
                        "message" => "branch not found"
                    ];
                    return response()->json($customer_not_found);
                }
            }else{
                return $account_opening_status_check;
            }

            

        }else{
            $customer_not_found = [
                "status"  => 404,
                "success" => false,
                "message" => "customer not found"
            ];
            return response()->json($customer_not_found);
        }


    }

    private function checkValidCustomer($user_id){
        $user_count = DB::table('users')->select('id')->where('id', $user_id)->count();
        if($user_count > 0){
            return true;
        }else{
            return false;
        }
    }

    private function validBranchCode($company_id, $branch_code){
        $branch_count = DB::table('branches')->select('id')->where('company_id', $company_id)->where('id', $branch_code)->count();
        if($branch_count > 0){
            return true;
        }else{
            return false;
        }
    }

    private function validAccountType($company_id, $account_type){
        $account_type_count = DB::table('account_types')->select('id')->where('company_id', $company_id)->where('id', $account_type)->count();
        if($account_type_count > 0){
            return true;
        }else{
            return false;
        }
    }



}
