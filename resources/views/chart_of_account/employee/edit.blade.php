@extends('layouts.app')

@section('title', 'Edit-Employee')

@push('css')
    <link href="{{ asset('assets/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/select2/select2-bootstrap4.min.css')}}" rel="stylesheet">
@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Add Employee</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Employee
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Employee</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Edit Employee Setup</h5>                   
                </div>
                <div class="ibox-content">
                    <form id="account-setup-form" action="{{ route('employee_setup.update', $employee_info->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Select User</label>
                            <div class="col-lg-8">
                                <select class="select2 form-control" required  onchange="userEmailPhone()" name="user_id" id="user_id">
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if($employee_info->user_id == $user->id) {{ "selected" }} @endif >{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        

                        <div class="form-group row" id="parent_acc">
                            <label class="col-lg-4 col-form-label">Select Designation</label>
                            <div class="col-lg-8">
                                <select class="select2 form-control" required  name="designation_id" id="designation_id">
                                    <option value="">Select Designation</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}" @if($employee_info->designation_id == $designation->id) {{ "selected" }} @endif >{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="parent_acc">
                            <label class="col-lg-4 col-form-label">Select Blood Group</label>
                            <div class="col-lg-8">
                                <select class="select2 form-control" required  name="blood_group_id" id="blood_group_id">
                                    <option value="">Select Blood Group</option>
                                    @foreach($blood_groups as $blood_group)
                                        <option value="{{ $blood_group->id }}" @if($employee_info->blood_group_id == $blood_group->id) {{ "selected" }} @endif >{{ $blood_group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Name</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="name" id="name" value="{{ $employee_info->name }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Personal Phone</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="personal_phone" id="personal_phone" value="{{ $employee_info->personal_phone }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Email</label>
                            <div class="col-lg-8">
                                <input type="email" class="form-control" name="personal_email" id="personal_email" value="{{ $employee_info->personal_email }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Father Name</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="father_name" id="father_name" value="{{ $employee_info->father_name }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Mother Name</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="mother_name" id="mother_name" value="{{ $employee_info->mother_name }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Spouse Name (If Married)</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="spouse_name" id="spouse_name" value="{{ $employee_info->spouse_name }}" >
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Office Phone</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="official_phone" id="official_phone" value="{{ $employee_info->official_phone }}">
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Current Address</label>
                            <div class="col-lg-8">
                                <textarea name="current_address" id="current_address" cols="30" rows="3" class="form-control" required>{{ $employee_info->current_address }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Permanent Address</label>
                            <div class="col-lg-8">
                                <textarea name="permanent_address" id="permanent_address" cols="30" rows="3" class="form-control" required>{{ $employee_info->permanent_address }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Reference</label>
                            <div class="col-lg-8">
                                <textarea name="reference" id="reference" cols="30" rows="3" class="form-control">{{ $employee_info->reference }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">National ID No</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="national_id_no" id="national_id_no" value="{{ $employee_info->national_id_no }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Passport ID No</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="passport_id_no" id="passport_id_no" value="{{ $employee_info->passport_id_no }}" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Emergency Contact Person</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="emergency_contact_person" id="emergency_contact_person" value="{{ $employee_info->emergency_contact_person }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Emergency Contact Person Relation</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="emergency_contact_person_relation" id="emergency_contact_person_relation" value="{{ $employee_info->emergency_contact_person_relation }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Previous Working Experience</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="previous_working_experience" id="previous_working_experience" value="{{ $employee_info->previous_working_experience }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Join Date</label>
                            <div class="col-lg-8">
                                <input type="date" class="form-control" name="join_date" id="join_date" value="{{ $employee_info->join_date }}" required>
                            </div>
                        </div>

                        <div class="form-group row" id="parent_acc">
                            <label class="col-lg-4 col-form-label">Work Type</label>
                            <div class="col-lg-8">
                                <select class="select2 form-control" required  name="work_type" id="work_type">
                                    <option value="">Select Work Type</option>
                                    <option value="fulltime" @if($employee_info->work_type == "fulltime") {{ "selected" }} @endif >Full-Time</option>
                                    <option value="parttime" @if($employee_info->work_type == "parttime") {{ "selected" }} @endif >Part-Time</option>
                                    <option value="contractual" @if($employee_info->work_type == "contractual") {{ "selected" }} @endif >Contractual</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="parent_acc">
                            <label class="col-lg-4 col-form-label">Upload Resume</label>
                            <div class="col-lg-8">
                                <div class="custom-file">
                                    <input id="logo" type="file" name="resume"  accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="custom-file-input">
                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                </div> 
                            </div>
                        </div>

                        <div class="form-group row" id="parent_acc">
                            <label class="col-lg-4 col-form-label">Photo</label>
                            <div class="col-lg-8">
                                <div class="custom-file">
                                    <input id="logo" type="file" name="photo" accept="image/x-png,image/gif,image/jpeg" class="custom-file-input">
                                    <label for="logo" class="custom-file-label">Choose file...</label>
                                </div> 
                            </div>
                        </div>

                        <input type="hidden" name="old_resume_path" id="old_resume_path" value="{{ $employee_info->resume }}">
                        <input type="hidden" name="old_photo_path" id="old_photo_path" value="{{ $employee_info->photo }}">

                       
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <button class="btn btn-sm btn-primary btn-block" type="submit">Submit</button>
                            </div>
                        </div>

                        
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
    <!-- Select2 -->
    <script src="{{ asset('assets/backend/layouts/js/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        $(".select2").select2({
            theme: 'bootstrap4',
        });
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }); 
    </script>

<script>
    $(document).ready(function(){

        $("#account-setup-form").validate({
           
        });
   });
</script>

<script>
    function userEmailPhone(){
        var user_id = $('#user_id').val();
        if(user_id != ''){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url : "{{ route('employee_setup.search_email_phone') }}",
                data: {
                    "user_id": user_id
                },
                success    : (data) => {
                   var obj = JSON.parse(data);
                   if(obj.status === 200){
                       $('#name').val(obj.data.name.trim());
                       $('#personal_email').val(obj.data.email.trim());
                       $('#personal_phone').val(obj.data.phone.trim());
                   }else{
                        $('#name').val('');
                        $('#personal_email').val('');
                        $('#personal_phone').val('');
                   }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    }
</script>




@endpush
