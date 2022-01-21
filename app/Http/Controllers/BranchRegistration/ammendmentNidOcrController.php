<?php

namespace App\Http\Controllers\BranchRegistration;

use App\Http\Controllers\Controller;
use App\Models\BranchRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Common\EcController;
use Illuminate\Support\Facades\DB;

class ammendmentNidOcrController extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    // OCR ammendment Data Update

    public function ammendmentOcr(Request $request){
        $id                                    = $request->input('registration_id');
        $branch_registraion                    = BranchRegistration::find($id);
        $branch_registraion->nid_number        = str_replace(" ","",$request->input('nid_number'));
        $branch_registraion->bn_name           = $request->input('bangla_name');
        $branch_registraion->en_name           = $request->input('english_name');
        $branch_registraion->father_name       = $request->input('father_name');
        $branch_registraion->mother_name       = $request->input('mother_name');
        $branch_registraion->date_of_birth     = $request->input('date_of_birth');
        $branch_registraion->present_address   = $request->input('address');
        $branch_registraion->permanent_address = $request->input('address');
        $branch_registraion->blood_group       = $request->input('blood_group');
        $branch_registraion->place_of_birth    = $request->input('place_of_birth');
        $branch_registraion->issue_date        = $request->input('issue_date');
        $updated = $branch_registraion->save();
        if($updated === true || $updated === false){
            // call ec api for compare text
            return $this->compareDataWithEC($id);
            
        }else{
            $data = [
                "error_code" => 400,
                "message"    => "Ammendment updated failed"
            ];
            return json_encode($data);
        }
    }


    private function compareDataWithEC($id){
        $registation_info = DB::table('branch_registrations')->select(
            'nid_number',
            'bn_name',
            'en_name',
            'father_name',
            'mother_name',
            'date_of_birth',
            'permanent_address'
        )
        ->where('id', $id)
        ->first();


        if($this->checkEcTable($registation_info->nid_number) === false){
            // call ec api
            $ec_controller   = new EcController();
            $ec_api_response = $ec_controller->ecAPI($registation_info->nid_number , Auth::user()->company_id, Auth::user()->id);

            if($ec_api_response !== true){
                return json_encode($ec_api_response);
            }
        }

        $ec_compare = $this->ecAndOcrCompare($id, $registation_info->nid_number);
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





    // EC & OCR Compare 

    public function ecAndOcrCompare($id, $nid_number){
      
        $self_info = DB::table('branch_registrations')->select(
            'nid_number',
            'mobile_number',
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

        $company_overall_percetage = $this->requiredOverallPercetage(Auth::user()->company_id);

        if($average >= $company_overall_percetage){
            $percentage_color         = "#1ab394";
            $is_passed_matching_score = true;
        }else{
            $percentage_color         = "#ed5565";
            $is_passed_matching_score = false;
        }

        $update_score = DB::table('branch_registrations')->where('id', $id)->update([
            "bn_name_percentage"      => $bn_name_percentage,
            "en_name_percentage"      => $en_name_percentage,
            "father_name_percentage"  => $father_name_percentage,
            "mother_name_percentage"  => $mother_name_percentage,
            "date_of_birth_percetage" => $date_of_birth_percentage,
            "address_percentage"      => $address_percentage,
            "text_maching_score"      => $average,
        ]);

        $data = [
            "error_code"                  => 200,
            "message"                     => "success",
            "ec_bn_name"                  => $ec_info->name,
            "ec_en_name"                  => $ec_info->nameEn,
            "ec_father_name"              => $ec_info->father,
            "ec_mother_name"              => $ec_info->mother,
            "ec_date_of_birth"            => $ec_info->dob,
            "ec_permanentAddress"         => $ec_info->permanentAddress,
            "ocr_bn_name"                 => $self_info->bn_name,
            "ocr_en_name"                 => $self_info->en_name,
            "ocr_father_name"             => $self_info->father_name,
            "ocr_mother_name"             => $self_info->mother_name,
            "ocr_date_of_birth_name"      => $self_info->date_of_birth,
            "ocr_address_name"            => $self_info->present_address,
            "bn_name_percentage"          => number_format($bn_name_percentage,2),
            "en_name_percentage"          => number_format($en_name_percentage,2),
            "father_name_percentage"      => number_format($father_name_percentage,2),
            "mother_name_percentage"      => number_format($mother_name_percentage,2),
            "date_of_birth_percentage"    => number_format($date_of_birth_percentage,2),
            "address_percentage"          => number_format($address_percentage,2),
            "average_text_matching_score" => number_format($average,2),
            "ec_photo_src"                => asset($ec_info->photo),
            "registration_id"             => $id,
            "nid_number"                  => $self_info->nid_number,
            "mobile_number"               => $self_info->mobile_number,
            "percentage_color"            => $percentage_color,
            "is_passed_matching_score"    => $is_passed_matching_score
        ];
        if($data){
            return json_encode($data);
        }else{
            return false;
        }       
    }


    // This function return company minimum required percentage

    private function requiredOverallPercetage($company_id){
        $company_percentage = DB::table('percentage_setups')->select('overall_percentage')->where('company_id', $company_id)->first();
        return $company_percentage->overall_percentage;
    }




}
