<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @group API Authentication
     * 
     * @authenticated
     * @response 200{
            "status" : 200,
            "success": true,
            "message": "success",
            "data"   : {
                "name"     : "Venture Solution Limited",
                "email"    : "vsl@gmail.com",
                "api_token": "$2a$09$w8G5k9SiK0WQctXclwu6TuN7RclNeRNaz2DZ4s9bGiP0cALrFRhAG$2a$09$w8G5k9SiK0WQc"
            }
        }
        @response  401 {
            "status" : 401,
            "success": false,
            "message": "unathencticated user"
        }
     */
    public function authInfo(Request $request){
        $data = [
            "status"  => 200,
            "success" => true,
            "message" => "success",
            "data"    => [
                "name"      => $request->user()->name,
                "email"     => $request->user()->email,
                "api_token" => $request->user()->api_token
            ]
        ];
        return response()->json($data);
    }
}
