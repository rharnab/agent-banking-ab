<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use App\Models\EcActualLog;
use App\Models\EcAllLog;
use App\Models\SelfRegistration;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Sms;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function sendMail($from_mail, $to_mail, $name, $subject, $body){ 
        return true;
        $data = [
            'from_mail' => $from_mail,
            'to_mail'   => $to_mail,
            'name'      => $name,
            'subject'   => $subject,
            'body'      => $body
        ];

        Mail::send('emails.template',$data,function($mail) use ($data) {
            $mail->from($data['from_mail']);
            $mail->to($data['to_mail']);
            $mail->subject($data['subject']);
        });        
        return true;
    }
    
    
   
    public function sendSMS($otp, $phone, $company_id, $user_id, $message){

     
        $message  = urlencode($message);
        $endpoint = "https://powersms.banglaphone.net.bd/httpapi/sendsms?userId=SBACBL&password=sbacbl1&smsText={$message}&commaSeperatedReceiverNumbers={$phone}";
        file_put_contents("end.txt", $endpoint."\n", FILE_APPEND);
        
        $curl     = curl_init();

        
        curl_setopt_array($curl, array(
            CURLOPT_URL            => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
          ));

        try{
            $response = curl_exec($curl);

            curl_close($curl);

            $sms             = new Sms();
            $sms->company_id = $company_id;
            $sms->user_id    = $user_id;
            $sms->request    = $message." phone-no: ". $phone;
            $sms->response   = json_encode($response);
            try{
                $sms->save();
                return true;
            }catch(Exception $e){
                return false;
            } 
        }catch(Exception $e){
            file_put_contents("sms_error.txt", $e->getMessage()."\n", FILE_APPEND);
            return false;
        }

    }


    public function ecActualCallLog($company_id, $user_id, $nid_number, $response){
        $ec_actual_log = new EcActualLog();
        $ec_actual_log->company_id  = $company_id;
        $ec_actual_log->user_id   = $user_id;
        $ec_actual_log->nid_number   = $nid_number;
        $ec_actual_log->response   = $response;
        $save_actual_log = $ec_actual_log->save();
        if($save_actual_log){
            if($this->ecAllLog($company_id, $user_id, $nid_number, $response) === true){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function ecAllLog($company_id, $user_id, $nid_number, $response){
        $ec_all_log = new EcAllLog();
        $ec_all_log->company_id   = $company_id;
        $ec_all_log->user_id    = $user_id;
        $ec_all_log->nid_number   = $nid_number;
        $ec_all_log->response   = $response;
        $ec_all_log = $ec_all_log->save();
        if($ec_all_log){
            return true;
        }
        return false;
    }


    public function userSelfRequestStatus($company_id, $user_id){
        $request_count = SelfRegistration::where('company_id', $company_id)->where('requested_user_id', $user_id)->count();
        if($request_count == 0){
            return false;
        }
        $info = DB::table('self_registrations')
        ->select('status')
        ->where('company_id', $company_id)
        ->where('requested_user_id', $user_id)
        ->first();
        if($info->status == 1){
            $data = [
                "status" => 201,
                "message" => "already account opening request",
                "data" => [
                    "message" => "your account opening request has been pending.Bank authority will contact as soon as possible"
                ]
            ];
            return response()->json($data);
        }elseif($info->status == 2){
            $data = [
                "status" => 201,
                "message" => "account opening requst already approved",
                "data" => [
                    "message" => "your account opening request has been already approved."
                ]
            ];
            return response()->json($data);
        }elseif($info->status == 3){
            $data = [
                "status" => 201,
                "message" => "account opening requst decline",
                "data" => [
                    "message" => "your account opening request has been already declined."
                ]
            ];
            return response()->json($data);
        }else{
            return false;
        }
    }





}


