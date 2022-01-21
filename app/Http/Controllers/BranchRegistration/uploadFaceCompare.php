<?php

namespace App\Http\Controllers\BranchRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Common\FaceVerificationController;
use Image;

class uploadFaceCompare extends Controller
{

    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function uploadFaceCompare(Request $request){
        if($request->has('upload_face_image')){
            $registration_id   = $request->input('face_compare_registration_id');
            
            
            
            $image = $request->file('upload_face_image');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
         
            $face_image_path = public_path('/face-image').'/'.$input['imagename'];
            $img = Image::make($image->getRealPath());
            $img->resize(512, 310, function ($constraint) {
                $constraint->aspectRatio();
            })->save($face_image_path);
            
            $face_image_path_array = explode("public", $face_image_path );
            
            $upload_image_path = "public".end($face_image_path_array);
            
            $ec_info = DB::table('branch_registrations as br')
            ->select('e.photo')
            ->leftJoin('ecs as e','br.nid_number' , '=', 'e.nid_number')
            ->where('br.id', $registration_id)
            ->first();
            $ec_face_image     = asset($ec_info->photo);

            $minimum_require_face_match_percentage = $this->requireFaceMatchPercentage(Auth::user()->company_id);

             // call to face verification api
             $face_verification              = new FaceVerificationController();
             $face_similarity_response_array = $face_verification->faceVarification($ec_face_image, asset($upload_image_path), Auth::user()->company_id, Auth::user()->id);
             
             if (is_object($face_similarity_response_array)) {
                 $face_similarity_response_array = json_encode($face_similarity_response_array);
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
                        $pass_color = "#1ab394";
    
                        $updated_percentage = DB::table('branch_registrations')->where('id', $registration_id)->update([
                            "webcam_face_image"                  => $upload_image_path,
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
                        "webcam_face_image"    => asset($upload_image_path),
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
                        "message" => "Face Does not match. please try again"
                    ];
                    return json_encode($data);
                }
                
                
                


                
            }


        }else{
            return "ok";
        }
    }

    //  Company minimum face maching percentage

    private function requireFaceMatchPercentage($company_id){
        $percetage_data = DB::table('percentage_setups')->select('face_percentage')->where('company_id', $company_id)->first();
        return $percetage_data->face_percentage;
    }



}
