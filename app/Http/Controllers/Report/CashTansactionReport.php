<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\AccountOpening;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Exception;


class CashTansactionReport extends Controller
{
    public function dateRangeStatement(){
        $agent_id = Auth::user()->agent_id;
        $datas = DB::select(DB::RAW("select dr_account_id,dr_amount,cr_account_id,cr_amount,tr.created_at  from agent_customer_accounts aca 
        inner join transactions tr on aca.account_no = tr.dr_account_id or  aca.account_no = tr.cr_account_id
        where aca.agent_id=$agent_id"));
        $data  = [
            "datas" => $datas
        ];
        return view('agent-user.report.cash.date-range.index', $data);
    }
}
