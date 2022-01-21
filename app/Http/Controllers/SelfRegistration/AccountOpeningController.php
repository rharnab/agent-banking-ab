<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountOpeningController extends Controller
{
    
    // Account Opening information updated
     
    public function accountOpening(Request $request){
        if($request->has('account_opening_id') && !empty($request->input('account_opening_id')) && $request->input('account_self_request_id') && !empty($request->input('account_self_request_id')) ){
           
            $account_opening_id      = $request->input('account_opening_id');
            $account_self_request_id = $request->input('account_self_request_id');

            $update_account_opening_info = DB::table('account_openings')->where('id', $account_opening_id)->update([
                "branch_id"                 => $request->input('branch_id'),
                "probably_monthly_income"   => $request->input('probably_monthly_income'),
                "probably_monthly_deposite" => $request->input('probably_monthly_deposite'),
                "probably_monthly_withdraw" => $request->input('probably_monthly_withdraw')
            ]);

            if($update_account_opening_info === 0 || $update_account_opening_info === 1){
                if($this->updateSelfRegistrationStep($account_self_request_id) === true){
                    $data = [
                        "error_code"         => 200,
                        "message"            => "success",
                        "account_opening_id" => $account_opening_id,
                        "self_request_id"    => $account_self_request_id
                    ];
                    return json_encode($data);
                }else{
                    $data = [
                        "error_code" => 400,
                        "message"    => "step update failed"
                    ];
                    return json_encode($data);
                } 
            }else{
                $data = [
                    "error_code" => 400,
                    "message"    => "account opening setup failed"
                ];
                return json_encode($data);
            }

        }else{
            $data = [
                "error_code" => 400,
                "message"    => "please fill up all field"
            ];
            return json_encode($data);
        }
    }



    // This function update account opening request successfully step covered
     
    private function updateSelfRegistrationStep($id){
        $update = DB::table('self_registrations')->where('id', $id)->update([
            "step_compleate_status" => 6
        ]);
        if($update === 0 || $update === 1){
            return true;
        }else{
            return false;
        }
    }



}

