<?php

namespace App\Http\Controllers\BranchRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OcrEditableSetup;

class customerRegistationController extends Controller
{
     // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Go-to Customer Registation Page

    public function showCustomerRegistationForm($mobile_number, $nid_number=''){  
        $ocrEditableField = OcrEditableSetup::where('company_id',Auth::user()->company_id)->first();    
        $data = [
            "mobile_number"    => $mobile_number,
            "nid_number"       => $nid_number,
            "ocrEditableField" => $ocrEditableField
        ];
        return view('branch-registration.registration.index', $data);
    }

}
