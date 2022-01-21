<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ec;

class EcController extends Controller
{
     // This Function Call For Ec Data

    public function ecAPI($nid_number, $company_id, $user_id){

        $response = $this->porichoyAPI($nid_number);


        // $filePath      = "public\\faysal_bai.txt";
        // $response      = file_get_contents(base_path($filePath));

        $responseArray = json_decode($response, true);
        $error_code    = $responseArray['errorCode'];
        $passKyc       = $responseArray['passKyc'];




        if($this->ecActualCallLog($company_id, $user_id, $nid_number,  $response) !== true){
            $data = [
                "error_code" => 400,
                "message"    => "API Log failed"
            ];
            return json_encode($data);
        }else{
            if($error_code != null){
                $data = [
                    "error_code" => 400,
                    "message"    => "EC API Error"
                ];
                return json_encode($data);
            }else{
                $voter_info = $responseArray['voter'];
                if($this->voterInforamtionStore($nid_number, $voter_info, $passKyc, $error_code) === true){
                    return true;
                }else{
                    $data = [
                        "error_code" => 400,
                        "message"    => "Failed & Dont try again"
                    ];
                    return json_encode($data);
                }
            }
        }
        
    }


     // This Function Call For Porichoy API

    private function porichoyAPI($nid_number){

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL            => 'https://porichoy.azurewebsites.net/api/kyc/nid-person-values', 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING       => '',
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_TIMEOUT        => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST  => 'POST',
    CURLOPT_POSTFIELDS     => '{
        "national_id": "'.$nid_number.'",
        "team_tx_id": "",
        "english_output": false,
        "person_dob": ""
    }',
    CURLOPT_HTTPHEADER => array(
        'x-api-key: 7751d4c8-5024-4f6c-915c-b75e17b25c7c',
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return  $response;
}





    private function voterInforamtionStore($nid_number, $voter_response , $passKyc, $errorCode){
     
        $image_path = $this->base64_to_jpeg($voter_response['photo'], $nid_number);

        if($image_path !== false){
            $ec                     = new EC();
            $ec->nid_number         = str_replace(" ","", $nid_number);
            $ec->name               = $voter_response['name'];
            $ec->nameEn             = $voter_response['nameEn'];
            $ec->father             = $voter_response['father'];
            $ec->mother             = $voter_response['mother'];
            $ec->gender             = $voter_response['gender'];
            $ec->spouse             = $voter_response['spouse'];
            $ec->dob                = date('Y-m-d', strtotime($voter_response['dob']));
            $ec->permanentAddress   = $voter_response['permanentAddress'];
            $ec->presentAddress     = $voter_response['presentAddress'];
            $ec->photo              = $image_path;
            $ec->fatherEn           = $voter_response['fatherEn'];
            $ec->motherEn           = $voter_response['motherEn'];
            $ec->spouseEn           = $voter_response['spouseEn'];
            $ec->permanentAddressEn = $voter_response['permanentAddressEn'];
            $ec->presentAddressEn   = $voter_response['presentAddressEn'];
            $ec->passKyc            = $passKyc;
            $ec->errorCode          = $errorCode;
            $ec->save();
            return true;
        }else{
            return false;
        }

        


       
    }



    // This function convert image into the base64 to image and store it

    private function base64_to_jpeg($base64_string, $nid_number) {
        
        $folderPath = "images/ec_image/{$nid_number}_";

        $image_base64 = base64_decode($base64_string);
        $file         = $folderPath . uniqid() . '.png';

        $file_saved = file_put_contents($file, $image_base64);

        if($file_saved){
            return str_replace(" ", "", $file);
        }

        return false;

    }



}
