<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountTypesController extends Controller
{
    /**
    * All Account Types
    * 
    * @authenticated
    * @response 200 {
        "status" : 200,
        "success": true,
        "message": "success",
        "data"   : {
            "all_account_types": [
                {
                    "id"  : 1,
                    "name": "Cash Security For BTB"
                },
                {
                    "id"  : 2,
                    "name": "Saving Deposite(General)"
                }
            ]
        }
    }
    */
    public function accountTypes(Request $request){
        try{
            $account_types =  DB::table('account_types')->select('id','name')->where('company_id', $request->user()->id)->get();
            $data = [
                "status"  => 200,
                "success" => true,
                "message" => "success",
                "data"    => [
                    "all_account_types" => $account_types
                ]
            ];
            return response()->json($data);
        }catch(Exception $e){
            $data = [
                "status"  => 400,
                "success" => false,
                "message" => $e->getMessage()
            ];
            return response()->json($data);
        }
       
        
    }
}
