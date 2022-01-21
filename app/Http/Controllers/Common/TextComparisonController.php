<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Score;
use App\Models\PercentageSetup;
use Illuminate\Support\Facades\Auth;

class TextComparisonController extends Controller
{
    //  Compare Ocr & EC data 

    public function showMatchingScore($customer_id, $ec_id){
        $customer_info = DB::table('customers')->where('id',$customer_id)->first();
        $ec_info       = DB::table('ecdatas')->where('id',$ec_id)->first();

        similar_text($ec_info->bn_name,             $customer_info->bn_name,                $bn_name_percentage);
        similar_text($ec_info->en_name,             $customer_info->en_name,                $en_name_percentage);
        similar_text($ec_info->father_name,         $customer_info->father_name,            $father_name_percentage);
        similar_text($ec_info->mother_name,         $customer_info->mother_name,            $mother_name_percentage);
        similar_text($ec_info->date_of_birth,       date('Y-m-d',strtotime($customer_info->date_of_birth)),          $date_of_birth_percentage);
        similar_text($ec_info->permanent_address,   $customer_info->address,                $address_percentage);
        similar_text($ec_info->blood_group,         $customer_info->blood_group,            $blood_group_percentage);

        $overallPercentage = ($bn_name_percentage+$en_name_percentage+$father_name_percentage+$mother_name_percentage+$date_of_birth_percentage+$address_percentage+$blood_group_percentage)/7;


        $checkScore = DB::table('scores')->select('id')->where('customer_id', $customer_id)->first();
        if($checkScore){
            $score                           = Score::find($checkScore->id);
            $score->customer_id              = $customer_id;
            $score->ecdata_id                = $ec_id;
            $score->bn_name_percentage       = $bn_name_percentage;
            $score->en_name_percentage       = $en_name_percentage;
            $score->father_name_percentage   = $father_name_percentage;
            $score->mother_name_percentage   = $mother_name_percentage;
            $score->address_percentage       = $address_percentage;
            $score->date_of_birth_percentage = $date_of_birth_percentage;
            $score->blood_group_percentage   = $blood_group_percentage;
            $score->user_id                  = Auth::user()->id;
            $score->save();
        }else{
            $score                           = new Score();
            $score->customer_id              = $customer_id;
            $score->ecdata_id                = $ec_id;
            $score->bn_name_percentage       = $bn_name_percentage;
            $score->en_name_percentage       = $en_name_percentage;
            $score->father_name_percentage   = $father_name_percentage;
            $score->mother_name_percentage   = $mother_name_percentage;
            $score->address_percentage       = $address_percentage;
            $score->date_of_birth_percentage = $date_of_birth_percentage;
            $score->blood_group_percentage   = $blood_group_percentage;
            $score->user_id                  = Auth::user()->id;
            $score->save();
        }
        


        $minimumPercentage              = PercentageSetup::where('company_id', Auth::user()->company_id)->first();
        $bn_name_percentage_color       = $bn_name_percentage >= $minimumPercentage->bn_name_percentage ? 'text-navy' : 'text-warning';
        $en_name_percentage_color       = $en_name_percentage >= $minimumPercentage->en_name_percentage ? 'text-navy' : 'text-warning';
        $father_name_percentage_color   = $father_name_percentage >= $minimumPercentage->father_name_percentage ? 'text-navy' : 'text-warning';
        $mother_name_percentage_color   = $mother_name_percentage >= $minimumPercentage->mother_name_percentage ? 'text-navy' : 'text-warning';
        $date_of_birth_percentage_color = $date_of_birth_percentage >= $minimumPercentage->date_of_birth_percentage ? 'text-navy' : 'text-warning';
        $blood_group_percentage_color   = $blood_group_percentage >= $minimumPercentage->date_of_birth_percentage ? 'text-navy' : 'text-warning';
        $address_percentage_color       = $address_percentage >= $minimumPercentage->address_percentage ? 'text-navy' : 'text-warning';
        $overallPercentage_color        = $overallPercentage >= $minimumPercentage->overall_percentage ? '#1ab394' : '#ff6666';
        $is_pass_text_matching          = $overallPercentage >= $minimumPercentage->overall_percentage ? true : false;

        $data = [
            "ocr_bangla_name"   => $customer_info->bn_name,
            "ocr_english_name"  => $customer_info->en_name,
            "ocr_father_name"   => $customer_info->father_name,
            "ocr_mother_name"   => $customer_info->mother_name,
            "ocr_date_of_birth" => $customer_info->date_of_birth,
            "ocr_blood_group"   => $customer_info->blood_group,
            "ocr_address"       => $customer_info->address,

            "ec_bangla_name"   => $ec_info->bn_name,
            "ec_english_name"  => $ec_info->en_name,
            "ec_father_name"   => $ec_info->father_name,
            "ec_mother_name"   => $ec_info->mother_name,
            "ec_date_of_birth" => $ec_info->date_of_birth,
            "ec_blood_group"   => $ec_info->blood_group,
            "ec_address"       => $ec_info->permanent_address,


            "percentage_bangla_name"   => number_format($bn_name_percentage,2),
            "percentage_english_name"  => number_format($en_name_percentage,2),
            "percentage_father_name"   => number_format($father_name_percentage,2),
            "percentage_mother_name"   => number_format($mother_name_percentage,2),
            "percentage_date_of_birth" => number_format($date_of_birth_percentage,2),
            "percentage_blood_group"   => number_format($blood_group_percentage,2),
            "percentage_address"       => number_format($address_percentage,2),
            "overallPercentage"        => number_format($overallPercentage,2),


            "bn_name_percentage_color"       => $bn_name_percentage_color,
            "en_name_percentage_color"       => $en_name_percentage_color,
            "father_name_percentage_color"   => $father_name_percentage_color,
            "mother_name_percentage_color"   => $mother_name_percentage_color,
            "date_of_birth_percentage_color" => $date_of_birth_percentage_color,
            "blood_group_percentage_color"   => $blood_group_percentage_color,
            "address_percentage_color"       => $address_percentage_color,
            "overallPercentage_color"        => $overallPercentage_color,
            "is_pass_text_matching"          => $is_pass_text_matching,

            
            "nid_number"    => $ec_info->nid_number,
            "customer_id"   => $customer_id,
            "ec_id"         => $ec_id,
            "customer_info" => $customer_info,
            "ec_face_image" => asset($ec_info->face_image)
        ];

        return json_encode($data);
    }


     //  Compare Customer & EC data 

    public function getOutsideCustomerAndECCompareResponse($customer_id, $ec_id){
        $customer_info = DB::table('customers')->where('id',$customer_id)->first(); // customer info
        $ec_info       = DB::table('ecdatas')->where('id',$ec_id)->first(); // election commision info

        similar_text($ec_info->bn_name,             $customer_info->bn_name,                $bn_name_percentage);
        similar_text($ec_info->en_name,             $customer_info->en_name,                $en_name_percentage);
        similar_text($ec_info->father_name,         $customer_info->father_name,            $father_name_percentage);
        similar_text($ec_info->mother_name,         $customer_info->mother_name,            $mother_name_percentage);
        similar_text($ec_info->date_of_birth,       date('Y-m-d',strtotime($customer_info->date_of_birth)),          $date_of_birth_percentage);
        similar_text($ec_info->permanent_address,   $customer_info->address,                $address_percentage);
        similar_text($ec_info->blood_group,         $customer_info->blood_group,            $blood_group_percentage);

        $overallPercentage = ($bn_name_percentage+$en_name_percentage+$father_name_percentage+$mother_name_percentage+$date_of_birth_percentage+$address_percentage+$blood_group_percentage)/7;

        $checkScore = DB::table('scores')->select('id')->where('customer_id', $customer_id)->first();
        if($checkScore){
            $score                           = Score::find($checkScore->id);
            $score->customer_id              = $customer_id;
            $score->ecdata_id                = $ec_id;
            $score->bn_name_percentage       = $bn_name_percentage;
            $score->en_name_percentage       = $en_name_percentage;
            $score->father_name_percentage   = $father_name_percentage;
            $score->mother_name_percentage   = $mother_name_percentage;
            $score->address_percentage       = $address_percentage;
            $score->date_of_birth_percentage = $date_of_birth_percentage;
            $score->blood_group_percentage   = $blood_group_percentage;
            $score->overall_text_percentage  = $overallPercentage;
            $score->user_id                  = $customer_info->requested_user_id;
            $score->save();
        }else{
            $score                           = new Score();
            $score->customer_id              = $customer_id;
            $score->ecdata_id                = $ec_id;
            $score->bn_name_percentage       = $bn_name_percentage;
            $score->en_name_percentage       = $en_name_percentage;
            $score->father_name_percentage   = $father_name_percentage;
            $score->mother_name_percentage   = $mother_name_percentage;
            $score->address_percentage       = $address_percentage;
            $score->date_of_birth_percentage = $date_of_birth_percentage;
            $score->blood_group_percentage   = $blood_group_percentage;
            $score->user_id                  = $customer_info->requested_user_id;
            $score->overall_text_percentage  = $overallPercentage;
            $score->save();
        }

        $data = [
            "customer_id" => $customer_info->id,
            "ec_id"       => $ec_id
        ];

        return json_encode($data);

       
    }

















}
