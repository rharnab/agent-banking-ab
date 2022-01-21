<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BranchListController extends Controller
{
    /**
    * All Branch List
    * 
    * @authenticated
    * @response 200 {
        "status" : 200,
        "success": true,
        "message": "success",
        "data"   : {
            "all_branch_lis": [
                {
                    "id"  : 1,
                    "name": "BARISAL"
                },
                {
                    "id"  : 2,
                    "name": "BOGRA"
                }
            ]
        }
    }
    */

    public function branchList(Request $request){
        try{
            $all_branch = DB::table('branches')->select('id','name')->where('company_id', $request->user()->id)->get();
            $data = [
                "status"  => 200,
                "success" => true,
                "message" => "success",
                "data"    => [
                    "all_branch_lis" => $all_branch
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
