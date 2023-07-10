@extends('layouts.admin_main')
@php
use Carbon\Carbon;
@endphp
@section('custom_css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

<!-- third party css end -->
<style type="text/css">
    .my-image {
        width: 72px !important;
        height: 72px !important;
        object-fit: cover;
        /* scale and align the image within its container */
    }
</style>
@endsection
@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{url('members/list')}}">Members</a></li>
                            <li class="breadcrumb-item active">Member Details</li>
                        </ol>
                    </div>
                    <h4 class="page-title"> Update Member Details</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row"><!-- Summary Reports -->
            <div class="col-12">
                <div class="card-box">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h4 class="header-title mb-3">Member Details</h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                            </div>
                        </div><!-- end col-->
                    </div>
                    <div class="row">
                        <ul class="nav nav-tabs nav-bordered col-12">
                            <li class="nav-item">
                                <a href="#MemberParticularsPane" data-toggle="tab" class="nav-link active">
                                    <i class="flaticon-face-scan "></i>
                                    Member Particulars
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#contributorPane" data-toggle="tab" class="nav-link ">
                                    <i class="flaticon-infaq"></i>
                                    Contributor
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#memberDependantsPane" data-toggle="tab" class="nav-link ">
                                    <i class="flaticon-leader"></i>
                                    Dependants
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#memberAttachmentsPane" data-toggle="tab" class="nav-link ">
                                    <i class="flaticon-paper"></i>
                                    Attachements
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content col-12">
                            <div class="tab-pane active" id="MemberParticularsPane">
                                <div class="col-12">
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Personal Data</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Designation</label>
                                                        <select class="form-control" name="evengelical_title" data-toggle="select2" required>
                                                            <option value="0">--Select Designation--</option>
                                                            @foreach($salutation_title as $title)
                                                            <option value="{{$title->id}}">{{$title->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Salutation</label>
                                                        <select class="form-control" name="salutation" data-toggle="select2" required>
                                                            <option value="0">--Select Salutation--</option>
                                                            <option value="MR">MR</option>
                                                            <option value="MS">MS</option>
                                                            <option value="MRS">MRS</option>
                                                            <option value="DR">DR</option>
                                                            <option value="REV">REV</option>
                                                            <option value="PST">PST</option>
                                                            <option value="PROF">PROF</option>
                                                            <option value="BISHOP">BISHOP</option>
                                                        </select>
                                                        @if ($errors->registerMemberDetails->has('salutation')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('salutation') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">First-name</label>
                                                        <input type="text" name="firstname" class="form-control form-control-sm" value="{{old('firstname')}}" oninput="this.value = this.value.toUpperCase()" id="firstname-1" placeholder="Firstname" autocomplete="off" required>
                                                        @if ($errors->registerMemberDetails->has('firstname')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('firstname') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Middlename</label>
                                                        <input type="text" name="middle_name" class="form-control form-control-sm" value="{{old('middle_name')}}" oninput="this.value = this.value.toUpperCase()" id="midname-1" placeholder="Middle Name" autocomplete="off" required>
                                                        @if ($errors->registerMemberDetails->has('middle_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('middle_name') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Last-name</label>
                                                        <input type="text" name="lastname" class="form-control form-control-sm" value="{{old('lastname')}}" oninput="this.value = this.value.toUpperCase()" id="lastname-1" placeholder="Last Name" autocomplete="off" required>
                                                        @if ($errors->registerMemberDetails->has('lastname')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('lastname') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Marital Status</label>
                                                        <select class="form-control" name="marital_status" data-toggle="select2">
                                                            <option value="0">--Select Marital status--</option>
                                                            <option value="MARRIED">MARRIED</option>
                                                            <option value="SINGLE">SINGLE</option>
                                                            <option value="DIVORCED">DIVORCED</option>
                                                        </select>
                                                        @if ($errors->registerMemberDetails->has('marital_status')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('marital_status') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Gender</label>
                                                        <select class="form-control" name="gender" data-toggle="select2">
                                                            <option value="0">--Select Gender--</option>
                                                            <option value="MALE">MALE</option>
                                                            <option value="FEMALE">FEMALE</option>
                                                        </select>
                                                        @if ($errors->registerMemberDetails->has('gender')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('gender') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Date of Birth</label>
                                                        <input type="text" name="dob" class="form-control form-control-sm" id="member_dobdatepicker" value="{{old('dob')}}" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd M yyyy" placeholder="Date of Birth">

                                                        @if ($errors->registerMemberDetails->has('dob')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('dob') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-3" class="control-label">Postal Address</label>
                                                        <input type="text" name="postalAddress" class="form-control form-control-sm" value="{{old('postalAddress')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Postal Address" autocomplete="off">

                                                        @if ($errors->registerMemberDetails->has('postalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('postalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-4" class="control-label">Physical Address</label>
                                                        <input type="text" name="physicalAddress" class="form-control form-control-sm" value="{{old('physicalAddress')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Physical Address" autocomplete="off">

                                                        @if ($errors->registerMemberDetails->has('physicalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('physicalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .end of Personal Data -->
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-5" class="control-label">Phone</label>
                                                        <input type="text" name="phone" class="form-control form-control-sm" id="input-phone" value="{{old('phone')}}" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(255) 000-000-000" autocomplete="off">
    
                                                        @if ($errors->registerMemberDetails->has('phone')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('phone') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-5" class="control-label">Email</label>
                                                        <input type="email" name="email" class="form-control form-control-sm" value="{{old('email')}}" oninput="this.value = this.value.toLowerCase()" id="input-email" placeholder="e.g xxxxx@gmail.com" autocomplete="off">
    
                                                        @if ($errors->registerMemberDetails->has('email')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('email') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Occupation</label>
                                                        <select class="form-control" name="occupation" data-toggle="select2">
                                                            <option value="0">--Select Occupation--</option>
                                                            <option value="PASTOR">PASTOR</option>
                                                            <option value="FARMER">FARMER</option>
                                                            <option value="UNEMPLOYED">UNEMPLOYED</option>
                                                            <option value="EMPLOYED">EMPLOYED</option>
                                                            <option value="RETIRED">RETIRED</option>
                                                            <option value="BUSINESS">BUSINESS</option>
                                                            <option value="NONE">NONE</option>
                                                        </select>
                                                        @if ($errors->registerMemberDetails->has('occupation')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('occupation') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Scheme joining date</label>
                                                        <input type="text" id="scheme_date" name="joining_date" class="form-control form-control-sm humanfd-datepicker" value="{{old('joining_date')}}" placeholder="Scheme joining of date">
                                                        @if ($errors->registerMemberDetails->has('joining_date')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('joining_date') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Service start Date</label>
                                                        <input type="text" name="service_date" class="form-control form-control-sm" data-provide="datepicker" data-date-autoclose="true" onkeydown="return false;" onpaste="return false;" data-date-format="dd MM yyyy" value="{{old('service_date')}}" placeholder="Date of Service start date">
                                                        @if ($errors->registerMemberDetails->has('service_date')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('service_date') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Identification Type</label>
                                                        <select class="form-control" name="id_type" data-toggle="select2">
                                                            <option value="0">--Select ID status--</option>
                                                            @foreach($identity_types as $identity)
                                                            <option value="{{$identity->id}}">{{$identity->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->registerMemberDetails->has('id_type')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('id_type') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="field-4" class="control-label">ID number</label>
                                                        <input type="text" name="id_number" id="id-number" class="form-control form-control-sm" value="{{old('id_number')}}" oninput="this.value = this.value.toUpperCase()" placeholder="ID number" autocomplete="off" required>
                                                        @if ($errors->registerMemberDetails->has('id_number')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('id_number') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end Member Particulars .tab-pane active-->
                            <div class="tab-pane" id="transferHistoryPane">
                                <div class="table-responsive">

                                </div> <!-- end .table-responsive-->
                            </div><!-- end .tab-pane active-->
                            <div class="tab-pane" id="contributionsPane">
                                <div class="table-responsive">

                                </div> <!-- end .table-responsive-->
                            </div><!-- end .tab-pane active-->
                        </div><!-- end .tab-content-->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
    </div> <!-- container -->

</div> <!-- content -->
@endsection
@section('custom_script')
<!-- third party js -->
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<!-- third party js ends -->

<!-- Datatables init -->
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- Datatables init -->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
<script type="text/javascript">
    $(".district_statusChangeLink").click(function() {
        var district_id = $(this).attr("data-district");
        var new_status = $(this).attr("data-new_status");
        var district_name = $(this).attr("data-district_name");
        new_status = new_status.toLowerCase();
        Swal.fire({
            title: "Are you sure?",
            html: 'You want to <span class="text-danger">' + new_status + '</span> <span class="text-info">' + district_name + ' </span> District!',
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, " + new_status + " it!",
            cancelButtonText: "No, Cancel!",
            confirmButtonClass: "btn btn-success mt-2",
            cancelButtonClass: "btn btn-danger ml-2 mt-2",
            buttonsStyling: !1,
        }).then(function(t) {
            t.value ?
                $.ajax({
                    type: 'POST',
                    url: "{{url('/ajax/update/district/status')}}",
                    data: {
                        district: district_id,
                        status: new_status,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

                    success: function(t) {
                        var district_status = t.statDistrictJSONArr.message_status
                        Swal.fire({
                            title: "Success!",
                            html: t.statDistrictJSONArr.message + " " + district_status.toLowerCase(),
                            type: "success"
                        }).then(function() {
                            location.reload();
                        });
                    }
                }) :
                t.dismiss === Swal.DismissReason.cancel;
        });

    });
</script><!-- ./Status Modal  -->
@endsection