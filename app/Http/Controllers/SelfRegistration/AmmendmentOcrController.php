<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AmmendmentOcrController extends Controller
{
    // Ammendment OCR data 
     
    public function ammendmentOcrData(Request $request){
        if($request->has('self_request_id') && !empty($request->input('self_request_id')) && $request->has('english_name') && !empty($request->input('english_name')) && $request->has('date_of_birth') && !empty($request->input('date_of_birth')) && $request->has('nid_number') && !empty($request->input('nid_number')) ) {
            $self_request_id = $request->input('self_request_id');
            $english_name    = $request->input('english_name');
            $nid_number      = $request->input('nid_number');
            $date_of_birth   = $request->input('date_of_birth');

            if($this->checkCompanyVerifiedCustomerList($self_request_id) === true){
                $data = [
                    "message"    => "This nid number account already exits",
                    "error_code" => 400
                ];
                return json_encode($data);
            }else{            
                $update_info = DB::table('self_registrations')->where('id', $self_request_id)->update([
                    "en_name"               => $english_name,
                    "nid_number"            => $nid_number,
                    "date_of_birth"         => $date_of_birth,
                    "step_compleate_status" => 2
                ]);

                if($update_info === 0 || $update_info === 1){
                    $data = [
                        "error_code"      => 200,
                        "message"         => "Ammendment Successfully",
                        "self_request_id" => $self_request_id
                    ];
                    return json_encode($data);
                }else{
                    $data = [
                        "message"    => "Ammendment Failed",
                        "error_code" => 400
                    ];
                    return json_encode($data);
                }
            }

        }else{
            $data = [
                "message"    => "Please fill up all field",
                "error_code" => 400
            ];
            return json_encode($data);
        }
    }


    // This function check this customer already added into out verified customer list
    
    private function checkCompanyVerifiedCustomerList($self_request_id){
        $self_info             = DB::table('self_registrations')->select('company_id','nid_number')->where('id', $self_request_id)->first();
        $verifiedCustomerCount = DB::table('verified_customers')->where('nid_number', $self_info->nid_number)->where('company_id', $self_info->company_id)->count();

        if($verifiedCustomerCount > 0){
            return true;
        }else{
            return false;
        }

    }




}
