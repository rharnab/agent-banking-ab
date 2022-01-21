<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountOpening;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Exception;


class AccountController extends Controller
{
    public function accountlist(){
		$agent_id = Auth::user()->agent_id;
		$infos = DB::select(DB::RAW("select at2.name as account_name, p.name as product_name, aca.account_name as account_title , aca.account_no,aca.created_at from agent_customer_accounts aca 
		left join account_types at2 on aca.account_type_id =at2.id
		left join products p  on aca.product_code = p.id
		where agent_id = '$agent_id'
		"));

		$data = [
			"infos" => $infos
		];
    	return view('account.account_list', $data);

    }
}
