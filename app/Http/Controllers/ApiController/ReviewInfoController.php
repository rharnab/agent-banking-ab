<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReviewInfoController extends Controller
{
    /**
    * Customer Review Information
    * 
    * @authenticated
    * 
    * @bodyParam  customer_id integer required customer_id for slef varification into the E-KYC Example                   : 1
    * @bodyParam  english_name string required  english_name review for data matching more accurecy Example: 1
    * @bodyParam  bangla_name string required  bangla_name review for data matching more accurecy Example: 1
    * @bodyParam  blood_group string required  blood_group review for data matching more accurecy Example: 1
    * @bodyParam  date_of_birth date required  date_of_birth review for data matching more accurecy Example: 1
    * @bodyParam  father_name string required  father_name review for data matching more accurecy Example: 1
    * @bodyParam  mother_name string required  mother_name review for data matching more accurecy Example: 1
    * @bodyParam  address text required  address review for data matching more accurecy Example: 1
    * @response 200{
        "status" : 200,
        "success": true,
        "message": "review-data successfully",
        "data"   : {
            "customer_id": "108"
        }
    }
    * @response 400 {
        "status" : 400,
        "success": false,
        "message": "The date of birth field is required."
    }
    */
    public function reviewInfo(Request $request){
        $company_id = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'customer_id'   => ['required','integer'],
            'english_name'  => ['required'],
            'bangla_name'   => ['required'],
            'blood_group'   => ['required'],
            'date_of_birth' => ['required', 'date'],
            'father_name'   => ['required'],
            'mother_name'   => ['required'],
            'address'       => ['required'],
        ],[
            'customer_id.required'   => 'customer_id must be needed',
            'customer_id.integer'    => 'customer_id field must be integer',
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
        $bangla_name   = $request->input('bangla_name');
        $blood_group   = $request->input('blood_group');
        $date_of_birth = $request->input('date_of_birth');
        $father_name   = $request->input('father_name');
        $mother_name   = $request->input('mother_name');
        $address       = $request->input('address');

        if($this->checkValidCustomer($customer_id) === true){ // valid customer

            // check account opening requst status
            $account_opening_status_check = $this->userSelfRequestStatus($company_id, $customer_id);
            if($account_opening_status_check === false){
                $self_info            = DB::table('self_registrations')->select('id')->where('company_id', $company_id)->where('requested_user_id', $customer_id)->where('status', 0)->first();
                $self_id              = $self_info->id;
    
                try{
                    DB::table('self_registrations')->where('id', $self_id)->update([
                        "bn_name"           => $bangla_name,
                        "en_name"           => $english_name,
                        "blood_group"       => $blood_group,
                        "date_of_birth"     => $date_of_birth,
                        "father_name"       => $father_name,
                        "mother_name"       => $mother_name,
                        "present_address"   => $address,
                        "permanent_address" => $address,
                        "step_compleate_status" => 7
                   ]);
    
                    $data =  [
                        "status"  => 200,
                        "success" => true,
                        "message" => "review-data successfully",
                        "data"    => [
                            "customer_id"       => $customer_id,
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
            }else{
                return $account_opening_status_check;
            }

           

        }else{
            $customer_not_found = [
                "status"   => 404,
                "success" => false,
                "message"  => "customer not found"
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


}
