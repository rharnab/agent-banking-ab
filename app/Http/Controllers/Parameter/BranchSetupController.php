<?php

namespace App\Http\Controllers\Parameter;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class BranchSetupController extends Controller
{
     // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }


    // Show All Roles

    public function index(){
        $branches = Branch::get();
        $data = [
            "branches" => $branches
        ];
        return view('parameter-setup.branch.index', $data);
    }


     // Redirect To Branch Create Page

    public function create(){
        return view("parameter-setup.branch.create");
    }


    
    // Store New Branch

    public function store(Request $request){
        $name           = $request->input('name');
        $address        = $request->input('address');
        $br_code        = $request->input('br_code');
        $branch_code    = $request->input('branch_code');
        $routing_number = $request->input('routing_number');

        $branch                 = new Branch();
        $branch->name           = $request->input('name');
        $branch->address        = $request->input('address');
        $branch->country_code   = '20';
        $branch->br_code        = $request->input('br_code');
        $branch->branch_code    = $request->input('branch_code');
        $branch->routing_number = $request->input('routing_number');
        $branch->company_id     = Auth::user()->company_id;
        $branch_store           = $branch->save();
        if($branch_store){
            Toastr::success('Branch Created Successfully','Success');
            return redirect()->route('parameter.branch.index');
        }else{
            Toastr::error('Branch Created Failed','Failed');
            return redirect()->route('parameter.branch.index');
        }
    }



    // Go to edit page with branch information

    public function edit($id){
        $branch = Branch::find($id);
        $data = [
            "branch" => $branch
        ];
        return view('parameter-setup.branch.edit', $data);
    }


       
    // Update Role 

    public function update(Request $request, $id){    
        $branch = Branch::find($id);
        $branch->name           = $request->input('name');
        $branch->address        = $request->input('address');
        $branch->country_code   = '20';
        $branch->br_code        = $request->input('br_code');
        $branch->branch_code    = $request->input('branch_code');
        $branch->routing_number = $request->input('routing_number');
        $branch->company_id     = Auth::user()->company_id;
        $branch_store           = $branch->save();
        if($branch_store){
            Toastr::success('Branch Update Successfully','Success');
            return redirect()->route('parameter.branch.index');
        }else{
            Toastr::error('Branch Update Failed','Failed');
            return redirect()->route('parameter.branch.index');
        }
    }


    
    // Delete Role

    public function delete($id){
        $delete = Branch::destroy($id);
        if($delete){
            Toastr::success('Branch Delete Successfully :)','Success');
            return redirect()->route('parameter.branch.index');
        }else{
            Toastr::error('Branch Delete Failed :)','Failed');
            return redirect()->route('parameter.branch.index');
        }
        
    }







}
