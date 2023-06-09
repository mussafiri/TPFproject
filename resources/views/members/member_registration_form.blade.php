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
                            <h4 class="header-title mb-3">Member Registration </h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button" data-toggle="modal" data-target="#add-district-modal-lg" class="btn btn-sm btn-info waves-effect waves-light font-weight-bold"><i class="mdi mdi-arrow-left-thick mr-1  "></i>Back</button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item" id="LimemberDetails">
                            <a href="#memberDetails" {!! ($response_message !="SUCCESS" )? ' data-toggle="tab" aria-expanded="true" class="nav-link active"' : ' class="nav-link disabled" ' ; !!}>
                                <i class="flaticon flaticon-user-1 mr-1"></i>
                                Member Details
                            </a>
                        </li>
                        <li class="nav-item" id="LimemberDependantsDetails">
                            <a href="#memberDependantsDetails" {!! ($response_message=='SUCCESS' )? ' data-toggle="tab" aria-expanded="true" class="nav-link active"' : ' class="nav-link disabled" ' ; !!}>
                                <!-- <a href="#memberDependantsDetails" data-toggle="tab" aria-expanded="true" class="nav-link" class="nav-link disabled" > -->
                                <i class="flaticon flaticon-community mr-1"></i>
                                Dependants Details
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane {!! ($response_message !='SUCCESS') ? ' active ' : '' ; !!} " id="memberDetails">
                            <form method="POST" id="formMemberDetails" enctype="multipart/form-data" action="{{url('/member/registration/submit')}}">
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
                                                        <input type="text" id="scheme_date" name="joining_date" class="form-control form-control-sm humanfd-datepicker" value="{{old('joining_date')}}" onkeydown="return false;" onpaste="return false;" placeholder="Scheme joining of date">
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
                                                        <input type="text" name="id_number" id="id-number" class="form-control form-control-sm" value="{{old('id_number')}}" oninput="this.value = this.value.toUpperCase()" placeholder="ID number" autocomplete="off" required>
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="field-4" class="control-label">District</label>
                                                        <input type="text" name="district" id="district" class="form-control form-control-sm" value="{{old('district')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="District" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="field-5" class="control-label">Zone</label>
                                                        <input type="text" name="zone" id="zone" class="form-control form-control-sm" value="{{old('zone')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Zone" readonly>
                                                        <span class="zoneErrorTxt text-danger" role="alert"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="field-5" class="control-label">Contribution Startdate</label>
                                                        <input type="text" name="contribution_startdate" id="contribution_start" class="form-control form-control-sm" value="{{old('contribution_startdate')}}" onkeydown="return false;" onpaste="return false;" placeholder=" Enter Contribution Start Date" autocomplete="off" >
                                                        @if ($errors->registerMemberDetails->has('contribution_startdate')) <span class="text-danger" id="contribution_startError" role="alert"> <strong><small>{{ $errors->registerMemberDetails->first('contribution_startdate') }}</small></strong></span>@endif
                                                        <span class="text-danger font-12" id="contribution_startError" role="alert"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="field-5" class="control-label">Member Monthly income</label>
                                                        <input type="text" name="monthly_income" id="monthly_income" class="form-control form-control-sm autonumber" value="{{old('monthly_income')}}" placeholder="Member Monthly Income" data-a-sign="TZS. " placeholder="Enter Income" autocomplete="off">
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
                        <div class="tab-pane {!!($response_message=='SUCCESS') ? ' active ' : '' ;!!}" id="memberDependantsDetails">
                            @if($member_data)
                            <!-- MEMBER SUMMARY INFORMATION -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Member Information</h4>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <h5 class="font-family-primary font-weight-semibold">Member Information Summary</h5>
                                                <p class="mb-2"><span class="font-weight-semibold mr-2">Name:</span><span class="font-12 text-right">{{$member_data? $member_data->title." ".$member_data->fname." ".$member_data->mname." ".$member_data->lname:" ";}} </span> </p>
                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Gender:</span> <span class="font-12 text-right">{{$member_data->gender}}</span></p>
                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Member code:</span> <span class="font-12 text-right">{{$member_data->member_code}}</span></p>
                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Occupation:</span><span class="font-12 text-right">{{$member_data->occupation}}</span> </p>
                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Phone:</span><span class="font-12 text-right">{{$member_data->phone}}</span></p>
                                                <p class="mb-0"><span class="font-weight-semibold mr-2">DOB:</span><span class="font-12 text-right">{{date('d M Y', strtotime($member_data->dob))}}</span></p>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Contributor:</span><span class="font-12 text-right">{{$member_data->contributor->name}}</span></p>
                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Type:</span><span class="font-12 text-right">{{$member_data->contributor->contributorType->name}}</span></p>
                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Section:</span><span class="font-12 text-right">{{$member_data->contributor->contributorSection->name}}</span></p>
                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Zone:</span><span class="font-12 text-right">{{$member_data->contributor->contributorSection->district->zone->name}}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card -->
                            </div>
                            <!-- END:: MEMBER SUMMARY INFORMATION -->
                            @endif
                            <div class="col-12">
                                <div class="col-12">
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2 row">Dependants Details</h5>
                                </div>
                                <form method="POST" id="formDependants" enctype="multipart/form-data" action="{{url('/member/dependants/submit')}}">
                                    @csrf
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <table id="dynamicAddRemove" class="w-100"></table>
                                        <table class="w-100">
                                            <tr>
                                                <td class="form-group col-lg-11 col-md-11 col-sm-12">
                                                    <div class="row font-12 border rounded pt-2" style="background-color:#fefefe;">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Relationship</label>
                                                                        <select class="form-control relationshipSelect commonInputClass" name="inputs[0][dep_relationship]" data-toggle="select2">
                                                                            <option value="FATHER" selected>FATHER</option>
                                                                        </select>
                                                                        <div><span class="text-danger" role="alert"></span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-4" class="control-label">Gender</label>
                                                                        <select class="form-control px-0 commonInputClass" name="inputs[0][dep_gender]" data-toggle="select2">
                                                                            <option value="0">--Select Gender--</option>
                                                                            <option value="MALE" selected>MALE</option>
                                                                        </select>
                                                                        <div><span class="text-danger" role="alert"></span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-4" class="control-label">Firstname</label>
                                                                        <input type="text" name="inputs[0][dep_firstname]" id="dep0" class="form-control form-control-sm" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="First name">
                                                                        <input type="text" name="member_id" value="{{$member_data?$member_data->id:0;}}" class="form-control form-control-sm" hidden>
                                                                        <span class="text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Middlename</label>
                                                                        <input type="text" name="inputs[0][dep_midname]" id="zone" class="form-control form-control-sm" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Middle name">
                                                                        <span class="text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Last name</label>
                                                                        <input type="text" name="inputs[0][dep_lastname]" id="zone" class="form-control form-control-sm" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Last name">
                                                                        <span class="zoneErrorTxt text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Phone</label>
                                                                        <input type="text" name="inputs[0][dep_phone]" class="form-control form-control-sm" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(000) 000-000-000">
                                                                        <span class="text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Occupation</label>
                                                                        <select class="form-control px-0" name="inputs[0][dep_occupation]" data-toggle="select2">
                                                                            <option value="0">--Select Gender--</option>
                                                                            <option value="FARMER">FARMER</option>
                                                                            <option value="UNEMPLOYED">UNEMPLOYED</option>
                                                                            <option value="RETIRED">RETIRED</option>
                                                                            <option value="EMPLOYED">EMPLOYED</option>
                                                                            <option value="BUSINESS">BUSINESS</option>
                                                                            <option value="PASTOR">PASTOR</option>
                                                                            <option value="NONE">NONE</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Vital Status</label>
                                                                        <select class="form-control px-0" name="inputs[0][dep_vital_status]" data-toggle="select2">
                                                                            <option value="0">--Select Status--</option>
                                                                            <option value="ALIVE">ALIVE</option>
                                                                            <option value="DECEASED">DECEASED</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Date of Birth</label>
                                                                        <input type="text" name="inputs[0][dep_dob]" class="form-control form-control-sm dep_parentdobdatepicker" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd MM yyyy" placeholder="DOB" autocomplete="off">
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
                                                                            <input class="dep_attachments commonInputClass" name="dep_photo[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6" id="divBirthCert">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Birth Certificate</label>
                                                                        <div class="file-loading">
                                                                            <input class="dep_attachments commonInputClass" id="inputBirthCert" name="dep_birthcert[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6" id="divmarriageCert" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Marriage Certificate</label>
                                                                        <div class="file-loading">
                                                                            <input class="dep_attachments commonInputClass" id="inputMarriageCert" name="dep_marriagecert[]" type="file">
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
                                                                        <select class="form-control relationshipSelect commonInputClass" name="inputs[1][dep_relationship]" data-toggle="select2">
                                                                            <option value="MOTHER" selected>MOTHER</option>
                                                                        </select>
                                                                        <div><span class="text-danger" role="alert"></span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-4" class="control-label">Gender</label>
                                                                        <select class="form-control px-0 commonInputClass" name="inputs[1][dep_gender]" data-toggle="select2">
                                                                            <option value="0">--Select Gender--</option>
                                                                            <option value="FEMALE" selected>FEMALE</option>
                                                                        </select>
                                                                        <span class="text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-4" class="control-label">Firstname</label>
                                                                        <input type="text" name="inputs[1][dep_firstname]" id="depFirstname" class="form-control form-control-sm commonInputClass" value="{{old('dep_firstname')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="First name">
                                                                        <span class="depFirstnameErrorTxt text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Middlename</label>
                                                                        <input type="text" name="inputs[1][dep_midname]" id="zone" class="form-control form-control-sm commonInputClass" value="{{old('dep_midname')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Middle name">
                                                                        <span class="zoneErrorTxt text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Last name</label>
                                                                        <input type="text" name="inputs[1][dep_lastname]" id="zone" class="form-control form-control-sm commonInputClass" value="{{old('dep_lastname')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Last name">
                                                                        <span class="zoneErrorTxt text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Phone</label>
                                                                        <input type="text" name="inputs[1][dep_phone]" class="form-control form-control-sm" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(000) 000-000-000">
                                                                        <span class="text-danger" role="alert"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Occupation</label>
                                                                        <select class="form-control px-0" name="inputs[1][dep_occupation]" data-toggle="select2">
                                                                            <option value="0">--Select Gender--</option>
                                                                            <option value="FARMER">FARMER</option>
                                                                            <option value="UNEMPLOYED">UNEMPLOYED</option>
                                                                            <option value="RETIRED">RETIRED</option>
                                                                            <option value="EMPLOYED">EMPLOYED</option>
                                                                            <option value="BUSINESS">BUSINESS</option>
                                                                            <option value="PASTOR">PASTOR</option>
                                                                            <option value="NONE">NONE</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Vital Status</label>
                                                                        <select class="form-control px-0" name="inputs[1][dep_vital_status]" data-toggle="select2">
                                                                            <option value="0">--Select Status--</option>
                                                                            <option value="ALIVE">ALIVE</option>
                                                                            <option value="DECEASED">DECEASED</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="field-5" class="control-label">Date of Birth</label>
                                                                        <input type="text" name="inputs[1][dep_dob]" class="form-control form-control-sm dep_parentdobdatepicker" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd M yyyy" placeholder="Date of Birth" autocomplete="off">
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
                                                                            <input class="dep_attachments commonInputClass" name="dep_photo[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6" id="divBirthCert">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Birth Certificate</label>
                                                                        <div class="file-loading">
                                                                            <input class="dep_attachments commonInputClass" id="inputBirthCert" name="dep_birthcert[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6" id="divmarriageCert" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label for="field-1" class="control-label">Marriage Certificate</label>
                                                                        <div class="file-loading">
                                                                            <input class="dep_attachments commonInputClass" id="inputMarriageCert" name="dep_marriagecert[]" type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
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
<script>
    $(document).ready(function() {
         $('#contribution_start').prop('disabled',true);
         $('#contribution_startError').html('First select the Scheme joining date');

        // Set the start date for the contribution datepicker when a scheme date is selected
        $('#scheme_date').on('change', function() {
            
            var pickedDate = $(this).val();
            var selectedDate =  moment(pickedDate).format('D MMM YYYY');
            $('#contribution_start').datepicker({
                format: 'dd M yyyy',
                startDate: selectedDate,
                endDate: 'today',
                autoclose: true,
                todayHighlight: true
                
            });
            $('#contribution_start').prop('disabled', false);
            $('#contribution_startError').html('');


        });
    });

</script>
<script type="text/javascript">
    flatpickr("#scheme_date", {
        minDate: "2019-01-01", // Sets the earliest selectable date to July 1, 2023
        maxDate: "today", // Sets the latest selectable date to July 1, 2023
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        // Other options...
    });


    // Function for Validation of Member duplicates
    $(document).ready(function() {
        $('#formMemberDetails').on('submit', function(e) {
            e.preventDefault();
            var birthdate = $('#member_dobdatepicker').val();
            var firstname = $('#firstname-1').val();
            var middlename = $('#midname-1').val();
            var lastname = $('#lastname-1').val();
            $.ajax({
                url: "{{url('/ajax/dynamic/member/duplicate/validation')}}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    firstname: firstname,
                    midname: middlename,
                    lastname: lastname,
                    dob: birthdate,
                },
                success: function(response) {
                    // handle successful response
                    var swal_error = response.validationError;
                    if (swal_error == "FAIL") {
                        var errorMessage = "<span class='font-16'> You want to proceeed, A Member with same Fullname  and Date of Birth already exists!</span>";
                        // sweetAlert implementation for Confrimation Dialog
                        Swal.fire({
                            title: "Are you sure?",
                            html: errorMessage,
                            type: "warning",
                            showCancelButton: !0,
                            confirmButtonText: "Yes, Proceed",
                            cancelButtonText: "No, Cancel!",
                            confirmButtonClass: "btn btn-success mt-2",
                            cancelButtonClass: "btn btn-danger ml-2 mt-2",
                            buttonsStyling: !1,
                        }).then((result) => {
                            if (result.value == true) {
                                // Your code on success confirmation
                                $('#formMemberDetails').unbind('submit').submit();
                            }
                        })
                    } else {
                        $('#formMemberDetails').unbind('submit');
                    }
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

        var b = 2;
        $('#addFields').on('click', function() {
            $("#dynamicAddRemove").prepend(
                '<tr>' +
                '<td class="form-group col-lg-11 col-md-11 col-sm-12">' +
                '<div class="row font-12 border rounded pt-2 my-2" style="background-color:#fefefe;">' +
                '<div class="col-lg-6">' +
                '<div class="row">' +
                '<div class="col-lg-6">' +
                '<div class="form-group">' +
                '<label for="field-1" class="control-label">Relationship</label>' +
                '<select class="form-control SelectRow relationshipRowSelect" data-row="' + b + '" name="inputs[' + b + '][dep_relationship]" data-toggle="select2">' +
                '<option value="0">--Select Relationship--</option>' +
                '<option value="SPOUSE">SPOUSE</option>' +
                '<option value="CHILD">CHILD</option>' +
                '</select>' +
                '<div><span class="text-danger" role="alert"></span></div>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6">' +
                '<div class="form-group">' +
                '<label for="field-4" class="control-label">Gender</label>' +
                '<select class="form-control px-0 SelectRow" name="inputs[' + b + '][dep_gender]" data-toggle="select2">' +
                '<option value="0">--Select Gender--</option>' +
                '<option value="MALE">MALE</option>' +
                '<option value="FEMALE">FEMALE</option>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6">' +
                '<div class="form-group">' +
                '<label for="field-4" class="control-label">Firstname</label>' +
                '<input type="text" name="inputs[' + b + '][dep_firstname]" id="depFirstname" class="form-control form-control-sm" oninput="this.value = this.value.toUpperCase()" placeholder="First name">' +
                '<span class="depFirstnameErrorTxt text-danger" role="alert"></span>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6">' +
                '<div class="form-group">' +
                '<label for="field-5" class="control-label">Middlename</label>' +
                '<input type="text" name="inputs[' + b + '][dep_midname]" id="zone" class="form-control form-control-sm" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Middle name">' +
                '<span class="text-danger" role="alert"></span>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6">' +
                '<div class="form-group">' +
                '<label for="field-5" class="control-label">Last name</label>' +
                '<input type="text" name="inputs[' + b + '][dep_lastname]" id="zone" class="form-control form-control-sm" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Last name">' +
                '<span class="text-danger" role="alert"></span>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6"><div class="form-group"><label class="control-label">Phone</label>' +
                '<input type="text" name="inputs[' + b + '][dep_phone]" class="form-control form-control-sm" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(000) 000-000-000">' +
                '<span class="text-danger" role="alert"></span>' +
                '</div></div>' +
                '<div class="col-lg-6"><div class="form-group"><label for="field-5" class="control-label">Occupation</label>' +
                '<select class="form-control px-0 SelectRow" name="inputs[' + b + '][dep_occupation]" data-toggle="select2">' +
                '<option value="0">--Select Gender--</option>' +
                '<option value="UNEMPLOYED">UNEMPLOYED</option><option value="STUDENT">STUDENT</option><option value="FARMER">FARMER</option><option value="RETIRED">RETIRED</option><option value="EMPLOYED">EMPLOYED</option><option value="BUSINESS">BUSINESS</option><option value="PASTOR">PASTOR</option><option value="NONE">NONE</option>' +
                '</select>' +
                '<select class="form-control px-0" name="inputs[' + b + '][dep_vital_status]" data-toggle="select2"><option value="ALIVE" selected>ALIVE</option></select>' +
                '</div></div>' +
                '<div class="col-lg-6">' +
                '<div class="form-group">' +
                '<label for="field-5" class="control-label">Date of Birth</label>' +
                '<input type="text" name="inputs[' + b + '][dep_dob]" class="form-control form-control-sm nonParentDep" placeholder="Date of Birth"  autocomplete="off">' +
                '<span class="text-danger" role="alert"> </span>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6">' +
                '<div class="row">' +
                '<div class="col-lg-6">' +
                '<div class="form-group">' +
                '<label for="field-1" class="control-label">Dependant Photo</label>' +
                '<div class="file-loading">' +
                '<input class="row_dep_attachments" name="dep_photo[]" type="file">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6" id="divBirthCert' + b + '">' +
                '<div class="form-group">' +
                '<label for="field-1" class="control-label">Birth Certificate</label>' +
                '<div class="file-loading">' +
                '<input class="row_dep_attachments" id="inputBirthCert' + b + '" name="dep_birthcert[]" type="file">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6" id="divmarriageCert' + b + '" style="display:none;">' +
                '<div class="form-group">' +
                '<label for="field-1" class="control-label">Marriage Certificate</label>' +
                '<div class="file-loading">' +
                '<input class="row_dep_attachments" id="inputMarriageCert' + b + '" name="dep_marriagecert[]" type="file">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="form-group col-lg-1 col-md-1 col-sm-12 text-right ml-auto">' +
                '<a  class="btn btn-icon btn-round btn-xs mb-2 btn-danger white removeFields" style="color:#fff"><em class="mdi mdi-close"></em></a>' +
                '</td>' +
                '</tr>'
            );
            $(".SelectRow").select2();
            // Dynamic row Attachments JS
            $(".row_dep_attachments").fileinput({
                frameClass: 'my-frame-class',
                previewClass: 'depattachment-file-input',
                removeLabel: '',
                initialPreviewAsData: true,
                showUpload: false,
                showCaption: false,
                dropZoneEnabled: false,
            });


            var input = '[name="inputs[' + b + '][dep_dob]"]';
            $('select[name="inputs[' + b + '][dep_relationship]"]').change(function() {
                // Fix for var b issue of incrementing is value after onchange event fx
                var rowID = $(this).attr("data-row");
                // check the value for the selected option 
                var relationType = $(this).find(":selected").val();

                if (relationType == "SPOUSE") {
                    var enddate = "-18Y";
                    $('#divBirthCert' + rowID).hide();
                    $('#divmarriageCert' + rowID).show();
                    $('#inputMarriageCert' + rowID).attr("required", "required");
                    $('#inputbirthCert' + rowID).removeAttr("required");
                    initDatepicker(enddate, null, input);
                }
                if (relationType == "CHILD") {
                    var newenddate = 'today';
                    var startdate = "-21Y";
                    $('#divmarriageCert' + rowID).hide();
                    $('#divBirthCert' + rowID).show();
                    $('#inputbirthCert' + rowID).attr("required", "required");
                    $('#inputMarriageCert' + rowID).removeAttr("required");

                    initDatepicker(newenddate, startdate, input);
                }
            });

            b++;
        });

    });

    // codes for Removing the dynamic Input Fields
    $(document).on('click', '.removeFields', function() {
        $(this).parents('tr').remove();
    });
</script>
<script type="text/javascript">
    // Funtion for Validation of the dynamic rows for Dependants
    $(document).ready(function() {
        $('#formDependants').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{url('/ajax/dynamic/validation')}}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    // handle successful response
                    var inputs_errors = response.errors;
                    if (inputs_errors) {
                        $.each(inputs_errors, function(field, messages) {
                            // alert(messages);
                            var name = field.split(".")[0] + "[" + field.split(".")[1] + "][" + field.split(".")[2] + "]";
                            $('input[name="' + name + '"], select[name="' + name + '"]').closest('div').find('span.text-danger').html(messages);
                        });
                    } else {
                        $('#formDependants').unbind('submit');
                    }
                }
            });
        });
    });
</script>

<!-- Datatables init -->
<script type="text/javascript">
    function initDatepicker(end_date, start_date, inputName) {
        $(inputName).datepicker('setDate', null);
        $(inputName).datepicker("destroy");
        $(inputName).datepicker({
            startDate: start_date,
            endDate: end_date,
            format: "dd MM yyyy",
            autoclose: true,
        });

    }

    $('#member_dobdatepicker').datepicker({
        endDate: "-18Y"
    });

    $('.dep_parentdobdatepicker').datepicker({
        endDate: "-21Y",
    });
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