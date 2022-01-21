@extends('layouts.app')

@section('title')
    OCR Editable Field Setup
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>OCR Editable Field Setup</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>OCR Editable Field Setup</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>OCR Editable Field Setup Create</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-4 offset-md-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>OCR Editable Field Setup</h5>
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
                    <form  action="{{  route('parameter-setup.ocr-editable-filed-setup.store')  }}" method="POST">
                        @csrf
                        <p>E-KYC OCR Editable Field Setup</p>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="bn_name"> &nbsp;&nbsp; Bangla Name </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="en_name"> &nbsp;&nbsp; English Name </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="father_name"> &nbsp;&nbsp; Father Name </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="mother_name">  &nbsp;&nbsp; Mother Name </label>
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="address"> &nbsp;&nbsp; Address </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="date_of_birth"> &nbsp;&nbsp; Date Of Birth </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="place_of_birth"> &nbsp;&nbsp; Place Of Birth </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="nid_number"> &nbsp;&nbsp; Nid Number</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="blood_group"> &nbsp;&nbsp; Blood Group </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="issue_date"> &nbsp;&nbsp; Issue Date </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <div class="i-checks">
                                    <label> <input type="checkbox" name="nid_code"> &nbsp;&nbsp; Nid Code</label>
                                </div>
                            </div>
                        </div>
                       

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
