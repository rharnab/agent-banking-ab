<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NomineeSetupController extends Controller
{
    // Nominee Setup For Self Request

    public function nomineeSetupController(Request $request){
        
        if($request->has('nominee_account_opening_id') && !empty($request->input('nominee_account_opening_id')) && $request->has('nominee_self_request_id') && !empty($request->input('nominee_self_request_id')) ){
            $nominee_account_opening_id = $request->input('nominee_account_opening_id');
            $nominee_self_request_id    = $request->input('nominee_self_request_id');

            $update_account_opening = DB::table('account_openings')->where('id', $nominee_account_opening_id)->update([
                "nominee_name"       => $request->input('nominee_name'),
                "nominee_nid_number" => $request->input('nominee_nid_number'),
                "nominee_address"    => $request->input('nominee_address'),
                "status" => 1,
                "request_timestamp" => date('Y-m-d H:i:s')
            ]);

            $self_info = DB::table('account_openings')->select('self_registration_id')->where('id', $nominee_account_opening_id)->first();

            if($update_account_opening === 0 || $update_account_opening === 1){
                if($this->updateSelfRegistrationStep($self_info->self_registration_id) === true){
                    $data = [
                        "message"    => "nominee added success",
                        "error_code" => 200
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
                    "message"    => "nominee added failed",
                    "error_code" => 400
                ];
                return json_encode($data);
            }

        }else{
            $data = [
                "message"    => "please fill up all field",
                "error_code" => 400
            ];
            return json_encode($data);
        }

    }


    // This function update account opening request successfully step covered
 
    private function updateSelfRegistrationStep($id){
        $update = DB::table('self_registrations')->where('id', $id)->update([
            "step_compleate_status" => 7,
            "status"                => 1
        ]);
        if($update === 0 || $update === 1){
            return true;
        }else{
            return false;
        }
    }




}
