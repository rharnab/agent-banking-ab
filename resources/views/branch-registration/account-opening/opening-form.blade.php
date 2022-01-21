@extends('layouts.app')

@section('title')
    account-opening-form
@endsection

@push('css')
    <link href="{{ asset('assets/css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/select2/select2-bootstrap4.min.css')}}" rel="stylesheet">
    <style>
        .wizard-big.wizard > .content {
            min-height: 545px!important;
        }
    </style>
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Customer</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Customer</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Account Opening</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
       <div class="col-lg-12">
          <div class="ibox">
             <div class="ibox-title">
                <h5></h5>
             </div>
             <div class="ibox-content">
                <h2>
                   Account Opening Form
                </h2>
                <p>E-Kyc Verified Customer Account Opening Form</p>
                <form id="form" action="{{ route('branch.registration.save_account_opening_request', $registration_id) }}" class="wizard-big" method="POST">
                   @csrf
                    <h1>Personal</h1>
                   <fieldset>
                      <div class="row">
                         <div class="col-lg-6">
                            <h2>Personal Information</h2>
                            <div class="form-group">
                               <label>Customer Type *</label>
                               <select name="customer_type" id="" class="form-control required">
                                  <option value="">Select Customer Type</option>
                                  <option value="individual" selected>INDIVIDUAL</option>
                                  <option value="staff">STAFF</option>
                               </select>
                            </div>
                            <div class="form-group">
                               <label>Name *</label>
                               <input id="name" name="name" value="{{ $self_info->nameEn }}" type="text" class="form-control required">
                            </div>
                            <div class="form-group">
                               <label>Date Of Birth</label>
                               <input id="date_of_birth" name="date_of_birth" type="date" value="{{ $self_info->dob }}"  class="form-control required">
                            </div>
                            <div class="form-group">
                               <label>Country Of Birth *</label>
                               <select name="country_of_birth" id="country_of_birth" class="form-control required ">
                                  <option value="">Select Country</option>
                                  @foreach($countries as $country)
                                  <option value="{{ $country->id }}" @if($country->id == 18) {{ "selected" }} @endif >{{ $country->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                               <label style="text-transform: capitalize">Place of birth district *</label>
                               <select name="place_of_birth_district" id="place_of_birth_district" class="form-control required">
                                  <option value="">Select District</option>
                                  @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                               <label>Gender</label>
                               <select name="gender" id="gender" class="form-control required">
                                  <option value="">Select Gender</option>
                                  <option value="male" @if($self_info->gender == "male") {{ "selected" }} @endif>Male</option>
                                  <option value="female" @if($self_info->gender == "female") {{ "selected" }} @endif>Fe-Male</option>
                               </select>
                            </div>
                         </div>
                         <div class="col-lg-6">
                            <h2>Relation</h2>
                            <div class="form-group">
                               <label>Father name *</label>
                               <input id="father_name" name="father_name" type="text" value="{{ $self_info->father }}" class="form-control required">
                            </div>
                            <div class="form-group">
                               <label>Mother name *</label>
                               <input id="mother_name" name="mother_name" type="text" value="{{ $self_info->mother }}" class="form-control required">
                            </div>
                         </div>
                      </div>
                   </fieldset>
                   <h1>Address</h1>
                   <fieldset>
                      <div class="row">
                         <div class="col-lg-6">
                            <h2>Present Address</h2>
                            <div class="form-group">
                               <label>Present Country *</label>
                               <select name="present_country_code" id="present_country_code" class="form-control  required">
                                  <option value="">Select Country</option>
                                  @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @if($country->id == 18) {{ "selected" }} @endif>{{ $country->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                               <label style="text-transform: capitalize">Present Address</label>
                               <textarea name="present_address" id="present_address" class="form-control required" cols="3" rows="3">{{ $self_info->present_address }}</textarea>
                            </div>
                            <div class="form-group">
                               <label>Present Division</label>
                               <select name="present_division" id="present_division" class="form-control required">
                                  <option value="">Present Division</option>
                                  @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" @if($division->id == $agent_data->division_id ) {{ "selected" }} @endif  >{{ $division->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                               <label>Present District</label>
                               <select name="present_district" id="present_district" class="form-control required ">
                                  <option value="">Present District</option>
                                  @foreach($districts as $district)
                                    <option value="{{ $district->id }}" @if($district->id == $agent_data->district_id ) {{ "selected" }} @endif >{{ $district->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                               <label>Mobile No For IB/SMS</label>
                               <input type="text" name="mobile_no_for_id_sms" value="{{ $self_info->mobile_number }}" class="form-control required">
                            </div>
                         </div>
                         <div class="col-lg-6">
                            <h2>Permanent Address</h2>
                            <div class="form-group">
                               <label>Permanent Country *</label>
                               <select name="parmanent_country_code" id="parmanent_country_code" class="form-control  required ">
                                  <option value="">Select Country</option>
                                  @foreach($countries as $country)
                                  <option value="{{ $country->id }}" @if($country->id == 18) {{ "selected" }} @endif>{{ $country->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                               <label style="text-transform: capitalize">Permanent Address</label>
                               <textarea name="parmanent_address" id="parmanent_address" class="form-control required" cols="3" rows="3">{{ $self_info->permanentAddress }}</textarea>
                            </div>
                            <div class="form-group">
                               <label>Permanent Division</label>
                               <select name="parmanent_division" id="parmanent_division" class="form-control required  ">
                                  <option value="">Permanent Division</option>
                                  @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" @if($division->id == $agent_data->division_id ) {{ "selected" }} @endif  >{{ $division->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                               <label>Permanent District</label>
                               <select name="parmanent_district" id="parmanent_district" class="form-control required  ">
                                  <option value="">Permanent District</option>
                                  @foreach($districts as $district)
                                    <option value="{{ $district->id }}" @if($district->id == $agent_data->district_id ) {{ "selected" }} @endif >{{ $district->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                         </div>
                      </div>
                   </fieldset>
                   <h1>Other Information</h1>
                   <fieldset>
                      <div class="row">
                         <div class="col-lg-6">
                            <h2>Other Information</h2>
                            <div class="form-group">
                               <label>Source of Fund *</label>
                               <input type="text" name="source_of_fund" id="source_of_fund" class="form-control required">
                            </div>
                            <div class="form-group">
                               <label>SBS Sector Code *</label>
                               <select name="sbs_sector_code" id="sbs_sector_code" class="form-control   required">
                                  <option value="">SBS Sector Code</option>
                                  @foreach($sbs_sector_codes as $sbs_sector_code)
                                  <option value="{{ $sbs_sector_code->id }}">{{ $sbs_sector_code->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                               <label>BB Occupation Category</label>
                               <select name="bb_occupation_code" id="bb_occupation_code" class="form-control   required">
                                  <option value="">Select BB Occupation Category</option>
                                  @foreach($bb_occupation_categories as $bb_occupation_categorie)
                                  <option value="{{ $bb_occupation_categorie->id }}">{{ $bb_occupation_categorie->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                               <label>Occupation Details *</label>
                               <textarea name="occupation_details" id="occupation_details" cols="3" rows="3" class="form-control required"></textarea>
                            </div>
                         </div>
                         <div class="col-lg-6">
                            <h2>&nbsp;</h2>
                            <div class="form-group">
                               <label>Monthly income / Annual Ternover *</label>
                               <input type="text" name="monthly_income_annual_tunover" id="monthly_income_annual_tunover" class="form-control required">
                            </div>
                            <div class="form-group">
                               <label>Communication Address</label>
                               <select name="communication_address" id="communication_address" class="form-control  required">
                                  <option value="">Select Communication Address</option>
                                  <option value="present_address" selected>Present Address</option>
                                  <option value="permanent_address">Permanent Address</option>
                                  <option value="professional_address">Professional Address</option>
                               </select>
                            </div>
                            <div class="form-group">
                               <label>Walk in Customer</label>
                               <select name="walk_in_customer" id="walk_in_customer" class="form-control required ">
                                  <option value="">Select walk in customer</option>
                                  <option value="yes" selected>Yes</option>
                                  <option value="no">No</option>
                               </select>
                            </div>
                         </div>
                      </div>
                   </fieldset>
                   <h1>Deposit</h1>
                   <fieldset>
                      <div class="row">
                         <div class="col-lg-6">
                            <h2>General Information</h2>
                            <div class="form-group">
                               <label>Account Type *</label>
                               <select name="account_type_code" id="account_type_code" onchange="findProduct()" class="form-control required ">
                                  <option value="">Account Type</option>
                                  @foreach($account_types as $account_type)
                                    <option value="{{ $account_type->id }}">{{ $account_type->name }}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                              <label>Product Type *</label>
                              <select name="product_code" id="product_code" class="form-control required ">
                                 <option value="">Product Type</option>
                                 @foreach($products as $product)
                                   <option value="{{ $product->id }}">{{ $product->name }}</option>
                                 @endforeach
                              </select>
                           </div>
                            <div class="form-group">
                               <label style="text-transform: capitalize">Mode Of Operation</label>
                               <select name="mode_of_operation" id="mode_of_operation" class="form-control required  ">
                                  <option value="">Mode of Operation</option>
                                  <option value="single">Single</option>
                                  <option value="jointly">Jointly</option>
                                  <option value="either_or_survivor">Either or Survivor</option>
                               </select>
                            </div>
                            <div class="form-group">
                               <label>Customer</label>
                               <input type="text" name="customer" id="customer" value="{{ $self_info->nameEn }}" class="form-control required">
                            </div>
                            <div class="form-group">
                               <label>Account Title</label>
                               <input type="text" name="account_title" id="account_title" value="{{ $self_info->nameEn }}" class="form-control required">
                            </div>
                            <div class="form-group">
                               <label>Account Opening Date</label>
                               <input type="date" name="ac_opening_date" value="{{ date('Y-m-d') }}" id="ac_opening_date" class="form-control required">
                            </div>
                         </div>
                         <div class="col-lg-6">
                            <h2>Charges / Other Info</h2>
                            <div class="form-group">
                               <label>Source Of Fund *</label>
                               <input type="text" name="charge_source_of_fund" id="charge_source_of_fund" class="form-control required">
                            </div>
                            <hr>
                            <h2>Introduces / Information</h2>
                            <div class="form-group">
                               <label>Introduces Account / PA No. *</label>
                               <input type="text" name="introduces_account_pa_no" id="introduces_account_pa_no" class="form-control required">
                            </div>
                         </div>
                      </div>
                   </fieldset>
                </form>
             </div>
          </div>
       </div>
    </div>
 </div>
@endsection


@push('js')
    <!-- Steps -->
    <script src="{{ asset('assets/js/plugins/steps/jquery.steps.min.js')}}"></script>

    <!-- Jquery Validate -->
    <script src="{{ asset('assets/js/plugins/validate/jquery.validate.min.js')}}"></script>

    <!-- Select2 -->
    <script src="{{ asset('assets/js/plugins/select2/select2.full.min.js')}}"></script>

<script>
    $(document).ready(function(){
        $("#wizard").steps();
        $("#form").steps({
            bodyTag: "fieldset",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex)
                {
                    return true;
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 3 && Number($("#age").val()) < 18)
                {
                    return false;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                // Suppress (skip) "Warning" step if the user is old enough.
                if (currentIndex === 2 && Number($("#age").val()) >= 18)
                {
                    $(this).steps("next");
                }

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3)
                {
                    $(this).steps("previous");
                }
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                var form = $(this);

                // Submit form input
               form.submit();
            }
        }).validate({
                    errorPlacement: function (error, element)
                    {
                        element.before(error);
                    },
                    rules: {
                        confirm: {
                            equalTo: "#password"
                        }
                    }
                });
   });

</script>

<script>
   function findProduct(){
      $.ajaxSetup({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         })
      var account_type_code = $('#account_type_code').val();
      if(account_type_code != ''){
         $.ajax({
            type: 'POST',
            url : "{{ route('branch.registration.find_product') }}",
            data: {
               "account_type_code": account_type_code,
            },
            success    : (data) => {
               console.log(data);
               $('#product_code').empty().append(data);
            },
            error: function(data) {
               console.log(data);
            }
         });
      }
   }
</script>

@endpush