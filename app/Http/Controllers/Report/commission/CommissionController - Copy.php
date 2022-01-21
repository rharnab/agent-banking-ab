<?php

namespace App\Http\Controllers\report\commission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CommissionControl666ler extends Controller
{
    public function account_open()
    {
    	

	 $data = DB::Select('SELECT * FROM `agent_customer_accounts` 
		LEFT JOIN account_open_types on account_open_types.id = agent_customer_accounts.product_code
		LEFT JOIN comissions on comissions.commission_trn_type = account_open_types.code
		WHERE comissions.commission_type=1');

    	return view('report.commission_report.account_open_commission', compact('data', $data));
    }

    public function transaction()
    {
    	
    	
	 $data = DB::Select('SELECT * FROM `agent_customer_accounts` 
		LEFT JOIN account_open_types on account_open_types.id = agent_customer_accounts.product_code
		LEFT JOIN comissions on comissions.commission_trn_type = account_open_types.code
		WHERE comissions.commission_type=2');

    	return view('report.commission_report.transaction_commission', compact('data', $data));
    }
    public function bill()
    {
    	
    	
	 $data = DB::Select('SELECT * FROM `agent_customer_accounts` 
		LEFT JOIN account_open_types on account_open_types.id = agent_customer_accounts.product_code
		LEFT JOIN comissions on comissions.commission_trn_type = account_open_types.code
		WHERE comissions.commission_type=3');

    	return view('report.commission_report.bill_collection_commission', compact('data', $data));
    }
    public function statement()
    {
    	
    	
	 $data = DB::Select('SELECT * FROM `agent_customer_accounts` 
		LEFT JOIN account_open_types on account_open_types.id = agent_customer_accounts.product_code
		LEFT JOIN comissions on comissions.commission_trn_type = account_open_types.code
		WHERE comissions.commission_type=4');

    	return view('report.commission_report.statement_commission', compact('data', $data));
    }

}
