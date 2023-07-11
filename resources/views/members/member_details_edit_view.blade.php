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
                                    Attachments
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content col-12">
                            <div class="tab-pane active" id="MemberParticularsPane">
                                <div class="col-12">
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Personal Data</h5>
                                    <form action="{{url('/member/edit/details/submit/'.Crypt::encryptString($member_data->id))}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Designation</label>
                                                            <select class="form-control" name="evengelical_title" data-toggle="select2" required>
                                                                <option value="0">--Select Designation--</option>
                                                                @foreach($salutation_title as $title)
                                                                @if (!($title->id != $member_data->member_salutation_id && $title->status != "ACTIVE"))
                                                                <option value="{{$title->id}}" {{($title->id == $member_data->member_salutation_id)? "selected":"";}}>{{$title->name}}</option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Salutation</label>
                                                            <select class="form-control" name="salutation" data-toggle="select2" required>
                                                                <option value="0">--Select Salutation--</option>
                                                                <option value="MR" {{$member_data->title =="MR" ? "selected":"";}}>MR</option>
                                                                <option value="MS" {{$member_data->title =="MS" ? "selected":"";}}>MS</option>
                                                                <option value="MRS" {{$member_data->title =="MRS" ? "selected":"";}}>MRS</option>
                                                                <option value="DR" {{$member_data->title =="DR" ? "selected":"";}}>DR</option>
                                                                <option value="REV" {{$member_data->title =="REV" ? "selected":"";}}>REV</option>
                                                                <option value="PST" {{$member_data->title =="PST" ? "selected":"";}}>PST</option>
                                                                <option value="PROF" {{$member_data->title =="PROF" ? "selected":"";}}>PROF</option>
                                                                <option value="BISHOP" {{$member_data->title =="BISHOP" ? "selected":"";}}>BISHOP</option>
                                                            </select>
                                                            @if ($errors->editMemberDetails->has('salutation')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('salutation') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">First-name</label>
                                                            <input type="text" name="firstname" class="form-control form-control-sm" value="{{old('firstname',$member_data->fname)}}" oninput="this.value = this.value.toUpperCase()" id="firstname-1" placeholder="Firstname" autocomplete="off" required>
                                                            @if ($errors->editMemberDetails->has('firstname')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('firstname') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Middlename</label>
                                                            <input type="text" name="middle_name" class="form-control form-control-sm" value="{{old('middle_name',$member_data->mname)}}" oninput="this.value = this.value.toUpperCase()" id="midname-1" placeholder="Middle Name" autocomplete="off" required>
                                                            @if ($errors->editMemberDetails->has('middle_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('middle_name') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Last-name</label>
                                                            <input type="text" name="lastname" class="form-control form-control-sm" value="{{old('lastname',$member_data->lname)}}" oninput="this.value = this.value.toUpperCase()" id="lastname-1" placeholder="Last Name" autocomplete="off" required>
                                                            @if ($errors->editMemberDetails->has('lastname')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('lastname') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Marital Status</label>
                                                            <select class="form-control" name="marital_status" data-toggle="select2">
                                                                <option value="0">--Select Marital status--</option>
                                                                <option value="MARRIED" {{$member_data->marital_status =="MARRIED" ? "selected":"";}}>MARRIED</option>
                                                                <option value="SINGLE" {{$member_data->marital_status =="SINGLE" ? "selected":"";}}>SINGLE</option>
                                                                <option value="DIVORCED" {{$member_data->marital_status =="DIVORCED" ? "selected":"";}}>DIVORCED</option>
                                                            </select>
                                                            @if ($errors->editMemberDetails->has('marital_status')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('marital_status') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Gender</label>
                                                            <select class="form-control" name="gender" data-toggle="select2">
                                                                <option value="0">--Select Gender--</option>
                                                                <option value="MALE" {{$member_data->gender=="MALE" ? "selected":""}}>MALE</option>
                                                                <option value="FEMALE" {{$member_data->gender=="FEMALE" ? "selected":""}}>FEMALE</option>
                                                            </select>
                                                            @if ($errors->editMemberDetails->has('gender')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('gender') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Date of Birth</label>
                                                            @php $dob = $member_data->dob != "NULL" ? date('d M Y',strtotime($member_data->dob)) :''; @endphp
                                                            <input type="text" name="dob" value="{{old('dob',$dob)}}" class="form-control form-control-sm" id="member_dobdatepicker">
                                                            @if ($errors->editMemberDetails->has('dob')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('dob') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div><!-- .end of Personal Data -->
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-3" class="control-label">Postal Address</label>
                                                            <input type="text" name="postalAddress" class="form-control form-control-sm" value="{{old('postalAddress',$member_data->postal_address)}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Postal Address" autocomplete="off">

                                                            @if ($errors->editMemberDetails->has('postalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('postalAddress') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-4" class="control-label">Physical Address</label>
                                                            <input type="text" name="physicalAddress" class="form-control form-control-sm" value="{{old('physicalAddress',$member_data->physical_address)}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Physical Address" autocomplete="off">

                                                            @if ($errors->editMemberDetails->has('physicalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('physicalAddress') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-5" class="control-label">Phone</label>
                                                            <input type="text" name="phone" class="form-control form-control-sm" id="input-phone" value="{{old('phone',$member_data->phone)}}" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(255) 000-000-000" autocomplete="off">

                                                            @if ($errors->editMemberDetails->has('phone')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('phone') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-5" class="control-label">Email</label>
                                                            <input type="email" name="email" class="form-control form-control-sm" value="{{old('email',$member_data->email)}}" oninput="this.value = this.value.toLowerCase()" id="input-email" placeholder="e.g xxxxx@gmail.com" autocomplete="off">

                                                            @if ($errors->editMemberDetails->has('email')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('email') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Scheme joining date</label>
                                                            <input type="text" id="scheme_date" name="joining_date" class="form-control form-control-sm humanfd-datepicker" value="{{old('joining_date',$member_data->join_at)}}" placeholder="Scheme joining of date">
                                                            @if ($errors->editMemberDetails->has('joining_date')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('joining_date') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Service start Date</label>
                                                            @php $service = $member_data->service_start_at != "NULL" ? date('d M Y',strtotime($member_data->service_start_at)) :''; @endphp
                                                            <input type="text" name="service_date" class="form-control form-control-sm" data-provide="datepicker" data-date-autoclose="true" onkeydown="return false;" data-date-format="dd M yyyy" value="{{old('service_date',$service)}}" placeholder="Date of Service start date">
                                                            @if ($errors->editMemberDetails->has('service_date')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('service_date') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Occupation</label>
                                                            <select class="form-control" name="occupation" data-toggle="select2">
                                                                <option value="0">--Select Occupation--</option>
                                                                <option value="PASTOR" {{$member_data->occupation =="PASTOR" ? "selected":"";}}>PASTOR</option>
                                                                <option value="FARMER" {{$member_data->occupation =="FARMER" ? "selected":"";}}>FARMER</option>
                                                                <option value="UNEMPLOYED" {{$member_data->occupation =="UNEMPLOYED" ? "selected":"";}}>UNEMPLOYED</option>
                                                                <option value="EMPLOYED" {{$member_data->occupation =="EMPLOYED" ? "selected":"";}}>EMPLOYED</option>
                                                                <option value="RETIRED" {{$member_data->occupation =="RETIRED" ? "selected":"";}}>RETIRED</option>
                                                                <option value="BUSINESS" {{$member_data->occupation =="BUSINESS" ? "selected":"";}}>BUSINESS</option>
                                                                <option value="NONE" {{$member_data->occupation =="NONE" ? "selected":"";}}>NONE</option>
                                                            </select>
                                                            @if ($errors->editMemberDetails->has('occupation')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('occupation') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="field-4" class="control-label">Member monthly income</label>
                                                            <input type="text" name="submission_type" class="form-control form-control-sm" value="MEMBER-PARTICULARS" hidden>
                                                            <input type="text" name="monthly_income" id="monthly_income" class="form-control form-control-sm autonumber" value="{{old('monthly_income',$member_data->income)}}" data-a-sign="TZS. " placeholder="Enter member monthly income" autocomplete="off">
                                                            @if ($errors->editMemberDetails->has('id_number')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->editMemberDetails->first('id_number') }}</small></strong></span>@endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" dropdown-divider col-12"></div>
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-info waves-effect waves-light float-right">Update Particulars</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- end Member Particulars .tab-pane active-->
                            <div class="tab-pane" id="contributorPane">
                                <div class="col-12">
                                    <h5 class="text-uppercase mt-0 mb-1 bg-light p-2">Contributor Data</h5>
                                    <p class="font-13"><i class="mdi mdi-star-half-full text-success font-18 mr-1 mt-0"></i>Change the Primary Contributor of the Member</p>
                                    <form action="{{url('/member/edit/details/submit/'.Crypt::encryptString($member_data->id))}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-12">
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
                                                            <label for="field-5" class="control-label">Zone</label>
                                                            <input type="text" name="zone" id="zone" class="form-control form-control-sm" value="{{old('zone')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Zone" readonly>
                                                            <span class="zoneErrorTxt text-danger" role="alert"></span>
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
                                                            <label for="field-4" class="control-label">Section</label>
                                                            <input type="text" name="submission_type" class="form-control form-control-sm" value="CONTRIBUTOR" hidden>
                                                            <input type="text" name="section" id="section" class="form-control form-control-sm" value="{{old('section')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="District" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
<script>
    $(document).ready(function() {
        var defaultDt = new Date('2023-07-13');
        $('#member_dobdatepicker').datepicker({
            format: 'dd M yyyy',
            // defaultDate: defaultDt,
        });
        // Set input value to defaultDate
        // $('#member_dobdatepicker').val("2023-07-13");
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
@endsection