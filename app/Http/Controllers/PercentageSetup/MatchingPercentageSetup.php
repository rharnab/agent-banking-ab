<?php

namespace App\Http\Controllers\PercentageSetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PercentageSetup;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class MatchingPercentageSetup extends Controller
{
    // Check Authencticate user
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show All Percentage Setup With Data-Table
    public function index(){
        $percentageSetups = PercentageSetup::all();
        $data = [
            "percentageSetups" => $percentageSetups
        ];
        return view('matching-score-setup.index',$data);
        
    }

     // Redirect To Create Page
    public function create(){
        return view('matching-score-setup.create');
    }

    // Store Data Into Database
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
                    'bn_name_percentage'       => 'required|numeric|min:0|max:100',
                    'en_name_percentage'       => 'required|numeric|min:0|max:100',
                    'father_name_percentage'   => 'required|numeric|min:0|max:100',
                    'mother_name_percentage'   => 'required|numeric|min:0|max:100',
                    'date_of_birth_percentage' => 'required|numeric|min:0|max:100',
                    'address_percentage'       => 'required|numeric|min:0|max:100',
                    'face_percentage'          => 'required|numeric|min:0|max:100',
                    'blood_group_percentage'          => 'required|numeric|min:0|max:100',
                    'overall_percentage'          => 'required|numeric|min:0|max:100',
                ],[
                    'bn_name_percentage.required' => 'Please enter bangla name match percentage.',
                    'bn_name_percentage.numeric'  => 'Only numeric carater supported.',
                    'bn_name_percentage.max'      => 'The bangla name match percentage may not be greater than 100.',
                    'bn_name_percentage.min'      => 'The bangla name match percentage must be at least 0.',

                    'en_name_percentage.required' => 'Please enter english name match percentage.',
                    'en_name_percentage.numeric'  => 'Only numeric carater supported.',
                    'en_name_percentage.max'      => 'The english name match percentage may not be greater than 100.',
                    'en_name_percentage.min'      => 'The english name match percentage must be at least 0.',

                    'father_name_percentage.required' => 'Please enter father name match percentage.',
                    'father_name_percentage.numeric'  => 'Only numeric carater supported.',
                    'father_name_percentage.max'      => 'The father name match percentage may not be greater than 100.',
                    'father_name_percentage.min'      => 'The father name match percentage must be at least 0.',

                    'date_of_birth_percentage.required' => 'Please enter date of birth match percentage.',
                    'date_of_birth_percentage.numeric'  => 'Only numeric carater supported.',
                    'date_of_birth_percentage.max'      => 'The enter date of birth match percentage may not be greater than 100.',
                    'date_of_birth_percentage.min'      => 'Theenter date of birth match percentage must be at least 0.',

                    'address_percentage.required' => 'Please enter address match percentage.',
                    'address_percentage.numeric'  => 'Only numeric carater supported.',
                    'address_percentage.max'      => 'The address match percentage may not be greater than 100.',
                    'address_percentage.min'      => 'The address match percentage must be at least 0.',

                    'face_percentage.required' => 'Please enter face match percentage.',
                    'face_percentage.numeric'  => 'Only numeric carater supported.',
                    'face_percentage.max'      => 'The face match percentage may not be greater than 100.',
                    'face_percentage.min'      => 'The face match percentage must be at least 0.',

                    'blood_group_percentage.required' => 'Please enter blood group match percentage.',
                    'blood_group_percentage.numeric'  => 'Only numeric carater supported.',
                    'blood_group_percentage.max'      => 'The blood group match percentage may not be greater than 100.',
                    'blood_group_percentage.min'      => 'The blood group match percentage must be at least 0.',

                    'overall_percentage.required' => 'Please enter overall match percentage.',
                    'overall_percentage.numeric'  => 'Only numeric carater supported.',
                    'overall_percentage.max'      => 'The overall match percentage may not be greater than 100.',
                    'overall_percentage.min'      => 'The overall match percentage must be at least 0.'

                   
                ]);


                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }



        
        $percentage_setup                           = new PercentageSetup();
        $percentage_setup->bn_name_percentage       = $request->input('bn_name_percentage');
        $percentage_setup->en_name_percentage       = $request->input('en_name_percentage');
        $percentage_setup->father_name_percentage   = $request->input('father_name_percentage');
        $percentage_setup->mother_name_percentage   = $request->input('mother_name_percentage');
        $percentage_setup->address_percentage       = $request->input('address_percentage');
        $percentage_setup->face_percentage          = $request->input('face_percentage');
        $percentage_setup->date_of_birth_percentage = $request->input('date_of_birth_percentage');
        $percentage_setup->blood_group_percentage   = $request->input('blood_group_percentage');
        $percentage_setup->overall_percentage       = $request->input('overall_percentage');
        $percentage_setup->user_id                  = Auth::user()->id;
        $percentage_setup->company_id               = Auth::user()->company_id;
        $create                                     = $percentage_setup->save();
        
        if($create){
            Toastr::success('Maching Score Setup :)','Success');
            return redirect()->route('matching.score.setup.index');
        }else{
            Toastr::error('Maching Score Setup :)','Failed');
            return redirect()->route('matching.score.setup.index');
        }

        

    }


    // Edit Score Setup
    function edit($id){
        $matchingSocreInfo = PercentageSetup::findOrFail($id);
        $data = [
            "matchingSocreInfo" => $matchingSocreInfo
        ];
        return view('matching-score-setup.edit',$data);
    }

    
    
    // Update Score Setup
    function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'bn_name_percentage'       => 'required|numeric|min:0|max:100',
            'en_name_percentage'       => 'required|numeric|min:0|max:100',
            'father_name_percentage'   => 'required|numeric|min:0|max:100',
            'mother_name_percentage'   => 'required|numeric|min:0|max:100',
            'date_of_birth_percentage' => 'required|numeric|min:0|max:100',
            'address_percentage'       => 'required|numeric|min:0|max:100',
            'face_percentage'          => 'required|numeric|min:0|max:100',
            'blood_group_percentage'   => 'required|numeric|min:0|max:100',
            'overall_percentage'       => 'required|numeric|min:0|max:100',
        ],[
            'bn_name_percentage.required' => 'Please enter bangla name match percentage.',
            'bn_name_percentage.numeric'  => 'Only numeric carater supported.',
            'bn_name_percentage.max'      => 'The bangla name match percentage may not be greater than 100.',
            'bn_name_percentage.min'      => 'The bangla name match percentage must be at least 0.',

            'en_name_percentage.required' => 'Please enter english name match percentage.',
            'en_name_percentage.numeric'  => 'Only numeric carater supported.',
            'en_name_percentage.max'      => 'The english name match percentage may not be greater than 100.',
            'en_name_percentage.min'      => 'The english name match percentage must be at least 0.',

            'father_name_percentage.required' => 'Please enter father name match percentage.',
            'father_name_percentage.numeric'  => 'Only numeric carater supported.',
            'father_name_percentage.max'      => 'The father name match percentage may not be greater than 100.',
            'father_name_percentage.min'      => 'The father name match percentage must be at least 0.',

            'date_of_birth_percentage.required' => 'Please enter date of birth match percentage.',
            'date_of_birth_percentage.numeric'  => 'Only numeric carater supported.',
            'date_of_birth_percentage.max'      => 'The enter date of birth match percentage may not be greater than 100.',
            'date_of_birth_percentage.min'      => 'Theenter date of birth match percentage must be at least 0.',

            'address_percentage.required' => 'Please enter address match percentage.',
            'address_percentage.numeric'  => 'Only numeric carater supported.',
            'address_percentage.max'      => 'The address match percentage may not be greater than 100.',
            'address_percentage.min'      => 'The address match percentage must be at least 0.',

            'face_percentage.required' => 'Please enter face match percentage.',
            'face_percentage.numeric'  => 'Only numeric carater supported.',
            'face_percentage.max'      => 'The face match percentage may not be greater than 100.',
            'face_percentage.min'      => 'The face match percentage must be at least 0.',

            'blood_group_percentage.required' => 'Please enter blood group match percentage.',
            'blood_group_percentage.numeric'  => 'Only numeric carater supported.',
            'blood_group_percentage.max'      => 'The blood group match percentage may not be greater than 100.',
            'blood_group_percentage.min'      => 'The blood group match percentage must be at least 0.',

            'overall_percentage.required' => 'Please enter overall match percentage.',
            'overall_percentage.numeric'  => 'Only numeric carater supported.',
            'overall_percentage.max'      => 'The overall match percentage may not be greater than 100.',
            'overall_percentage.min'      => 'The overall match percentage must be at least 0.'

           
        ]);


        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $percentage_setup                           = PercentageSetup::findOrFail($id);
        $percentage_setup->bn_name_percentage       = $request->input('bn_name_percentage');
        $percentage_setup->en_name_percentage       = $request->input('en_name_percentage');
        $percentage_setup->father_name_percentage   = $request->input('father_name_percentage');
        $percentage_setup->mother_name_percentage   = $request->input('mother_name_percentage');
        $percentage_setup->address_percentage       = $request->input('address_percentage');
        $percentage_setup->face_percentage          = $request->input('face_percentage');
        $percentage_setup->date_of_birth_percentage = $request->input('date_of_birth_percentage');
        $percentage_setup->blood_group_percentage   = $request->input('blood_group_percentage');
        $percentage_setup->overall_percentage       = $request->input('overall_percentage');
        $percentage_setup->user_id                  = Auth::user()->id;
        $percentage_setup->company_id               = Auth::user()->company_id;

        $update = $percentage_setup->save();
        if($update){
            Toastr::success('Maching Score Updated :)','Success');
            return redirect()->route('matching.score.setup.index');
        }else{
            Toastr::error('Maching Score Updated :)','Failed');
            return redirect()->route('matching.score.setup.index');
        }        

    }

    // Delete Score Setup
    function delete($id){
        $delete = PercentageSetup::destroy($id);
        if($delete){
            Toastr::success('Maching Score Deleted :)','Success');
            return redirect()->route('matching.score.setup.index');
        }else{
            Toastr::error('Maching Score Deleted :)','Failed');
            return redirect()->route('matching.score.setup.index');
        }
    }





}
