@extends('layouts.app')

@section('title')
    Matching Score Setup
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Matching Score Setup</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Matching Score Setup</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Matching Score Modify</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6 offset-md-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Matching Score Setup</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form id="matching_score_create_form" action="{{  route('matching.score.setup.update',$matchingSocreInfo->id)  }}" method="POST">
                        @csrf
                        <p>E-KYC Mathing Socre Setup</p>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Bangla Name Match Percentage</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control  @error('bn_name_percentage') is-invalid @enderror" name="bn_name_percentage" value="{{ $matchingSocreInfo->bn_name_percentage }}" required > 
                                @if($errors->has('bn_name_percentage'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bn_name_percentage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">English Name Match Percentage</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control @error('en_name_percentage') is-invalid @enderror" name="en_name_percentage" value="{{ $matchingSocreInfo->en_name_percentage }}" required > 
                                @if($errors->has('en_name_percentage'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('en_name_percentage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Father Name Match Percentage</label>
                            <div class="col-lg-8">
                                <input type="text"  class="form-control @error('father_name_percentage') is-invalid @enderror" name="father_name_percentage" value="{{ $matchingSocreInfo->father_name_percentage }}" required> 
                                @if($errors->has('father_name_percentage'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('father_name_percentage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Mother Name Match Percentage</label>
                            <div class="col-lg-8">
                                <input type="text"  class="form-control @error('mother_name_percentage') is-invalid @enderror" name="mother_name_percentage" value="{{ $matchingSocreInfo->mother_name_percentage }}" required> 
                                @if($errors->has('mother_name_percentage'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mother_name_percentage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Date Of Birth Match Percentage</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control @error('date_of_birth_percentage') is-invalid @enderror" name="date_of_birth_percentage" value="{{ $matchingSocreInfo->date_of_birth_percentage }}" required> 
                                @if($errors->has('date_of_birth_percentage'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_of_birth_percentage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Adress Match Percentage</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control @error('address_percentage') is-invalid @enderror" name="address_percentage" value="{{ $matchingSocreInfo->address_percentage }}" required> 
                                @if($errors->has('address_percentage'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address_percentage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Face Match Percentage</label>
                            <div class="col-lg-8">
                                <input type="text"  class="form-control @error('face_percentage') is-invalid @enderror" name="face_percentage" value="{{ $matchingSocreInfo->face_percentage }}" required> 
                                @if($errors->has('face_percentage'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('face_percentage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Blood Group Percentage</label>
                            <div class="col-lg-8">
                                <input type="text"  class="form-control @error('blood_group_percentage') is-invalid @enderror" name="blood_group_percentage" value="{{$matchingSocreInfo->blood_group_percentage }}" required> 
                                @if($errors->has('blood_group_percentage'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('blood_group_percentage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Overall Percentage</label>
                            <div class="col-lg-8">
                                <input type="text"  id="overall_percentage"  class="form-control @error('overall_percentage') is-invalid @enderror" name="overall_percentage" value="{{ $matchingSocreInfo->overall_percentage }}" required> 
                                @if($errors->has('overall_percentage'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('overall_percentage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit">Modify</button>
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
    <script>
        $(function() {

        $.validator.setDefaults({
            errorClass: 'help-block',
            highlight: function(element) {
                $(element)
                .closest('.form-group')
                .addClass('has-error');
            },
            unhighlight: function(element) {
                $(element)
                .closest('.form-group')
                .removeClass('has-error');
            },
            errorPlacement: function (error, element) {
                if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent());
                } else {
                error.insertAfter(element);
                }
            }
            });

           

            $("#matching_score_create_form").validate({
                rules: {
                    bn_name_percentage: {
                        required: true,
                        number : true,
                        min : 0,
                        max: 100,
                        
                    },
                    en_name_percentage: {
                        required: true,
                        number : true,
                        min : 0,
                        max: 100,
                    },
                    father_name_percentage: {
                        required: true,
                        number : true,
                        min : 0,
                        max: 100,
                    },
                    mother_name_percentage: {
                        required: true,
                        number : true,
                        min : 0,
                        max: 100,
                    },
                    date_of_birth_percentage: {
                        required: true,
                        number : true,
                        min : 0,
                        max: 100,
                    },
                    address_percentage: {
                        required: true,
                        number : true,
                        min : 0,
                        max: 100,
                    },
                    face_percentage: {
                        required: true,
                        number : true,
                        min : 0,
                        max: 100,
                    },
                    blood_group_percentage: {
                        required: true,
                        number : true,
                        min : 0,
                        max: 100,
                    },
                    overall_percentage: {
                        required: true,
                        number : true,
                        min : 0,
                        max: 100,
                    },
                },
                messages: {
                    bn_name_percentage: {
                        required: 'please write customer bangla-name match minimum score',
                        number : 'only number format supported',
                        min : 'bangla-name match score must be gater or equal then 0',
                        max: 'bangla-name match score must be gater or equal then 100',
                        
                    },
                    en_name_percentage: {
                        required: 'please write customer english-name match minimum score',
                        number : 'only number format supported',
                        min : 'english-name match score must be gater or equal then 0',
                        max: 'english-name match score must be gater or equal then 100',
                        
                    },
                    father_name_percentage: {
                        required: 'please write customer father-name match minimum score',
                        number : 'only number format supported',
                        min : 'father-name match score must be gater or equal then 0',
                        max: 'father-name match score must be gater or equal then 100',
                        
                    },
                    mother_name_percentage: {
                        required: 'please write customer mother-name match minimum score',
                        number : 'only number format supported',
                        min : 'mother-name match score must be gater or equal then 0',
                        max: 'mother-name match score must be gater or equal then 100',
                        
                    },
                    date_of_birth_percentage: {
                        required: 'please write customer date-of-birth match minimum score',
                        number : 'only number format supported',
                        min : 'date-of-birth match score must be gater or equal then 0',
                        max: 'date-of-birth match score must be gater or equal then 100',
                        
                    },
                    address_percentage: {
                        required: 'please write customer address match minimum score',
                        number : 'only number format supported',
                        min : 'address match score must be gater or equal then 0',
                        max: 'address match score must be gater or equal then 100',
                        
                    },
                    face_percentage: {
                        required: 'please write customer face match minimum score',
                        number : 'only number format supported',
                        min : 'face match score must be gater or equal then 0',
                        max: 'face match score must be gater or equal then 100',
                        
                    },
                    blood_group_percentage: {
                        required: 'please write customer blood group match minimum score',
                        number : 'only number format supported',
                        min : 'blood group percentage match score must be gater or equal then 0',
                        max: 'blood group percentage match score must be gater or equal then 100',                        
                    },
                    overall_percentage: {
                        required: 'please write customer overall percentage match minimum score',
                        number : 'only number format supported',
                        min : 'overall percentage match score must be gater or equal then 0',
                        max: 'overall percentage match score must be gater or equal then 100',                        
                    },
                }
            });

        });
    </script>
@endpush




