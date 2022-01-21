<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AccountOpening;
use App\Models\GlMapping;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Exception;

class GlMappingController extends Controller
{
   
     /**
     * Check Authencticate user
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show ALl Product List
     *
     */
    public function index(){
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
        return view('super-admin.gl-mapping.index', $data);
    }


    /**
     * Redirect To add gl mapping page
     *
     */
    public function create(){
        $accounts = DB::table('accounts')->select('id', 'name')->where('company_id', Auth::user()->company_id)->where('status', 1)->get();
        $products = DB::table('products')->select('id', 'name')->where('company_id', Auth::user()->company_id)->where('status', 1)->get();
        $data     = [
            "accounts" => $accounts,
            "products" => $products,
        ];
        return view('super-admin.gl-mapping.create', $data);
    }


    
    /**
     * Store Gl Mapping
     *
     */
    public function store(Request $request){
        $gl_mapping             = new GlMapping();
        $gl_mapping->company_id = Auth::user()->company_id;
        $gl_mapping->product_id = $request->input('product_id');
        $gl_mapping->account_id = $request->input('account_id');
        $gl_mapping->status     = 0;
        $gl_mapping->created_by = Auth::user()->id;
        try{
            $gl_mapping->save();
            Toastr::success('GL Mapping Successfully','Success');
            return redirect()->route('gl_mapping.index');
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Failed');
            return redirect()->route('gl_mapping.create');
        }
    }

    /**
     * Show all pending gl
     *
     */
    public function pending(){
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
        ->where('gl.created_by', '<>', Auth::user()->id)
        ->where('gl.status', 0)
        ->get();
        $data = [
            "maping_gls" => $maping_gls
        ];
        return view('super-admin.gl-mapping.pending', $data);
    }


    public function authorizeGlMapping(Request $request, $id){
        try{
            DB::table('gl_mappings')->where('company_id', Auth::user()->company_id)->where('id', $id)->update([
                "status"             => 1,
                "approved_by"        => Auth::user()->id,
                "approved_timestamp" => date('Y-m-d H:i:s')
            ]);
            Toastr::success('GL Mapping Autorization Successfully','Success');
            return redirect()->route('gl_mapping.pending');
            
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Error');
            return redirect()->route('gl_mapping.pending');
        }
    }


}
