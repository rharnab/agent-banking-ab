<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountOpening;
use Brian2694\Toastr\Facades\Toastr;

class ResendRequestController extends Controller
{
    /**
     * Check Authencticate user
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Show old account opening request info for edit and resend request
     *
     */
    public function showEditPage(){
        $all_branch = DB::table('branches')
        ->select(['id', 'name'])
        ->where('company_id', Auth::user()->company_id)
        ->get();


        $account_info = DB::table('account_openings as ao')
        ->select('ao.*')
        ->leftJoin('self_registrations as sr', 'ao.self_registration_id', '=', 'sr.id')
        ->where('sr.requested_user_id', Auth::user()->id)
        ->where('sr.company_id', Auth::user()->company_id)
        ->where('sr.status', 3)
        ->where('ao.status', 3)
        ->first();
        $data = [
            "request_info" => $account_info,
            "all_branch"   => $all_branch
        ];
        return view('self-registration.self-request.edit' , $data);
    }


    /**
     * Resend account opening request
     *
     */
    public function resendRequest(Request $request, $id){

        $account_opening                            = AccountOpening::find($id);
        $account_opening->branch_id                 = $request->input('branch_id');
        $account_opening->probably_monthly_income   = $request->input('probably_monthly_income');
        $account_opening->probably_monthly_deposite = $request->input('probably_monthly_deposite');
        $account_opening->probably_monthly_withdraw = $request->input('probably_monthly_withdraw');
        $account_opening->nominee_name              = $request->input('nominee_name');
        $account_opening->nominee_nid_number        = $request->input('nominee_nid_number');
        $account_opening->nominee_address           = $request->input('nominee_address');
        $account_opening->status                    = 1;
        $account_opening->request_timestamp         = date('Y-m-d H:i:s');
        $save                                       = $account_opening->save();      
 
        if($save){
            if($this->updateSelfRequestStatus($account_opening->self_registration_id) === true){
                Toastr::success('Your account opening request send successfully :)','Success');
                return redirect()->route('outside.customer.request_view');
            }else{
                Toastr::error('Your account opening request send failed :)','Failed');
                return redirect()->route('outside.customer.request_view');
            }            
        }else{
            Toastr::error('Your account opening request send failed :)','Failed');
            return redirect()->route('outside.customer.request_view');
        }
 
    }



    private function updateSelfRequestStatus($id){
        $updated = DB::table('self_registrations')->where('id', $id)->update([
            "status" => 1
        ]);
        if($updated === 1 || $updated === 0) {
            return true;           
        }else{
            return false;
        }
    }
    


}
