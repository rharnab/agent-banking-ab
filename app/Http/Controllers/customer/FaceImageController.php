<?php
namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Face;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use App\Models\VerifiedCustomer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Common\FaceVerificationController;


class FaceImageController extends Controller
{
     // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function faceCompare(Request $request){        
        if($request->has('face_upload_submit') && $request->input('face_upload_submit') == 1){
            $customer_id = $request->input('face_upload_customer_id');
            $folderPath = "images/face-image/ec-face/";
            $ec_id      = $request->input('face_upload_ec_id');
    
            $web_cam_face_image = "nid-front-" .uniqid()  .".". $request->upload_face_image->extension();
            $request->upload_face_image->move($folderPath, $web_cam_face_image);
        }else{
            $customer_id       = $request->input('customer_id');
            $ec_id             = $request->input('ec_id');
            $webcam_face_image = $request->input('webcam_face_image');
    
            define('UPLOAD_DIR', 'images/face-image/webcam-photo/');
            $image_parts    = explode(";base64,", $webcam_face_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type     = $image_type_aux[1];
            $image_base64   = base64_decode($image_parts[1]);
            $web_cam_face_image           = UPLOAD_DIR . uniqid().time() . '.png';
            file_put_contents($web_cam_face_image, $image_base64);
        }
        

        if($request->has('face_upload_submit') && $request->input('face_upload_submit') == 1){
            $webacm_image_path = "images/face-image/ec-face/" . $web_cam_face_image;
        }else{
            $webacm_image_path = $web_cam_face_image;
        }
        
        // update webcam image 
        $ec_data = DB::table('ecdatas')->select('face_image')->where('id', $ec_id)->first();

        $minimum_require_face_match_percentage = $this->requireFaceMatchPercentage(Auth::user()->company_id);


        $face_matching_response = $this->faceComparison($ec_data->face_image, $webacm_image_path);
        
        $face_match_response_array = json_decode($face_matching_response, true);
        if($face_match_response_array['isIdentical'] == true){
            $recognize_percentage = $face_match_response_array['confidence'] * 100;
            if($recognize_percentage >= $minimum_require_face_match_percentage){
                $is_varified = 1;
                $this->companyVarifiedCustomer($customer_id);
                // insert face image data
                $isFaceDataFound = Face::where('customer_id', $customer_id)->get();
                if($isFaceDataFound->count() > 0){
                    $face                       = Face::where('customer_id', $customer_id)->first();
                    $face->customer_id          = $customer_id;
                    $face->ec_id                = $ec_id;
                    $face->nid_scan_face_image  = '';
                    $face->ec_face_image        = $ec_data->face_image;
                    $face->webcam_face_image    = $webacm_image_path;
                    $face->recognize_percentage = $recognize_percentage;
                    $face->is_verified          = $is_varified;
                    $face->user_id              = Auth::user()->id;
                    $face->save();
                }else{
                    $face                       = new Face();
                    $face->customer_id          = $customer_id;
                    $face->ec_id                = $ec_id;
                    $face->nid_scan_face_image  = '';
                    $face->ec_face_image        = $ec_data->face_image;
                    $face->webcam_face_image    = $webacm_image_path;
                    $face->recognize_percentage = $recognize_percentage;
                    $face->is_verified          = $is_varified;
                    $face->user_id              = Auth::user()->id;
                    $face->save();
                } 
                $face_data = Face::where('customer_id', $customer_id)->first();
                $data = [
                    "customer_id"          => $face_data->customer_id,
                    "ec_id"                => $face_data->ec_id,
                    "nid_scan_face_image"  => $face_data->nid_scan_face_image,
                    "ec_face_image"        => asset($face_data->ec_face_image),
                    "webcam_face_image"    => asset($face_data->webcam_face_image),
                    "recognize_percentage" => $face_data->recognize_percentage,
                    "is_verified"          => $face_data->is_verified,
                    "user_id"              => $face_data->user_id,
                    "error_code"           => 200
                ];
                return json_encode($data);  
            }else{
                $data = [
                    "error_code" => 400,
                    "message"    => "please smile & take image again"
                ];
                return  json_encode($data);
            }
        }else{
            $data = [
                "error_code" => 400,
                "message"    => "please smile & take image again"
            ];
            return json_encode($data);
        }             
         
    }


    function faceComparison($ec_image, $webcam_image){
        $ec_image_url     = asset($ec_image);
        $webcam_image_url = asset($webcam_image);

        return $ec_image_url . " + ".$webcam_image_url;
    

        $face_verification = new FaceVerificationController();
        $result            = $face_verification->faceVarification($ec_image_url, $webcam_image_url);
        return json_encode($result);
    }



    function requireFaceMatchPercentage($company_id){
        $percetage_data = DB::table('percentage_setups')->select('face_percentage')->where('company_id', $company_id)->first();
        return $percetage_data->face_percentage;
    }



    function companyVarifiedCustomer($customer_id){
        $customer_info = Customer::where('id', $customer_id)->first();
        $customer_info->is_verified = 1;
        $customer_info->save();

        $checkIsVerified = VerifiedCustomer::where('customer_id', $customer_id)->get();
        if($checkIsVerified->count() > 0){
            $varifiedCustomer                = VerifiedCustomer::where('customer_id', $customer_id)->first();
            $varifiedCustomer->customer_id   = $customer_id;
            $varifiedCustomer->mobile_number = $customer_info->mobile_no;
            $varifiedCustomer->nid_number    = str_replace(" ","",$customer_info->nid_number);
            $varifiedCustomer->company_id    = Auth::user()->company_id;
            $varifiedCustomer->save();
        }else{
            $varifiedCustomer                = new VerifiedCustomer();
            $varifiedCustomer->customer_id   = $customer_id;
            $varifiedCustomer->mobile_number = $customer_info->mobile_no;
            $varifiedCustomer->nid_number    = str_replace(" ","",$customer_info->nid_number);
            $varifiedCustomer->company_id    = Auth::user()->company_id;
            $varifiedCustomer->save();
        }
        
    }




}
