<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AllVarifiedCustomerController extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function allVerifiedCustomer(){
        $customerList = DB::table('verified_customers as  vc')
        ->select(
            'c.id',
            'c.en_name',
            'c.present_address',
            'c.mobile_number',
            'c.nid_number',
            'f.webcam_face_image',
            'vc.created_at'
        )
        ->join('customers as c', 'vc.customer_id',  '=', 'c.id')
        ->leftJoin('users as u', 'c.user_id',  '=', 'u.id')
        ->leftJoin('faces as f', 'f.customer_id',  '=', 'c.id')
        ->where('u.company_id', Auth::user()->company_id)
        ->where('u.branch_id', Auth::user()->branch_id)
        ->get();
        $data = [
            "customerList" => $customerList
        ];
        
        return view('customer.verified-customer.index', $data);
    }




    public function customerView($id){
       $view_info = DB::table('customers as c')
       ->select(
           'c.id',
           'c.nid_front_image',
           'c.nid_back_image',
           'c.bn_name',
           'c.en_name',
           'c.father_name',
           'c.mother_name',
           'c.date_of_birth',
           'c.nid_number',
           'c.mobile_number',
           'c.present_address',
           'c.created_at',
           'f.webcam_face_image',
           's.bn_name_percentage',
           's.en_name_percentage',
           's.father_name_percentage',
           's.mother_name_percentage',
           's.address_percentage',
           's.date_of_birth_percetage',
           's.nid_and_webcam_recognize_percentage',
           's.ec_and_webcam_recognize_percentage',
           's.text_maching_score',
           'e.name',
           'e.nameEn',
           'e.father',
           'e.mother',
           'e.dob',
           'e.permanentAddress',
           'e.photo'
       )
       ->join('faces as f', 'c.id', '=', 'f.customer_id')
       ->join('scores as s', 'c.id', '=', 's.customer_id')
       ->join('ecs as e', 'e.nid_number', '=', 'c.nid_number')
       ->where('c.id', $id)
       ->first();
       $data = [
           "request_info" => $view_info
       ];
       return view('customer.verified-customer.single-customer-details', $data);
    }














}
