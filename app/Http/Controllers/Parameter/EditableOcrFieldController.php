<?php

namespace App\Http\Controllers\Parameter;

use App\Http\Controllers\Controller;
use App\Models\OcrEditableSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class EditableOcrFieldController extends Controller
{
    // Check Authencticate user
     
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show All Editable Field Setup With Data-Table

    public function index(){
        $ocr_data = OcrEditableSetup::where('company_id',Auth::user()->company_id)->first();

        $data = [
            "ocr_data" => $ocr_data
        ];
        return view('parameter-setup.editable-ocr-field-setup.index',$data);        
    }

     // Redirect To Create Page

    public function create(){
        return view('parameter-setup.editable-ocr-field-setup.create');
    }


    // Store Data Into Database

    public function store(Request $request){

        $bn_name        = $request->has('bn_name')? 1 : 0;
        $en_name        = $request->has('en_name')? 1 : 0;
        $father_name    = $request->has('father_name')? 1 : 0;
        $mother_name    = $request->has('mother_name')? 1 : 0;
        $address        = $request->has('address')? 1 : 0;
        $date_of_birth  = $request->has('date_of_birth')? 1 : 0;
        $place_of_birth = $request->has('place_of_birth')? 1 : 0;
        $nid_number     = $request->has('nid_number')? 1 : 0;
        $blood_group    = $request->has('blood_group')? 1 : 0;
        $issue_date     = $request->has('issue_date')? 1 : 0;
        $nid_code       = $request->has('nid_code')? 1 : 0;
       
        $ocr_editable_data                 = new OcrEditableSetup();
        $ocr_editable_data->bn_name        = $bn_name;
        $ocr_editable_data->en_name        = $en_name;
        $ocr_editable_data->father_name    = $father_name;
        $ocr_editable_data->mother_name    = $mother_name;
        $ocr_editable_data->address        = $address;
        $ocr_editable_data->date_of_birth  = $date_of_birth;
        $ocr_editable_data->place_of_birth = $place_of_birth;
        $ocr_editable_data->nid_number     = $nid_number;
        $ocr_editable_data->blood_group    = $blood_group;
        $ocr_editable_data->issue_date     = $issue_date;
        $ocr_editable_data->nid_code       = $nid_code;
        $ocr_editable_data->company_id     = Auth::user()->company_id;
        $ocr_editable_data->user_id        = Auth::user()->id;

        $ocr_data_save = $ocr_editable_data->save();
        if($ocr_data_save){
            Toastr::success('OCR Editable Field Setup :)','Success');
            return redirect()->route('parameter-setup.ocr-editable-filed-setup.index');
        }else{
            Toastr::error('OCR Editable Field Setup :)','Failed');
            return redirect()->route('parameter-setup.ocr-editable-filed-setup.index');
        }
    }


    // Edit Score Setup

    function edit($id){
        $ocr_data = OcrEditableSetup::findOrFail($id);
        $data = [
            "ocr_data" => $ocr_data
        ];
        return view('parameter-setup.editable-ocr-field-setup.edit',$data);
    }


     
    // Update Score Setup

    function update(Request $request,$id){

        $bn_name        = $request->has('bn_name')? 1 : 0;
        $en_name        = $request->has('en_name')? 1 : 0;
        $father_name    = $request->has('father_name')? 1 : 0;
        $mother_name    = $request->has('mother_name')? 1 : 0;
        $address        = $request->has('address')? 1 : 0;
        $date_of_birth  = $request->has('date_of_birth')? 1 : 0;
        $place_of_birth = $request->has('place_of_birth')? 1 : 0;
        $nid_number     = $request->has('nid_number')? 1 : 0;
        $blood_group    = $request->has('blood_group')? 1 : 0;
        $issue_date     = $request->has('issue_date')? 1 : 0;
        $nid_code       = $request->has('nid_code')? 1 : 0;
      
        
        $ocr_data                 = OcrEditableSetup::findOrFail($id);
        $ocr_data->bn_name        = $bn_name;
        $ocr_data->en_name        = $en_name;
        $ocr_data->father_name    = $father_name;
        $ocr_data->mother_name    = $mother_name;
        $ocr_data->address        = $address;
        $ocr_data->date_of_birth  = $date_of_birth;
        $ocr_data->place_of_birth = $place_of_birth;
        $ocr_data->nid_number     = $nid_number;
        $ocr_data->blood_group    = $blood_group;
        $ocr_data->issue_date     = $issue_date;
        $ocr_data->nid_code       = $nid_code;

        $update = $ocr_data->save();
        if($update){
            Toastr::success('OCR Editable Field Setup Updated :)','Success');
            return redirect()->route('parameter-setup.ocr-editable-filed-setup.index');
        }else{
            Toastr::error('OCR Editable Field Setup Updated :)','Failed');
            return redirect()->route('parameter-setup.ocr-editable-filed-setup.index');
        }        

    }

     // Delete Score Setup

    function delete($id){
        $delete = OcrEditableSetup::destroy($id);
        if($delete){
            Toastr::success('OCR Editable Field Setup Deleted :)','Success');
            return redirect()->route('parameter-setup.ocr-editable-filed-setup.index');
        }else{
            Toastr::error('OCR Editable Field Setup Deleted :)','Failed');
            return redirect()->route('parameter-setup.ocr-editable-filed-setup.index');
        }
    }



}
