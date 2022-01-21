<?php

namespace App\Http\Controllers\BranchRegistration;

use App\Http\Controllers\Controller;
use App\Models\AccountOpening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use Brian2694\Toastr\Facades\Toastr;

class AccountOpeningController extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showAccountOpeningForm($id){

        $agent_data = DB::table('agent_users')->select('division_id', 'district_id')->where('company_id', Auth::user()->company_id)->where('user_id', Auth::user()->user_id)->first();

       $self_info =  DB::table('branch_registrations as br')
       ->join('ecs as ecs', 'br.nid_number', '=', 'ecs.nid_number')
        ->where('br.id', $id)
        ->first();
        $countries                = DB::table('countries')->get();
        $districts                = DB::table('districts')->get();
        $divisions                = DB::table('divisions')->get();
        $sbs_sector_codes         = DB::table('sbs_sector_codes')->get();
        $bb_occupation_categories = DB::table('bb_occupation_categories')->get();
        $account_types            = DB::table('account_types')->get();
        $products                 = DB::table('products')->where('company_id', Auth::user()->company_id)->get();

        $data                     = [
           "agent_data"               => $agent_data,
           "self_info"                => $self_info,
           "products"                 => $products,
           "countries"                => $countries,
           "divisions"                => $divisions,
           "districts"                => $districts,
           "sbs_sector_codes"         => $sbs_sector_codes,
           "bb_occupation_categories" => $bb_occupation_categories,
           "account_types"            => $account_types,
           "registration_id"          => $id
        ];

        return view('branch-registration.account-opening.opening-form', $data);
    }


    public function saveAccountOpeningRequest(Request $request, $id){
        $account_opening                                = new AccountOpening();
        $account_opening->branch_registraion_id         = $id;
        $account_opening->company_id                    = Auth::user()->company_id;
        $account_opening->agent_id                      = Auth::user()->agent_id;
        $account_opening->agent_user_id                 = Auth::user()->id;
        $account_opening->customer_type                 = $request->input('customer_type');
        $account_opening->name                          = $request->input('name');
        $account_opening->date_of_birth                 = date('Y-m-d', strtotime($request->input('date_of_birth')));
        $account_opening->country_of_birth              = $request->input('country_of_birth');
        $account_opening->place_of_birth_district       = $request->input('place_of_birth_district');
        $account_opening->gender                        = $request->input('gander');
        $account_opening->father_name                   = $request->input('father_name');
        $account_opening->mother_name                   = $request->input('mother_name');
        $account_opening->present_country_code          = $request->input('present_country_code');
        $account_opening->present_address               = $request->input('present_address');
        $account_opening->present_division              = $request->input('present_division');
        $account_opening->present_district              = $request->input('present_district');
        $account_opening->mobile_no_for_id_sms          = $request->input('mobile_no_for_id_sms');
        $account_opening->parmanent_country_code        = $request->input('parmanent_country_code');
        $account_opening->parmanent_address             = $request->input('parmanent_address');
        $account_opening->parmanent_division            = $request->input('parmanent_division');
        $account_opening->parmanent_district            = $request->input('parmanent_district');
        $account_opening->source_of_fund                = $request->input('source_of_fund');
        $account_opening->sbs_sector_code               = $request->input('sbs_sector_code');
        $account_opening->bb_occupation_code            = $request->input('bb_occupation_code');
        $account_opening->occupation_details            = $request->input('occupation_details');
        $account_opening->monthly_income_annual_tunover = $request->input('monthly_income_annual_tunover');
        $account_opening->communication_address         = $request->input('communication_address');
        $account_opening->walk_in_customer              = $request->input('walk_in_customer');
        $account_opening->account_type_code             = $request->input('account_type_code');
        $account_opening->product_code                  = $request->input('product_code');
        $account_opening->mode_of_operation             = $request->input('mode_of_operation');
        $account_opening->customer                      = $request->input('customer');
        $account_opening->account_title                 = $request->input('account_title');
        $account_opening->ac_opening_date               = date('Y-m-d', strtotime($request->input('ac_opening_date')));
        $account_opening->charge_source_of_fund         = $request->input('charge_source_of_fund');
        $account_opening->introduces_account_pa_no      = $request->input('introduces_account_pa_no');
        $account_opening->status                        = 1;
        $account_opening->request_timestamp             = date('Y-m-d H:i:s');
        $account_opening_saved                          = $account_opening->save();
        if($account_opening_saved){
            Toastr::success('Customer Account opening request success. waiting for authorization :)','Success');
            return redirect()->route('branch.registration.show_customer_search_form');
        }else{
            Toastr::error('Customer Account Opening Request Failed :)','Failed');
            return redirect()->back();
        }
    }



    public function findProduct(Request $request){
        $account_type_code = $request->input('account_type_code');
        $data = DB::table('products')->select('id', 'name')->where('company_id', Auth::user()->company_id)->where('account_type_id', $account_type_code)->get();
        $output = "<option>Select Product Code</option>";
        foreach($data as $dat){
            $output .= "<option value='$dat->id'>$dat->name</option>";
        }
        echo $output;
    }









}
