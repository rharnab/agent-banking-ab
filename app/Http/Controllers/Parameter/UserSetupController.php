<?php

namespace App\Http\Controllers\Parameter;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserSetupController extends Controller
{
    // Check Authencticate user

    public function __construct()
    {
        $this->middleware('auth');
    }

     // Show All Roles
     
    public function index(){

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
        return view('parameter-setup.user.index', $data);
    }


    // Redirect To User Create Page
     
    public function create(){
        $branches = Branch::where('company_id', Auth::user()->company_id)->where('id', 1)->get();
        $roles = Role::where('company_id', Auth::user()->company_id)->whereIn('id', [1,2])->get();
        $data = [
            "branches" => $branches,
            "roles"    => $roles,
        ];
        return view("parameter-setup.user.create", $data);
    }


     // Store New User
     
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|unique:users',
            'role_id'   => 'required',
            'name'      => 'required',
            'email'     => 'required',
            'phone'     => 'required|unique:users',
            'branch_id' => 'required',
        ],[
            'user_id.required'   => 'please write user id',
            'role_id.required'   => 'please select user access label',
            'name.required'      => 'please write user name',
            'email.required'     => 'please enter user email address',
            'email.unique'       => 'email has already exists',
            'phone.required'     => 'please enter user mobile number',
            'phone.unique'       => 'mobile number already exists',
            'branch_id.required' => 'please select branch',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user                    = new User();
        $user->user_id           = $request->input('user_id');
        $user->company_id        = Auth::user()->company_id;
        $user->role_id           = $request->input('role_id');
        $user->name              = $request->input('name');
        $user->email             = $request->input('email');
        $user->phone             = $request->input('phone');
        $user->password          =  Hash::make('12345678');
        $user->is_active         = 0;
        $user->company_is_active = Auth::user()->company_is_active;
        $user->created_user_id   = Auth::user()->id;
        $user->branch_id         = $request->input('branch_id');
        $saved_user = $user->save();
        if($saved_user){
                Toastr::success('User Created Successfully.','Success');
                return redirect()->route('parameter.user.index');
        }else{
                Toastr::error('User Created Failed','Failed');
                return redirect()->route('parameter.user.index');
        }
    }


    // Go to edit page with user information
     
    public function edit($id){
        $user     = User::find($id);
        $roles    = Role::where('company_id', Auth::user()->company_id)->get();
        $branches = Branch::where('company_id', Auth::user()->company_id)->get();
        $data     = [
            "user"     => $user,
            "roles"    => $roles,
            "branches" => $branches
        ];
        return view('parameter-setup.user.edit', $data);
    }


        
    // Update User 
     

    public function update(Request $request, $id){    

        $validator = Validator::make($request->all(), [
            'user_id'   => 'required',
            'role_id'   => 'required',
            'name'      => 'required',
            'email'     => 'required|unique:users,email,'.$id,
            'phone'     => 'required|unique:users,phone,'.$id,
            'branch_id' => 'required',
        ],[
            'user_id.required'   => 'please write user id',
            'role_id.required'   => 'please select user access label',
            'name.required'      => 'please write user name',
            'email.required'     => 'please enter user email address',
            'email.unique'       => 'email has already exists',
            'phone.required'     => 'please enter user mobile number',
            'phone.unique'       => 'mobile number already exists',
            'branch_id.required' => 'please select branch',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user                    = User::find($id);

        $old_user_id = $user->user_id;
        $old_name = $user->name;
        $old_email = $user->email;
        $old_mobile = $user->phone;
        $old_role_id = $user->role_id;
        $old_branch_id = $user->branch_id;

        $user->user_id           = $request->input('user_id');
        $user->company_id        = Auth::user()->company_id;
        $user->role_id           = $request->input('role_id');
        $user->name              = $request->input('name');
        $user->email             = $request->input('email');
        $user->phone             = $request->input('phone');
        $user->is_active         = 0;
        $user->company_is_active = Auth::user()->company_is_active;
        $user->created_user_id   = Auth::user()->id;
        $user->branch_id         = $request->input('branch_id');
        $updated_user            = $user->save();

        DB::table('user_modified_log')->insert([

            'old_user_id'=> $old_user_id,
            'old_name'=>$old_name,
            'old_email'=>$old_email,
            'old_mobile'=>$old_mobile,
            'old_role'=>$old_role_id,
            'old_branch'=>$old_branch_id,

            'new_user_id'=>$user->user_id ,
            'new_name' => $user->name ,
            'new_email' => $user->email ,
            'new_mobile' => $user->phone ,
            'new_role'=> $user->role_id,
            'new_branch'=>  $user->branch_id

        ]);

        if($updated_user){
            Toastr::success('User Updated Successfully.','Success');
            return redirect()->route('parameter.user.index');
        }else{
            Toastr::error('User Updated Failed','Failed');
            return redirect()->route('parameter.user.index');
        }
    }


     
    // Delete Role
     
    public function delete($id){
        $delete = User::destroy($id);
        if($delete){
            Toastr::success('User Delete Successfully.','Success');
            return redirect()->route('parameter.user.index');
        }else{
            Toastr::error('User Delete Failed','Failed');
            return redirect()->route('parameter.user.index');
        }
        
    }


    // Deactive Role
     
    public function deactive($id){
        $user            = User::find($id);
        $user->is_active = 0;
        $deactive        = $user->save();
        if($deactive){
            Toastr::success('User Deactive Successfully.','Success');
            return redirect()->route('parameter.user.index');
        }else{
            Toastr::error('User Deactive Failed','Failed');
            return redirect()->route('parameter.user.index');
        }
    }


    // Active User
   
    public function active($id){
        $user            = User::find($id);
        $user->is_active = 1;
        $active        = $user->save();
        if($active){
            Toastr::success('User Active Successfully.','Success');
            return redirect()->route('parameter.user.index');
        }else{
            Toastr::error('User Active Failed','Failed');
            return redirect()->route('parameter.user.index');
        }
    }





}
