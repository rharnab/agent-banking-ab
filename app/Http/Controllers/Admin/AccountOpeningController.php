<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AccountOpeningController extends Controller
{
    // Check Authencticate user
    public function __construct()
    {
        $this->middleware('auth');
    }


    // Showing all account opening request
     
    public function allRequest(){
        $all_request = DB::table('self_registrations as sr')
                        ->select('sr.id', 'sr.webcam_face_image', 'sr.en_name', 'sr.mobile_number', 'sr.present_address', 'ao.request_timestamp')
                        ->leftJoin('account_openings as ao', 'sr.id', '=', 'ao.self_registration_id')
                        ->where('ao.company_id', Auth::user()->company_id)
                        ->where('ao.status', 1)
                        ->where('sr.status', 1)
                        ->where('ao.branch_id', Auth::user()->branch_id)
                        ->get();

        $data = [
            "all_request" => $all_request
        ];
       return view('admin.account-opening.all-request' , $data);

    }

    // Single Account opening request details

    public function singleRequest(int $id){
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
            'b.name as branch_name'            
        )
        ->leftJoin('account_openings as ao', 'sr.id', '=', 'ao.self_registration_id')
        ->leftJoin('branches as b', 'ao.branch_id', '=', 'b.id')
        ->where('sr.id', $id)
        ->first();
        $data = [
            "request_info" => $request_info
        ];


        return view('admin.account-opening.single-request' , $data);
    }

    
}
