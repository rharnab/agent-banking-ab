<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\VerifiedCustomer;
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


    // All Verified customer list

    public function index(){
       $customerList = DB::table('verified_customers as vc')
       ->select(
           'vc.id',
           'vc.mobile_number',
           'vc.nid_number',
           'cu.en_name',
           'ec.present_address as address',
           'cu.date_of_birth',
           'f.webcam_face_image'
       )
       ->leftjoin('customers as cu', 'vc.customer_id', '=', 'cu.id')
       ->leftjoin('ecdatas as ec', 'ec.nid_number', '=', 'vc.nid_number')
       ->leftjoin('faces as f', 'vc.customer_id', '=', 'f.customer_id')
       ->where('vc.company_id', Auth::user()->company_id)->get();
      
       
       $data = [
           "customerList" => $customerList
       ];
       return view('customer.verified-customer.index', $data);
    }

}
