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
@endpush

@section('content')
<input type="hidden" id="token" value="{{ csrf_token() }}">
<!-- Step Section Start -->
<div class="wrapper  animated fadeInRight" style="padding: 20px 14px 0px;">
   <div class="row">
      <div class="col-md-12">
         <div class="ibox">
            <div class="ibox-content" style="padding: 0px">
               <div class="container">
                  <div class="progress-bar_custom">
                     <div class="step">
                        <p class="step_text_1" onclick="currentStep(1)">Customer Nid Image Upload</p>
                        <div class="bullet step_bullet_1" >
                           <span>1</span>
                        </div>
                        <div class="check fas fa-check"></div>
                     </div>
                     <div class="step">
                        <p class="step_text_2" onclick="currentStep(2)">Customer NID Image To OCR Data</p>
                        <div class="bullet step_bullet_2">
                           <span>2</span>
                        </div>
                        <div class="check fas fa-check"></div>
                     </div>
                     <div class="step">
                        <p class="step_text_3" onclick="currentStep(3)">Compare EC & NID IMAGE</p>
                        <div class="bullet step_bullet_3" >
                           <span>3</span>
                        </div>
                        <div class="check fas fa-check"></div>
                     </div>
                     <div class="step">
                        <p class="step_text_4" onclick="currentStep(4)">Webcam Face Image</p>
                        <div class="bullet step_bullet_4" >
                           <span>4</span>
                        </div>
                        <div class="check fas fa-check"></div>
                     </div>
                     <div class="step">
                        <p class="step_text_5" onclick="currentStep(5)">Face Matching Score</p>
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
                              <input id="front_image" type="file" name="front_image" class="custom-file-input @error('front_image') is-invalid @enderror">
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
                              <input id="back_image" type="file" name="back_image" class="custom-file-input @error('back_image') is-invalid @enderror">
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
                                                   <input type="text" name="mobile_number" id="mobile_number" value="{{ $mobile_number ?? '' }}" readonly class="form-control"> 
                                                </div>
                                             </div>
                                             <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Front Ocr Data</label>
                                                <div class="col-lg-9">
                                                   <textarea class="form-control" rows="8" id="front_data" name="front_data"  readonly ></textarea>
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
                                                   <input type="text" @if($ocrEditableField->date_of_birth == 0) readonly @endif id="date_of_birth" name="date_of_birth" class="form-control">
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
                                                   <textarea class="form-control" rows="8" id="back_data" name="back_data"   readonly  ></textarea>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Address</label>
                                                <div class="col-lg-9">
                                                   <textarea class="form-control" rows="3" @if($ocrEditableField->address == 0) readonly @endif id="address" name="address"></textarea>
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
                           <td>Blood Group</td>
                           <td><span id="ec_blood_group"></span></td>
                           <td><span id="ocr_blood_group"></span></td>
                           <td  id="blood_group_percentage">0% </td>
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
         <button class="btn btn-primary" id="face_photo"> Next <i class="fa fa-forward"></i> &nbsp;&nbsp; </button>
      </div>
   </div>
</div>
<!-- Compare EC & OCR Data End-->
<!-- Upload Face Image Section Start -->
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
                        <input type="hidden" name="face_upload_submit" value="1">
                        <input type="hidden" name="face_upload_customer_id" id="face_upload_customer_id">
                        <input type="hidden" name="face_upload_ec_id" id="face_upload_ec_id">
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
                     <img   src="" id="ec_face_image_prview" 
                        class="img img-fluid img-responsive" style="height: 100%; width: 100%;"  alt="">                        
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
                        <img id="photo" class="webcam_face_image img img-fluid img-responsive" alt="The screen capture will appear in this box.">
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
<!-- Upload Face Image Section End -->

<!-- Face Match Score  Section Start -->
<div class="step_5">
   
   <div class="wrapper animated fadeInRight row" id="verify_success">
      <div class="col-md-12">
         <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            Customer Varified Successfully. <a class="alert-link" href="{{ route('customer.show_search_form') }}">Register new customer</a>.
         </div>
      </div>
   </div>
   <div class="wrapper animated fadeInRight row" id="verify_failed">
      <div class="col-md-12">
         <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            Your face cannot match our required percentage.  <span onclick="currentStep(4)">Please go back</span>  and take new photo.
         </div>
      </div>
   </div>
   <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
         <div class="col-lg-4">
            <div class="ibox ">
               <div class="ibox-title text-uppercase">
                  <h5>Custome Face EC-Respone</h5>
               </div>
               <div class="ibox-content" style="height: 295px;display: flex; align-items: center; justify-content: center;" >
                  <img   src="" id="ec_face_image" class="img img-fluid img-responsive" style="height: 100%; width: 100%;"  alt="">                        
               </div>
            </div>
         </div>
         {{-- Back image part show --}}
         <div class="col-lg-4" >
            <div class="ibox ">
               <div class="ibox-title text-uppercase">
                  <h5>FACE IMAGE WEB-CAM</h5>
               </div>
               <div class="ibox-content" style="height: 295px;display: flex; align-items: center; justify-content: center;">                        
                  <img  class="img img-fluid"  style="height: 100%; width: 100%;" src="" id="customer_face_image"    alt="">                        
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
<!-- Face Match Score Section End -->
<!-- Success Toast notifications Section Start -->
<div style="position: absolute; top: 20px; right: 20px;">
   <div class="toast toast1 toast-bootstrap" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header" style="background: green; color:white">
         <i class="fa fa-newspaper-o"> </i>
         <strong class="mr-auto m-l-sm"><span id="toast_success_heading"></span></strong>               
         <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="toast-body">
         <span id="toast_success_message"></span>
      </div>
   </div>
</div>
<!-- Success Toast notifications Section End -->
<!-- Error Toast notifications Section Start -->
<div style="position: absolute; top: 20px; right: 20px;">
   <div class="toast toast2 toast-bootstrap" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header" style="background: red; color:white">
         <i class="fa fa-newspaper-o"> </i>
         <strong class="mr-auto m-l-sm"><span id="toast_error_heading"></span></strong>               
         <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="toast-body">
         <span id="toast_error_message"></span>
      </div>
   </div>
</div>
<!-- Error Toast notifications Section End -->
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

    <!-- Initial Jquery Run Start -->
    <script>
        $(function(){
            $('#upload_face_image_show_part').hide();

            // font image upload
            $("#upload_face_image").change(function() {
                $('#face_image_taken_show_section').hide();
                $('#upload_face_image_show_part').show();

                readURL(this);
            });


            // after upload front image preview function
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#upload_face_imge_preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
        });
    </script>
    <!-- Initial Jquery Run End -->

    <!-- Notification Toaser Section Start -->
    <script>        
        function successToastNotification(heading, message){
            $(function () {                
                let toast1 = $('.toast1');
            
                toast1.toast({
                    delay: 5000,
                    animation: true
                });
                $('#toast_success_heading').html(heading.trim());
                $('#toast_success_message').html(message.trim());
                toast1.toast('show');    
            })
        }

        function errorToastNotification(heading, message){
            $(function () {
                let toast2 = $('.toast2');            
                toast2.toast({
                    delay: 5000,
                    animation: true
                });
                $('#toast_error_heading').html(heading.trim());
                $('#toast_error_message').html(message.trim());
                toast2.toast('show');    
            })
        }

       
    </script>
     <!-- Notification Toaser Section End -->

      <!-- Upload Face Image Section Start -->
    <script>
        $(document).ready(function(e) {               
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#upload-face-image-form').submit(function(e) {
                if( document.getElementById("upload_face_image").files.length == 0  ){
                    return false;
                }else{
                    $('#loader4').children('.ibox-content').addClass('sk-loading'); //add loading
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type       : 'POST',
                        url        : "{{ route('customer.registation.face_compare')}}",
                        data       : formData,
                        cache      : false,
                        contentType: false,
                        processData: false,
                        success    : (data) => {  
                            $('#loader4').children('.ibox-content').removeClass('sk-loading'); //add loading
                            var obj = JSON.parse(data);
                            if(obj.error_code === 400){
                               errorToastNotification("Face Match", "Please smile & take photo again"); 
                              return false;
                           }else if(obj.error_code === 200){
                              currentStep(5);
                              $('#face_matching_score_ec_face').attr('src', obj.ec_face_image.trim());
                              $('#face_matching_score_web_cam_image').attr('src',obj.webcam_face_image.trim());
                              showFaceMatchingScore(obj.recognize_percentage, obj.is_verified);
                            }    
                        },
                        error: function(data) {
                            $('#ibox1').children('.ibox-content').removeClass('sk-loading');
                        }
                    });
                }                
            });
        });
    </script>
    <!-- Upload Face Image Section End -->



    <!-- Upload NID Section Start -->
    <script>
        $(document).ready(function(e) {               
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#customer-nid-upload').submit(function(e) {
                if( document.getElementById("front_image").files.length == 0  || document.getElementById("back_image").files.length == 0 ){
                    return false;
                }else{
                    $('#loader1').children('.ibox-content').addClass('sk-loading'); //add loading
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type       : 'POST',
                        url        : "{{ route('customer.registation.upload.nid') }}",
                        data       : formData,
                        cache      : false,
                        contentType: false,
                        processData: false,
                        success    : (data) => {    
                            successToastNotification("NID OCR SuccessFully :)", "NID OCR Success, now review and ammendment ocr data");                   
                            $('#loader1').children('.ibox-content').removeClass('sk-loading'); // remove loading
                            currentStep(2);
                            var obj = JSON.parse(data);
                            // data fillup from ajax start
                            $('#customer_id').val(obj.id);
                            $('#front_data').val(obj.front_data.trim());
                            $('#nid_number').val(obj.nid_number.trim());
                            $('#bangla_name').val(obj.bn_name.trim());
                            $('#english_name').val(obj.en_name.trim());
                            $('#father_name').val(obj.father_name.trim());
                            $('#mother_name').val(obj.mother_name.trim());
                            $('#nid_unique_data').val(obj.nid_unique_data);
                            $('#date_of_birth').val(obj.date_of_birth.trim());
                            $('#back_data').val(obj.back_data.trim());
                            $('#address').val(obj.address.trim());
                            $('#blood_group').val(obj.blood_group.trim());
                            $('#place_of_birth').val(obj.place_of_birth.trim());
                            $('#issue_date').val(obj.issue_date.trim());
                        },
                        error: function(data) {
                            $('#ibox1').children('.ibox-content').removeClass('sk-loading');
                        }
                    });
                }                
            });
        });
    </script>
    <!-- Upload NID Section End -->

    <!-- OCR Data Review & Ammendment  Start -->
    <script type="text/javascript">
        $(document).ready(function(e) {   
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#ocr-data-save-form').submit(function(e) {
                $('#loader2').children('.ibox-content').addClass('sk-loading'); //add loading
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type       : 'POST',
                    url        : "{{ route('customer.registation.ocr.ammendment')}}",
                    data       : formData,
                    cache      : false,
                    contentType: false,
                    processData: false,
                    success    : (data) => {
                        $('#loader2').children('.ibox-content').removeClass('sk-loading'); //add loading
                        currentStep(3);
                        var obj = JSON.parse(data);
                        showPercentageIntoCompareTable(obj); // show data into compare table  
                        showOverAllMatchingScore(obj.overallPercentage, obj.overallPercentage_color, obj.is_pass_text_matching);   
                        $('#ec_id').val(obj.ec_id); 
                        showCustomerInforForFaceUpload(obj);
                        
                        $('#face_upload_customer_id').val(obj.customer_id);
                        $('#face_upload_ec_id').val(obj.ec_id);
                    },
                    error: function(data) {
                        $('#loader2').children('.ibox-content').removeClass('sk-loading'); //add loading
                    }
                });           
            });
        });

    </script>


<script>
    function showPercentageIntoCompareTable(obj){
        // bangla name percentage
        $('#ec_bangla_name').html(obj.ec_bangla_name);
        $('#ocr_bangla_name').html(obj.ocr_bangla_name);
        $('#bangla_name_percentage').html(obj.percentage_bangla_name);
        $('#bangla_name_percentage').addClass(obj.bn_name_percentage_color);
        
        // english name percentage
        $('#ec_english_name').html(obj.ec_english_name);
        $('#ocr_english_name').html(obj.ocr_english_name);
        $('#english_name_percentage').html(obj.percentage_english_name);
        $('#english_name_percentage').addClass(obj.en_name_percentage_color);
        

        // father name percentage
        $('#ec_father_name').html(obj.ec_father_name);
        $('#ocr_father_name').html(obj.ocr_father_name);
        $('#father_name_percentage').html(obj.percentage_father_name);
        $('#father_name_percentage').addClass(obj.father_name_percentage_color);
        

        // mother name percentage
        $('#ec_mother_name').html(obj.ec_mother_name);
        $('#ocr_mother_name').html(obj.ocr_mother_name);
        $('#mother_name_percentage').html(obj.percentage_mother_name);
        $('#mother_name_percentage').addClass(obj.mother_name_percentage_color);
        

        // date of birth percentage
        $('#ec_date_of_birth').html(obj.ec_date_of_birth);
        $('#ocr_date_of_birth').html(obj.ocr_date_of_birth);
        $('#date_of_birth_percentage').html(obj.percentage_date_of_birth);
        $('#date_of_birth_percentage').addClass(obj.date_of_birth_percentage_color);
        

        // blood group percentage
        $('#ec_blood_group').html(obj.ec_blood_group);
        $('#ocr_blood_group').html(obj.ocr_blood_group);
        $('#blood_group_percentage').html(obj.percentage_blood_group);
        $('#blood_group_percentage').addClass(obj.blood_group_percentage_color);
        

        // address percentage
        $('#ec_address').html(obj.ec_address);
        $('#ocr_address').html(obj.ocr_address);
        $('#address_percentage').html(obj.percentage_address);
        $('#address_percentage').addClass(obj.address_percentage_color);
        
    }

    function showOverAllMatchingScore(score, color, result){
        var total_score   = 100;
        var match_score   = score;
        var unmatch_score = total_score - match_score;
        $('#overallmatcingtext').html(total_score + " / " + match_score);
        if(result === true){
            successToastNotification("Success", "Text maching score passing successfully");
            $('#textMatchinResult').html("Text Matching Verified");
        }else{
            errorToastNotification("Failed" , "Text Matching Score passing failed");
            $('#textMatchinResult').html("Text Matching Verification Failed");
        }
        $('#overallmatcingtext').html(total_score + " / " + match_score);
        var sparklineCharts = function(){        
            $("#overallspacleCircle").sparkline([match_score, unmatch_score], {
                type       : 'pie',
                height     : '140',
                sliceColors: [ color, '#F5F5F5']
            });
        };

        var sparkResize;

        $(window).resize(function(e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparklineCharts, 500);
        });

        sparklineCharts();
    }

    function showCustomerInforForFaceUpload(obj){
        $("#face_customer_nid").val(obj.customer_info.nid_number.trim());
        $("#face_customer_mobile_number").val(obj.customer_info.mobile_no.trim());
        $("#face_customer_english_name").val(obj.customer_info.en_name.trim());
        $("#face_customer_bangla_name").val(obj.customer_info.bn_name.trim());
        $("#face_customer_date_of_birth").val(obj.customer_info.date_of_birth.trim());
        $("#ec_face_image_prview").attr("src", obj.ec_face_image);
    }
</script>


<script>
    $('#startbutton').on('click', function(){
        $('#face_image_taken_show_section').show();
        $('#upload_face_image_show_part').hide();
    });
</script>

    <!-- OCR Data Review & Ammendment End -->

    <!-- Face Image Take From Webcam Section Start -->
    <script>
        $('#face_photo').on('click',function(e){
            currentStep(4);
        });

        function faceCompare(){
            var customer_id       = $("#customer_id").val();
            var ec_id             = $('#ec_id').val();
            var webcam_face_image = $('.webcam_face_image').attr('src');
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if(customer_id != '' && ec_id != '' && webcam_face_image !=''){
                $('#loader4').children('.ibox-content').addClass('sk-loading'); //add loading
                $.ajax({
                    type       : 'POST',
                    url        : "{{ route('customer.registation.face_compare')}}",
                    data       : {
                        "_token"           : $('#token').val(),
                        "customer_id"      : customer_id,
                        "ec_id"            : ec_id,
                        "webcam_face_image": webcam_face_image,
                    },
                    success    : (data) => {
                        $('#loader4').children('.ibox-content').removeClass('sk-loading'); //add loading
                        console.log(data);
                        // var obj = JSON.parse(data);
                        // if(obj.error_code === 400){
                        //       errorToastNotification("Face Match", "Please smile & take photo again"); 
                        //    }else if(obj.error_code === 200){
                        //       currentStep(5);
                        //       $('#face_matching_score_ec_face').attr('src', obj.ec_face_image.trim());
                        //       $('#face_matching_score_web_cam_image').attr('src',obj.webcam_face_image.trim());
                        //       showFaceMatchingScore(obj.recognize_percentage, obj.is_verified);
                        //    }
                    },
                    error: function(data) {
                        $('#loader4').children('.ibox-content').addClass('sk-loading'); //add loading
                    }
                });
            }else{
                errorToastNotification("Failed", "Please take webcam photo before face compare");
            }             
              
        }



        function showFaceMatchingScore(score, is_verified){
            var total_score   = 100;
            var match_score   = score;
            var unmatch_score = total_score - match_score;
            var color = '';
            if(is_verified == 1){
                $('#verify_failed').hide();
                $('#verify_success').show();               
                successToastNotification("Success", "Customer Face machting score passed succesfully.Now this customer is verified our application");
                $('#faceMatchingResult').html("Customer Verified");
                color = "#1ab394";
            }else{
                $('#verify_success').hide();
                $('#verify_failed').show();
                errorToastNotification("Failed", "Customer Face machting score passed failed.Please Try agin");
                $('#faceMatchingResult').html("Customer Verification Failed");
                color = "#ff6666";
            }
            $('#overallFaceMachingtext').html(total_score + " / " + match_score);
            var sparklineCharts = function(){        
                $("#facematchingscore").sparkline([match_score, unmatch_score], {
                    type: 'pie',
                    height: '140',
                    sliceColors: [color, '#F5F5F5']
                });
            };

            var sparkResize;

            $(window).resize(function(e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(sparklineCharts, 500);
            });

            sparklineCharts();
        }
    </script>
    <!-- Face Image Take From Webcam Section End -->




@endpush

