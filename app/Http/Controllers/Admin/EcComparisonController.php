<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Common\EcController;
use App\Http\Controllers\Common\FaceVerificationController;


class EcComparisonController extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Ec Comparison For Self Registartion

    public function ecCompare(Request $request){
        if($request->has('id') && !empty($request->input('id')) ){
            $id         = $request->input('id');
            $nid_info   = DB::table('self_registrations')->select('nid_number')->where('id', $id)->first();
            $nid_number = $nid_info->nid_number;
            
            if($this->checkEcTable($nid_number) === false){
                // call ec api
                $ec_controller   = new EcController();
                $ec_api_response = $ec_controller->ecAPI($nid_number , Auth::user()->company_id, Auth::user()->id);

                if($ec_api_response !== true){
                    return json_encode($ec_api_response);
                }

            }

            $ec_compare = $this->ecAndOcrCompare($id, $nid_number);
            if($ec_compare !== false){
                return $ec_compare;
            }else{
                $data = [
                    "error_code" => 400,
                    "message" => "Failed to ec comapre"
                ];
                return json_encode($data);
            }

        }
    }



    // Check EC Table  ALready Data Exists

    private function checkEcTable($nid_number){
        $nid_number = str_replace(" ", "", $nid_number);
        $nid_info   = DB::table('ecs')->where('nid_number', $nid_number)->count();
        if($nid_info > 0){   
            if($this->ecHitLogStore($nid_number) === true){
                return true;
            }else{
                return false;
            }            
        }else{
            return false;
        }
    }


    // EC & OCR Compare 

    public function ecAndOcrCompare($id, $nid_number){
        $self_info = DB::table('self_registrations')->select(
            'bn_name',
            'en_name',
            'father_name',
            'mother_name',
            'date_of_birth',
            'present_address'
        )
        ->where('id', $id)
        ->first();

        $ec_info = DB::table('ecs')->select(
            'name',
            'nameEn',
            'father',
            'mother',
            'dob',
            'permanentAddress',
            'photo'
        )
        ->where('nid_number', $nid_number)
        ->first();

        similar_text(strtolower($ec_info->name), strtolower($self_info->bn_name), $bn_name_percentage);
        similar_text(strtolower($ec_info->nameEn), strtolower($self_info->en_name), $en_name_percentage);
        similar_text(strtolower($ec_info->father), strtolower($self_info->father_name), $father_name_percentage);
        similar_text(strtolower($ec_info->mother),  strtolower($self_info->mother_name), $mother_name_percentage);
        similar_text(strtolower($ec_info->dob),strtolower($self_info->date_of_birth), $date_of_birth_percentage);
        similar_text(strtolower($ec_info->permanentAddress), strtolower($self_info->present_address), $address_percentage);

        $average = ($bn_name_percentage + $en_name_percentage + $father_name_percentage + $mother_name_percentage + $date_of_birth_percentage + $address_percentage) / 6;


        $data = [
            "error_code"                  => 200,
            "message"                     => "success",
            "ec_bn_name"                  => $ec_info->name,
            "ec_en_name"                  => $ec_info->nameEn,
            "ec_father_name"              => $ec_info->father,
            "ec_mother_name"              => $ec_info->mother,
            "ec_date_of_birth"            => $ec_info->dob,
            "ec_permanentAddress"         => $ec_info->permanentAddress,
            "bn_name_percentage"          => number_format($bn_name_percentage,2),
            "en_name_percentage"          => number_format($en_name_percentage,2),
            "father_name_percentage"      => number_format($father_name_percentage,2),
            "mother_name_percentage"      => number_format($mother_name_percentage,2),
            "date_of_birth_percentage"    => number_format($date_of_birth_percentage,2),
            "address_percentage"          => number_format($address_percentage,2),
            "average_text_matching_score" => number_format($average,2),
            "ec_photo_src"                => asset($ec_info->photo)
        ];
        if($data){
            return json_encode($data);
        }else{
            return false;
        }       


    }



    // EC Response From Our database + log create

    public function ecHitLogStore($nid_number){
        $ec_info = DB::table('ecs')
        ->where('nid_number', $nid_number)
        ->first();
        $response = json_encode($ec_info);
        if($this->ecAllLog(Auth::user()->company_id, Auth::user()->id, $nid_number,  $response) === true){
            return true;
        }else{
            return false;
        }
    }
    
    
    // EC Face Compare With Custome self-registration

    public function ecFaceCompare(Request $request){
        $id = $request->input('id');
        $self_info = DB::table('self_registrations as sr')
                    ->select('sr.webcam_face_image', 'ecs.photo')
                    ->leftJoin('ecs as ecs', 'sr.nid_number', '=', 'ecs.nid_number')
                    ->where('sr.id', $id)
                    ->first();
        if($self_info){
            $webcam_image = asset($self_info->webcam_face_image);
            $ec_photo     = asset($self_info->photo);

            // call to face verification api
            $face_verification              = new FaceVerificationController();
            $face_similarity_response_array = $face_verification->faceVarification(asset($ec_photo), asset($webcam_image), Auth::user()->company_id, Auth::user()->id);
            
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
                $data = [
                    "error_code"           => 200,
                    "message"              => "success",
                    "isIdentical"          => $face_similarity_response_array['isIdentical'],
                    "recognize_percentage" => number_format($face_similarity_response_array['confidence'] * 100 , 2)
                ];
                return json_encode($data);
            }
            
        }
    }




}
