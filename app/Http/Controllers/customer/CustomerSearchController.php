<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use App\Models\VerifiedCustomer;

class CustomerSearchController extends Controller
{
     // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    // Redirect to customer  search page

    public function showCustomerSearchForm(){
        return view('customer.customer-search.index');
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

        return $check_response;


        
        
        // $data = [
        //     "customerDatas"          => $customerDatas,
        //     "mobile_number"          => $mobile_number,
        //     "nid_number"             => $nid_number,
        //     "is_available_register"  => $is_available_register,
        //     "customer_search_result" => true,
        // ];

        // if(count($customerDatas) > 0 ){
        //     // if couster found
        //     $data['is_customer_found'] = true;
        //     //Toastr::warning('This customer already registered','Success');
        //     return view('customer.customer-search.index',$data);
        // }else{
        //     // if coustomer not found
        //     $data['is_customer_found'] = false;
        //    // Toastr::warning('Customer not found.Please register this customer :)','Warning');
        //     return view('customer.customer-search.index',$data);
        // }




    }// end find customer 



    private function checkCustomerRegistion($nid_number = null, $mobile_number){
        if($nid_number != null){
            $check_verified_customer_list = DB::table('verified_customers')->where('mobile_number', $mobile_number)->where('nid_number', $nid_number)->where('company_id', Auth::user()->company_id)->count();
            if($check_verified_customer_list > 0){
                $is_available_register = false;
            }else{
                $is_available_register = true;
            }
        }else{
            $check_verified_customer_list = DB::table('verified_customers')->where('mobile_number', $mobile_number)->where('company_id', Auth::user()->company_id)->count();
            if($check_verified_customer_list > 0){
                $is_available_register = false;
            }else{
                $is_available_register = true;
            }
        }

        return $is_available_register;

    }





}
