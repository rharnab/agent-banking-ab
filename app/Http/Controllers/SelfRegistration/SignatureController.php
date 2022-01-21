<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use App\Models\AccountOpening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SignatureController extends Controller
{
    /**
     * Account Opening Request Self Signature Upload
     *
    */
    public function singnatureUpload(Request $request){
        
        if($request->has('signature_self_request_id') && !empty($request->input('signature_self_request_id')) && $request->has('signature_self_request_id') ){
          
            $signature_self_request_id = $request->input('signature_self_request_id');

            $self_info = DB::table('self_registrations')
            ->select('company_id', 'en_name', 'bn_name', 'blood_group', 'date_of_birth', 'father_name', 'mother_name', 'present_address')
            ->where('id', $signature_self_request_id)
            ->first();

            $today           = date('Y-m-d');
            $folderPath      = "images/signature/{$today}/";
            $signature_image = "signature_image" .uniqid()  .".". $request->signature_image->extension();
            $request->signature_image->move($folderPath, $signature_image);

            $signature_image_path = "images/signature/{$today}/" . $signature_image;

            $checkAccountOpening = AccountOpening::where('self_registration_id', $signature_self_request_id)->get();

            if($checkAccountOpening->count() > 0){ // if already requested
                $account_opening                       = AccountOpening::where('self_registration_id',$signature_self_request_id)->first();
                $account_opening->self_registration_id = $signature_self_request_id;
                $account_opening->company_id           = $self_info->company_id;
                $account_opening->signature_image      = $signature_image_path;
                $account_opening->status               = 0;
            }else{
                $account_opening                       = new AccountOpening();
                $account_opening->self_registration_id = $signature_self_request_id;
                $account_opening->company_id           = $self_info->company_id;
                $account_opening->signature_image      = $signature_image_path;
                $account_opening->status               = 0;
            }

            $saved_account_opening            = $account_opening->save();
            if($saved_account_opening){
                if($this->updateSelfRegistrationStep($signature_self_request_id) === true){
                    $data = [
                        "error_code"         => 200,
                        "message"            => "success",
                        "self_request_id"    => $signature_self_request_id,
                        "account_opening_id" => $account_opening->id,
                        "en_name"            => $self_info->en_name,
                        "bn_name"            => $self_info->bn_name,
                        "blood_group"        => $self_info->blood_group,
                        "date_of_birth"      => $self_info->date_of_birth,
                        "father_name"        => $self_info->father_name,
                        "mother_name"        => $self_info->mother_name,
                        "present_address"    => $self_info->present_address
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
                    "message"    => "singatue failed.try again"
                ];
                return json_encode($data);
            }

        }else{
            $data = [
                "error_code" => 400,
                "message"    => "please take signature image"
            ];
            return json_encode($data);
        }
    }



    /**
     * This function update account opening request successfully step covered
     *
    */
    private function updateSelfRegistrationStep($id){
        $update = DB::table('self_registrations')->where('id', $id)->update([
            "step_compleate_status" => 4
        ]);
        if($update === 0 || $update === 1){
            return true;
        }else{
            return false;
        }
    }


}
