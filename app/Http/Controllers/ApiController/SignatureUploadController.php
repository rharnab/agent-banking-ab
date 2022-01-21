<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\AccountOpening;
use App\Models\Branch;
use Exception;

class SignatureUploadController extends Controller
{
    /**
    * Customer Signature Upload
    * 
    * @authenticated
    * 
    * @bodyParam  customer_id integer required customer_id for slef varification into the E-KYC Example: 1
    * @bodyParam  signature_image text required  signature_image base64 format send for Signature Example: data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAf4AAAE7CAMAAAAL
    * @response 200 {
            "status" : 200,
            "success": true,
            "message": "signature upload successfully",
            "data"   : {
                "customer_id"  : "106",
                "bangla_name"  : "মােঃ সামিউল হক",
                "blood_group"  : "",
                "date_of_birth": "1990-01-15",
                "father_name"  : "মােঃ সানাউল হক",
                "mother_name"  : "মাতা",
                "address"      : "গণপ্রজাতন্ত্রী বাংলাদেশ সরকার মােঃ সামিউল হক পিতা মােঃ সানাউল হক মাতা আফরুজা হক"
            }
        }
    * @response 404 {
        "status" : 404,
        "success": false,
        "message": "customer not found"
    }
    */
    public function signatureUpload(Request $request){
        $company_id = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'customer_id'     => ['required','integer'],
            'signature_image' => ['required'],
        ],[
            'customer_id.required'     => 'customer_id must be needed',
            'customer_id.integer'      => 'customer_id field must be integer',
            'signature_image.required' => 'please give customer face image',
        ]);

        if ($validator->fails()) {
            $validation_error = [
                "status"  => 400,
                "success" => false,
                "message" => $validator->messages()->first()
            ];
            return response()->json($validation_error);
        }

        $customer_id          = $request->input('customer_id');
        $signature_image      = $request->input('signature_image');

        if($this->checkValidCustomer($customer_id) === true){

            // check account opening requst status
            $account_opening_status_check = $this->userSelfRequestStatus($company_id, $customer_id);
            if($account_opening_status_check === false){
                $signature_image_path = $this->base64ToPng($signature_image);
                $self_info            = DB::table('self_registrations')
                ->select('id', 'bn_name' ,'en_name' , 'father_name' , 'mother_name' , 'date_of_birth' , 'blood_group' , 'permanent_address' )
                ->where('company_id', $company_id)
                ->where('requested_user_id', $customer_id)
                ->where('status', 0)
                ->first();
                $self_id              = $self_info->id;

                $checkAccountOpening = AccountOpening::where('self_registration_id', $self_id)->get();

                if($checkAccountOpening->count() > 0){ // if already requested
                    $account_opening = AccountOpening::where('self_registration_id',$self_id)->first();
                }else{
                    $account_opening = new AccountOpening();
                }
                $account_opening->self_registration_id = $self_id;
                $account_opening->company_id           = $company_id;
                $account_opening->signature_image      = $signature_image_path;
                $account_opening->status               = 0;

                try{
                    $account_opening->save();  
                    DB::table('self_registrations')->where('id', $self_id)->update([
                        "step_compleate_status" => 6,
                        "status"                => 0
                    ]);              
                    $data =  [
                        "status"  => 200,
                        "success" => true,
                        "message" => "signature upload successfully",
                        "data"    => [
                            "customer_id"   => $customer_id,
                            "bangla_name"   => $self_info->bn_name,
                            "blood_group"   => $self_info->blood_group,
                            "date_of_birth" => $self_info->date_of_birth,
                            "father_name"   => $self_info->father_name,
                            "mother_name"   => $self_info->mother_name,
                            "address"       => $self_info->permanent_address
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
                "status"  => 404,
                "success" => false,
                "message" => "customer not found"
            ];
            return response()->json($customer_not_found);
        }
        
        
    }

    private function base64ToPng($base64_string) {        
        $folderPath   = "public/file_storage/self_registration_storage/signature/";
        $base64_string = str_replace("data:image/png;base64,","",$base64_string);
        $base64_string = str_replace("data:image/jpeg;base64,","",$base64_string);
        $image_base64 = base64_decode( $base64_string );
        $file         = $folderPath .time(). uniqid() . '.png';
        $file_saved   = file_put_contents($file, $image_base64);
        if($file_saved){
            return str_replace(" ", "", $file);
        }
        return false;

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
