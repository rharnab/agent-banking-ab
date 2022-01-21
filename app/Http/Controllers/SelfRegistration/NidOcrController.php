<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Common\OcrController;
use Illuminate\Support\Facades\DB;
use App\Models\SelfRegistration;
use Image;

class NidOcrController extends Controller
{

    // Save Upload Nid & Read Nid Image Using Google Vision

    public function nidUploadAndOcr(Request $request){

        

        // form validation
        $validator = Validator::make($request->all(), [
            'front_image' => 'required|mimes:jpeg,jpg,png',
            'back_image'  => 'required|mimes:jpeg,jpg,png',
        ],[
            'front_image.required' => 'Please select customer nid front image.',
            'front_image.mimes'    => 'Only supprted jpg | png |jpeg.',
            'back_image.required'  => 'Please select customer nid back image.',
            'back_image.mimes'     => 'Only supprted jpg | png |jpeg.',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $phone   = $request->input('phone');
        $user_id = $request->input('user_id');

        if( $request->hasFile('front_image') && $request->hasFile('back_image')){

            // $self_info = DB::table('self_registrations')
            //                 ->select('id', 'en_name', 'nid_number', 'date_of_birth')
            //                 ->where('id', 1)
            //                 ->first();

            // $data = [
            //     "error_code"           => 200,
            //     "message"              => "success",
            //     "en_name"              => $self_info->en_name,
            //     "nid_number"           => $self_info->nid_number,
            //     "date_of_birth"        => $self_info->date_of_birth,
            //     "self_registration_id" => $self_info->id
            // ];
            // return json_encode($data);


       
            $front_image = $request->file('front_image');
            $front_image_name = time().'.'.$front_image->getClientOriginalExtension();
         
            $frontImageFullPath = public_path('/nid-front-image').'/'.$front_image_name;
            $img = Image::make($front_image->getRealPath());
            $img->resize(512, 310, function ($constraint) {
                $constraint->aspectRatio();
            })->save($frontImageFullPath);
            
            $frontImageFullPath_arary = explode("public", $frontImageFullPath );
            
            $frontImageFullPath = "public".end($frontImageFullPath_arary);
            
            
            $back_image = $request->file('back_image');
            $back_image_name = time().'.'.$back_image->getClientOriginalExtension();
         
            $backImageFullPath = public_path('/nid-back-image').'/'.$back_image_name;
            $img = Image::make($back_image->getRealPath());
            $img->resize(512, 310, function ($constraint) {
                $constraint->aspectRatio();
            })->save($backImageFullPath);
            
            $backImageFullPatharray = explode("public", $backImageFullPath );
            
            $backImageFullPath = "public".end($backImageFullPatharray);
            
            
            

            // company id find out
            $company_id = $this->getCustomerCompanyId($user_id);


            // Call to image ocr controller and get ocr dta 
            $ocrController = new OcrController();
            $frontImageOcr = $ocrController->frontNidimageToDataReader($frontImageFullPath, $company_id, $user_id);
            $frontImageOcrData = [
                "bangla_name"   => $frontImageOcr['bangla_name'],
                "english_name"  => $frontImageOcr['english_name'],
                "father_name"   => $frontImageOcr['father_name'],
                "mother_name"   => $frontImageOcr['mother_name'],
                "nid_number"    => $frontImageOcr['nid_number'],
                "date_of_birth" => $frontImageOcr['date_of_birth'],
                "front_data"    => $frontImageOcr['front_data'],
            ];

            $backImageOcr = $ocrController->BackNidimageToDataReader($backImageFullPath, $company_id, $user_id);
            $backImageOcrData = [
                "present_address" => $backImageOcr['present_address'],
                "issue_date"      => $backImageOcr['issue_date'],
                "blood_group"     => $backImageOcr['blood_group'],
                "place_of_birth"  => str_replace(":", "", $backImageOcr['place_of_birth']),
                "back_data"       => $backImageOcr['back_data'],
                "nid_unique_data" => $backImageOcr['nid_unique_data'],
            ];


            $check_self_registration_count = SelfRegistration::where('company_id', $company_id)->where('requested_user_id', $user_id)->where('status', 0)->count();
            
            if($check_self_registration_count > 0 ){                
                $self_registration = SelfRegistration::where('company_id', $company_id)->where('requested_user_id', $user_id)->where('status', 0)->first();
                $self_registration->company_id            = $company_id;
                $self_registration->requested_user_id     = $user_id;
                $self_registration->nid_front_image       = $frontImageFullPath;
                $self_registration->nid_back_image        = $backImageFullPath;
                $self_registration->front_data            = $frontImageOcrData['front_data'];
                $self_registration->back_data             = $backImageOcrData['back_data'];
                $self_registration->bn_name               = $frontImageOcrData['bangla_name'];
                $self_registration->en_name               = $frontImageOcrData['english_name'];
                $self_registration->father_name           = $frontImageOcrData['father_name'];
                $self_registration->mother_name           = $frontImageOcrData['mother_name'];
                $self_registration->date_of_birth         = $frontImageOcrData['date_of_birth'];
                $self_registration->nid_number            = str_replace(" ", "",$frontImageOcrData['nid_number']);
                $self_registration->mobile_number         = $phone;
                $self_registration->present_address       = $backImageOcrData['present_address'];
                $self_registration->permanent_address     = $backImageOcrData['present_address'];
                $self_registration->blood_group           = $backImageOcrData['blood_group'];
                $self_registration->place_of_birth        = $backImageOcrData['place_of_birth'];
                $self_registration->issue_date            = $backImageOcrData['issue_date'];
                $self_registration->status                = 0;
                $self_registration->step_compleate_status = 2;

            }else{
                // new self-registration section start
                $self_registration                        = new SelfRegistration();
                $self_registration->company_id            = $company_id;
                $self_registration->requested_user_id     = $user_id;
                $self_registration->nid_front_image       = $frontImageFullPath;
                $self_registration->nid_back_image        = $backImageFullPath;
                $self_registration->front_data            = $frontImageOcrData['front_data'];
                $self_registration->back_data             = $backImageOcrData['back_data'];
                $self_registration->bn_name               = $frontImageOcrData['bangla_name'];
                $self_registration->en_name               = $frontImageOcrData['english_name'];
                $self_registration->father_name           = $frontImageOcrData['father_name'];
                $self_registration->mother_name           = $frontImageOcrData['mother_name'];
                $self_registration->date_of_birth         = $frontImageOcrData['date_of_birth'];
                $self_registration->nid_number            = str_replace(" ", "",$frontImageOcrData['nid_number']);
                $self_registration->mobile_number         = $phone;
                $self_registration->present_address       = $backImageOcrData['present_address'];
                $self_registration->permanent_address     = $backImageOcrData['present_address'];
                $self_registration->blood_group           = $backImageOcrData['blood_group'];
                $self_registration->place_of_birth        = $backImageOcrData['place_of_birth'];
                $self_registration->issue_date            = $backImageOcrData['issue_date'];
                $self_registration->status                = 0;
                $self_registration->step_compleate_status = 2;
            }

            
           
            

            $saved_selfregistration = $self_registration->save();

            if($saved_selfregistration){
                $self_registration_id   = $self_registration->id;

                $self_info = DB::table('self_registrations')
                            ->select('id', 'en_name', 'nid_number', 'date_of_birth')
                            ->where('id', $self_registration_id)
                            ->first();
                if($self_info){
                    $data = [
                        "error_code"           => 200,
                        "message"              => "success",
                        "en_name"              => $self_info->en_name,
                        "nid_number"           => $self_info->nid_number,
                        "date_of_birth"        => $self_info->date_of_birth,
                        "self_registration_id" => $self_registration_id
                    ];
                    return json_encode($data);
                }else{
                    $data = [
                        "error_code" => 400,
                        "message"    => "fetch self info failed"
                    ];
                    return json_encode($data);
                }
                
            }else{
                $data = [
                    "error_code" => 400,
                    "message"    => "self registration failed"
                ];
                return json_encode($data);
            }
        }else{
            $data = [
                "error_code" => 400,
                "message"    => "image not found.please select & try again"
            ];
            return json_encode($data);
        }

    }


    // Find out company id from user id

    private function getCustomerCompanyId($user_id){
        $user_info = DB::table('users')->select('company_id')->where('id', $user_id)->first();
        return $user_info->company_id;
    }




}
