<?php

namespace App\Http\Controllers\report\commission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
class CommissionController extends Controller
{
    public function account_open()
    {

      $query =DB::table('agents')->select('name', 'id')->whereNotNull('name');
      $user_id =  Auth::user()->role_id;
      $agent_id = Auth::user()->agent_id;

      if($user_id == 1 || $user_id == 2)
      {
        
       $all_agents  =  DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
      }else{
        
        $all_agents = DB::table('agents')->select('name', 'id')->whereNotNull('name')->where('id', $agent_id)->OrderBy('name', 'ASC')->get();
      }

     
    	

     
         
    	return view('report.commission_report.account.account_open_commission', compact('all_agents', $all_agents));
    }

    public function show_account_open_commission(Request $request)
    {
       $agent_id =  $request->agent_id;
       $frm_date = date('Y-m-d', strtotime($request->frm_date));
       $to_date =date('Y-m-d', strtotime($request->to_date));

       if($agent_id !='')
       {
            $agent = "and a.id='$agent_id' ";
       }else{
         $agent = '';
       }

      $data = DB::select("SELECT sum(aoc.commission_amount) as t_commission_amt, count(aca.id) as t_transaction ,a.name as agent_name, p.name as commission_type_name, aoc.*  from agents a 
            left join agent_customer_accounts aca on aca.agent_id = a.id 
            left join products p on p.id = aca.product_code 
            left join account_open_commission aoc on aoc.commission_type = p.code
            where date(aca.created_at) between '$frm_date' and '$to_date' $agent
            group by aoc.commission_type");

    
                    

       return view('report.commission_report.account.show_account_commission_details', compact('data', $data));
    }

    public function acc_open_details()
    {
      $query =DB::table('agents')->select('name', 'id')->whereNotNull('name');
      $user_id =  Auth::user()->role_id;
      $agent_id = Auth::user()->agent_id;

      if($user_id == 1 || $user_id == 2)
      {
        
       $all_agents  =  DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
      }else{
        
        $all_agents = DB::table('agents')->select('name', 'id')->whereNotNull('name')->where('id', $agent_id)->OrderBy('name', 'ASC')->get();
      }
  
        return view('report.commission_report.account.commission_details', compact('all_agents', $all_agents));
    }

    public function acc_open_details_report(Request $request)
    {
       $agent_id =  $request->agent_id;
       $frm_date = date('Y-m-d', strtotime($request->frm_date));
       $to_date =date('Y-m-d', strtotime($request->to_date));

       if($agent_id !='')
       {
            $agent = "and a.id='$agent_id' ";
       }else{
         $agent = '';
       }

      $data = DB::select("SELECT aca.account_no, aca.account_name, a.name as agent_name, p.name as commission_type_name, aoc.*, date(aca.created_at) as creat_date, aca.created_by, u.name as user_name  from agents a 
            left join agent_customer_accounts aca on aca.agent_id = a.id 
            left join products p on p.id = aca.product_code 
            left join account_open_commission aoc on aoc.commission_type = p.code
            left join users u on u.id = aca.created_by 
            where date(aca.created_at) between '$frm_date' and '$to_date' $agent ");


       return view('report.commission_report.account.commission_details_report', compact('data', $data));


      }

    /*---------------------------------------------------------------------------------------------------------------------*/

    public function transaction_summary()
    {
      $query =DB::table('agents')->select('name', 'id')->whereNotNull('name');
      $user_id =  Auth::user()->role_id;
      $agent_id = Auth::user()->agent_id;

      if($user_id == 1 || $user_id == 2)
      {
        
       $all_agents  =  DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
      }else{
        
        $all_agents = DB::table('agents')->select('name', 'id')->whereNotNull('name')->where('id', $agent_id)->OrderBy('name', 'ASC')->get();
      }

       
        $products =DB::table('transaction_types')->select('name', 'code')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
         return view('report.commission_report.transaction.transaction_summary', compact('all_agents', 'products'));
    }

    public function transaction_summary_report(Request $request)
    {

       $agent_id =  $request->agent_id;
       $com_type = $request->commission_type;
       $frm_date = date('Y-m-d', strtotime($request->frm_date));
       $to_date =date('Y-m-d', strtotime($request->to_date));

       if($com_type !='')
       {
          $com_condition = "and tc.commission_type ='$com_type' ";
       }else{
          $com_condition = " ";
       }

       if($agent_id !='')
       {
            $agent = "and a.id='$agent_id' ";
       }else{
         $agent = '';
       }
       
       $data = DB::select("SELECT  au.name as agent_user_name ,a.name as agent_name, sum(tr.amount) as t_amount,
                      count(tr.id) as t_transaction, tt.name as transaction_type_name,
                      sum(tc.percentage__amount) as t_parcentage,
                      sum(tc.commission_amount) as t_commmison_amt
                      from (select *,
                      if(account_type=2 and transaction_type =1, cr_account_no , 
                        if(account_type =2 and transaction_type = 3, dr_account_no, 
                          if(account_type = 2 and transaction_type = 5, dr_account_no, '')
                        )
                      ) as account_no 
                      from transactions t ) as tr
                      left join agent_customer_accounts aca on tr.account_no=aca.account_no 
                      left join products p2 on aca.product_code = p2.id 
                      left join agents a on tr.agent_id = a.id
                      left join agent_users au on tr.agent_user_id = au.id
                      left join transaction_types tt on tr.transaction_type=tt.code
                      left join  transaction_commission tc on tt.code = tc.commission_type 
                      where date(tr.approved_timestamp) between '$frm_date' and '$to_date' $com_condition $agent
                      group  by tc.commission_type ");

       return view('report.commission_report.transaction.transaction_summary_report', compact('data')); 
    }

    public function transaction_details()
    {
      $query =DB::table('agents')->select('name', 'id')->whereNotNull('name');
      $user_id =  Auth::user()->role_id;
      $agent_id = Auth::user()->agent_id;

     if($user_id == 1 || $user_id == 2)
      {
        
       $all_agents  =  DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
      }else{
        
        $all_agents = DB::table('agents')->select('name', 'id')->whereNotNull('name')->where('id', $agent_id)->OrderBy('name', 'ASC')->get();
      }

         //$all_agents =DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
          $products =DB::table('transaction_types')->select('name', 'code')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
         return view('report.commission_report.transaction.transaction_details', compact('all_agents', 'products'));
    }

    public function transaction_details_report(Request $request)
    {
       $agent_id =  $request->agent_id;
       $com_type = $request->commission_type;
       $frm_date = date('Y-m-d', strtotime($request->frm_date));
       $to_date =date('Y-m-d', strtotime($request->to_date));

       if($agent_id !='')
       {
            $agent = "and a.id='$agent_id' ";
       }else{
         $agent = '';
       }

       if($com_type !='')
       {
          $com_condition = "and tc.commission_type ='$com_type' ";
       }else{
          $com_condition = " ";
       }

       
       $data= DB::select("SELECT tc.percentage__amount, date(tr.approved_timestamp) as approve_date, tr.amount,a.name  as agent_name,au.name as agent_user_name,p2.name as account_type,aca.account_name ,aca.account_no, tt.name  as transaction_types_name,tr.transaction_type, tc.commission_amount from (select *,
          if(account_type=2 and transaction_type =1, cr_account_no , 
            if(account_type =2 and transaction_type = 3, dr_account_no, 
              if(account_type = 2 and transaction_type = 5, dr_account_no, '')
            )
          ) as account_no 
          from transactions t ) as tr
          left join agent_customer_accounts aca on tr.account_no=aca.account_no 
          left join products p2 on aca.product_code = p2.id 
          left join agents a on tr.agent_id = a.id
          left join agent_users au on tr.agent_user_id = au.id
          left join transaction_types tt on tr.transaction_type=tt.code
          left join  transaction_commission tc on tt.code = tc.commission_type 
          where date(tr.approved_timestamp) between '$frm_date' and '$to_date' $agent $com_condition ");


       return view('report.commission_report.transaction.transaction_details_report', compact('data')); 
    }

   /* --------------------------------------------------------------------------------------------------------------------*/
    public function bill_summary()
    {
      $query =DB::table('agents')->select('name', 'id')->whereNotNull('name');
      $user_id =  Auth::user()->role_id;
      $agent_id = Auth::user()->agent_id;

     if($user_id == 1 || $user_id == 2)
      {
        
       $all_agents  =  DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
      }else{
        
        $all_agents = DB::table('agents')->select('name', 'id')->whereNotNull('name')->where('id', $agent_id)->OrderBy('name', 'ASC')->get();
      }

       
         return view('report.commission_report.bill.bill_summary', compact('all_agents'));
    }

     public function bill_summary_report(Request $request)
    {
       $agent_id =  $request->agent_id;
       $frm_date = date('Y-m-d', strtotime($request->frm_date));
       $to_date =date('Y-m-d', strtotime($request->to_date));

       if($agent_id !='')
       {
            $agent = "and a.id='$agent_id' ";
       }else{
         $agent = '';
       }
       
       return view('report.commission_report.bill.bill_summary_report'); 
    }

    public function bill_details()
    {
      $query =DB::table('agents')->select('name', 'id')->whereNotNull('name');
      $user_id =  Auth::user()->role_id;
      $agent_id = Auth::user()->agent_id;

     if($user_id == 1 || $user_id == 2)
      {
        
       $all_agents  =  DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
      }else{
        
        $all_agents = DB::table('agents')->select('name', 'id')->whereNotNull('name')->where('id', $agent_id)->OrderBy('name', 'ASC')->get();
      }

        
         return view('report.commission_report.bill.bill_details', compact('all_agents'));
    }

    public function bill_details_report(Request $request)
    {
       $agent_id =  $request->agent_id;
       $frm_date = date('Y-m-d', strtotime($request->frm_date));
       $to_date =date('Y-m-d', strtotime($request->to_date));

       if($agent_id !='')
       {
            $agent = "and a.id='$agent_id' ";
       }else{
         $agent = '';
       }
       
       return view('report.commission_report.bill.bill_details_report'); 
    }

    /*-----------------------------------------------------------------------------------------------------------------*/
     public function statement_summary()
    {
      $query =DB::table('agents')->select('name', 'id')->whereNotNull('name');
      $user_id =  Auth::user()->role_id;
      $agent_id = Auth::user()->agent_id;

      if($user_id == 1 || $user_id == 2)
      {
        
       $all_agents  =  DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
      }else{
        
        $all_agents = DB::table('agents')->select('name', 'id')->whereNotNull('name')->where('id', $agent_id)->OrderBy('name', 'ASC')->get();
      }

        //$all_agents =DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
         return view('report.commission_report.statement.statement_summary', compact('all_agents'));
    }

     public function statement_summary_report(Request $request)
    {
       $agent_id =  $request->agent_id;
       $frm_date = date('Y-m-d', strtotime($request->frm_date));
       $to_date =date('Y-m-d', strtotime($request->to_date));

       if($agent_id !='')
       {
            $agent = "and a.id='$agent_id' ";
       }else{
         $agent = '';
       }
       
       return view('report.commission_report.statement.statement_summary_report'); 
    }

    public function statement_details()
    {
      $query =DB::table('agents')->select('name', 'id')->whereNotNull('name');
      $user_id =  Auth::user()->role_id;
      $agent_id = Auth::user()->agent_id;

      if($user_id == 1 || $user_id == 2)
      {
        
       $all_agents  =  DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
      }else{
        
        $all_agents = DB::table('agents')->select('name', 'id')->whereNotNull('name')->where('id', $agent_id)->OrderBy('name', 'ASC')->get();
      }

         //$all_agents =DB::table('agents')->select('name', 'id')->whereNotNull('name')->OrderBy('name', 'ASC')->get();
         return view('report.commission_report.statement.statement_details', compact('all_agents'));
    }

    public function statement_details_report(Request $request)
    {
       $agent_id =  $request->agent_id;
       $frm_date = date('Y-m-d', strtotime($request->frm_date));
       $to_date =date('Y-m-d', strtotime($request->to_date));

       if($agent_id !='')
       {
            $agent = "and a.id='$agent_id' ";
       }else{
         $agent = '';
       }
       
       return view('report.commission_report.statement.statement_details_report'); 
    }

}
