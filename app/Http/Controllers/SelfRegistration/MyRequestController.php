<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyRequestController extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function requestView(){
        $user_id = Auth::user()->id;
        $request_info = DB::table('self_registrations as sr')
        ->select(
            'sr.id',
            'sr.webcam_face_image',
            'sr.en_name',
            'sr.bn_name',
            'sr.mobile_number',
            'sr.present_address',
            'sr.nid_front_image',
            'sr.nid_back_image',
            'ao.signature_image',
            'sr.nid_and_webcam_recognize_percentage',
            'sr.father_name',
            'sr.mother_name',
            'sr.date_of_birth',
            'sr.blood_group',
            'ao.request_timestamp',
            'ao.nominee_name',
            'ao.nominee_nid_number',
            'ao.nominee_address',
            'ao.probably_monthly_income',
            'ao.probably_monthly_deposite',
            'ao.probably_monthly_withdraw',
            'sr.status',
            'b.name as branch_name',
            'ecs.name',
            'nameEn',
            'father',
            'mother',
            'dob',
            'permanentAddress',
            'photo'       
        )
        ->leftJoin('account_openings as ao', 'sr.id', '=', 'ao.self_registration_id')
        ->leftJoin('branches as b', 'ao.branch_id', '=', 'b.id')
        ->leftJoin('ecs as ecs', 'sr.nid_number', '=', 'ecs.nid_number')
        ->where('sr.requested_user_id', $user_id)
        ->where('sr.company_id', Auth::user()->company_id)
        ->first();


        similar_text(strtolower($request_info->name), strtolower($request_info->bn_name), $bn_name_percentage);
        similar_text(strtolower($request_info->nameEn), strtolower($request_info->en_name), $en_name_percentage);
        similar_text(strtolower($request_info->father), strtolower($request_info->father_name), $father_name_percentage);
        similar_text(strtolower($request_info->mother),  strtolower($request_info->mother_name), $mother_name_percentage);
        similar_text(strtolower($request_info->dob),strtolower($request_info->date_of_birth), $date_of_birth_percentage);
        similar_text(strtolower($request_info->permanentAddress), strtolower($request_info->present_address), $address_percentage);

        $average = ($bn_name_percentage + $en_name_percentage + $father_name_percentage + $mother_name_percentage + $date_of_birth_percentage + $address_percentage) / 6;


        $ec_info = [
            "error_code"                  => 200,
            "ec_bn_name"                  => $request_info->name,
            "ec_en_name"                  => $request_info->nameEn,
            "ec_father_name"              => $request_info->father,
            "ec_mother_name"              => $request_info->mother,
            "ec_date_of_birth"            => $request_info->dob,
            "ec_permanentAddress"         => $request_info->permanentAddress,
            "bn_name_percentage"          => number_format($bn_name_percentage,2),
            "en_name_percentage"          => number_format($en_name_percentage,2),
            "father_name_percentage"      => number_format($father_name_percentage,2),
            "mother_name_percentage"      => number_format($mother_name_percentage,2),
            "date_of_birth_percentage"    => number_format($date_of_birth_percentage,2),
            "address_percentage"          => number_format($address_percentage,2),
            "average_text_matching_score" => number_format($average,2),
            "ec_photo_src"                => asset($request_info->photo)
        ];


        $data = [
            "request_info" => $request_info,
            "ec_info"      => $ec_info
        ];
        return view('self-registration.self-request.view' , $data);
    }
}
