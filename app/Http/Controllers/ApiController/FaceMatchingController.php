<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Common\FaceVerificationController;
use Exception;

class FaceMatchingController extends Controller
{
    /**
    * Customer Face Verification
    * 
    * @authenticated
    * 
    * @bodyParam  customer_id integer required customer_id for slef varification into the E-KYC Example: 1
    * @bodyParam  face_image text required  face_image base64 format send for Face Verification Example: data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAf4AAAE7CAMAAAAL
    * @response 200 {
        "status" : 200,
        "success": true,
        "message": "face varification success",
        "data"   : {
            "customer_id"         : "108",
            "isIdentical"         : true,
            "recognize_percentage": 66.713,
            "required_percentage" : 50,
            "verified"            : true
        }
    }
    * @response 400 {
            "status" : 400,
            "success": false,
            "message": "face identification failed",
            "data"   : {
                "isIdentical"         : false,
                "recognize_percentage": "14.34",
                "verified"            : false
            }
        }

    * @response 400 {
        "status" : 400,
        "success": false,
        "message": "does no fillup required percentage",
        "data"   : {
            "isIdentical"         : true,
            "recognize_percentage": 66.713,
            "required_percentage" : 80,
            "verified"            : false
        }
    }
    */
    public function faceVerification(Request $request){
        $company_id = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'customer_id' => ['required','integer'],
            'face_image'  => ['required'],
        ],[
            'customer_id.required' => 'customer_id must be needed',
            'customer_id.integer'  => 'customer_id field must be integer',
            'face_image.required'  => 'please give customer face image',
        ]);

        if ($validator->fails()) {
            $validation_error = [
                "status"  => 400,
                "success" => false,
                "message" => $validator->messages()->first()
            ];
            return response()->json($validation_error);
        }

        $customer_id = $request->input('customer_id');
        $face_image  = $request->input('face_image');
        
        

        if($this->checkValidCustomer($customer_id) === true){

            // check account opening requst status
            $account_opening_status_check = $this->userSelfRequestStatus($company_id, $customer_id);
            if($account_opening_status_check === false){
                $face_image_path = $this->base64ToPng($face_image);
                $self_info       = DB::table('self_registrations')->select('nid_front_image', 'id')->where('company_id', $company_id)->where('requested_user_id', $customer_id)->where('status', 0)->first();
                $nid_front_image = $self_info->nid_front_image;
                

                // Call to the Face Comparison Function for face verification
                    $face_match_response_array = $this->faceComparison($nid_front_image, $face_image_path, $company_id, $customer_id);

                    if (!is_object($face_match_response_array)) {
                        $face_match_response_array = json_encode($face_match_response_array);
                    }

                    if(!is_array($face_match_response_array)){
                        $face_match_response_array = json_decode($face_match_response_array, true);
                    }
                    
                    if(!is_array($face_match_response_array)){
                        $face_match_response_array = json_decode($face_match_response_array, true);
                    }

                    if(!is_array($face_match_response_array)){
                        $face_match_response_array = json_decode($face_match_response_array, true);
                    }

                    if(!is_array($face_match_response_array)){
                        $face_match_response_array = json_decode($face_match_response_array, true);
                    }
                    
                    if(!is_array($face_match_response_array)){
                        $face_match_response_array = json_decode($face_match_response_array, true);
                    }

                    if(!is_array($face_match_response_array)){
                        $face_match_response_array = json_decode($face_match_response_array, true);
                    }
                // end face verification call


                if(isset($face_match_response_array['error_code']) && $face_match_response_array['error_code'] === 400){
                    $face_verify_error = [
                        "status"  => 400,
                        "success" => false,
                        "message" => $face_match_response_array['error_message']
                    ];
                    return response()->json($face_verify_error);
                }else{

                    if($face_match_response_array['isIdentical'] == true){
                        $recognize_percentage = $face_match_response_array['confidence'] * 100;

                        $require_percentage = $this->requireFaceMatchPercentage($company_id);
                        if($recognize_percentage >= $require_percentage){
                            try{
                                DB::table('self_registrations')->where('id', $self_info->id)->update([
                                    "webcam_face_image"                   => $face_image_path,
                                    "nid_and_webcam_recognize_percentage" => $recognize_percentage,
                                    "face_verification"                   => true,
                                    "step_compleate_status"               => 5,
                                ]);

                                $data =  [
                                    "status"  => 200,
                                    "success" => true,
                                    "message" => "face varification success",
                                    "data"    => [
                                        "customer_id"          => $customer_id,
                                        "isIdentical"          => true,
                                        "recognize_percentage" => $recognize_percentage,
                                        "required_percentage"  => $require_percentage,
                                        "verified"             => true
                                    ]
                                ];
                                return response()->json($data);

                            }catch(Exception $e){
                                $data =  [
                                    "status"  => 500,
                                    "success" => false,
                                    "message" => "face maching failed",
                                ];
                                return response()->json($data);
                            }
                        }else{
                            $data =  [
                                "status"  => 400,
                                "success" => false,
                                "message" => "does no fillup required percentage",
                                "data"    => [                                    
                                    "isIdentical"          => true,
                                    "recognize_percentage" => $recognize_percentage,
                                    "required_percentage"  => $require_percentage,
                                    "verified"             => false
                                ]
                            ];
                            return response()->json($data);
                        }
                    }else{
                        $data =  [
                            "status"  => 400,
                            "success" => false,
                            "message" => "face identification failed",
                            "data"    => [
                                "isIdentical"          => false,
                                "recognize_percentage" => number_format($face_match_response_array['confidence'] * 100,2),
                                "verified"             => false
                            ]
                        ];
                        return response()->json($data);
                    }

                }
            }else{
                return $account_opening_status_check;
            }


            

            



        }else{
            $customer_not_found = [
                "status"  => 404,
                "success" => false,
                "message" => "error",
                "data"    => [
                    "message" => "customer not found"
                ]
            ];
            return response()->json($customer_not_found);
        }

         
    }



    private function base64ToPng($base64_string) {        
        $folderPath   = "public/file_storage/self_registration_storage/face_image/";
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

    
    function faceComparison($nid_front_image, $webcam_image, $company_id, $user_id){
        $nid_front_image   = asset($nid_front_image);
        $webcam_image_url  = asset($webcam_image);
        $face_verification = new FaceVerificationController();
        $result            = $face_verification->faceVarification($nid_front_image, $webcam_image_url, $company_id, $user_id);
        return json_encode($result);
    }

    function requireFaceMatchPercentage($company_id){
        $percetage_data = DB::table('percentage_setups')->select('face_percentage')->where('company_id', $company_id)->first();
        return $percetage_data->face_percentage;
    }




}
