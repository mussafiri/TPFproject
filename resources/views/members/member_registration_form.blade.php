@extends('layouts.admin_main')
@section('custom_css')
<!-- third party css -->
<link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<!-- kartik Fileinput-->
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fontawesome-kartik.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/bootstrap-icons.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fileinput.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer-fa/theme.css')}}" />

<!-- third party css end -->
<style>
    .kv-avatar .krajee-default.file-preview-frame,
    .kv-signature .krajee-default.file-preview-frame,
    .kv-avatar .krajee-default.file-preview-frame:hover,
    .kv-signature .krajee-default.file-preview-frame:hover,
    .file-preview-other {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;


    }

    .kv-avatar .file-preview-frame {

        height: 100px important !;
        /* Set the desired height */

    }

    .kv-avatar,
    .kv-signature {
        display: inline-block;
    }

    .kv-avatar .file-input,
    .kv-signature .file-input {
        display: table-cell;
        width: 213px;
    }

    .kv-reqd {
        color: red;
        font-family: monospace;
        font-weight: normal;
    }

    .my-frame-class {

        width: 150px;
        max-height: 150px important !;
    }

    .depattachment-file-input {

        /* display: inline-block; */
        display: table-cell;
        max-height: 150px;
        width: 180px;
    }

    .depattachment-file-input .file-upload-indicator,
    .file-actions {
        display: inline-block;

    }

    .depattachment-file-input .file-footer-caption {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: center;
    }

    .depattachment-file-input .file-actions {
        margin-left: auto;
        float: right;
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
                            <li class="breadcrumb-item"><a href="{{url('/members/list')}}">Members</a></li>
                            <li class="breadcrumb-item active">Registration</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Members Management</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- end row-->
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h4 class="header-title mb-3">Member Registration</h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button" data-toggle="modal" data-target="#add-district-modal-lg" class="btn btn-sm btn-info waves-effect waves-light font-weight-bold"><i class="mdi mdi-arrow-left-thick mr-1  "></i>Back</button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item" id="LimemberDetails">
                            <a href="#memberDetails" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                <i class="flaticon flaticon-user-1 mr-1"></i>
                                Member Details
                            </a>
                        </li>
                        <li class="nav-item" id="LimemberDependantsDetails">
                            <a href="#memberDependantsDetails" class="nav-link" data-toggle="tab" aria-expanded="true">
                                <i class="flaticon flaticon-community mr-1"></i>
                                Dependants Details
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="memberDetails">
                            <form method="POST" enctype="multipart/form-data" action="{{url('/member/registration/submit')}}">
                                @csrf
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Personal Data {{$response_message}}</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Designation</label>
                                                        <select class="form-control" name="evengelical_title" data-toggle="select2" required>
                                                            <option value="0">--Select Designation--</option>
                                                            @foreach($titles as $title)
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
                                                        <input type="text" name="firstname" class="form-control form-control-sm" value="{{old('firstname')}}" oninput="this.value = this.value.toUpperCase()" id="field-1" placeholder="Firstname">
                                                        @if ($errors->registerMemberDetails->has('firstname')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('firstname') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Middlename</label>
                                                        <input type="text" name="middle_name" class="form-control form-control-sm" value="{{old('middle_name')}}" oninput="this.value = this.value.toUpperCase()" id="field-1" placeholder="Middle Name">
                                                        @if ($errors->registerMemberDetails->has('middle_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('middle_name') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Last-name</label>
                                                        <input type="text" name="lastname" class="form-control form-control-sm" value="{{old('lastname')}}" oninput="this.value = this.value.toUpperCase()" id="field-1" placeholder="Last Name">
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
                                                        <input type="text" name="postalAddress" class="form-control form-control-sm" value="{{old('postalAddress')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Postal Address">

                                                        @if ($errors->registerMemberDetails->has('postalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('postalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-4" class="control-label">Physical Address</label>
                                                        <input type="text" name="physicalAddress" class="form-control form-control-sm" value="{{old('physicalAddress')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Physical Address">

                                                        @if ($errors->registerMemberDetails->has('physicalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('physicalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-5" class="control-label">Phone</label>
                                                        <input type="text" name="phone" class="form-control form-control-sm" id="input-phone" value="{{old('phone')}}" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(000) 000-000-000" autocomplete="off">

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
                                                        <input type="text" name="joining_date" class="form-control form-control-sm humanfd-datepicker" value="{{old('joining_date')}}" placeholder="Date of Birth">
                                                        @if ($errors->registerMemberDetails->has('joining_date')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('joining_date') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Service start Date</label>
                                                        <input type="text" name="service_date" class="form-control form-control-sm humanfd-datepicker" value="{{old('service_date')}}" placeholder="Date of Birth">
                                                        @if ($errors->registerMemberDetails->has('service_date')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('service_date') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Identification Type</label>
                                                        <select class="form-control" name="id_type" data-toggle="select2">
                                                            <option value="0">--Select ID status--</option>
                                                            @foreach($ids as $identity)
                                                            <option value="{{$identity->id}}">{{$identity->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->registerMemberDetails->has('id_type')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('id_type') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="field-4" class="control-label">ID number</label>
                                                        <input type="text" name="id_number" id="id-number" class="form-control form-control-sm" value="{{old('id_number')}}" oninput="this.value = this.value.toUpperCase()" placeholder="ID number">
                                                        @if ($errors->registerMemberDetails->has('id_number')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('id_number') }}</small></strong></span>@endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-12">
                                                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Attachments</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- <div class="form-group"> -->
                                                    <label for="field-1" class="control-label">Member Photo</label>

                                                    <div class="kv-avatar">
                                                        <div class="file-loading">
                                                            <input id="avatar-1" name="member_avatar" type="file">
                                                        </div>
                                                    </div>
                                                    <div class="kv-avatar-hint">
                                                        <small>Select file < 1500 KB</small>
                                                    </div>
                                                    <!-- </div> -->
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group kv-signature">
                                                        <label for="field-1" class="control-label">Member Signature</label>
                                                        <div class="file-loading">
                                                            <input id="member-sign" name="member_signature" type="file">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label"> Member ID Attachment</label>
                                                        <div class="file-loading">
                                                            <input id="member-id" name="member_id" type="file">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Registration Form Attachment</label>
                                                        <div class="file-loading">
                                                            <input id="reg-form" name="regform_attachment" type="file">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="col-12 mt-3">
                                                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2 row">Contributor Details</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">Contributor</label>
                                                        <select class="form-control contirbutorSelect" name="contributor_name" data-toggle="select2">
                                                            <option value="0">-- Select Contributor --</option>
                                                            @foreach($contributors as $contributor)
                                                            <option value="{{$contributor->id}}">{{$contributor->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="contirbutorError" role="alert"> <strong><small>@if ($errors->registerMemberDetails->has('contributor_name')){{ $errors->registerMemberDetails->first('contributor_name') }}@endif</small></strong></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="field-4" class="control-label">Section</label>
                                                        <input type="text" name="section" id="section" class="form-control form-control-sm" value="{{old('section')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="District" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="field-4" class="control-label">District</label>
                                                        <input type="text" name="district" id="district" class="form-control form-control-sm" value="{{old('district')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="District" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="field-5" class="control-label">Zone</label>
                                                        <input type="text" name="zone" id="zone" class="form-control form-control-sm" value="{{old('zone')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Zone" readonly>
                                                        <span class="zoneErrorTxt text-danger" role="alert"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="field-5" class="control-label">Monthly income</label>
                                                        <input type="text" name="monthly_income" id="monthly_income" class="form-control form-control-sm autonumber" value="{{old('monthly_income')}}" placeholder="Monthly Income" data-a-sign="TZS. " placeholder="Enter Income" autocomplete="off">
                                                        @if ($errors->registerMemberDetails->has('monthly_income')) <span class="text-danger" id="contributor" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('monthly_income') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-divider col-12 mt-4"></div>
                                        <div class="col-md-12 px-4">
                                            <button type="submit" class="btn btn-info waves-effect waves-light float-right">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- end tab-pane -->
                        <!-- Dependant tab-pane -->
                        <div class="tab-pane" id="memberDependantsDetails">
                            <div class="col-12">
                                <div class="col-12">
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2 row">Dependants Details</h5>
                                </div>
                                <form method="POST" id="formDependants" enctype="multipart/form-data" action="{{url('/member/dependants/submit')}}">
                                    @csrf
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <table class="w-100">
                                            <tr>
                                                <td class="form-group col-lg-11 col-md-11 col-sm-12">
                                                    <div class="row font-12 border rounded pt-2" style="background-color:#fefefe;">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Relationship</label>
                                                                        <select class="form-control relationshipSelect" name="inputs[0][dep_relationship]" data-toggle="select2">
                                                                            <option value="0">--Select Relationship--</option>
                                                                            <option value="SPOUSE">SPOUSE</option>
                                                                            <option value="CHILD">CHILD</option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-4" class="control-label">Gender</label>
                                                                        <select class="form-control px-0" name="inputs[0][dep_gender]" data-toggle="select2">
                                                                            <option value="0">--Select Gender--</option>
                                                                            <option value="MALE">MALE</option>
                                                                            <option value="FEMALE">FEMALE</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-4" class="control-label">Firstname</label>
                                                                        <input type="text" name="inputs[0][dep_firstname]" id="dep0" class="form-control form-control-sm" value="{{old('dep_firstname')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="First name">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Middlename</label>
                                                                        <input type="text" name="inputs[0][dep_midname]" id="zone" class="form-control form-control-sm" value="{{old('dep_midname')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Middle name">
                                                                        <span class="zoneErrorTxt text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Last name</label>
                                                                        <input type="text" name="inputs[0][dep_lastname]" id="zone" class="form-control form-control-sm" value="{{old('dep_lastname')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Last name">
                                                                        <span class="zoneErrorTxt text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Date of Birth</label>
                                                                        <input type="text" name="inputs[0][dep_dob]" class="form-control form-control-sm dep_dobdatepicker" value="{{old('dep_dob')}}" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd MM yyyy" placeholder="DOB" autocomplete="off">
                                                                        <span class="text-danger" role="alert"> </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Dependant Photo</label>
                                                                        <div class="file-loading">
                                                                            <input class="dep_attachments" name="dep_photo[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6" id="divBirthCert">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Birth Certificate</label>
                                                                        <div class="file-loading">
                                                                            <input class="dep_attachments" id="inputBirthCert" name="dep_birthcert[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6" id="divmarriageCert" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Marriage Certificate</label>
                                                                        <div class="file-loading">
                                                                            <input class="dep_attachments" id="inputMarriageCert" name="dep_marriagecert[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="form-group col-lg-1 col-md-1 col-sm-12 text-right ml-auto">
                                                    <a id="addFields" class="btn btn-icon btn-round btn-xs mb-2 btn-success white" style="color:#fff"><em class="mdi mdi-plus"></em></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form-group col-lg-11 col-md-11 col-sm-12">
                                                    <div class="row font-12 border rounded pt-2 mt-2" style="background-color:#fefefe;">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Relationship</label>
                                                                        <select class="form-control relationshipSelect" name="inputs[1][dep_relationship]" data-toggle="select2">
                                                                            <option value="0">--Select Relationship--</option>
                                                                            <option value="SPOUSE">SPOUSE</option>
                                                                            <option value="CHILD">CHILD</option>
                                                                        </select>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-4" class="control-label">Gender</label>
                                                                        <select class="form-control px-0" name="inputs[1][dep_gender]" data-toggle="select2">
                                                                            <option value="0">--Select Gender--</option>
                                                                            <option value="MALE">MALE</option>
                                                                            <option value="FEMALE">FEMALE</option>
                                                                        </select>
                                                                        <span class="text-danger" role="alert"> {{ $errors->first('dep_gender') }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-4" class="control-label">Firstname</label>
                                                                        <input type="text" name="inputs[1][dep_firstname]" id="depFirstname" class="form-control form-control-sm" value="{{old('dep_firstname')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="First name">
                                                                        <span class="depFirstnameErrorTxt text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Middlename</label>
                                                                        <input type="text" name="inputs[1][dep_midname]" id="zone" class="form-control form-control-sm" value="{{old('dep_midname')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Middle name">
                                                                        <span class="zoneErrorTxt text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Last name</label>
                                                                        <input type="text" name="inputs[1][dep_lastname]" id="zone" class="form-control form-control-sm" value="{{old('dep_lastname')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Last name">
                                                                        <span class="zoneErrorTxt text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Date of Birth</label>
                                                                        <input type="text" name="inputs[1][dep_dob]" class="form-control form-control-sm dep_dobdatepicker" value="{{old('dep_dob')}}" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd M yyyy" placeholder="Date of Birth" autocomplete="off">
                                                                        <span class="text-danger" role="alert"> </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Dependant Photo</label>
                                                                        <div class="file-loading">
                                                                            <input class="dep_attachments" name="dep_photo[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6" id="divBirthCert">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Birth Certificate</label>
                                                                        <div class="file-loading">
                                                                            <input class="dep_attachments" id="inputBirthCert" name="dep_birthcert[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6" id="divmarriageCert" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Marriage Certificate</label>
                                                                        <div class="file-loading">
                                                                            <input class="dep_attachments" id="inputMarriageCert" name="dep_marriagecert[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table id="dynamicAddRemove" class="w-100"></table>
                                        <div class="col-md-12 px-4 dropdown-divider"></div>
                                        <div class="col-md-12 mb-4">
                                            <button type="submit" id="submit-button" class="btn btn-info waves-effect waves-light float-right formDependants">Submit</button>
                                        </div>
                                    </div>



                                </form>
                            </div>
                        </div><!-- end Dependant tab-pane -->
                    </div><!-- end tab-content -->
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container -->
</div> <!-- content -->
@endsection
@section('custom_script')
<!-- third party js -->
<!-- third party js ends -->
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.js')}}"></script>
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer-fa/theme.js')}}"></script>

<!-- Datatables init -->
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script type="text/javascript">
    var b = 2;
    $('#addFieldsBed').on('click', function() {
        $("#addRemoveBedRow").prepend(
            // <tr>
            //     <td class="form-group col-lg-11 col-md-11 col-sm-12">
            //         <div class="row font-12 border rounded pt-2 mt-2" style="background-color:#fefefe;">
            //             <div class="col-lg-6">
            //                 <div class="row">
            //                     <div class="col-lg-6">
            //                         <div class="form-group">
            //                             <label for="field-1" class="control-label">Relationship</label>
            //                             <select class="form-control relationshipSelect" name="dep_relationship[]" data-toggle="select2">
            //                                 <option value="0">--Select Relationship--</option>
            //                                 <option value="SPOUSE">SPOUSE</option>
            //                                 <option value="CHILD">CHILD</option>
            //                             </select>
            //                             <span class="text-danger" role="alert"> {{ $errors->first('contributor_name') }}</span>
            //                         </div>
            //                     </div>
            //                     <div class="col-lg-6">
            //                         <div class="form-group">
            //                             <label for="field-4" class="control-label">Gender</label>
            //                             <select class="form-control px-0" name="dep_gender[]" data-toggle="select2">
            //                                 <option value="0">--Select Gender--</option>
            //                                 <option value="MALE">MALE</option>
            //                                 <option value="FEMALE">FEMALE</option>
            //                             </select>
            //                             <span class="text-danger" role="alert"> {{ $errors->first('dep_gender') }}</span>
            //                         </div>
            //                     </div>
            //                     <div class="col-lg-6">
            //                         <div class="form-group">
            //                             <label for="field-4" class="control-label">Firstname</label>
            //                             <input type="text" name="dep_firstname[]" id="depFirstname" class="form-control form-control-sm" value="{{old('dep_firstname')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="First name">
            //                             <span class="depFirstnameErrorTxt text-danger" role="alert"></span>
            //                         </div>
            //                     </div>
            //                     <div class="col-lg-6">
            //                         <div class="form-group">
            //                             <label for="field-5" class="control-label">Middlename</label>
            //                             <input type="text" name="dep_midname[]" id="zone" class="form-control form-control-sm" value="{{old('dep_midname')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Middle name">
            //                             <span class="zoneErrorTxt text-danger" role="alert"></span>
            //                         </div>
            //                     </div>
            //                     <div class="col-lg-6">
            //                         <div class="form-group">
            //                             <label for="field-5" class="control-label">Last name</label>
            //                             <input type="text" name="dep_lastname[]" id="zone" class="form-control form-control-sm" value="{{old('dep_lastname')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Last name">
            //                             <span class="zoneErrorTxt text-danger" role="alert"></span>
            //                         </div>
            //                     </div>
            //                     <div class="col-lg-6">
            //                         <div class="form-group">
            //                             <label for="field-5" class="control-label">Date of Birth</label>
            //                             <input type="text" name="dep_dob[]" class="form-control form-control-sm dep_dobdatepicker" value="{{old('dep_dob')}}" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd M yyyy" placeholder="Date of Birth" autocomplete="off">
            //                             <span class="text-danger" role="alert"> </span>
            //                         </div>
            //                     </div>
            //                 </div>
            //             </div>
            //             <div class="col-lg-6">
            //                 <div class="row">
            //                     <div class="col-lg-6">
            //                         <div class="form-group">
            //                             <label for="field-1" class="control-label">Dependant Photo</label>
            //                             <div class="file-loading">
            //                                 <input class="dep_attachments" name="dep_photo[]" type="file">
            //                             </div>
            //                         </div>
            //                     </div>
            //                     <div class="col-lg-6" id="divBirthCert">
            //                         <div class="form-group">
            //                             <label for="field-1" class="control-label">Birth Certificate</label>
            //                             <div class="file-loading">
            //                                 <input class="dep_attachments" id="inputBirthCert" name="dep_birthcert[]" type="file">
            //                             </div>
            //                         </div>
            //                     </div>
            //                     <div class="col-lg-6" id="divmarriageCert" style="display:none;">
            //                         <div class="form-group">
            //                             <label for="field-1" class="control-label">Marriage Certificate</label>
            //                             <div class="file-loading">
            //                                 <input class="dep_attachments" id="inputMarriageCert" name="dep_marriagecert[]" type="file">
            //                             </div>
            //                         </div>
            //                     </div>
            //                 </div>
            //             </div>
            //         </div>
            //     </td>
            // </tr>
        );

        $("#addedRowSelect2Input" + b).find(".inputselect2").select2();
        b++;
    });
</script>
<script type="text/javascript">
    // $("#formDependants").submit(function(e) {
    // e.preventDefault();
    // var formIsValid = true;

    // // Check if inputs are valid
    // var inputCount = $("#formDependants input").length;
    // var completedRequests = 0;
    // $("#formDependants input").each(function(index, element) {
    //     var input = $(element);

    //     $.ajax({
    //     type: 'POST',
    //     url: "{{url('/ajax/dynamic/validation')}}",
    //     data: {
    //         'rak': input.val(),
    //         '_token': '{{ csrf_token() }}'
    //     },
    //     dataType: 'json',
    //     success: function(response) {
    //         input.next(".text-danger").empty();
    //         completedRequests++;
    //         if(completedRequests == inputCount) {
    //         if(formIsValid) {
    //             $("#formDependants")[0].submit();
    //         }
    //         }
    //     },
    //     error: function(response) {
    //         var errors = response.responseJSON.errors;
    //         alert(errors);
    //         if (errors[input.attr('name')]) {
    //         input.next(".text-danger").text(errors[input.attr('name')][0]);
    //         } else {
    //         input.next(".text-danger").empty();
    //         }
    //         formIsValid = false;
    //         completedRequests++;
    //         if(completedRequests == inputCount) {
    //         if(formIsValid) {
    //             $("#formDependants")[0].submit();
    //         }
    //         }
    //     },
    //     async: true
    //     });
    // });
    // });
    $(document).ready(function() {
        $('#formDependants').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{url('/ajax/dynamic/validation')}}",
                method: 'POST',
                data:formData,
                success: function(response) {
                    // handle successful response
                    alert("response");
                    var inputs_errors = response.errors;
                    if(inputs_errors) {
                        $.each(inputs_errors, function(field, messages) {
                        alert(messages[0]);
                        $('input[name="inputs['+field+'][dep_midname]"]').after('<span class="text-danger" role="alert">Wronga</span>');
                    });
                    }

                }
            });
        });
    });
</script>



<!-- Datatables init -->
<script type="text/javascript">
    $('#member_dobdatepicker').datepicker({
        endDate: "-18Y"
    });
    $('.dep_dobdatepicker').datepicker({
        startDate: "-21Y",
        endDate: new Date()
    });
</script>
<script>
    //START:: On change of the Relationship select 
    // $(document).ready(function() {
    $('.relationshipSelect').change(function() {
        var realationType = $(this).find(":selected").val();
        if (realationType == "SPOUSE") {
            $('#divmarriageCert').show();
            $('#divBirthCert').hide()
            $('#inputMarriageCert').attr("required", "required");
            $('#inputbirthCert').removeAttr("required");

        } else if (realationType == "CHILD") {
            $('#divmarriageCert').hide();
            $('#divBirthCert').show();
            $('#inputbirthCert').attr("required", "required");
            $('#inputMarriageCert').removeAttr("required");
        } else {
            $('#divmarriageCert').hide();
            $('#divBirthCert').hide()
            $('#inputMarriageCert').removeAttr("required");
            $('#inputbirthCert').removeAttr("required");

        }

    });
    // });
    //END:: Relationship select
</script>
<script type="text/javascript">
    // CONTROL TO ACTIVATE THE NAV TABS AFTER REDIRECTION OF THE FORM
    var formResponse = "<?= $response_message; ?>";
    // if (formResponse == "SUCCESS") {
    //      // Get the nav item and content element
    //     const navItem = document.querySelector('li#LimemberDependantsDetails a');
    //     const contentElement = document.querySelector('div.tab-content div#memberDependantsDetails');

    //     // Add the 'active' class to the nav item
    //     navItem.classList.add('active');

    //     // Add the 'show' and 'active' classes to the content element
    //     contentElement.classList.add('show');
    //     contentElement.classList.remove('disabled');
    //     contentElement.classList.add('active');
    //     // Renove the active class for Member details Tab elements
    //     $('li#LimemberDetails a').removeClass("active");
    //     $('div.tab-content div#memberDetails').removeClass("active");
    //     $('li#LimemberDetails a').addClass("disabled");

    // }else{
    //     // Get the nav item and content element
    //     const navItem = document.querySelector('li#LimemberDetails a');
    //     const contentElement = document.querySelector('div.tab-content div#memberDetails');

    //     // Add the 'active' class to the nav item
    //     navItem.classList.add('active');

    //     // Add the 'show' and 'active' classes to the content element
    //     contentElement.classList.add('show');
    //     contentElement.classList.add('active');

    // }
</script>
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

<script>
    //START:: On page load set defautl selection
    $(document).ready(function() {
        $('.contirbutorSelect option[value=0]').prop('selected', true);
        $('#district').val('');
        $('#zone').val('');
    });
    //END:: ON PAGE load



    //START:: On event
    $('.contirbutorSelect').change(function() {
        var contributor = $(this).find(":selected").val();
        if (contributor == 0) {
            $("#contirbutorError").html('Kindly, select a Contributor');
            $('#district').val('');
            $('#zone').val('');
            $('#section').val('');
        } else {
            $("#contirbutorError").html('');
            $.ajax({
                url: "{{url('/ajax/get/contributor/data')}}",
                type: 'POST',
                data: {
                    contributor_id: contributor,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.contributorDataArr.code == 201) {
                        $('.districtErrorTxt').html('');
                        $('.zoneErrorTxt').html('');
                        $('#section').val(response.contributorDataArr.section);
                        $('#district').val(response.contributorDataArr.district);
                        $('#zone').val(response.contributorDataArr.zone);
                    } else {
                        $('.districtErrorTxt').html(response.contributorDataArr.district_message)
                        $('.zoneErrorTxt').html(response.contributorDataArr.zone_message)
                        $("#contirbutorError").html('Kindly select a Section');
                    }
                }
            });
        }
    });
</script>
<script>
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="bi-tag"></i>' +
        '</button>';
    $("#avatar-1").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        dropZoneEnabled: false,
        browseIcon: '<i class="bi-person-bounding-box"> </i> <span class"font-12"> Member Photo</span>',
        removeIcon: '<i class="bi-x-lg"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        // defaultPreviewContent: '<img src="/samples/default-avatar-male.png" alt="Your Avatar">',
        layoutTemplates: {
            main2: '{preview} ' + ' {remove} {browse}'
        },
        allowedFileExtensions: ["jpg", "jpeg", "png", "gif"],

    });
</script>
<script>
    $(document).ready(function() {
        $("#member-sign").fileinput({
            uploadUrl: "#",
            allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf'],
            showClose: false,
            showCaption: false,
            showUpload: false,
            showCancel: false,
            showRemove: false,
            dropZoneEnabled: false,
            browseLabel: '',
            browseIcon: '<i class="bi-vector-pen"> </i> <span class"font-12"> Attach Member Signature</span>',
            maxTotalFileCount: 1,
            fileActionSettings: {
                showUpload: false,
                showRemove: true,
            },
            maxFileSize: 2000,
            // initialCaption: "The Moon and the Earth"
        });
    });
</script>
<script>
    $(document).ready(function() {
        $("#reg-form").fileinput({
            uploadUrl: "#",
            allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx', 'doc'],
            showUpload: false,
            showCancel: false,
            showRemove: false,
            maxTotalFileCount: 1,
            browseLabel: '',
            browseIcon: '<i class="bi bi-file-earmark-pdf"> </i> <span class"font-12"> Attach form </span>',
            fileActionSettings: {
                showUpload: false,
                showRemove: true,
            },
            maxFileSize: 2000,
            // initialCaption: "The Moon and the Earth"
        });
    });

    $(document).ready(function() {
        $("#member-id").fileinput({
            uploadUrl: "#",
            allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            showClose: false,
            showUpload: false,
            showCancel: false,
            showRemove: false,
            dropZoneEnabled: false,
            browseLabel: '',
            browseIcon: '<i class="bi bi-postcard"> </i> <span class"font-12"> Attach Member ID Card</span>',
            fileActionSettings: {
                showUpload: false,
                showRemove: true,
            },
            maxFileSize: 2000,
            // initialCaption: "The Moon and the Earth"
        });
    });
    $(document).ready(function() {
        $(".dep_attachments").fileinput({
            frameClass: 'my-frame-class',
            previewClass: 'depattachment-file-input',
            removeLabel: '',
            initialPreviewAsData: true,
            showUpload: false,
            showCaption: false,
            dropZoneEnabled: false,

        });
    });
</script>
@endsection