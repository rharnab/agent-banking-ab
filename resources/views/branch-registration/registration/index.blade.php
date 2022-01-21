@extends('layouts.app')

@section('title')
    Search Customer
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Customer Registation</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Customer</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Customer Registation</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@push('css')
    <link href="{{ asset('assets/css/customer-registation.css')}}" rel="stylesheet">
    <style>
      div#error_message_show_section {
         padding: 0px 14px;
      }
      #photo {
         min-width: 267px;
         margin-top: 13px;
         min-height: 226px;
         background: #D5D5D5;
      }
    </style>
@endpush

@section('content')
<input type="hidden" id="token" value="{{ csrf_token() }}">

<!-- Route List Section Start -->
<input type="hidden" id="nid_ocr_route" value="{{ route('branch.registration.nid_ocr') }}">
<input type="hidden" id="ocr_data_review_and_ammendment_route" value="{{ route('branch.registration.nid_ocr.ammendment') }}">
<input type="hidden" id="webcam_face_compare" value="{{ route('branch.registration.webcam_face_compare')}}">
<input type="hidden" id="upload_face_compare_route" value="{{ route('branch.registration.upload_face_compare')}}">
<input type="hidden" id="account_opening_route" value="{{ route('branch.registration.account_opening_form') }}">
<!-- Route List Section End -->


<!-- Step Section Start -->
   <div class="wrapper  animated fadeInRight" style="padding: 20px 14px 0px;">
      <div class="row">
         <div class="col-md-12">
            <div class="ibox">
               <div class="ibox-content" style="padding: 0px">
                  <div class="container">
                     <div class="progress-bar_custom">
                        <div class="step">
                           <p class="step_text_1">Customer Nid Image Upload</p>
                           <div class="bullet step_bullet_1" >
                              <span>1</span>
                           </div>
                           <div class="check fas fa-check"></div>
                        </div>
                        <div class="step">
                           <p class="step_text_2">Customer NID Image To OCR Data</p>
                           <div class="bullet step_bullet_2">
                              <span>2</span>
                           </div>
                           <div class="check fas fa-check"></div>
                        </div>
                        <div class="step">
                           <p class="step_text_3">Compare EC & NID IMAGE</p>
                           <div class="bullet step_bullet_3" >
                              <span>3</span>
                           </div>
                           <div class="check fas fa-check"></div>
                        </div>
                        <div class="step">
                           <p class="step_text_4">Webcam Face Image</p>
                           <div class="bullet step_bullet_4" >
                              <span>4</span>
                           </div>
                           <div class="check fas fa-check"></div>
                        </div>
                        <div class="step">
                           <p class="step_text_5">Face Matching Score</p>
                           <div class="bullet step_bullet_5">
                              <span>5</span>
                           </div>
                           <div class="check fas fa-check"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<!-- Setp Section End -->

<!-- Error Message Show Start Section -->
<div class="wrapper wrapper-content animated fadeInRight" id="error_message_show_section">
   <div class="row">
      <div class="col-lg-12">
         <div class="ibox collapsed">
            <div style="padding: 20px 14px;  background: #ed5565;  color: #ffffff; font-weight: bold;">
               <h5 id="error_message"></h5>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Error Message Show End Section -->

<!-- NID Upload Section Start -->
<div class="step_1">
   <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
         <div class="col-lg-4">
            <div class="ibox" id="loader1">
               <div class="ibox-title text-uppercase">
                  <h5>Customer Nid Image Upload</h5>
               </div>
               <div class="ibox-content">
                  <div class="sk-spinner sk-spinner-double-bounce">
                     <div class="sk-double-bounce1"></div>
                     <div class="sk-double-bounce2"></div>
                  </div>
                  <form  method="POST" enctype="multipart/form-data" id="customer-nid-upload" action="javascript:void(0)">
                     <!-- Start NID Upload Form -->
                     @csrf
                     <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Mobile Number</label>
                        <div class="col-lg-8">
                           <input type="text" placeholder="Mobile Number" readonly  name="mobile_number" value="{{ $mobile_number?? '' }}" class="form-control  @error('mobile_number') is-invalid @enderror"> 
                           @if($errors->has('mobile_number'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('mobile_number') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-lg-4 col-form-label">NID Number</label>
                        <div class="col-lg-8">
                           <input type="text" name="nid_number" readonly value="{{ $nid_number ?? '' }}" placeholder="NID Number" class="form-control @error('nid_number') is-invalid @enderror">
                           @if($errors->has('nid_number'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('nid_number') }}</strong>
                           </span>
                           @endif 
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Nid Front Image</label>
                        <div class="col-lg-8">
                           <div class="custom-file">
                              <input id="front_image" accept="image/*" type="file" name="front_image" class="custom-file-input @error('front_image') is-invalid @enderror">
                              <label for="logo" class="custom-file-label">Choose nid front side image.......</label>
                              @if($errors->has('front_image'))
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('front_image') }}</strong>
                              </span>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Nid Back Image</label>
                        <div class="col-lg-8">
                           <div class="custom-file">
                              <input id="back_image" accept="image/*" type="file" name="back_image" class="custom-file-input @error('back_image') is-invalid @enderror">
                              <label for="logo" class="custom-file-label">Choose nid back side image.......</label>
                           </div>
                        </div>
                     </div>
                     <div class="form-group row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-8">
                           <button class="btn btn-primary btn-block" type="submit">Next</button> 
                        </div>
                     </div>
                  </form>
                  <!-- End NID Upload Form -->
               </div>
            </div>
         </div>
         {{-- Front Image Show Part --}}
         <div class="col-lg-4" id="front_image_show_part">
            <div class="ibox ">
               <div class="ibox-title text-uppercase">
                  <h5>National ID Front Image</h5>
               </div>
               <div class="ibox-content" style="height: 290px;display: flex; align-items: center; justify-content: center;">
                  <img  class="img img-fluid img-responsive" style="width:100%; height: 100%;" src=""  id="front_image_preview"  alt="">                        
               </div>
            </div>
         </div>
         {{-- Back image part show --}}
         <div class="col-lg-4" id="back_image_show_part">
            <div class="ibox ">
               <div class="ibox-title text-uppercase">
                  <h5>National ID Back Image</h5>
               </div>
               <div class="ibox-content" style="height: 290px;display: flex; align-items: center; justify-content: center;" >
                  <img  class="img img-fluid img-responsive" style="width:100%; height: 100%;"   src="" id="back_image_preview" alt="">                        
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- NID Upload Section End -->

<!-- OCR Data Review & Ammendment Section Start -->
<div class="step_2">
   <form id="ocr-data-save-form"  method="POST" enctype="multipart/form-data"  action="javascript:void(0)" >
      <div class="wrapper wrapper-content animated fadeInRight" style="padding-bottom: 0px">
         <div class="row">
            <div class="col-lg-12">
               <div class="ibox" id="loader2">
                  <div class="ibox-title text-uppercase">
                     <h5>NID IMAGE TO OCR DATA</h5>
                  </div>
                  <div class="ibox-content">
                     <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                     </div>
                     <div class="col-lg-12">
                        <div class="tabs-container">
                           <ul class="nav nav-tabs" role="tablist">
                              <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> NID Front Image</a></li>
                              <li><a class="nav-link" data-toggle="tab" href="#tab-2">NID Back Image</a></li>
                           </ul>
                           <div class="tab-content">
                              <div role="tabpanel" id="tab-1" class="tab-pane active">
                                 <div class="panel-body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Mobile Number</label>
                                             <div class="col-lg-9">
                                                <input type="text" name="mobile_number" id="mobile_number"  readonly class="form-control"> 
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Front Ocr Data</label>
                                             <div class="col-lg-9">
                                                <textarea class="form-control" rows="11" id="front_data" name="front_data"  readonly ></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">NID Number</label>
                                             <div class="col-lg-9">
                                                <input type="text"  @if($ocrEditableField->nid_number == 0) readonly @endif name="nid_number" id="nid_number" class="form-control">
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Bangla Name</label>
                                             <div class="col-lg-9">
                                                <input type="text"@if($ocrEditableField->bn_name == 0) readonly @endif id="bangla_name" name="bangla_name" class="form-control">
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">English Name</label>
                                             <div class="col-lg-9">
                                                <input type="text"  @if($ocrEditableField->en_name == 0) readonly @endif id="english_name" name="english_name" class="form-control">
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Father Name</label>
                                             <div class="col-lg-9">
                                                <input type="text" @if($ocrEditableField->father_name == 0) readonly @endif id="father_name" name="father_name" class="form-control">
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Mother Name</label>
                                             <div class="col-lg-9">
                                                <input type="text"  @if($ocrEditableField->mother_name == 0) readonly @endif id="mother_name" name="mother_name" class="form-control">
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Date Of Birth</label>
                                             <div class="col-lg-9">
                                                <input type="date" @if($ocrEditableField->date_of_birth == 0) readonly @endif id="date_of_birth" name="date_of_birth" class="form-control">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div role="tabpanel" id="tab-2" class="tab-pane">
                                 <div class="panel-body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Back Ocr Data</label>
                                             <div class="col-lg-9">
                                                <textarea class="form-control" rows="11" id="back_data" name="back_data"   readonly  ></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Address</label>
                                             <div class="col-lg-9">
                                                <textarea class="form-control" rows="4" @if($ocrEditableField->address == 0) readonly @endif id="address" name="address"></textarea>
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Blood Group</label>
                                             <div class="col-lg-9">
                                                <input type="text"  @if($ocrEditableField->blood_group == 0) readonly @endif name="blood_group" id="blood_group" class="form-control">
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Place Of Birth</label>
                                             <div class="col-lg-9">
                                                <input type="text"  @if($ocrEditableField->place_of_birth == 0) readonly @endif name="place_of_birth" id="place_of_birth" class="form-control">
                                             </div>
                                          </div>
                                          <div class="form-group row">
                                             <label class="col-lg-3 col-form-label">Issue Date</label>
                                             <div class="col-lg-9">
                                                <input type="text"  @if($ocrEditableField->issue_date == 0) readonly @endif name="issue_date" id="issue_date" class="form-control">
                                             </div>
                                          </div>
                                          <!-- Hiddent Registrion ID For Next Step -->
                                          <input type="hidden" id="registration_id" name="registration_id">
                                          <!-- Hiddent Registrion ID For Next Step -->
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="button_div" style="margin-top: -20px; margin-left:15px;padding-bottom: 20px;">
         <button onclick="currentStep(1)" class="btn btn-danger mt-3"> <i class="fa fa-backward"></i> &nbsp;&nbsp; Previous</button>
         &nbsp;
         <button type="submit" class="btn btn-primary mt-3"> Next  &nbsp; <i class="fa fa-forward"></i></button>         
      </div>
   </form>
</div>
<!-- OCR Data Review & Ammendment Section End -->

<!-- Compare EC & OCR Data Start-->
<div class="step_3">
   <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
         <div class="col-lg-9">
            <div class="ibox ">
               <div class="ibox-title text-uppercase">
                  <h5>MATCHING SCORE IN EC & OCR</h5>
               </div>
               <div class="ibox-content">
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th style="width: 150px">NAME</th>
                           <th>EC DATA</th>
                           <th>OCR DATA</th>
                           <th>SCORE</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>Bangla Name</td>
                           <td><span id="ec_bangla_name"></span></td>
                           <td><span id="ocr_bangla_name"></span></td>
                           <td id="bangla_name_percentage">0% </td>
                        </tr>
                        <tr>
                           <td>English Name</td>
                           <td><span id="ec_english_name"></span></td>
                           <td><span id="ocr_english_name"></span></td>
                           <td id="english_name_percentage">0% </td>
                        </tr>
                        <tr>
                           <td>Father Name</td>
                           <td><span id="ec_father_name"></span></td>
                           <td><span id="ocr_father_name"></span></td>
                           <td  id="father_name_percentage">0% </td>
                        </tr>
                        <tr>
                           <td>Mother Name</td>
                           <td><span id="ec_mother_name"></span></td>
                           <td><span id="ocr_mother_name"></span></td>
                           <td  id="mother_name_percentage">0% </td>
                        </tr>
                        <tr>
                           <td>Date Of Birth</td>
                           <td><span id="ec_date_of_birth"></span></td>
                           <td><span id="ocr_date_of_birth"></span></td>
                           <td  id="date_of_birth_percentage">0% </td>
                        </tr>
                        <tr>
                           <td>Address</td>
                           <td><span id="ec_address"></span></td>
                           <td><span id="ocr_address"></span></td>
                           <td id="address_percentage">0% </td>
                        </tr>
                        <input type="hidden" id="ec_id" value="ec_id">
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="ibox">
               <div class="ibox-title text-uppercase">
                  <h5>OVERALL MATCHING SCORE</h5>
               </div>
               <div class="ibox-content" style="height: 300px">
                  <h5 id="textMatchinResult" style="font-weight: bold; text-transform:uppercase"></h5>
                  <br>
                  <h2 id="overallmatcingtext">100/0</h2>
                  <div class="text-center">
                     <div id="overallspacleCircle"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="wrapper animated fadeInRight row button_div_for_comparison" style="margin-top: -50px; padding-bottom: 20px;">
      <div class="col-md-12">
         <button class="btn btn-danger" onclick="currentStep(2)"> <i class="fa fa-backward"></i> &nbsp;&nbsp; Previous</button>
         <button class="btn btn-primary" id="text-compare-next-button" onclick="currentStep(4)"> Next <i class="fa fa-forward"></i> &nbsp;&nbsp; </button>
      </div>
   </div>
</div>
<!-- Compare EC & OCR Data End-->

<!-- Face Compare Section Start -->
<div class="step_4">
   <form id="upload-face-image-form"  method="POST" enctype="multipart/form-data"  action="javascript:void(0)" >
      <div class="wrapper wrapper-content animated fadeInRight">
         <div class="row">
            <div class="col-lg-3">
               <div class="ibox" id="loader4">
                  <div class="ibox-title text-uppercase">
                     <h5>Customer Information</h5>
                  </div>
                  <div class="ibox-content">
                     <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                     </div>
                     <div class="form">
                        <input type="hidden"  name="face_compare_registration_id" id="face_compare_registration_id">
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <input type="text" id="face_customer_nid"  readonly  class="form-control"> 
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <input type="text" id="face_customer_mobile_number"  readonly  class="form-control"> 
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <input type="text" id="face_customer_english_name" readonly  class="form-control"> 
                           </div>
                        </div>
                        <div class="form-group row" style="display: none">
                           <div class="col-lg-12">
                              <input type="text" id="face_customer_bangla_name"  readonly  class="form-control"> 
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <input type="text" id="face_customer_date_of_birth"  readonly class="form-control"> 
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <label for="">Upload Face Image</label>
                              <input id="upload_face_image" type="file" name="upload_face_image" >
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3">
               <div class="ibox ">
                  <div class="ibox-title text-uppercase">
                     <h5>Custome Face EC-Respone</h5>
                  </div>
                  <div class="ibox-content" style="height: 295px;display: flex; align-items: center; justify-content: center;" >
                     <img   src="" id="ec_face_image_prview" class="img img-fluid img-responsive" style="height: 100%; width: 100%;"  alt="">                        
                  </div>
               </div>
            </div>
            {{-- Back image part show --}}
            <div class="col-lg-3" >
               <div class="ibox ">
                  <div class="ibox-title text-uppercase">
                     <h5>FACE IMAGE TAKE</h5>
                  </div>
                  <div class="ibox-content" style="height: 295px;display: flex; align-items: center; justify-content: center;">
                     <div class="contentarea">
                        <div class="camera">
                           <video id="video">Video stream not available.</video>
                        </div>
                        <div><button id="startbutton">Take photo</button></div>
                        <canvas id="canvas"></canvas>
                     </div>
                     {{-- <img  class="img img-fluid"  style="height: 100%; width: 100%;" src="" id="face_image_priview"    alt="">                         --}}
                  </div>
               </div>
            </div>
            {{-- Back image part show --}}
            <div class="col-lg-3" id="face_image_taken_show_section" >
               <div class="ibox">
                  <div class="ibox-title text-uppercase">
                     <h5>FACE IMAGE</h5>
                  </div>
                  <div class="ibox-content" style="height: 300px">
                     <div class="output">
                        <img id="photo" class="webcam_face_image img img-fluid img-responsive">
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3" id="upload_face_image_show_part">
               <div class="ibox ">
                  <div class="ibox-title text-uppercase">
                     <h5>UPLOAD FACE IMAGE</h5>
                  </div>
                  <div class="ibox-content" style="height: 290px;display: flex; align-items: center; justify-content: center;" >
                     <img  class="img img-fluid img-responsive" style="width:100%; height: 100%;"   src="" id="upload_face_imge_preview" alt="">                        
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="wrapper animated fadeInRight row" style="margin-top: -43px;  padding-bottom: 20px;">
         <div class="col-md-12">
            <button class="btn btn-danger" onclick="currentStep(3)"> <i class="fa fa-backward"></i> &nbsp;&nbsp; Previous</button>
            <button type="submit" class="btn btn-info">Upload Compare &nbsp; <i class="fa fa-forward"></i></button>
            <button type="button" class="btn btn-primary" onclick="faceCompare()">Webcam Compare &nbsp; <i class="fa fa-forward"></i></button>
         </div>
      </div>
   </form>
</div>
<!-- Face Compare Section End -->

<!-- Face Matching Score Show Start Section -->
<div class="step_5">
   <div class="wrapper animated fadeInRight row" id="verify_success">
      <div class="col-md-12">
         <div class="ibox collapsed">
            <div style="padding: 20px 14px;  background: #18a689;  color: #ffffff; font-weight: bold;">
               <h5 id="face_verified_message"></h5>
            </div>
         </div>
      </div>
   </div>
   <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
         <div class="col-lg-4">
            <div class="ibox ">
               <div class="ibox-title text-uppercase">
                  <h5>Customer EC-Face Image</h5>
               </div>
               <div class="ibox-content" style="height: 295px;display: flex; align-items: center; justify-content: center;" >
                  <img   src="" id="verified_customer_ec_face_image" class="img img-fluid img-responsive" style="height: 100%; width: 100%;"  alt="">                        
               </div>
            </div>
         </div>
         {{-- Back image part show --}}
         <div class="col-lg-4" >
            <div class="ibox ">
               <div class="ibox-title text-uppercase">
                  <h5>Customer Face Image</h5>
               </div>
               <div class="ibox-content" style="height: 295px;display: flex; align-items: center; justify-content: center;">                        
                  <img  class="img img-fluid"  style="height: 100%; width: 100%;" src="" id="verified_customer_image"    alt="">                        
               </div>
            </div>
         </div>
         {{-- Back image part show --}}
         <div class="col-lg-4">
            <div class="ibox">
               <div class="ibox-title text-uppercase">
                  <h5>FACE MACHING SCORE</h5>
               </div>
               <div class="ibox-content" style="height: 300px">
                  <div class="text-center">
                     <h5 id="faceMatchingResult" style="text-align:left; font-weight: bold; text-transform: uppercase;"></h5>
                     <h1 id="overallFaceMachingtext"></h1>
                     <div id="facematchingscore"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="wrapper animated fadeInRight row" style="margin-top: -55px">
      <div class="col-md-12">
         <button class="btn btn-danger" onclick="currentStep(4)"> <i class="fa fa-backward"></i> &nbsp;&nbsp; Previous</button>
      </div>
   </div>
   <br>
</div>
<!-- Face Matching Score Show End Section -->

@endsection


@push('js')
   <!-- Sparkline -->
   <script src="{{ asset('assets/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

   <!-- WebCam Js -->
   <script src="{{ asset('assets/custom-js/customer-registation/webcam.js') }}"></script>

   <!-- Customer Regitstation-->
   <script src="{{ asset('assets/custom-js/customer-registation/customer-registation.js') }}"></script>

   <!-- Customer Regitstation-->
   <script src="{{ asset('assets/custom-js/customer-registation/nid-upload.js') }}"></script>

   <!-- Branch Registation Initial Js Loader -->
   <script src="{{ asset('assets/custom-js/branch-registration/branch_registration.js') }}"></script>

   <!-- Upload Nid & Ocr Js Loader -->
   <script src="{{ asset('assets/custom-js/branch-registration/upload_nid_and_ocr.js') }}"></script>

   <!-- Review & Ammendment OCR Data js loader -->
   <script src="{{ asset('assets/custom-js/branch-registration/ocr_data_review_and_ammendment.js') }}"></script>

   <!-- Webcam Face Compare Js Loader -->
   <script src="{{ asset('assets/custom-js/branch-registration/webcam_face_compare.js') }}"></script>
   
   <!-- Upload Image Face Compare Js Loader -->
   <script src="{{ asset('assets/custom-js/branch-registration/upload_image_face_compare.js') }}"></script>


@endpush