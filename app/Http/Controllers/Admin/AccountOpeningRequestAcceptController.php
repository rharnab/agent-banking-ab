<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Face;
use App\Models\Score;
use App\Models\VerifiedCustomer;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;


class AccountOpeningRequestAcceptController extends Controller
{
   // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }


    // Accept Account Opening Request

    public function acceptAccountOpeningRequest($id){
        $request_info = DB::table('self_registrations as sr')
        ->select(
            'sr.id',
            'sr.company_id',
            'sr.requested_user_id',
            'sr.nid_front_image',
            'sr.nid_back_image',
            'sr.front_data',
            'sr.back_data',
            'sr.bn_name',
            'sr.en_name',
            'sr.father_name',
            'sr.mother_name',
            'sr.date_of_birth',
            'sr.nid_number',
            'sr.mobile_number',
            'sr.present_address',
            'sr.permanent_address',
            'sr.blood_group',
            'sr.place_of_birth',
            'sr.issue_date',
            'sr.nid_unique_data',
            'sr.step_compleate_status',
            'sr.webcam_face_image',
            'sr.nid_and_webcam_recognize_percentage',
            'sr.ec_and_webcam_recognize_percentage',
            'sr.face_verification',
            'ecs.name',
            'ecs.nameEn',
            'ecs.father',
            'ecs.mother',
            'ecs.dob',
            'ecs.permanentAddress',
            'ecs.id as ec_id',
            'ao.branch_id',
            'ao.id as account_opening_id'
        )
        ->leftJoin('ecs as ecs', 'sr.nid_number', 'ecs.nid_number')
        ->leftJoin('account_openings as ao', 'sr.id', 'ao.self_registration_id')
        ->where('sr.id' , $id)
        ->first();
        
        // add new customer with this user
        $customer                        = new Customer();
        $customer->company_id            = $request_info->company_id;
        $customer->user_id               = $request_info->requested_user_id;
        $customer->nid_front_image       = $request_info->nid_front_image;
        $customer->nid_back_image        = $request_info->nid_back_image;
        $customer->front_data            = $request_info->front_data;
        $customer->back_data             = $request_info->back_data;
        $customer->bn_name               = $request_info->bn_name;
        $customer->en_name               = $request_info->en_name;
        $customer->father_name           = $request_info->father_name;
        $customer->mother_name           = $request_info->mother_name;
        $customer->date_of_birth         = $request_info->date_of_birth;
        $customer->nid_number            = $request_info->nid_number;
        $customer->mobile_number         = $request_info->mobile_number;
        $customer->present_address       = $request_info->present_address;
        $customer->permanent_address     = $request_info->permanent_address;
        $customer->blood_group           = $request_info->blood_group;
        $customer->place_of_birth        = $request_info->place_of_birth;
        $customer->issue_date            = $request_info->issue_date;
        $customer->nid_unique_data       = $request_info->nid_unique_data;
        $customer->step_compleate_status = $request_info->step_compleate_status;
        $customer->status                = 1;
        $customer->is_self_request       = 1;
        $customer->self_request_id       = $request_info->id;
        $customer->accepted_user_id      = Auth::user()->id;
        $customer->accepted_timestamp    = date('Y-m-d H:i:s');
        $save_customer = $customer->save();
        if($save_customer){
            // add data into the face table
            $customer_id                               = $customer->id;
            $face                                      = new Face();
            $face->customer_id                         = $customer_id;
            $face->webcam_face_image                   = $request_info->webcam_face_image;
            $face->nid_and_webcam_recognize_percentage = $request_info->nid_and_webcam_recognize_percentage;
            $face->ec_and_webcam_recognize_percentage  = $request_info->ec_and_webcam_recognize_percentage;
            $face->face_verification                   = $request_info->face_verification;
            $face_saved = $face->save();
            if($face_saved){
                // score store
                similar_text(strtolower($request_info->name), strtolower($request_info->bn_name), $bn_name_percentage);
                similar_text(strtolower($request_info->nameEn), strtolower($request_info->en_name), $en_name_percentage);
                similar_text(strtolower($request_info->father), strtolower($request_info->father_name), $father_name_percentage);
                similar_text(strtolower($request_info->mother), strtolower($request_info->mother_name), $mother_name_percentage);
                similar_text(strtolower($request_info->dob), strtolower($request_info->date_of_birth), $date_of_birth_percentage);
                similar_text(strtolower($request_info->permanentAddress), strtolower($request_info->present_address), $address_percentage);
                $text_meching_score = ($bn_name_percentage + $en_name_percentage + $father_name_percentage + $mother_name_percentage + $date_of_birth_percentage + $address_percentage ) / 2;

                $score                                      = new Score();
                $score->customer_id                         = $customer_id;
                $score->ecdata_id                           = $request_info->ec_id;
                $score->bn_name_percentage                  = number_format($bn_name_percentage, 2);
                $score->en_name_percentage                  = number_format($en_name_percentage, 2);
                $score->father_name_percentage              = number_format($father_name_percentage, 2);
                $score->mother_name_percentage              = number_format($mother_name_percentage, 2);
                $score->address_percentage                  = number_format($address_percentage, 2);
                $score->date_of_birth_percetage             = number_format($date_of_birth_percentage, 2);                
                $score->nid_and_webcam_recognize_percentage = $request_info->nid_and_webcam_recognize_percentage;
                $score->ec_and_webcam_recognize_percentage  = $request_info->ec_and_webcam_recognize_percentage;
                $score->text_maching_score                  = number_format($text_meching_score , 2);
                $score->user_id                             = Auth::user()->id;
                $score_saved = $score->save();
                if($score_saved){
                    // save user with verified customer list
                    $verified_customer                = new VerifiedCustomer();
                    $verified_customer->company_id    = $request_info->company_id;
                    $verified_customer->customer_id   = $customer_id;
                    $verified_customer->mobile_number = $request_info->mobile_number;
                    $verified_customer->nid_number    = $request_info->nid_number;

                    $verified_customer_saved = $verified_customer->save();
                    if($verified_customer_saved){
                        $user                    = User::find($request_info->requested_user_id);
                        $user->user_id           = strtolower(str_replace(" ",".", $request_info->en_name));
                        $user->name              = $request_info->en_name;
                        $user->password          = Hash::make('12345678');
                        $user->is_active         = 1;
                        $user->company_is_active = 1;
                        $user->created_user_id   = Auth::user()->id;
                        $user->branch_id         = $request_info->branch_id;
                        $user_saved = $user->save();
                        if($user_saved){
                            if($this->updateAccountOpeningRequest($request_info->account_opening_id) === true){
                                if($this->updateSelfRegistration($request_info->id) === true){
                                    Toastr::success('Account opening request approved successfully :)','Success');
                                    return redirect()->back();
                                }else{
                                    Toastr::error('Account opening request approved faield.)','Failed');
                                    return redirect()->back();
                                }
                            }else{
                                Toastr::error('Account opening request approved faield :::::)','Failed');
                                return redirect()->back(); 
                            }
                        }else{
                            Toastr::error('Account opening request approved faield ::::)','Failed');
                            return redirect()->back();
                        }
                    }

                }else{
                    Toastr::error('Account opening request approved faield :::)','Failed');
                    return redirect()->back();
                }
            }else{
                Toastr::error('Account opening request approved faield ::)','Failed');
                return redirect()->back();
            }
        }else{
            Toastr::error('Account opening request approved faield :)','Failed');
            return redirect()->back();
        }


    }



    // Update Account Opening Request

    public function updateAccountOpeningRequest($id){
        $update = DB::table('account_openings')->where('id', $id)->update([
            "status" => 2
        ]);
        if($update){
            return true;
        }else{
            return false;
        }
    }

    // Update Self Registration 

    public function updateSelfRegistration($id){
        $update = DB::table('self_registrations')->where('id', $id)->update([
            "status" => 2
        ]);
        if($update){
            return true;
        }else{
            return false;
        }
    }







}
