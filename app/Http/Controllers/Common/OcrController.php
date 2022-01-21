<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\NIDFrontPartDataFormatingController;
use App\Http\Controllers\Common\NIDBackPartDataFormatingController;
use Google\Cloud\Vision\VisionClient;
use App\Models\OcrLog;

class OcrController extends Controller
{
    
     // Ocr NID Front Part

    public function frontNidimageToDataReader($imagePath, $company_id, $user_id){
        $filePath = "google-cloud-key/ekyc.json";
        $vision   = new VisionClient(["keyFile" => json_decode(file_get_contents($filePath) , true)]);
        $photo    = fopen($imagePath, "r");
        $image    = $vision->image($photo, ['TEXT_DETECTION']);
        $result   = $vision->annotate($image);
        $texts    = $result->text();
        foreach($texts as $key=>$text)
        {
            $description[]=$text->description();
        }
        $front_part         = new NIDFrontPartDataFormatingController();
        $response           = $front_part->frontNidimageToDataReader($description[0]);
        $actual_response    = json_encode($description[0]);
        $formatted_response = json_encode($response);
        if($this->ocrLog($imagePath, $company_id, $user_id, $actual_response, $formatted_response ) === true){
            return $response;
        }else{
            return false;
        }

    }


     // OCR Nid Back Part

    public function BackNidimageToDataReader($imagePath, $company_id, $user_id){
        $filePath = "google-cloud-key/ekyc.json";
        $vision   = new VisionClient(["keyFile" => json_decode(file_get_contents($filePath) , true)]);
        $photo    = fopen($imagePath, "r");
        $image    = $vision->image($photo, ['TEXT_DETECTION']);
        $result   = $vision->annotate($image);
        $texts    = $result->text();
        foreach($texts as $key=>$text)
        {
            $description[]=$text->description();
        }
        $backPart = new NIDBackPartDataFormatingController();
        $response =  $backPart->BackPartResponse($description[0]);

        $actual_response    = json_encode($description[0]);
        $formatted_response = json_encode($response);
        if($this->ocrLog($imagePath, $company_id, $user_id, $actual_response, $formatted_response ) === true){
            return $response;
        }else{
            return false;
        }
    }



    public function ocrLog($imagePath, $company_id, $user_id, $actual_response, $formatted_response){
        $ocr_log                     = new OcrLog();
        $ocr_log->company_id         = $company_id;
        $ocr_log->user_id            = $user_id;
        $ocr_log->image              = $imagePath;
        $ocr_log->response           = $actual_response;
        $ocr_log->formatted_response = $formatted_response;
        $save_log = $ocr_log->save();
        if($save_log){
            return true;
        }else{
            return false;
        }
    }



}
