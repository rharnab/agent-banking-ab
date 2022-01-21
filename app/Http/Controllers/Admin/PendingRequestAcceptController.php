<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentCustomerAccount;
use App\Models\Customer;
use App\Models\Face;
use App\Models\Score;
use App\Models\VerifiedCustomer;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Exception;

class PendingRequestAcceptController extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Pending Customer Authorize

    public function acceptPendingRequest($id){
        $request_info = DB::table('branch_registrations as br')
        ->where('br.id', $id)
        ->first();
        $data = [
            "request_info" => $request_info
        ];
       
        $user                    = new User();
        $user->user_id           = strtolower(str_replace(" ",".", $request_info->en_name));
        $user->name              = $request_info->en_name;
        $user->password          = Hash::make('12345678');
        $user->phone             = $request_info->mobile_number;
        $user->is_active         = 1;
        $user->company_is_active = 1;
        $user->created_user_id   = Auth::user()->id;
        $user->company_id         = $request_info->company_id;
        $user->branch_id         = $request_info->branch_id;
        $user->role_id           = 4;
        $user_saved = $user->save();
        if($user_saved){
            $user_id = $user->id;

            // customer crate
            $customer = new Customer();
            $customer->company_id            = $request_info->company_id;
            $customer->user_id               = $user_id;
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
            $customer->is_self_request       = 0;
            $customer->accepted_user_id      = Auth::user()->id;
            $customer->accepted_timestamp    = date('Y-m-d H:i:s');
            $save_customer = $customer->save();
            if($save_customer){
                $customer_id = $customer->id;

                // add data into faces table 
                $face = new Face();
                $face->customer_id                         = $customer_id;
                $face->webcam_face_image                   = $request_info->webcam_face_image;
                $face->nid_and_webcam_recognize_percentage = $request_info->nid_and_webcam_recognize_percentage;
                $face->ec_and_webcam_recognize_percentage  = $request_info->ec_and_webcam_recognize_percentage;
                $face->face_verification                   = $request_info->face_verification;
                $face_saved = $face->save();

                if($face_saved){
                    $score                                      = new Score();
                    $score->customer_id                         = $customer_id;
                    $score->ecdata_id                           = $this->getEcID($request_info->nid_number);
                    $score->bn_name_percentage                  = $request_info->bn_name_percentage;
                    $score->en_name_percentage                  = $request_info->en_name_percentage;
                    $score->father_name_percentage              = $request_info->father_name_percentage;
                    $score->mother_name_percentage              = $request_info->mother_name_percentage;
                    $score->address_percentage                  = $request_info->address_percentage;
                    $score->date_of_birth_percetage             = $request_info->date_of_birth_percetage;                
                    $score->nid_and_webcam_recognize_percentage = $request_info->nid_and_webcam_recognize_percentage;
                    $score->ec_and_webcam_recognize_percentage  = $request_info->ec_and_webcam_recognize_percentage;
                    $score->text_maching_score                  = $request_info->text_maching_score;
                    $score->user_id                             = Auth::user()->id;
                    $score_saved = $score->save();

                    if($score_saved){
                        $verified_customer                = new VerifiedCustomer();
                        $verified_customer->company_id    = $request_info->company_id;
                        $verified_customer->customer_id   = $customer_id;
                        $verified_customer->mobile_number = $request_info->mobile_number;
                        $verified_customer->nid_number    = $request_info->nid_number;    
                        $verified_customer_saved = $verified_customer->save();
                        if($verified_customer_saved){

                            if($this->createAccountInfo($id, $customer_id) == true){
                                $updated = DB::table('branch_registrations')->where('id', $id)->update([
                                    "status" => 2
                                ]);
                                if($updated){
    
    
                                    $updated = DB::table('account_openings')->where('branch_registraion_id', $id)->update([
                                        "status" => 2
                                    ]);
    
                                    
                                    Toastr::success('Customer Authorize Successfully :)','Success');
                                    return redirect()->back();
                                }else{
                                    Toastr::error('Customer Authorize Failed :)','Failed');
                                    return redirect()->back();
                                }
                            }else{
                                Toastr::error('Account Information create failed :)','Failed');
                                return redirect()->back();
                            }
                           
                           
                        }else{
                            Toastr::error('Verifieed Customer List Added Failed :)','Failed');
                            return redirect()->back();
                        }
                    }else{
                        Toastr::error('Score Save Failed :)','Failed');
                        return redirect()->back();
                    }

                }else{
                    Toastr::error('Face Data Creation Failed :)','Failed');
                    return redirect()->back();
                }

            }else{
                Toastr::error('Customer Creation Failed :)','Failed');
                return redirect()->back();
            }

        }else{
            Toastr::error('User Registration Failed :)','Failed');
            return redirect()->back();
        }     

    }



    private function getEcID($nid_number){
        $ec_info = DB::table('ecs')->select('id')->where('nid_number', $nid_number)->first();
        return $ec_info->id;
    }



    private function createAccountInfo($branch_request_id, $customer_id){
        $request_info = DB::table('branch_registrations as br')
        ->select(
            'br.company_id', 
            'ao.agent_id',
            'ao.agent_user_id',
            'br.id as branch_registration_id',
            'ao.id as acccount_opening_id',
            'ao.account_type_code',
            'ao.product_code',
            'ao.account_title'
        )
        ->leftJoin('account_openings as ao', 'br.id', '=', 'ao.branch_registraion_id')
        ->where('br.id', $branch_request_id)
        ->where('br.company_id', Auth::user()->company_id)
        ->first();

        $customer_info = DB::table('customers as  c')
        ->select(
            's.id as score_id', 
            'f.id as face_id'
        )
        ->leftJoin('scores as s', 'c.id' , 's.customer_id' )
        ->leftJoin('faces as f', 'c.id' , 'f.customer_id' )
        ->where('c.id', $customer_id)
        ->where('c.company_id', Auth::user()->company_id)
        ->first();

        $data = [
            "request_info" => $request_info,
            "customer_info" => $customer_info,
        ];

       $max_serial =  $this->maximumAccountSerial($request_info->product_code);

        $agent_customer_account                         = new AgentCustomerAccount();
        $agent_customer_account->company_id             = Auth::user()->company_id;
        $agent_customer_account->agent_id               = $request_info->agent_id;
        $agent_customer_account->agent_user_id          = $request_info->agent_user_id;
        $agent_customer_account->branch_registration_id = $request_info->branch_registration_id;
        $agent_customer_account->account_opening_id     = $request_info->acccount_opening_id;
        $agent_customer_account->customer_id            = $customer_id;
        $agent_customer_account->score_id               = $customer_info->score_id;
        $agent_customer_account->face_id                = $customer_info->face_id;
        $agent_customer_account->account_type_id        = $request_info->account_type_code;
        $agent_customer_account->product_code           = $request_info->product_code;
        $agent_customer_account->serial                 = $max_serial;
        $agent_customer_account->account_no             = $this->createAccountNumber($request_info->agent_id, $request_info->product_code, $max_serial);
        $agent_customer_account->account_name           = $request_info->account_title;
        $agent_customer_account->created_by             = Auth::user()->id;

        try{
            $agent_customer_account->save();
            return true;
        }catch(Exception $e){
            file_put_contents("sadfa.txt",$e->getMessage());
            return false;
        }
    }



    private function maximumAccountSerial($product_code){
        $max_acc_code = DB::table('agent_customer_accounts')->select('serial')->where('serial', DB::raw("(select max(`serial`) from agent_customer_accounts where product_code='$product_code' limit 1)"))->first();
     
        $account_code = $max_acc_code->serial ?? 100000;
        return $account_code + 1;
    }


    private function createAccountNumber($agent_id, $product_code, $max_serial){
        $info = DB::table('agents as a')
        ->select(
            'b.routing_number'
        )
        ->leftJoin('branches as b', 'a.branch_id', 'b.id')
        ->where('a.id', $agent_id)
        ->first();
        $prodcut_code = DB::table('products')->select('code')->where('id', $product_code)->first();
        $routing_no = $info->routing_number;
        $account_code = substr($routing_no, 0,4).$prodcut_code->code.$max_serial;
        return $account_code;
    }





}
