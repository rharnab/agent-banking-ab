<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NIDBackPartDataFormatingController extends Controller
{
    function BackPartResponse($response){
   
        $responseArray = explode("\n", $response);
        $dataArray = [];
        foreach($responseArray as $data){
            array_push($dataArray, $data);
        }
    
    
        $addressArray = [];
        $addressNo = 0;
        foreach($dataArray as $data){
            if($this->is_english($data) === false){
                array_push($addressArray, $data);
            }
            $addressNo++;
        }
    
        
        $data = [
            "back_data"       => $response,
            "present_address" => preg_replace('/[A-Za-z0-9<]/', '', join(" ", $addressArray)),
            "blood_group"     => trim(preg_replace("~Blood|blood|Group|group-~", ' ',$this->findBloodGroup($dataArray))),
            "place_of_birth"  => trim(preg_replace("~Place|place|Of|of|Birth|birth-~", ' ',$this->filePlaceOfBirth($dataArray))),
            "issue_date"      => $this->findIssueDate($dataArray),
            "nid_unique_data" => ''
        ];  
        
        return $data;
    
    }



    function is_english($str)
    {
        if (strlen($str) != strlen(utf8_decode($str))) {
            return false;
        } else {
            return true;
        }
    }


    function findBloodGroup($dataArray){
        $firstBanglaName = 0;
        foreach($dataArray as $data){
            similar_text("blood group", strtolower($data), $percentage);
            if($percentage > 70){
                array_splice($dataArray, $firstBanglaName, 1); 
                return $data;
            }
            $firstBanglaName++;     
        }    
    }

    function filePlaceOfBirth($dataArray){
        $firstBanglaName = 0;
        foreach($dataArray as $data){
            similar_text("Place of Birth", strtolower($data), $percentage);
            if($percentage > 50){
                array_splice($dataArray, $firstBanglaName, 1); 
                return $data;
            }
            $firstBanglaName++;     
        }
    }

    function findPlaceOfBirth($dataArray){
        $firstBanglaName = 0;
        foreach($dataArray as $data){
            similar_text("Place of Birth", strtolower($data), $percentage);
            return $percentage;
            if($percentage > 50){
                array_splice($dataArray, $firstBanglaName, 1); 
                return $data;
            }
            $firstBanglaName++;     
        }    
    }


    function findIssueDate($dataArray){
        $firstBanglaName = 0;
        foreach($dataArray as $data){
            if(count($this->standard_date_format($data)) > 0 ){
                return $this->standard_date_format($data)[0]; 
            }  
            $firstBanglaName++;       
        }
    }


    function standard_date_format($str) {
        preg_match_all('/(\d{1,2}) (\w+) (\d{4})/', $str, $matches);
        $dates  = array_map("strtotime", $matches[0]);
        $result = array_map(function($v) {return date("Y-m-d", $v); }, $dates);
        return $result;
    }
}
