<?php

namespace App\Http\Controllers\chart_of_account;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class EmployeeController extends Controller
{
     /**
     * Check Authencticate user
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show All Setup Account
     *
     * @return void
     */
    public function index(){
        $employees = DB::table('employees as e')
        ->select(
            'e.id',
            'e.name',
            'e.personal_phone',
            'e.personal_email',
            'e.join_date',
            'e.resume',
            'e.status',
            'ds.name as designation_name',
        )
        ->leftJoin('designations as ds', 'e.designation_id', 'ds.id')
        ->where('e.company_id', Auth::user()->company_id)
        ->get();
        $data = [
            "employees" => $employees
        ];
        return view('chart_of_account.employee.index', $data);
    }

    /**
     * Redirect To Employee Create Page
     *
     * @return void
     */
    public function create(){
        $users        = DB::table('users')->select('id','name')->where('company_id', Auth::user()->company_id)->where('is_active', 1)->get();
        $designations = DB::table('designations')->select('id','name')->where('company_id', Auth::user()->company_id)->where('status', 1)->get();
        $blood_groups = DB::table('blood_groups')->select('id','name')->where('company_id', Auth::user()->company_id)->where('status', 1)->get();
        $data         = [
            "users"        => $users,
            "designations" => $designations,
            "blood_groups" => $blood_groups,
        ];
        return view('chart_of_account.employee.create', $data);
    }

    
    /**
     * Store Employee Information
     *
     * @return void
     */
    public function store(Request $request){
        
        $employee_info = DB::table('employees')->select('id')->where('user_id', $request->input('user_id'))->where('company_id', Auth::user()->company_id)->first();
        if( isset($employee_info->id)  && !empty($employee_info->id) ){
            $employee = Employee::find($employee_info->id);
        }else{
            $employee = new Employee();           
        }

        if ($request->hasFile('resume')) {
            $imageName = uniqid().time().'.'.$request->resume->extension();
            $request->resume->move(public_path('file_storage/employee/resume'), $imageName);
            $resume_path = "public/file_storage/employee/resume/{$imageName}";
        }else{
            $resume_path = '';
        }

        if ($request->hasFile('photo')) {
            $imageName = uniqid().time().'.'.$request->photo->extension();
            $request->photo->move(public_path('file_storage/employee/photo'), $imageName);
            $photo_path = "public/file_storage/employee/photo/{$imageName}";
        }else{
            $photo_path = '';
        }

        if($request->has('spouse_name') && !empty($request->input('spouse_name'))){
            $is_married = 1;
        }else{
            $is_married = 0;
        }

        $employee->company_id                        =  Auth::user()->company_id;
        $employee->user_id                           = $request->input('user_id');
        $employee->designation_id                    = $request->input('designation_id');
        $employee->blood_group_id                    = $request->input('blood_group_id');
        $employee->name                              = $request->input('name');
        $employee->father_name                       = $request->input('father_name');
        $employee->mother_name                       = $request->input('mother_name');
        $employee->is_married                        = $is_married;
        $employee->spouse_name                       = $request->input('spouse_name');
        $employee->personal_phone                    = $request->input('personal_phone');
        $employee->official_phone                    = $request->input('official_phone');
        $employee->personal_email                    = $request->input('personal_email');
        $employee->current_address                   = $request->input('current_address');
        $employee->permanent_address                 = $request->input('permanent_address');
        $employee->reference                         = $request->input('reference');
        $employee->national_id_no                    = $request->input('national_id_no');
        $employee->passport_id_no                    = $request->input('passport_id_no');
        $employee->emergency_contact_person          = $request->input('emergency_contact_person');
        $employee->emergency_contact_person_relation = $request->input('emergency_contact_person_relation');
        $employee->previous_working_experience       = $request->input('previous_working_experience');
        $employee->join_date                         = date('Y-m-d', strtotime($request->input('join_date')));
        $employee->work_type                         = $request->input('work_type');
        $employee->resume                            = $resume_path;
        $employee->photo                             = $photo_path;
        $employee->status                            = 0;
        $employee->created_by                        = Auth::user()->id;

        try{
            $employee->save();
            Toastr::success('Employee Setup Successfully :)','Success');
            return redirect()->route('employee_setup.index');
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Failed');
            return redirect()->route('employee_setup.create');
        }        
    }

    /**
     * Search User Name & Email & Phone
     *
     * @return void
     */
    public function searchEmailPhone(Request $request){
        if($request->has('user_id') && !empty($request->has('user_id'))){
            $user_id = $request->input('user_id');
            $data    = DB::table('users')->select('name', 'email', 'phone')->where('company_id', Auth::user()->company_id)->where('id', $user_id)->first();
            $response = [
                "status" => 200,
                "data"   => [
                    "name"  => $data->name,
                    "email" => $data->email,
                    "phone" => $data->phone
                ]
            ];
            return json_encode($response);
        }else{
            $response = [
                "status" => 404
            ];
            return json_encode($response);
        }
    }


    public function edit($id){
        $users        = DB::table('users')->select('id','name')->where('company_id', Auth::user()->company_id)->where('is_active', 1)->get();
        $designations = DB::table('designations')->select('id','name')->where('company_id', Auth::user()->company_id)->where('status', 1)->get();
        $blood_groups = DB::table('blood_groups')->select('id','name')->where('company_id', Auth::user()->company_id)->where('status', 1)->get();
        $employee_info = DB::table('employees')->where('company_id', Auth::user()->company_id)->where('id', $id)->first();

        $data = [
            "employee_info" => $employee_info,
            "users"         => $users,
            "designations"  => $designations,
            "blood_groups"  => $blood_groups,
        ];
        return view('chart_of_account.employee.edit', $data);
    }



    public function update(Request $request, $id){
        

        if ($request->hasFile('resume')) {
            $imageName = uniqid().time().'.'.$request->resume->extension();
            $request->resume->move(public_path('file_storage/employee/resume'), $imageName);
            $resume_path = "public/file_storage/employee/resume/{$imageName}";
        }else{
            $resume_path = $request->input('old_resume_path');
        }

        if ($request->hasFile('photo')) {
            $imageName = uniqid().time().'.'.$request->photo->extension();
            $request->photo->move(public_path('file_storage/employee/photo'), $imageName);
            $photo_path = "public/file_storage/employee/photo/{$imageName}";
        }else{
            $photo_path = $request->input('old_photo_path');
        }


        if($request->has('spouse_name') && !empty($request->input('spouse_name'))){
            $is_married = 1;
        }else{
            $is_married = 0;
        }

        $employee = Employee::find($id);
        
        $employee->user_id                           = $request->input('user_id');
        $employee->designation_id                    = $request->input('designation_id');
        $employee->blood_group_id                    = $request->input('blood_group_id');
        $employee->name                              = $request->input('name');
        $employee->father_name                       = $request->input('father_name');
        $employee->mother_name                       = $request->input('mother_name');
        $employee->is_married                        = $is_married;
        $employee->spouse_name                       = $request->input('spouse_name');
        $employee->personal_phone                    = $request->input('personal_phone');
        $employee->official_phone                    = $request->input('official_phone');
        $employee->personal_email                    = $request->input('personal_email');
        $employee->current_address                   = $request->input('current_address');
        $employee->permanent_address                 = $request->input('permanent_address');
        $employee->reference                         = $request->input('reference');
        $employee->national_id_no                    = $request->input('national_id_no');
        $employee->passport_id_no                    = $request->input('passport_id_no');
        $employee->emergency_contact_person          = $request->input('emergency_contact_person');
        $employee->emergency_contact_person_relation = $request->input('emergency_contact_person_relation');
        $employee->previous_working_experience       = $request->input('previous_working_experience');
        $employee->join_date                         = date('Y-m-d', strtotime($request->input('join_date')));
        $employee->work_type                         = $request->input('work_type');
        $employee->resume                            = $resume_path;
        $employee->photo                             = $photo_path;
        $employee->status                            = 0;
        $employee->updated_by                        = Auth::user()->id;
        $employee->updated_at                        = date('Y-m-d H:i:s');

        try{
            $employee->save();
            Toastr::success('Employee Update Successfully :)','Success');
            return redirect()->route('employee_setup.index');
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Failed');
            return redirect()->route('employee_setup.edit', $id);
        }   

    }



    public function pending(){
        $employees = DB::table('employees as e')
        ->select(
            'e.id',
            'e.name',
            'e.personal_phone',
            'e.personal_email',
            'e.join_date',
            'e.resume',
            'e.status',
            'ds.name as designation_name',
        )
        ->leftJoin('designations as ds', 'e.designation_id', 'ds.id')
        ->where('e.company_id', Auth::user()->company_id)
        ->where('e.status', 0)
        ->get();
        $data = [
            "employees" => $employees
        ];
        return view('chart_of_account.employee.pending', $data);
    }



    public function authorizeEmployee(Request $request, $id){
        try{
            DB::table('employees')->where('id', $id)->update([
                "status"             => 1,
                "approved_by"        => Auth::user()->id,
                "approved_timestamp" => date('Y-m-d H:i:s')
            ]);
            Toastr::success('Emplooyee Authorize Successfully :)','Success');
            return redirect()->route('employee_setup.pending');
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Failed');
            return redirect()->route('employee_setup.pending');
        }
    }






}
