<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\VerifiedCustomer;
use Illuminate\Http\Request;

class SinglerCustomerProfileController extends Controller
{
   // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($id){
        $customer = VerifiedCustomer::find($id);
        $data = [
            "customer" => $customer
        ];
        return view('customer.profile.index', $data);
    }
}
