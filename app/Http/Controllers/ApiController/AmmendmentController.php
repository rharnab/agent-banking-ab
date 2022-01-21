<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AmmendmentController extends Controller
{
    /**
    * OCR Ammendment
    * 
    * @authenticated
    * 
    * @bodyParam  customer_id integer required customer_id for slef varification into the E-KYC Example: 1
    * @bodyParam  english_name text required  English Name Ammendment If OCR Read Wrong Data Example: Md.Rabiul Hasan
    * @bodyParam  nid_back_image text required  NID Number Ammendment If OCR Read Wrong Data Example: 123 456 7890
    * @bodyParam  date_of_birth text required Date Of Birth ammendment If OCR Read Wrong Data Example: 1997-04-13
    * @response 200 {
        "status" : 200,
        "success": true,
        "message": "ocr-ammendment successfully",
        "data"   : {
            "customer_id": "108"
        }
    }
    * @response 400{
        "status" : 400,
        "success": false,
        "message": "nid number already exists"
    }
    * @response 400 {
        "status" : 400,
        "success": false,
        "message": "please give english name"
    }
    *
    */
    public function ammendmentOcr(Request $request){
        $company_id = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'customer_id'   => ['required','integer'],
            'english_name'  => ['required'],
            'nid_number'    => ['required'],
            'date_of_birth' => ['required','date'],
        ],[
            'customer_id.required'   => 'customer_id must be needed',
            'customer_id.integer'    => 'customer_id field must be integer',
            'english_name.required'  => 'please give english name',
            'nid_number.required'    => 'please give nid number',
            'date_of_birth.required' => 'please give your date of birth',
            'date_of_birth.date'     => 'invalid date',
        ]);

        if ($validator->fails()) {
            $validation_error = [
                "status"  => 400,
                "success" => false,
                "message" => $validator->messages()->first()
            ];
            return response()->json($validation_error);
        }

        $customer_id   = $request->input('customer_id');
        $english_name  = $request->input('english_name');
        $nid_number    = $request->input('nid_number');
        $date_of_birth = $request->input('date_of_birth');

        if($this->checkValidCustomer($customer_id) === true){

            // check account opening requst status
            $account_opening_status_check = $this->userSelfRequestStatus($company_id, $customer_id);
            if($account_opening_status_check === false){
                $self_id = $this->selfRequestId($customer_id);
                try{
                    if($this->nidNumberExist($nid_number, $company_id) === false){
                        DB::table('self_registrations')->where('id', $self_id)->update([
                            "en_name"               => $english_name,
                            "nid_number"            => $nid_number,
                            "date_of_birth"         => $date_of_birth,
                            "step_compleate_status" => 4
                        ]);
                        $data = [
                            "status"   => 200,
                            "success" => true,
                            "message"  => "ocr-ammendment successfully",
                            "data"     => [
                                "customer_id" => $customer_id
                            ]
                        ];
                        return response()->json($data);
                    }else{
                        $data = [
                            "status"  => 400,
                            "success" => false,
                            "message" => "nid number already exists"
                        ];
                        return response()->json($data);
                    }
                    
                }catch(Exception $e){
                    $data =  [
                        "status"  => 500,
                        "success" => false,
                        "message" => "ocr amemndment failed"
                    ];
                    return response()->json($data);
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


    private function selfRequestId($user_id){
        $self_info = DB::table('self_registrations')->select('id')->where('requested_user_id', $user_id)->first();
        return $self_info->id;
    }

    private function nidNumberExist($nid_number, $company_id){
        $check_count = DB::table('self_registrations')->where('nid_number', $nid_number)->where('company_id', $company_id)->count();
        if($check_count > 0){
            return true;
        }else{
            return false;
        }
    }


}
