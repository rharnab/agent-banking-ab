<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NIDFrontPartDataFormatingController extends Controller
{
    // Front Data Manage Section Start 
        public function frontNidimageToDataReader($response){
            $dataArray = explode("\n", $response);
            
            $stringArray = [];
            foreach($dataArray as $data){
                $string = str_replace(" ","",$data);
                if(strlen($string) > 6){
                    array_push($stringArray, $data);
                }
            }
    
                
            $mother = 0;
            foreach($stringArray as $data){
                
                similar_text("মাতা", $data, $percentage);
                if($percentage > 70){
                    array_splice($stringArray, $mother, 1); 
                }
                $mother++;
            }
    
    
    
            $father = 0;
            foreach($stringArray as $data){
                
                similar_text("পিতা ", $data, $percentage);
                if($percentage > 70){
                    array_splice($stringArray, $father, 1); 
                }
                $mother++;
            }
    
            $gpbs = 0;
            foreach($stringArray as $data){
                
                similar_text("গণপ্রজাতন্ত্রী বাংলাদেশ সরকার", $data, $percentage);
                if($percentage > 70){
                    array_splice($stringArray, $gpbs, 1); 
                }
                $gpbs++;
            }
    
            $rebublic = 0;
            foreach($stringArray as $data){
                
                similar_text("Government of the People's Republic of Bangladesh", $data, $percentage);
                if($percentage > 70){
                    array_splice($stringArray, $rebublic, 1); 
                }
                $rebublic++;
            }
    
            $nationalidcard = 0;
            foreach($stringArray as $data){
                
                similar_text("National ID Card", $data, $percentage);
                if($percentage > 70){
                    array_splice($stringArray, $nationalidcard, 1); 
                }
                $nationalidcard++;
            }
    
            $dob = 0;
            foreach($stringArray as $data){    
                similar_text("Date of Birth", $data, $percentage);
                if($percentage > 50){
                    $stringArray[$dob] = trim(preg_replace("~Date|date|Of|of|Birth|birth-~", ' ', $data) );
                }
                $dob++;
            }
    
            $nid = 0;
            foreach($stringArray as $data){    
                similar_text("NID No", $data, $percentage);
                if($percentage > 50){
                    $stringArray[$nid] = trim(preg_replace("~Nid|nid|NO|no-~", ' ', $data) );
                }
                $nid++;
            }
    
    
            if($this->is_english($stringArray[0]) === true){
                array_splice($stringArray, 0, 1); 
            }
    
            $data = [
                "bangla_name"   => $this->findBanglaName($stringArray),
                "english_name"  => $this->findEnglishName($stringArray),
                "father_name"   => $this->findFatherName($stringArray),
                "mother_name"   => $this->findMotherName($stringArray),
                "date_of_birth" => $this->findDateOfBirth($stringArray),
                "nid_number"    => $this->findNidNumber($stringArray),
                "front_data"    => $response
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
    
    
    
        function findBanglaName($stringArray){
            $firstBanglaName = 0;
            foreach($stringArray as $data){
                if($this->is_english($data) == false){
                return $data;
                }
                $firstBanglaName++;
            }
        }
    
        function findEnglishName($stringArray){
            $firstBanglaName = 0;
            foreach($stringArray as $data){
                if($this->is_english($data) == false){
                    return $stringArray[$firstBanglaName + 1];
                }
                $firstBanglaName++;
            }
        }
    
        function findFatherName($stringArray){
            $firstBanglaName = 0;
            foreach($stringArray as $data){
                if($this->is_english($data) == false){
                    $firstBanglaName++;
                }
                if($firstBanglaName == 2){
                    return $data;
                }
                
            }
        }
    
        function findMotherName($stringArray){
            $firstBanglaName = 0;
            foreach($stringArray as $data){
                if($this->is_english($data) == false){
                    $firstBanglaName++;
                }
                if($firstBanglaName == 3){
                    return $data;
                }
                
            }
        }
    
    
        function findNidNumber($stringArray){
            $firstBanglaName = 0;
            foreach($stringArray as $data){
                $str = preg_replace('/\D/', '', $data);
                if(strlen($str) > 7){
                    return $stringArray[$firstBanglaName];
                }
                $firstBanglaName++;        
            }
        }
    
        function findDateOfBirth($stringArray){
            $firstBanglaName = 0;
            foreach($stringArray as $data){
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
