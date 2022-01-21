<?php

namespace App\Http\Controllers\BranchRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\OcrEditableSetup;
use App\Models\BranchRegistration;
use App\Http\Controllers\Common\OcrController;
use Image;

class NidOCRController extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Nid image upload and read data from image

    public function uploadNidImage(Request $request){
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

        $mobile_number = $request->input('mobile_number');
        $nid_number    = $request->input('nid_number');

        if($request->hasFile('front_image') && $request->hasFile('back_image')){

            
            
            
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
            
            

            $ocrEditableField = OcrEditableSetup::where('company_id',Auth::user()->company_id)->first();

            // return $this->branchRegistrionOcrInfo(3);

            $ocrController = new OcrController();
            $frontImageOcr = $ocrController->frontNidimageToDataReader($frontImageFullPath, Auth::user()->company_id, Auth::user()->id);
            $frontImageOcrData = [
                "bangla_name"   => $frontImageOcr['bangla_name'],
                "english_name"  => $frontImageOcr['english_name'],
                "father_name"   => $frontImageOcr['father_name'],
                "mother_name"   => $frontImageOcr['mother_name'],
                "nid_number"    => $frontImageOcr['nid_number'],
                "date_of_birth" => $frontImageOcr['date_of_birth'],
                "front_data"    => $frontImageOcr['front_data'],
            ];

            $backImageOcr = $ocrController->BackNidimageToDataReader($backImageFullPath, Auth::user()->company_id, Auth::user()->id);
            $backImageOcrData = [
                "present_address" => $backImageOcr['present_address'],
                "issue_date"      => $backImageOcr['issue_date'],
                "blood_group"     => $backImageOcr['blood_group'],
                "place_of_birth"  => str_replace(":", "", $backImageOcr['place_of_birth']),
                "back_data"       => $backImageOcr['back_data'],
                "nid_unique_data" => $backImageOcr['nid_unique_data'],
            ];

            $retry_count = BranchRegistration::where('status', 0)->where('mobile_number', $mobile_number)->where('company_id', Auth::user()->company_id)->orWhere('nid_number', $nid_number)->count();
            if($retry_count > 0){
                $branch_registration = BranchRegistration::where('status', 0)->where('mobile_number', $mobile_number)->where('company_id', Auth::user()->company_id)->orWhere('nid_number', $nid_number)->first();
            }else{
                $branch_registration = new BranchRegistration();
            }
            $branch_registration->company_id            = Auth::user()->company_id;
            $branch_registration->branch_id             = Auth::user()->branch_id;
            $branch_registration->nid_front_image       = $frontImageFullPath;
            $branch_registration->nid_back_image        = $backImageFullPath;
            $branch_registration->front_data            = $frontImageOcrData['front_data'];
            $branch_registration->back_data             = $backImageOcrData['back_data'];
            $branch_registration->bn_name               = $frontImageOcrData['bangla_name'];
            $branch_registration->en_name               = $frontImageOcrData['english_name'];
            $branch_registration->father_name           = $frontImageOcrData['father_name'];
            $branch_registration->mother_name           = $frontImageOcrData['mother_name'];
            $branch_registration->date_of_birth         = $frontImageOcrData['date_of_birth'];
            $branch_registration->nid_number            = $frontImageOcrData['nid_number'] ?? $nid_number;
            $branch_registration->mobile_number         = $mobile_number;
            $branch_registration->present_address       = $backImageOcrData['present_address'];
            $branch_registration->permanent_address     = $backImageOcrData['present_address'];
            $branch_registration->blood_group           = $backImageOcrData['blood_group'];
            $branch_registration->place_of_birth        = $backImageOcrData['place_of_birth'];
            $branch_registration->issue_date            = $backImageOcrData['issue_date'];
            $branch_registration->nid_unique_data       = '';
            $branch_registration->step_compleate_status = 1;
            $branch_registration->created_user_id       = Auth::user()->id;

            $branch_registration_saved = $branch_registration->save();
            if($branch_registration_saved){
                $branch_registration_id = $branch_registration->id;
                return $this->branchRegistrionOcrInfo($branch_registration_id);
            }else{
                $data = [
                    "error_code" => 400,
                    "message"    => "nid-ocr failed"
                ];
                return json_encode($data);
            }

        }else{
            $data = [
                "error_code" => 400,
                "message"    => "please select & upload nid image"
            ];
            return json_encode($data);
        }
        
    }


    private function branchRegistrionOcrInfo($id){
        $registration_info = BranchRegistration::find($id);
        $data = [
            "error_code"      => 200,
            "message"         => "success",
            "registration_id" => $registration_info->id,
            "mobile_number"   => $registration_info->mobile_number,
            "front_data"      => $registration_info->front_data,
            "nid_number"      => $registration_info->nid_number,
            "bangla_name"     => $registration_info->bn_name,
            "english_name"    => $registration_info->en_name,
            "father_name"     => $registration_info->father_name,
            "mother_name"     => $registration_info->mother_name,
            "date_of_birth"   => $registration_info->date_of_birth,
            "back_data"       => $registration_info->back_data,
            "address"         => $registration_info->present_address,
            "blood_group"     => $registration_info->blood_group,
            "place_of_birth"  => $registration_info->place_of_birth,
            "issue_date"      => $registration_info->issue_date
        ];
        return json_encode($data);
    }











}
