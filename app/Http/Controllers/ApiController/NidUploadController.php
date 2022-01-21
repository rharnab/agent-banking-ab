<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Common\OcrController;
use App\Models\SelfRegistration;
use Exception;

class NidUploadController extends Controller
{
    /**
    * Customer Nid-Ocr
    * 
    * @authenticated
    * 
    * @bodyParam  customer_id integer required customer_id for slef varification into the E-KYC Example: 1
    * @bodyParam  nid_front_image text required  nid_front_image base64 format send for OCR Nid Front Part Example: data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAf4AAAE7CAMAAAAL
    * @bodyParam  nid_back_image text required  nid_back_image base64 format send for OCR Nid Back Part Example: data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgMAAAFACAMAAAAWIY8
    * @response 200 {
        "status" : 200,
        "success": true,
        "message": "nid-ocr successfully",
        "data"   : {
            "customer_id"  : "108",
            "english_name" : "MD. SAMIUL HAQUE",
            "nid_number"   : "6410581760",
            "date_of_birth": "1995-11-19"
        }
    }

    @response 400 {
        "status" : 400,
        "success": false,
        "message": "please give nid front image"
    }
    */
    public function nidUpload(Request $request){
        $company_id    = $request->user()->id;
        $ocrController = new OcrController();

        

        $validator = Validator::make($request->all(), [
            'customer_id'     => ['required','integer'],
            'nid_front_image' => ['required'],
            'nid_back_image' => ['required'],
        ],[
            'customer_id.required'     => 'customer_id must be needed',
            'customer_id.integer'      => 'customer_id field must be integer',
            'nid_front_image.required' => 'please give nid front image',
            'nid_back_image.required'  => 'please give nid back image',
        ]);
         
        if ($validator->fails()) {
            $validation_error = [
                "status"  => 400,
                "success" => false,
                "message" => $validator->messages()->first()
            ];
            return response()->json($validation_error);
        }
        $customer_id     = $request->input('customer_id');
        $nid_front_image = $request->input('nid_front_image');
        $nid_back_image  = $request->input('nid_back_image');

        if($this->checkValidCustomer($customer_id) === true){

            // check account opening requst status
            $account_opening_status_check = $this->userSelfRequestStatus($company_id, $customer_id);
            
            if($account_opening_status_check === false){
                $nid_front_image_path = $this->base64ToPng($nid_front_image);
                $nid_back_image_path  = $this->base64ToPng($nid_back_image);

                $frontImageOcr = $ocrController->frontNidimageToDataReader($nid_front_image_path, $company_id, $customer_id);
                $frontImageOcrData = [
                    "bangla_name"   => $frontImageOcr['bangla_name'],
                    "english_name"  => $frontImageOcr['english_name'],
                    "father_name"   => $frontImageOcr['father_name'],
                    "mother_name"   => $frontImageOcr['mother_name'],
                    "nid_number"    => $frontImageOcr['nid_number'],
                    "date_of_birth" => $frontImageOcr['date_of_birth'],
                    "front_data"    => $frontImageOcr['front_data'],
                ];

                $backImageOcr = $ocrController->BackNidimageToDataReader($nid_back_image_path, $company_id, $customer_id);
                $backImageOcrData = [
                    "present_address" => $backImageOcr['present_address'],
                    "issue_date"      => $backImageOcr['issue_date'],
                    "blood_group"     => $backImageOcr['blood_group'],
                    "place_of_birth"  => str_replace(":", "", $backImageOcr['place_of_birth']),
                    "back_data"       => $backImageOcr['back_data'],
                    "nid_unique_data" => $backImageOcr['nid_unique_data'],
                ];

                $check_self_registration_count = SelfRegistration::where('company_id', $company_id)->where('requested_user_id', $customer_id)->where('status', 0)->count();
                if($check_self_registration_count > 0){
                    $self_registration = SelfRegistration::where('company_id', $company_id)->where('requested_user_id', $customer_id)->where('status', 0)->first();
                }else{
                    $self_registration = new SelfRegistration();
                }

                $self_registration->company_id            = $company_id;
                $self_registration->requested_user_id     = $customer_id;
                $self_registration->nid_front_image       = $nid_front_image_path;
                $self_registration->nid_back_image        = $nid_back_image_path;
                $self_registration->front_data            = $frontImageOcrData['front_data'];
                $self_registration->back_data             = $backImageOcrData['back_data'];
                $self_registration->bn_name               = $frontImageOcrData['bangla_name'];
                $self_registration->en_name               = $frontImageOcrData['english_name'];
                $self_registration->father_name           = $frontImageOcrData['father_name'];
                $self_registration->mother_name           = $frontImageOcrData['mother_name'];
                $self_registration->date_of_birth         = $frontImageOcrData['date_of_birth'];
                $self_registration->nid_number            = str_replace(" ", "",$frontImageOcrData['nid_number']);
                $self_registration->mobile_number         = $this->customerPhoneNumber($customer_id);
                $self_registration->present_address       = $backImageOcrData['present_address'];
                $self_registration->permanent_address     = $backImageOcrData['present_address'];
                $self_registration->blood_group           = $backImageOcrData['blood_group'];
                $self_registration->place_of_birth        = $backImageOcrData['place_of_birth'];
                $self_registration->issue_date            = $backImageOcrData['issue_date'];
                $self_registration->status                = 0;
                $self_registration->step_compleate_status = 3;

                try{
                    $self_registration->save();
                    try{
                        $self_info = DB::table('self_registrations')->select('en_name', 'nid_number', 'date_of_birth')->where('requested_user_id', $customer_id)->where('status', 0)->first();
                        $data = [
                            "status"  => 200,
                            "success" => true,
                            "message" => "nid-ocr successfully",
                            "data"    => [
                                "customer_id"   => $customer_id,
                                "english_name"  => $self_info->en_name,
                                "nid_number"    => $self_info->nid_number,
                                "date_of_birth" => $self_info->date_of_birth,
                            ]
                        ];
                        return response()->json($data);
                    }catch(Exception $e){
                        $data =  [
                            "status"  => 500,
                            "success" => false,
                            "message" => $e->getMessage()
                        ];
                        return response()->json($data);
                    }
                


                }catch(Exception $e){
                    $data =  [
                        "status"  => 500,
                        "success" => false,
                        "message" => $e->getMessage()
                    ];
                    return response()->json($data);
                }
            }else{
                return $account_opening_status_check;
            }

            



            
           

        }else{
            $customer_not_found = [
                "status"  => 404,
                "success" => false,
                "message" => "customer not found"
            ];
            return response()->json($customer_not_found);
        }


        
    }



    private function base64ToPng($base64_string) {
        
        $folderPath = "public/file_storage/self_registration_storage/nid_image/";

        $image_base64 = base64_decode(str_replace("data:image/png;base64,","",$base64_string) );
        $file         = $folderPath .time().uniqid() . '.png';

        $file_saved = file_put_contents($file, $image_base64);

        if($file_saved){
            return str_replace(" ", "", $file);
        }

        return false;

    }


    public function checkValidCustomer($user_id){
        $user_count = DB::table('users')->select('id')->where('id', $user_id)->count();
        if($user_count > 0){
            return true;
        }else{
            return false;
        }
    }


    public function customerPhoneNumber($user_id){
        $user_info = DB::table('users')->select('phone')->where('id', $user_id)->first();
        return $user_info->phone;
    }




}


