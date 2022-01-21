<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewdataController extends Controller
{

    /**
     * Modify OCR Data 
     *
    */
    public function modifyOcrData(Request $request){
       if( $request->has('review_account_opening_self_request_id') && !empty($request->input('review_account_opening_self_request_id'))  && $request->has('review_account_opeing_id') && !empty($request->input('review_account_opeing_id')) ){
           $review_account_opening_self_request_id = $request->input('review_account_opening_self_request_id');
           $review_account_opeing_id               = $request->input('review_account_opeing_id');

           $update_self_info = DB::table('self_registrations')->where('id', $review_account_opening_self_request_id)->update([
                "bn_name"           => $request->input('review_bangla_name'),
                "en_name"           => $request->input('review_english_name'),
                "blood_group"       => $request->input('review_blood_group'),
                "date_of_birth"     => $request->input('review_date_of_birth'),
                "father_name"       => $request->input('review_father_name'),
                "mother_name"       => $request->input('review_mother_name'),
                "present_address"   => $request->input('review_address'),
                "permanent_address" => $request->input('review_address'),
           ]);
            
           if($update_self_info === 1 || $update_self_info === 0){
                if($this->updateSelfRegistrationStep($review_account_opening_self_request_id) === true){
                    $data = [
                        "error_code"         => 200,
                        "message"            => "success",
                        "account_opening_id" => $review_account_opeing_id,
                        "self_request_id"    => $review_account_opening_self_request_id
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
                    "message"    => "review failed"
                ];
                return json_encode($data);
           }
       }else{
            $data = [
                "error_code" => 400,
                "message"    => "please fill up all field for imporveing maching score"
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
            "step_compleate_status" => 5
        ]);
        if($update === 0 || $update === 1){
            return true;
        }else{
            return false;
        }
    }

    


}
