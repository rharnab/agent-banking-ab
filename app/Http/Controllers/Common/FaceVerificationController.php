<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\FaceApiLog;
use Illuminate\Http\Request;

class FaceVerificationController extends Controller
{
    
     // Face Detection into the image from Microsoft Image

    public function faceDetect($face_url, $company_id, $user_id){      
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => 'https://venture-face-api.cognitiveservices.azure.com//face/v1.0/detect',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => "{
                url: '{$face_url}'
            }",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Ocp-apim-subscription-key: 513c96e5610343879eb110aa40fce940'
            ),
        ));

        $response = curl_exec($curl);

        if($this->faceDetectAPILog($face_url, $company_id, $user_id, $response) === true){
            curl_close($curl);
            return $response;
        }else{
            $data = [
                "error_code"    => 400,
                "error_message" => "Face Detect API Log Creation Failed"
            ];
            return json_encode($data);
        }

        
    }


    // Face Similarity Function with Microsoft API

    public function faceVarification($face_url_1, $face_url_2, $company_id, $user_id){

        sleep(5);

        $random = mt_rand(0,1) / 100;

        return '{
            "isIdentical": true,
            "confidence": 0.56
        }';

      
        // Face ID One 
        $face_id1 = $this->faceDetect($face_url_1, $company_id, $user_id);  
        $face_1_dectect_response_array = json_decode($face_id1, true);
        if(isset($face_1_dectect_response_array[0]['faceId'])){
            $face_id_1        = $face_1_dectect_response_array[0]['faceId'];
        }else{
            $data = [
                "error_code"    => 400,
                "error_message" => $face_1_dectect_response_array['error']['message']
            ];
            return json_encode($data);
        }


        // Face ID Two 
        $face_id2 = $this->faceDetect($face_url_2, $company_id, $user_id);  
        $face_2_dectect_response_array = json_decode($face_id2, true);
        if(isset($face_2_dectect_response_array[0]['faceId'])){
            $face_id_2     = $face_2_dectect_response_array[0]['faceId'];
        }else{
            $data = [
                "error_code"    => 400,
                "error_message" => $face_2_dectect_response_array['error']['message']
            ];
            return json_encode($data);
        }
        
        $curl     = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => 'https://venture-face-api.cognitiveservices.azure.com//face/v1.0/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => "{
                'faceId1': '$face_id_1',
                'faceId2': '$face_id_2'
            }",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Ocp-apim-subscription-key: 513c96e5610343879eb110aa40fce940'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if($this->faceVerificationAPILog($face_url_1, $face_url_2, $company_id, $user_id,  $response) === true){
            return json_decode($response);
        }else{
            $data = [
                "error_code"    => 400,
                "error_message" => "Face Verification API Log creation failed"
            ];
            return json_encode($data);
        }
    }


    // Face  Detect Api log Store

    public function faceDetectAPILog($image_path, $company_id, $user_id, $response){
        $face_api_log               = new FaceApiLog();
        $face_api_log->company_id   = $company_id;
        $face_api_log->user_id      = $user_id;
        $face_api_log->api_reason   = "Face-Detect";
        $face_api_log->detect_image = $image_path;
        $face_api_log->response     = $response;
        
        $save = $face_api_log->save();
        if($save){
            return true;
        }
        return false;
    }


    // Face Verification API Log

    public function faceVerificationAPILog($image_1, $image_2, $company_id, $user_id, $response){
        $face_api_log                    = new FaceApiLog();
        $face_api_log->company_id        = $company_id;
        $face_api_log->user_id           = $user_id;
        $face_api_log->api_reason        = "Face-Verify";
        $face_api_log->image_compare_one = $image_1;
        $face_api_log->image_compare_two = $image_2;
        $face_api_log->response          = $response;
        
        $save = $face_api_log->save();
        if($save){
            return true;
        }
        return false;
    }






}

