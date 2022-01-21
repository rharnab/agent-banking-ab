<?php

namespace App\Http\Controllers\SelfRegistration;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CheckSelfRegistrationStatusController extends Controller
{

    public static  function checkSelfRequestCompleate($company_id, $user_id){
       
        $request_data_count = DB::table('self_registrations as sr')
        ->leftJoin('account_openings  as ao', 'sr.id' , '=', 'ao.self_registration_id')
        ->where('sr.company_id', $company_id)
        ->where('sr.requested_user_id', $user_id)
        ->count();


        if($request_data_count > 0){
            $request_data = DB::table('self_registrations as sr')
            ->select('sr.status as self_status', 'ao.status as account_opening_status')
            ->leftJoin('account_openings  as ao', 'sr.id' , '=', 'ao.self_registration_id')
            ->where('sr.company_id', $company_id)
            ->where('sr.requested_user_id', $user_id)
            ->first();

            

            if($request_data->self_status == 1){
                if($request_data->account_opening_status == 1){
                    return 'Your account opening request already pening.';
                }elseif($request_data->account_opening_status === 2){
                    return 'Your account opening request already approved.please login';
                }elseif($request_data->account_opening_status === 3){
                    return 'Your account opening request already decline.please login & resent request';
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }else{
            return false;
        }
    }


}
