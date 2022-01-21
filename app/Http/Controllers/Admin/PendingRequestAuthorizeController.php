<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendingRequestAuthorizeController extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }


    // Show all pending request

    public function showAllPendingRequest(){
        $company_id   = Auth::user()->company_id;
        $branch_id    = Auth::user()->branch_id;
        $request_list = DB::table('branch_registrations as br')
        ->select(
            'br.id',
            'br.en_name',
            'br.nid_number' ,
            'br.mobile_number' ,
            'ao.request_timestamp' ,
            'br.present_address',
            'br.webcam_face_image'
        )
        ->leftJoin('account_openings as ao', 'ao.branch_registraion_id', '=', 'br.id')
        ->where('br.company_id', $company_id)
        ->where('br.branch_id', $branch_id)
        ->where('br.status', 1)
        ->where('ao.status', 1)
        ->where('br.created_user_id', '<>', Auth::user()->id)  
        ->where('ao.agent_id', Auth::user()->agent_id)      
        ->get();
        $data = [
            "request_list" => $request_list
        ];

        return view('admin.pending-request.all-pending-request', $data);

    }


    // View Single Request Details

    public function viewSingleRequestDetails($id){
        $request_info = DB::table('branch_registrations as br')
        ->select(
            'br.id',
            'br.status',
            'br.nid_front_image',
            'br.nid_back_image',
            'br.webcam_face_image',
            'br.en_name',
            'br.bn_name',
            'br.father_name',
            'br.mother_name',
            'br.date_of_birth',
            'br.present_address',
            'br.nid_number',
            'br.mobile_number',
            'br.request_timestamp',
            'br.bn_name_percentage',
            'br.en_name_percentage',
            'br.father_name_percentage',
            'br.mother_name_percentage',
            'br.address_percentage',
            'br.date_of_birth_percetage',
            'br.ec_and_webcam_recognize_percentage',
            'e.nameEn',
            'e.father',
            'e.mother',
            'e.photo',
            'e.dob',
            'e.permanentAddress',
            'ao.request_timestamp',
            'ao.customer_type',
            'ao.name',
            'ao.date_of_birth',
            'ao.country_of_birth',
            'ao.place_of_birth_district',
            'ao.gender',
            'ao.father_name',
            'ao.mother_name',
            'ao.present_address',
            'ao.present_division',
            'ao.present_district',
            'ao.mobile_no_for_id_sms',
            'ao.parmanent_address',
            'ao.parmanent_division',
            'ao.parmanent_district',
            'ao.source_of_fund',
            'ao.sbs_sector_code',
            'ao.bb_occupation_code',
            'ao.occupation_details',
            'ao.monthly_income_annual_tunover',
            'ao.communication_address',
            'ao.walk_in_customer',
            'ao.account_type_code',
            'ao.mode_of_operation',
            'ao.customer',
            'ao.account_title',
            'ao.ac_opening_date',
            'ao.charge_source_of_fund',
            'ao.introduces_account_pa_no',
            'pc.name as present_country',
            'pa.name as parmanent_country',
            'cob.name as country_of_birth_name',
            'pobd.name as place_of_birth_district_name',
            'pd.name as present_division_name',
            'pard.name as parmanent_division_name',
            'pdd.name as present_district_name',
            'padd.name as parmanent_district_name',
            'ssc.sector_code as sbs_sector_code',
            'ssc.name as sbs_sector_name',
            'boc.code as bb_occupation_code',
            'boc.name as bb_occupation_name',
            'at.code as account_type_code',
            'at.name as account_type_name',
            'e.name as ec_bn_name'
        )
        ->leftJoin('ecs as e', 'br.nid_number', '=', 'e.nid_number')
        ->leftJoin('account_openings as ao', 'ao.branch_registraion_id', '=', 'br.id')
        ->leftJoin('countries as pc', 'pc.id', '=', 'ao.present_country_code')
        ->leftJoin('countries as pa', 'pa.id', '=', 'ao.parmanent_country_code')
        ->leftJoin('countries as cob', 'cob.id', '=', 'ao.country_of_birth')
        ->leftJoin('districts as pobd', 'pobd.id', '=', 'ao.place_of_birth_district')
        ->leftJoin('districts as pdd', 'pdd.id', '=', 'ao.present_district')
        ->leftJoin('districts as padd', 'padd.id', '=', 'ao.parmanent_district')
        ->leftJoin('divisions as pd', 'pd.id', '=', 'ao.present_division')
        ->leftJoin('divisions as pard', 'pard.id', '=', 'ao.parmanent_division')
        ->leftJoin('sbs_sector_codes as ssc', 'ssc.id', '=', 'ao.sbs_sector_code')
        ->leftJoin('bb_occupation_categories as boc', 'boc.id', '=', 'ao.bb_occupation_code')
        ->leftJoin('account_types as at', 'at.id', '=', 'ao.account_type_code')
        ->where('br.id', $id)
        ->first();

        $average_text_score = ($request_info->bn_name_percentage + $request_info->en_name_percentage + $request_info->father_name_percentage  + $request_info->mother_name_percentage + $request_info->address_percentage + $request_info->date_of_birth_percetage ) / 6;
        
        $data = [
            "request_info"       => $request_info,
            "average_text_score" => number_format($average_text_score,2)
        ];
        
        return view('admin.pending-request.view-request-details', $data);
    }





}
