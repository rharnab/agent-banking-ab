<?php

namespace App\Http\Controllers\BranchRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerSearchController extends Controller
{

     // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    
     // Redirecto To the customer search page

    public function showCustomerSearchForm(){
        return view('branch-registration.customer-search.index');
    }

    // Find Varified Customer Or Not

    public function findCustomer(Request $request){
         // check validation
         $validator = Validator::make($request->all(), [
            'mobile_number' => 'required',
        ],[
            'mobile_number.required' => 'Please enter customer mobile number.',                       
        ]);


        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $mobile_number = $request->input('mobile_number');
        $nid_number    = $request->input('nid_number');  

        $check_response = $this->checkCustomerRegistion($nid_number, $mobile_number);
        
        if($check_response === true){
            $data = [
                "mobile_number"         => $mobile_number,
                "nid_number"            => $nid_number,
                "is_available_register" => $check_response,
            ];
            return view('branch-registration.customer-search.customer_not_found', $data);
        }else{
            $data = [
                "mobile_number"         => $mobile_number,
                "nid_number"            => $nid_number,
                "is_available_register" => $check_response,
            ];
            return view('branch-registration.customer-search.customer_found', $data);
        }
        
       

        

        

    }

    
    private function checkCustomerRegistion($nid_number = null, $mobile_number){
        if($nid_number != null){
            $check_verified_customer_list = DB::table('verified_customers')->where('mobile_number', $mobile_number)->where('nid_number', $nid_number)->where('company_id', Auth::user()->company_id)->count();
            if($check_verified_customer_list > 0){
                return false;
            }else{
                return true;
            }
        }else{
            $check_verified_customer_list = DB::table('verified_customers')->where('mobile_number', $mobile_number)->where('company_id', Auth::user()->company_id)->count();
            if($check_verified_customer_list > 0){
                return false;
            }else{
                return true;
            }
        }

    }



}
