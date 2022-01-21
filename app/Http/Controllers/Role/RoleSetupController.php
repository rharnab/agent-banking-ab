<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\User;
use Brian2694\Toastr\Facades\Toastr;


class RoleSetupController extends Controller
{
    // Check Authencticate user
    public function __construct()
    {
        $this->middleware('auth');
    }


    // Show All Roles
    public function index(){
        $roles = Role::where('company_id', Auth::user()->company_id)->get();
        $data = [
            "roles" => $roles
        ];
        return view("role.index", $data);
    }


    // Create New Roles
    public function create(){
        return view("role.create");
    }


    // Store New Role
    public function store(Request $request){

        if($request->has('name') && $request->has('status')){
            $name   = $request->input('name');
            $status = $request->input('status');
            
            // data insert into the role table
            $role                  = new Role();
            $role->name            = $name;
            $role->status          = $status;
            $role->company_id      = Auth::user()->company_id;
            $role->created_user_id = Auth::user()->id;
            if($role->save()){
                Toastr::success('Role Created Successfully','Success');
                return redirect()->route('role.index');
            }else{
                Toastr::error('Role Created Failed','Failed');
                return redirect()->route('role.create');
            }
        }
    }


    
    // Go to edit page with role information
    public function edit($id){
        $role = Role::find($id);
        $data = [
            "role" => $role
        ];
        return view('role.edit', $data);
    }


        
    // Update Role 
     public function update(Request $request, $id){        
        $name   = $request->input('name');
        $status = $request->input('status');

        $role = Role::find($id);
        $role->name            = $name;
        $role->status          = $status;
        $role->company_id      = Auth::user()->company_id;
        $role->created_user_id = Auth::user()->id;
        if($role->save()){
            Toastr::success('Role Update Successfully','Success');
            return redirect()->route('role.index');
        }else{
            Toastr::error('Role Update Failed','Failed');
            return redirect()->route('role.create');
        }
    }


    // Delete Role
    public function delete($id){
        if($this->checkAlreadyUse($id) === true){
            Toastr::error('This role alreay use','Failed');
            return redirect()->route('role.index');
        }else{
            $delete = Role::destroy($id);
            if($delete){
                Toastr::success('Role Delete Successfully :)','Success');
                return redirect()->route('role.index');
            }else{
                Toastr::error('Role Delete Failed :)','Failed');
                return redirect()->route('role.index');
            }
        }
        
    }


    public function checkAlreadyUse($id){
        $role         = Role::find($id);
        $role_status  = $role->status;
        $already_user = User::where('role_id', $role_status)->where('company_id', Auth::user()->company_id)->get();
        if($already_user->count() > 0){
            return true;
        }else{
            return false;
        }
    }




}
