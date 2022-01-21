<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;
use App\Http\Controllers\Common\FaceVerificationController;

class FaceComparisonController extends Controller
{

    // Customer Face Verification

    public function faceImage(Request $request){
        if($request->has('face_self_requested_id') && !empty($request->input('face_self_requested_id')) && $request->has('f_image') ){
            $face_self_requested_id = $request->input('face_self_requested_id');
            $self_info = DB::table('self_registrations')->select('company_id', 'requested_user_id', 'nid_front_image')->where('id', $face_self_requested_id)->first();

            $company_id = $self_info->company_id;
            $user_id    = $self_info->requested_user_id;

            $minimum_require_face_match_percentage = $this->requireFaceMatchPercentage($self_info->company_id) ?? 0;

            $image = $request->file('f_image');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
         
            $face_image_path = public_path('/face-image').'/'.$input['imagename'];
            $img = Image::make($image->getRealPath());
            $img->resize(512, 310, function ($constraint) {
                $constraint->aspectRatio();
            })->save($face_image_path);
            
            $face_image_path_array = explode("public", $face_image_path );
            
            $face_image_path = "public".end($face_image_path_array);
            

            // Call to the Face Comparison Function for face verification
            $face_match_response_array       = $this->faceComparison($self_info->nid_front_image, $face_image_path, $company_id, $user_id);

            
            
            if (!is_object($face_match_response_array)) {
                $face_match_response_array = json_encode($face_match_response_array);
            }

            if(!is_array($face_match_response_array)){
                $face_match_response_array = json_decode($face_match_response_array, true);
            }
            
            if(!is_array($face_match_response_array)){
                $face_match_response_array = json_decode($face_match_response_array, true);
            }
    
            
            if(isset($face_match_response_array['error_code']) && $face_match_response_array['error_code'] === 400){
                $data = [
                    "error_code" => 400,
                    "message" => $face_match_response_array['error_message']
                ];
                return json_encode($data);
            }else{
                
                if($face_match_response_array['isIdentical'] == true){
                    $recognize_percentage = $face_match_response_array['confidence'] * 100;
                    if($recognize_percentage >= $minimum_require_face_match_percentage){
                        $update_face_comparison_info = DB::table('self_registrations')->where('id', $face_self_requested_id)->update([
                            "webcam_face_image"                   => $face_image_path,
                            "nid_and_webcam_recognize_percentage" => $recognize_percentage,
                            "face_verification"                   => true,
                            "step_compleate_status"               => 3,
                        ]);
    
                        if($update_face_comparison_info === 0 || $update_face_comparison_info === 1){
                            $data = [
                                "error_code"      => 200,
                                "message"         => "Face Verificaiton Success",
                                "self_request_id" => $face_self_requested_id
                            ];
                            return json_encode($data);
                        }else{
                            $data = [
                                "message"    => "Please smile & take selfi again",
                                "error_code" => 400
                            ];
                            return json_encode($data);
                        }
    
                    }else{
                        $data = [
                            "error_code" => 400,
                            "message"    => "Face does not match. please smile & take selfi again"
                        ];
                        echo json_encode($data);
                    }
                }else{
                    $data = [
                        "error_code" => 400,
                        "message"    => "Face Does not match. Please try again"
                    ];
                    echo json_encode($data);
                }
            }
            

           
            
            

        }else{
            $data = [
                "error_code" => 400,
                "message"    => "please take selfi"
            ];
            echo json_encode($data);
        }
    }


    //  Return Company Minumum Face Match Percentage

    private function requireFaceMatchPercentage($company_id){
        $percetage_data = DB::table('percentage_setups')->select('face_percentage')->where('company_id', $company_id)->first();
        return $percetage_data->face_percentage;
    }


    //  This function return 2 face comparison percentage

    function faceComparison($nid_front_image, $webcam_image, $company_id, $user_id){
        $nid_front_image  = asset($nid_front_image);
        $webcam_image_url = asset($webcam_image);

        $face_verification = new FaceVerificationController();
        $result            = $face_verification->faceVarification($nid_front_image, $webcam_image_url, $company_id, $user_id);
        return json_encode($result);
    }




}
