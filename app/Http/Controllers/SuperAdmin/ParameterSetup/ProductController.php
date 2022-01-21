<?php

namespace App\Http\Controllers\SuperAdmin\ParameterSetup;

use App\Http\Controllers\Controller;
use App\Models\AccountOpening;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Exception;

class ProductController extends Controller
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
        return view('super-admin.paramete-setup.product.index', $data);
    }

    /**
     * Redirect To product create page
     *
     */
    public function create(){
        $account_types = DB::table('account_types')->where('company_id', Auth::user()->company_id)->get();
        $data = [
            "account_types" => $account_types
        ];
        return view('super-admin.paramete-setup.product.create', $data);
    }


    /**
     * Store Product
     *
     */
    public function store(Request $request){
        $product                  = new Product();
        $product->company_id      = Auth::user()->company_id;
        $product->account_type_id = $request->input('account_type_id');
        $product->code            = $request->input('code');
        $product->name            = $request->input('name');
        $product->status          = 0;
        $product->created_by      = Auth::user()->id;
        try{
            $product->save();
            Toastr::success('Product Created Successfully','Success');
            return redirect()->route('product.parament_setup.index');
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Failed');
            return redirect()->route('product.parament_setup.create');
        }
    }


    public function pending(){
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
        ->where('p.status', 0)
        ->get();
        $data = [
            "infos" => $infos
        ];
        return view('super-admin.paramete-setup.product.pending', $data);
    }


    public function authorizeProduct(Request $request, $id){
        try{
            DB::table('products')->where('company_id', Auth::user()->company_id)->where('id', $id)->update([
                "status"             => 1,
                "approved_by"        => Auth::user()->id,
                "approved_timestamp" => date('Y-m-d H:i:s')
            ]);
            Toastr::success('Product Autorization Successfully','Success');
            return redirect()->route('product.parament_setup.pending');
            
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Error');
            return redirect()->route('product.parament_setup.pending');
        }
    }



}
