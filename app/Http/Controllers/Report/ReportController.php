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



class ReportController extends Controller
{
    public function productlist(){
    	
    	 $infos = DB::table('products as p')
        ->select(
            'at.name as account_type',
            'p.name',
            'p.id',
            'p.code',
            'p.status'
        )
        ->leftJoin('account_types as at', 'p.account_type_id', 'at.id')
        ->where('p.company_id', Auth::user()->company_id)
        ->get();
        $data = [
            "infos" => $infos
        ];
      

    	return view('report/product_list_report', $data);

    }

    public function branchlist(){

    	$infos = DB::table('branches')->get();

    	// echo "<pre>";
    	// print_r($infos);
    	// die;
    	return view('report/brach_list_report', compact('infos'));
    }


    public function listofgl(){

        $accounts = DB::table('accounts as a')
                ->select('a.*','aa.name as parent_accont_name','at.name as account_type_name')
                ->leftJoin('accounts as aa', 'a.immediate_parent', 'aa.id')
                ->leftJoin('gl_account_types as at', 'a.acc_types', 'at.id')
                ->where('a.company_id', Auth::user()->company_id)
                ->orderBy('a.id','desc')
                ->get();     
        $data = [
            "accounts" => $accounts
        ];


        return view('report/list_of_gl', $data);
    }

    public function productMapping(){

        $maping_gls = DB::table('gl_mappings as gl')
        ->select(
            'gl.id',
            'a.name as account_name',
            'a.acc_code  as account_no',
            'p.name as product_name',
            'gl.status'
        )
        ->leftJoin('accounts as a','gl.account_id',  'a.id')
        ->leftJoin('products as p','gl.product_id',  'p.id')
        ->where('gl.company_id', Auth::user()->company_id)
        ->get();
        $data = [
            "maping_gls" => $maping_gls
        ];

        return view('report/product_mapping', $data);


    }

    public function user_list(){

         $users = DB::table('users')
        ->select([
            'users.id',
            'users.user_id',
            'users.name',
            'users.email',
            'users.phone',
            'users.created_at',
            'users.is_active',
            'branches.name as branch_name',
            'roles.name as role_name'            
        ])
        ->leftJoin('roles', 'users.role_id', 'roles.status')
        ->leftJoin('branches', 'users.branch_id', 'branches.id')
        ->where('users.company_id', Auth::user()->company_id)
        ->where('roles.company_id', Auth::user()->company_id)
        ->where('users.branch_id', '!=', 0)
        ->get();
        
        
        $data = [
            "users" => $users,
        ];

        return view('report/user_list', $data);
    }


    public function user_edit_log(){

        $users_edit_log = DB::table('user_modified_log')->get();

        // echo "<pre>";
        // print_r($users_edit_log);die;

        return view('report/user_edit_log',compact('users_edit_log'));

    }


    public function log_report()
    {
        return view('report.limit_log.modify_limit_rerport');
    }

    public function limit_report(Request $request)
    {
        $data = DB::select("SELECT a.name as agent_name, au.name as agent_user_name,lm.old_limit, lm.new_limit, 
                    lm.status, u.name crete_by, u2.name as approve_by, date(lm.created_at) as create_date , date(lm.approved_timestamp) as approve_date ,  lm.status
                    from agent_user_limit_modify_logs lm
                    left join agents a on a.id =  lm.agent_id 
                    left join agent_users au on au.id= lm.agent_user_id 
                    left join users u on u.id = lm.created_by 
                    left join users u2 on u2.id = lm.approved_by where date(lm.created_at) between '2020-01-01' and '2021-12-01' ");
        return view('report.limit_log.modify_log_report_info', compact('data'));
    }
}
