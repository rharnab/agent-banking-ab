<?php

namespace App\Http\Controllers\BranchRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Common\FaceVerificationController;

class WebcamFaceCompare extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }


    // Webcam Face compare function

    public function faceCompare(Request $request){
        if($request->has('registration_id') && !empty($request->input('registration_id')) &&$request->has('ec_face_image') && !empty($request->input('ec_face_image')) && $request->has('webcam_face_image') && !empty($request->input('webcam_face_image'))  ){
            $registration_id   = $request->input('registration_id');
            $ec_face_image     = $request->input('ec_face_image');
            $webcam_face_image = $request->input('webcam_face_image');

            define('UPLOAD_DIR', 'images/face-image/webcam-photo/');
            $image_parts             = explode(";base64,", $webcam_face_image);
            $image_type_aux          = explode("image/", $image_parts[0]);
            $image_type              = $image_type_aux[1];
            $image_base64            = base64_decode($image_parts[1]);
            $web_cam_face_image_path = UPLOAD_DIR . uniqid().time() . '.png';
            file_put_contents($web_cam_face_image_path, $image_base64);

            $minimum_require_face_match_percentage = $this->requireFaceMatchPercentage(Auth::user()->company_id);

            // call to face verification api
            $face_verification              = new FaceVerificationController();
            $face_similarity_response_array = $face_verification->faceVarification($ec_face_image, asset($web_cam_face_image_path), Auth::user()->company_id, Auth::user()->id);
            
            if (is_object($face_similarity_response_array)) {
                $face_similarity_response_array = json_encode($face_similarity_response_array);
            }

            if(!is_array($face_similarity_response_array)){
                $face_similarity_response_array = json_decode($face_similarity_response_array, true);
            }
            
             if(!is_array($face_similarity_response_array)){
                $face_similarity_response_array = json_decode($face_similarity_response_array, true);
            }


            if(isset($face_similarity_response_array['error_code']) && $face_similarity_response_array['error_code'] === 400){
                $data = [
                    "error_code" => 400,
                    "message" => $face_similarity_response_array['error_message']
                ];
                return json_encode($data);
            }else{
                
                if($face_similarity_response_array['isIdentical'] == true){
                    $recongnize_percentage = $face_similarity_response_array['confidence'] * 100;
               
                    if($minimum_require_face_match_percentage <= $recongnize_percentage){
                        $is_pass_percentage = true;
                        $pass_color         = "#1ab394";
    
                        $updated_percentage = DB::table('branch_registrations')->where('id', $registration_id)->update([
                            "webcam_face_image"                  => $web_cam_face_image_path,
                            "ec_and_webcam_recognize_percentage" => $recongnize_percentage,
                            "face_verification"                  => true,
                            "status"                             => 1,
                            "request_timestamp"                  => date('Y-m-d H:i:s')                        
                        ]);
                    }else{
                        $is_pass_percentage = false;
                        $pass_color = "#ec4758";
                    }
    
                    
    
                    $data = [
                        "error_code"           => 200,
                        "message"              => "success",
                        "ec_image_path"        => $ec_face_image,
                        "webcam_face_image"    => asset($web_cam_face_image_path),
                        "isIdentical"          => $face_similarity_response_array['isIdentical'],
                        "recognize_percentage" => $recongnize_percentage,
                        "is_pass_percentage"   => $is_pass_percentage,
                        "pass_color"           => $pass_color,
                        "registration_id"      => $registration_id
                    ];
                    return json_encode($data);
                }else{
                     $data = [
                        "error_code" => 400,
                        "message" => "Face does not match. Please take photo again"
                    ];
                    return json_encode($data);
                }
                
                


                
            }


            
        }else{
            $data = [
                "error_code" => 400,
                "message" => "please take photo and compare again"
            ];
            return json_encode($data);
        }
    }


    //  Company minimum face maching percentage

    private function requireFaceMatchPercentage($company_id){
        $percetage_data = DB::table('percentage_setups')->select('face_percentage')->where('company_id', $company_id)->first();
        return $percetage_data->face_percentage;
    }




}
