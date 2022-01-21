@extends('layouts.app')

@push('css')
    <link href="{{ asset('assets/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <style>
        .add-new-button{
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
        }
    </style>
@endpush

@section('title')
    Ocr Filed Editable Setup
@endsection

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Ocr Filed Editable Setup</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Parameter Setup</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Ocr Filed Editable Setup</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

@section('content')

<div class="row mt-3">
    <div class="col-md-12 add-new-button">
        <a href="{{ route('parameter-setup.ocr-editable-filed-setup.create') }}" class="btn btn-primary dim" ><i class="fa fa-plus"></i> Add New</a>
    </div>    
</div>  

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>E-KYC Matching Score Setup List</h5>
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

                <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
            <tr>
                <th>Bangla Name</th>
                <th>English Name</th>
                <th>Father Name</th>
                <th>Mother Name</th>
                <th>Date Of Birth</th>
                <th>Place Of Birth</th>
                <th>Blood Group</th>
                <th>Address</th>
                <th>Nid Number</th>
                <th>Issue Date</th>
                <th>Nid Data</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @if(isset($ocr_data->bn_name))
                    <tr class="text-center">
                        <td><input type="checkbox"  @if($ocr_data->bn_name == 1) checked @endif ></td>
                        <td><input type="checkbox"  @if($ocr_data->en_name == 1) checked @endif ></td>
                        <td><input type="checkbox"  @if($ocr_data->father_name == 1) checked @endif ></td>
                        <td><input type="checkbox"  @if($ocr_data->mother_name == 1) checked @endif ></td>
                        <td><input type="checkbox"  @if($ocr_data->date_of_birth == 1) checked @endif ></td>
                        <td><input type="checkbox"  @if($ocr_data->place_of_birth == 1) checked @endif ></td>
                        <td><input type="checkbox"  @if($ocr_data->blood_group == 1) checked @endif ></td>
                        <td><input type="checkbox"  @if($ocr_data->address == 1) checked @endif ></td>
                        <td><input type="checkbox"  @if($ocr_data->nid_number == 1) checked @endif ></td>
                        <td><input type="checkbox"  @if($ocr_data->issue_date == 1) checked @endif ></td>
                        <td><input type="checkbox"  @if($ocr_data->nid_code == 1) checked @endif ></td>
                        <td>
                            <a class="btn btn-white btn-bitbucket" href="{{ route('parameter-setup.ocr-editable-filed-setup.edit',$ocr_data->id)  }}">
                                <i class="fa fa-pencil"></i> 
                            </a>
                            <button class="btn btn-white btn-bitbucket" type="button" onclick="deleteOcrEditableSetup({{ $ocr_data->id }})">
                                <i class="fa fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $ocr_data->id }}" action="{{ route('parameter-setup.ocr-editable-filed-setup.delete',$ocr_data->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr> 
                @endif           
            </tbody>
            
            </table>
                </div>

            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script>
    
        function deleteOcrEditableSetup(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>
@endpush