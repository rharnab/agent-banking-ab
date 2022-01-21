@php
   use App\Http\Controllers\Controller; 
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-KYC | SELF-REGISTRATION</title>

    
    <link rel="shortcut icon" sizes="16x16" type="image/jpg" href="{{ asset('assets/img/favicon-32x32.png') }}"/>


    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/customer-registation.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
  
    <link href="{{ asset('assets/css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/customer-registation.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/outside-customer.css')}}" rel="stylesheet">




   <style>
      .help-block {
         font-weight: bold;
         color: red;
      }
      .ibox-title h5 {
         text-transform: uppercase;
         font-weight: bold;
         color: #000;
      }
      img#signature_image_preview {
         padding-left: 18px;
      }
      .error_message {
         padding: 10px 0px 0px 18px;
         margin-bottom: -21px;
         font-size: 80%;
         color: #dc3545;
      }
   </style>


</head>

<input type="hidden" id="token" value="{{ csrf_token() }}">

<body class="gray-bg">

   <div class="spiner_example">
      <div class="sk-spinner sk-spinner-double-bounce me">
         <div class="sk-double-bounce1"></div>
         <div class="sk-double-bounce2"></div>
      </div>
   </div>

   <!-- Hidden Route Section Start -->
   <input type="hidden" id="nid_upload_and_ocr_route" value="{{ route('self.registation.nid_upload_and_ocr') }}">
   <input type="hidden" id="ammendment_ocr_data_route" value="{{ route('self.registation.ammendment_ocr_data') }}">
   <input type="hidden" id="face_image_route" value="{{ route('self.registation.face_image') }}">
   <input type="hidden" id="signature_upload_route" value="{{ route('self.registation.signature_upload') }}">
   <input type="hidden" id="review_data_route" value="{{ route('self.registation.review_data') }}">
   <input type="hidden" id="account_opening_route" value="{{ route('self.registation.account_opening') }}">
   <input type="hidden" id="nominee_setup_route" value="{{ route('self.registation.nominee_setup') }}">
   <!-- Hidden Route Section End -->

<section class="full-conetent">

      @php
         $check_status =  App\Http\Controllers\SelfRegistration\CheckSelfRegistrationStatusController::checkSelfRequestCompleate($company_id, $user_id);
      @endphp


{{ $check_status }}
      


      @if($check_status !== false)
         <div class="wrapper  animated fadeInRight" style="padding: 20px 14px 0px;">
            <div class="row">
               <div class="col-lg-12">
                  <div class="ibox collapsed">
                     <div style="padding: 20px 14px;  background: #ed5565;  color: #ffffff; font-weight: bold;">
                        <h5>{{ $check_status }}</h5>
                     </div>
                  </div>
               </div>
            </div>
         </div>         
      @else
         <div class="wrapper  animated fadeInRight" style="padding: 20px 14px 0px;">
            <div class="row">
               <div class="col-md-12">
                  <div class="ibox outstep">
                     <div class="ibox-content">
                        <div class="container">
                           <h4 class="text-center" id="text_up" style="color: #1ab394;text-transform: uppercase;">NID Image Upload</h4>
                           <div class="progress-bar_custom">
                              <div class="step">
                                 <p class="step_text_1"> Nid  Upload</p>
                                 <div class="bullet step_bullet_1">
                                    <span>1</span>
                                 </div>
                                 <div class="check fas fa-check"></div>
                              </div>
                              <div class="step">
                                 <p class="step_text_2">Amendment data</p>
                                 <div class="bullet step_bullet_2">
                                    <span>2</span>
                                 </div>
                                 <div class="check fas fa-check"></div>
                              </div>
                              <div class="step">
                                 <p class="step_text_3">Face Image</p>
                                 <div class="bullet step_bullet_3">
                                    <span>3</span>
                                 </div>
                                 <div class="check fas fa-check"></div>
                              </div>
                              <div class="step">
                                 <p class="step_text_4">Signature Upload</p>
                                 <div class="bullet step_bullet_4">
                                    <span>4</span>
                                 </div>
                                 <div class="check fas fa-check"></div>
                              </div>
                              <div class="step">
                                 <p class="step_text_5">Review Data</p>
                                 <div class="bullet step_bullet_5">
                                    <span>5</span>
                                 </div>
                                 <div class="check fas fa-check"></div>
                              </div>
                              <div class="step">
                                 <p class="step_text_6">Account Opening</p>
                                 <div class="bullet step_bullet_6">
                                    <span  onclick=" outSideCurrentStep(6); text_up6();" >6</span>
                                 </div>
                                 <div class="check fas fa-check"></div>
                              </div>
                              <div class="step">
                                 <p class="step_text_7">Nominee Setup</p>
                                 <div class="bullet step_bullet_7">
                                    <span>7</span>
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
         <!-- Error message section start  -->
         <div class="error_message" id="error_message_show_section" >
            <div class="row">
               <div class="col-md-12">
                  <p id="error_messasge_block" style="font-weight:bold; font-size:12px; text-transform:capitalize"></p>
               </div>
            </div>
         </div>
         <!-- Error message section end  -->
         
         <!-- NID Upload Section Start -->
         <div class="step_1">
            <div class="wrapper wrapper-content animated fadeInRight" id="loader1">
               <form id="nid-upload" method="POST" enctype="multipart/form-data" action="javascript:void(0)">
                  @csrf
                  <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                  <input type="hidden" name="phone" id="phone" value="{{ $phone }}">
                  <div class="row">
                     {{-- Front Image Show Part --}}
                     <div class="col-lg-4" id="front_image_show_part">
                        <div class="ibox ">
                           <div class="ibox-title text-uppercase">
                              <h5>National ID Front Image</h5>
                           </div>
                           <div class="ibox-content" style="height: 200px;display: flex; align-items: center; justify-content: center;">
                              <img  class="img img-fluid img-responsive" style="width:100%; height: 100%;" src="https://www.setaswall.com/wp-content/uploads/2017/04/Pastel-Gray-Solid-Color-Background-Wallpaper-5120x2880-768x432.png"  id="front_image_preview"  alt="">                        
                           </div>
                           <div class="fileinput fileinput-new">
                              <span class="btn btn-primary btn-file"><span class="fileinput-new">Nid Front</span>
                              <span class="fileinput-exists">Change</span><input id="front_image" required type="file" accept="image/*" name="front_image" /></span>
                           </div>
                           <p class="help-block" id="nid_front_image_error_message"></p>
                        </div>
                     </div>
                     {{-- Back image part show --}}
                     <div class="col-lg-4" id="back_image_show_part">
                        <div class="ibox ">
                           <div class="ibox-title text-uppercase">
                              <h5>National ID Back Image</h5>
                           </div>
                           <div class="ibox-content" style="height: 200px;display: flex; align-items: center; justify-content: center;" >
                              <img  class="img img-fluid img-responsive" style="width:100%; height: 100%;"    src="https://www.setaswall.com/wp-content/uploads/2017/04/Pastel-Gray-Solid-Color-Background-Wallpaper-5120x2880-768x432.png" id="back_image_preview" alt="">                        
                           </div>
                           <div class="fileinput fileinput-new">
                              <span class="btn btn-primary btn-file">
                              <span class="fileinput-new">NID Back</span>
                              <span class="fileinput-exists">Change</span>
                              <input id="back_image" type="file" required accept="image/*" name="back_image" />
                              </span>
                           </div>
                           <p class="help-block" id="nid_back_image_error_message"></p>
                        </div>
                        <div class="form-group row" style="padding-left: 15px;">
                           <div class="col-lg-8"></div>
                           <div class="col-lg-4">
                              <button class="btn btn-primary btn-block" type="submit">Next   &nbsp; &nbsp; <i class="fa fa-forward"></i></button> 
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <!-- NID Upload Section End -->

         <!-- OCR Data Review & Ammendment Section Start -->
         <div class="step_2">
            <div class="wrapper wrapper-content animated fadeInRight">
               <div class="row">
                  <div class="col-lg-4"></div>
                  <div class="col-lg-4">
                     <form id="ammendment-data" method="POST" enctype="multipart/form-data" action="javascript:void(0)">
                        <div class="ibox">
                           <div class="ibox-title text-uppercase">
                              <h5>AMENDMENT DATA</h5>
                           </div>
                           <input type="hidden" id="self_request_id" name="self_request_id">
                           <div class="ibox-content">
                              <div class="col-lg-12">
                                 <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Name (English)</label>
                                    <div class="col-lg-8">
                                       <input type="text" class="form-control" required  name="english_name" id="english_name" >
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Date Of Birth</label>
                                    <div class="col-lg-8">
                                       <input type="date" class="form-control" required  name="date_of_birth" id="date_of_birth">
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">NID Number</label>
                                    <div class="col-lg-8">
                                       <input type="text" class="form-control" required name="nid_number" placeholder="NID Number" id="nid_number">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <br>
                           <div class="row">
                              <div class="col-sm-6" style="width: 50%">
                                 <button type="button" onclick="outSideCurrentStep(1);text_up1();" class="btn btn-danger btn-block"><i class="fa fa-backward"></i> &nbsp; &nbsp; Back</button>                       
                              </div>
                              <div class="col-sm-6"  style="width: 50%">
                                 <button type="submit" class="btn btn-primary btn-block">Next &nbsp; &nbsp; <i class="fa fa-forward"></i></button>
                              </div>
                           </div>
                     </form>
                     </div>
                  </div>
                  <div class="col-lg-4"></div>
               </div>
            </div>
         </div>
         <!-- OCR Data Review & Ammendment Section End -->

         <!-- Face Match Score  Section Start -->
         <div class="step_3">
            <div class="wrapper wrapper-content animated fadeInRight">
               <div class="row">
                  <div class="col-lg-4">
                  </div>
                  {{-- Front Image Show Part --}}
                  <div class="col-lg-4" id="f_image_show_part">
                     <form id="face-image-upload" method="POST" enctype="multipart/form-data" action="javascript:void(0)">
                        @csrf
                        <input type="hidden" id="face_self_requested_id" name="face_self_requested_id">
                        <p class="help-block" style="padding-left: 6px;" id="face-match-error-message"></p>
                        <div class="ibox ">
                           <div class="ibox-title text-uppercase">
                              <h5>Face Image</h5>
                           </div>
                           <div class="ibox-content" style="height: 290px;display: flex; align-items: center; justify-content: center;">
                              <img  class="img img-fluid img-responsive" style="width:100%; height: 100%;"  src="https://www.setaswall.com/wp-content/uploads/2017/04/Pastel-Gray-Solid-Color-Background-Wallpaper-5120x2880-768x432.png"  id="f_image_preview"  alt="">                        
                           </div>
                           <div class="fileinput fileinput-new face-image-button">
                              <span class="btn btn-primary btn-file"><span class="fileinput-new">Face Image</span>
                              <span class="fileinput-exists">Change</span><input id="f_image" required type="file" accept="image/*" name="f_image" /></span>
                           </div>
                           <p class="help-block" id="face_upload_error_message"></p>
                           <br>
                           <div class="row">
                              <div class="col-sm-6" style="width: 50%">
                                 <button type="button" onclick="outSideCurrentStep(2);text_up2();" class="btn btn-danger btn-block"><i class="fa fa-backward"></i> &nbsp; &nbsp; Back</button>                       
                              </div>
                              <div class="col-sm-6"  style="width: 50%">
                                 <button type="submit" class="btn btn-primary btn-block">Next &nbsp; &nbsp; <i class="fa fa-forward"></i></button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <!-- Face Match Score  Section Start -->

         <!-- Signature Upload Section Start -->
         <div class="step_4">
            <div class="wrapper wrapper-content animated fadeInRight">
               <div class="row">
                  <div class="col-lg-4">
                  </div>
                  {{-- Front Image Show Part --}}
                  <div class="col-lg-4" id="signature_image_show_part">
                     <form id="signature-upload" method="POST" enctype="multipart/form-data" action="javascript:void(0)">
                        <input type="hidden" name="signature_self_request_id" id="signature_self_request_id">
                        @csrf
                        <div class="ibox ">
                           <div class="ibox-title text-uppercase">
                              <h5>Signature</h5>
                           </div>
                           <div class="ibox-content" style="height: 153px;display: flex; align-items: center; justify-content: center;">
                              <img  class="img img-fluid img-responsive" style="width:100%; height: 100%;" src="https://www.setaswall.com/wp-content/uploads/2017/04/Pastel-Gray-Solid-Color-Background-Wallpaper-5120x2880-768x432.png"  id="signature_image_preview"  alt="">                        
                           </div>
                           <div class="fileinput fileinput-new" style="top: 163px;">
                              <span class="btn btn-primary btn-file"><span class="fileinput-new">Signature</span>
                              <span class="fileinput-exists">Change</span><input id="signature_image" required type="file" accept="image/*" name="signature_image" /></span>
                           </div>
                           <p class="help-block" id="signature_error_message"></p>
                        </div>
                        <div class="row">
                           <div class="col-sm-6" style="width: 50%">
                              <button type="button" onclick="outSideCurrentStep(3);text_up3();" class="btn btn-danger btn-block"><i class="fa fa-backward"></i> &nbsp; &nbsp; Back</button>                       
                           </div>
                           <div class="col-sm-6"  style="width: 50%">
                              <button type="submit" class="btn btn-primary btn-block">Next &nbsp; &nbsp; <i class="fa fa-forward"></i></button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <!-- Signature Upload Section End -->

         <!-- Review Customer Own Information Section Start -->
         <div class="step_5">
            <form id="review-data-submit" method="POST" enctype="multipart/form-data"  action="javascript:void(0)" >
               @csrf
               <input type="hidden" id="review_account_opening_self_request_id" name="review_account_opening_self_request_id">
               <input type="hidden" id="review_account_opeing_id" name="review_account_opeing_id">
               <div class="col-lg-6 offset-lg-3">
                  <div class="tabs-container">
                     <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Customer Own Information</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Customer Family Information</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Address</a></li>
                     </ul>
                     <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                           <div class="panel-body">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                       <label class="col-lg-3 col-form-label">Name (English) </label>
                                       <div class="col-lg-9">
                                          <input type="text" name="review_english_name"  id="review_english_name" class="form-control"> 
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-lg-3 col-form-label">Bangla Name</label>
                                       <div class="col-lg-9">
                                          <input type="text" name="review_bangla_name" id="review_bangla_name" class="form-control"> 
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-lg-3 col-form-label">Blodd Group</label>
                                       <div class="col-lg-9">
                                          <input type="text" name="review_blood_group" id="review_blood_group" class="form-control"> 
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-lg-3 col-form-label">Date of Birth</label>
                                       <div class="col-lg-9">
                                          <input type="date" name="review_date_of_birth" id="review_date_of_birth" class="form-control"> 
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
                                       <label class="col-lg-3 col-form-label">Father Name</label>
                                       <div class="col-lg-9">
                                          <input type="text" name="review_father_name"  id="review_father_name"   class="form-control"> 
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label class="col-lg-3 col-form-label">Mother Name</label>
                                       <div class="col-lg-9">
                                          <input type="text" name="review_mother_name" id="review_mother_name" class="form-control">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div role="tabpanel" id="tab-3" class="tab-pane">
                           <div class="panel-body">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                       <label class="col-lg-3 col-form-label">Address</label>
                                       <div class="col-lg-9">
                                          <textarea name="review_address"  id="review_address"   class="form-control" cols="10" rows="5"></textarea>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-sm-6" style="width: 50%">
                        <button type="button" onclick="outSideCurrentStep(4);text_up4();" class="btn btn-danger btn-block"><i class="fa fa-backward"></i> &nbsp; &nbsp; Back</button>                       
                     </div>
                     <div class="col-sm-6"  style="width: 50%">
                        <button type="submit" class="btn btn-primary btn-block">Next &nbsp; &nbsp; <i class="fa fa-forward"></i></button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <!-- Review Customer Own Information Section End -->

         <!-- Account Opening Section Start -->
         <div class="step_6">
            <div class="wrapper wrapper-content animated fadeInRight">
               <div class="row">
                  <div class="col-lg-4"></div>
                  <div class="col-lg-4">
                     <form id="account_opening_information"  method="POST" enctype="multipart/form-data"  action="javascript:void(0)">
                        <div class="ibox">
                           <div class="ibox-title text-uppercase">
                              <h5>Account Opening Information</h5>
                           </div>
                           <input type="hidden" name="account_opening_id" id="account_opening_id">                      
                           <input type="hidden" name="account_self_request_id" id="account_self_request_id">                      
                           <div class="ibox-content">
                              <div class="col-lg-12">
                                  
                                  <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Account Type</label>
                                    <div class="col-lg-8">
                                       <select  class="form-control" name="branch_id" required>
                                          <option value="">--Select Account Type--</option>
                                          <option value="">Saving Account</option>
                                          <option value="">Cash Security For BTB</option>
                                       </select>
                                    </div>
                                 </div>
                                  
                                 <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Select Branch</label>
                                    <div class="col-lg-8">
                                       <select  class="form-control" name="branch_id" required >
                                          <option value="">--Select Branch--</option>
                                          @foreach($allBranch as $singleBranch)
                                          <option value="{{ $singleBranch->id }}">{{ $singleBranch->name }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Monthly Income</label>
                                    <div class="col-lg-8">
                                       <input type="number" name="probably_monthly_income" required class="form-control" placeholder="Monthly Income">                                       
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Probably Monthly Deposite</label>
                                    <div class="col-lg-8">
                                       <input type="number" name="probably_monthly_deposite" required class="form-control" placeholder="Probably Monthly Deposite">                                       
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Probably Monthly Withdraw</label>
                                    <div class="col-lg-8">
                                       <input type="number" name="probably_monthly_withdraw" required class="form-control" placeholder="Probably Monthly Withdray">                                       
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <br>
                           <div class="row">
                              <div class="col-sm-6" style="width: 50%">
                                 <button type="button" onclick="outSideCurrentStep(5);text_up5();" class="btn btn-danger btn-block"><i class="fa fa-backward"></i> &nbsp; &nbsp; Back</button>                       
                              </div>
                              <div class="col-sm-6"  style="width: 50%">
                                 <button type="submit" class="btn btn-primary btn-block">Next &nbsp; &nbsp; <i class="fa fa-forward"></i></button>
                              </div>
                           </div>
                     </form>
                     </div>
                  </div>
                  <div class="col-lg-4"></div>
               </div>
            </div>
         </div>
         <!-- Account Opening Section End -->

         <!-- Nominee Setup Section Start -->
         <div class="step_7">
            <div class="wrapper wrapper-content animated fadeInRight">
               <div class="row">
                  <div class="col-lg-4"></div>
                  <div class="col-lg-4">
                     <div class="ibox" id="loader1">
                        <div class="ibox-title text-uppercase">
                           <h5>Nominee Setup</h5>
                        </div>
                        <div class="ibox-content" style="height: 290px;display: flex; align-items: center; justify-content: center;">
                           <form id="nominee_setup"  method="POST" enctype="multipart/form-data" action="javascript:void(0)">
                              @csrf
                              <input type="hidden" name="nominee_account_opening_id" id="nominee_account_opening_id">
                              <input type="hidden" name="nominee_self_request_id" id="nominee_self_request_id">
                              <div class="form-group row" style="padding-left: 15px;margin-top: 30px;">
                                 <label class="col-lg-4">Nominee Name</label>
                                 <div class="col-lg-8">
                                    <div class="name">
                                       <input type="text" name="nominee_name" required class="form-control" >                                       
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row" style="padding-left: 15px;">
                                 <label class="col-lg-4">Nominee NID Number</label>
                                 <div class="col-lg-8">
                                    <div class="nid_number">
                                       <input type="text" name="nominee_nid_number" required class="form-control" >                                       
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group row" style="padding-left: 15px;">
                                 <label class="col-lg-4">Address</label>
                                 <div class="col-lg-8">
                                    <div class="address">
                                       <textarea class="form-control" name="nominee_address" required rows="3" cols="6"></textarea>                                       
                                    </div>
                                 </div>
                              </div>
                              <!-- End NID Upload Form -->
                        </div>
                        <br><br>
                        <div class="row">
                        <div class="col-sm-6" style="width: 50%">
                        <button type="button"  onclick="outSideCurrentStep(6);text_up6();" class="btn btn-danger btn-block"><i class="fa fa-backward"></i> &nbsp; &nbsp; Back</button>                       
                        </div>
                        <div class="col-sm-6"  style="width: 50%">
                        <button type="submit" class="btn btn-primary btn-block">Next &nbsp; &nbsp; <i class="fa fa-forward"></i> </button>
                        </div>
                        </div>
                        </form>
                     </div>
                  </div>
                  <div class="col-lg-4"></div>
               </div>
            </div>
         </div>
         <!-- Nominee Setup Section Start -->
         
         <!-- Confirmation Section Start -->
         <div class="step_8">
            <div class="wrapper  animated fadeInRight" style="padding: 20px 14px 0px;">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="ibox collapsed">
                        <div style="background-color: #1ab394; color:#FFF; padding: 20px 14px">
                           <h5>Your acccount opening request has been successfully receive. Bank authority will contact with you very soon.</h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Confirmation Section End -->
      @endif

</section>                       
                       


   <script src="{{ asset('assets/js/jquery-3.1.1.min.js') }}"></script>
   <script src="{{ asset('assets/js/popper.min.js') }}"></script>
   <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
   <script src="{{ asset('assets/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
   <script src="{{ asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

   <!-- Custom and plugin javascript -->
   <script src="{{ asset('assets/js/inspinia.js') }}"></script>
   <script src="{{ asset('assets/js/plugins/pace/pace.min.js') }}"></script>

   <script src="{{ asset('assets/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>


   <!-- jQuery Validator Js -->
   <script src="{{ asset('assets/js/plugins/validator/validate.min.js') }}"></script>
   <script src="{{ asset('assets/js/plugins/validator/additional-method.min.js') }}"></script>

   <!-- Custom Validation in Js  -->
   <script src="{{ asset('assets/custom-js/outside-customer/validation.js') }}"></script>

   <!-- Customer Regitstation-->
   <script src="{{ asset('assets/custom-js/customer-registation/customer-registation.js') }}"></script>
   <script src="{{ asset('assets/custom-js/outside-customer/index.js') }}"></script>

   <!-- Self Registation Js Loaded  -->
   <script src="{{ asset('assets/custom-js/self-registration/self_registration.js') }}"></script>

   <!-- Nid Upload & Ocr Js loader -->
   <script src="{{ asset('assets/custom-js/self-registration/nid_upload_and_ocr.js') }}"></script>

   <!--Ammendment Data Js loader -->
   <script src="{{ asset('assets/custom-js/self-registration/ammendment_data.js') }}"></script>

   
   <!--Face Verification Js loader -->
   <script src="{{ asset('assets/custom-js/self-registration/face_verification.js') }}"></script>

   
   <!--Signature Upload Js loader -->
   <script src="{{ asset('assets/custom-js/self-registration/signature_upload.js') }}"></script>

   <!--Review & Modify  Js loader -->
   <script src="{{ asset('assets/custom-js/self-registration/review_and_modify.js') }}"></script>

   <!-- Account Opening Js Loader -->
   <script src="{{ asset('assets/custom-js/self-registration/account_opening.js') }}"></script>

   <!-- Account Opening Js Loader -->
   <script src="{{ asset('assets/custom-js/self-registration/nominee_setup.js') }}"></script>





</body>
</html>
