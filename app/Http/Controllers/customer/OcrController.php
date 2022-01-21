<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OcrEditableSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use Google\Cloud\Vision\VisionClient;


class OcrController extends Controller
{

    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }



    // Nid image upload and read data from image

    public function uploadNidImage(Request $request){

        // $customerData = Customer::where('id', 1)->first();
        // return json_encode($customerData);


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

        if($request->hasFile('front_image') && $request->hasFile('back_image') ){
            
            $today      = date('Y-m-d');
            $unique_id  = uniqid();
            $folderPath = "images/nid-image/{$today}/{$unique_id}";

            $frontImagePath = "nid-front-" . $mobile_number . "-" . uniqid() . "." . $request->front_image->extension();
            $request->front_image->move($folderPath, $frontImagePath);

            $backImagePath = "nid-back-" . $mobile_number . "-" . uniqid() . "." . $request->back_image->extension();
            $request->back_image->move($folderPath, $backImagePath);

            $frontImageFullPath = "{$folderPath}/{$frontImagePath}";
            $backImageFullPath  = "{$folderPath}/{$backImagePath}";

            $ocrEditableField = OcrEditableSetup::where('company_id',Auth::user()->company_id)->first();

            $ocrController = new OcrController();

            $frontImageOcr = $ocrController->frontNidimageToDataReader($frontImageFullPath);
            $frontImageOcrData = [
                "bangla_name"   => $frontImageOcr['bangla_name'],
                "english_name"  => $frontImageOcr['english_name'],
                "father_name"   => $frontImageOcr['father_name'],
                "mother_name"   => $frontImageOcr['mother_name'],
                "nid_number"    => $frontImageOcr['nid_number'],
                "date_of_birth" => $frontImageOcr['date_of_birth'],
                "front_data"    => $frontImageOcr['front_data'],
            ];

            $backImageOcr = $ocrController->BackNidimageToDataReader($backImageFullPath);
            $backImageOcrData = [
                "present_address" => $backImageOcr['present_address'],
                "issue_date"      => $backImageOcr['issue_date'],
                "blood_group"     => $backImageOcr['blood_group'],
                "place_of_birth"  => str_replace(":", "", $backImageOcr['place_of_birth']),
                "back_data"       => $backImageOcr['back_data'],
                "nid_unique_data" => $backImageOcr['nid_unique_data'],
            ];

            // data insert into customer table
            $customer                  = new Customer();
            $customer->front_data      = $frontImageOcrData['front_data'];
            $customer->back_data       = $backImageOcrData['back_data'];
            $customer->front_image     = $frontImageFullPath;
            $customer->back_image      = $backImageFullPath;
            $customer->bn_name         = $frontImageOcrData['bangla_name'];
            $customer->en_name         = $frontImageOcrData['english_name'];
            $customer->father_name     = $frontImageOcrData['father_name'];
            $customer->mother_name     = $frontImageOcrData['mother_name'];
            $customer->date_of_birth   = $frontImageOcrData['date_of_birth'];
            $customer->nid_number      = $frontImageOcrData['nid_number'];
            $customer->mobile_no       = $mobile_number;
            $customer->address         = $backImageOcrData['present_address'];
            $customer->blood_group     = $backImageOcrData['blood_group'];
            $customer->place_of_birth  = $backImageOcrData['place_of_birth'];
            $customer->issue_date      = $backImageOcrData['issue_date'];
            $customer->nid_unique_data = '';
            $customer->user_id         = Auth::user()->id;
            $customer->save();
            $customer_id = $customer->id;
            $customerData = Customer::where('id', $customer_id)->first();
            return json_encode($customerData);
          
        }

    }


    public function frontNidimageToDataReader($imagePath){
        $filePath = "google-cloud-key/ekyc.json";
        $vision   = new VisionClient(["keyFile" => json_decode(file_get_contents($filePath) , true)]);
        $photo    = fopen($imagePath, "r");
        $image    = $vision->image($photo, ['TEXT_DETECTION']);
        $result   = $vision->annotate($image);
        $texts    = $result->text();
        foreach($texts as $key=>$text)
        {
            $description[]=$text->description();
        }
        $front_part = new NIDFrontPartDataFormatingController();
        return $front_part->frontNidimageToDataReader($description[0]);
    }


    public function BackNidimageToDataReader($imagePath){
        $filePath = "google-cloud-key/ekyc.json";
        $vision   = new VisionClient(["keyFile" => json_decode(file_get_contents($filePath) , true)]);
        $photo    = fopen($imagePath, "r");
        $image    = $vision->image($photo, ['TEXT_DETECTION']);
        $result   = $vision->annotate($image);
        $texts    = $result->text();
        foreach($texts as $key=>$text)
        {
            $description[]=$text->description();
        }
        $backPart = new NIDBackPartDataFormatingController();
        return $backPart->BackPartResponse($description[0]);
    }



}
