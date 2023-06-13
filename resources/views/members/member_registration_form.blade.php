@extends('layouts.admin_main')
@section('custom_css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<!-- kartik Fileinput-->
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fontawesome-kartik.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/bootstrap-icons.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fileinput.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.css')}}" />

<!-- third party css end -->
<style>
    .kv-avatar .krajee-default.file-preview-frame,
    .kv-avatar .krajee-default.file-preview-frame:hover,
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

    .kv-avatar {
        display: inline-block;
    }

    .kv-avatar .file-input {
        display: table-cell;
        width: 213px;
    }

    .kv-reqd {
        color: red;
        font-family: monospace;
        font-weight: normal;
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
                    <form method="POST" enctype="multipart/form-data" action="{{url('/member/registration/submit')}}">
                        @csrf
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Personal Data</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-1" class="control-label">Designation</label>
                                                <select class="form-control" name="evengelical_title" data-toggle="select2">
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
                                                <select class="form-control" name="salutation" data-toggle="select2">
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
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-1" class="control-label">First-name</label>
                                                <input type="text" name="firstname" class="form-control form-control-sm" value="{{old('firstname')}}" oninput="this.value = this.value.toUpperCase()" id="field-1" placeholder="Firstname">
                                                <span class="text-danger" role="alert"> {{ $errors->first('firstname') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-1" class="control-label">Middlename</label>
                                                <input type="text" name="middle_name" class="form-control form-control-sm" value="{{old('middle_name')}}" oninput="this.value = this.value.toUpperCase()" id="field-1" placeholder="Middle Name">
                                                <span class="text-danger" role="alert"> {{ $errors->first('middle_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-1" class="control-label">Last-name</label>
                                                <input type="text" name="lastname" class="form-control form-control-sm" value="{{old('lastname')}}" oninput="this.value = this.value.toUpperCase()" id="field-1" placeholder="Last Name">
                                                <span class="text-danger" role="alert"> {{ $errors->first('lastname') }}</span>
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
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-1" class="control-label">Date of Birth</label>
                                                <input type="text" name="dob" class="form-control form-control-sm" value="{{old('dob')}}" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd M yyyy" data-date-min-date="-18Y" placeholder="Date of Birth">
                                                <span class="text-danger" role="alert"> {{ $errors->first('dob') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-3" class="control-label">Postal Address</label>
                                                <input type="text" name="postalAddress" class="form-control form-control-sm" value="{{old('postalAddress')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Postal Address" required>
                                                <span class="text-danger" role="alert"> {{ $errors->first('postalAddress') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-4" class="control-label">Physical Address</label>
                                                <input type="text" name="physicalAddress" class="form-control form-control-sm" value="{{old('physicalAddress')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Physical Address" required>
                                                <span class="text-danger" role="alert"> {{ $errors->first('physicalAddress') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-5" class="control-label">Phone</label>
                                                <input type="text" name="phone" class="form-control form-control-sm" id="input-phone" value="{{old('phone')}}" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(000) 000-000-000" autocomplete="off" required>
                                                <span class="text-danger" role="alert"> {{ $errors->first('phone') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-5" class="control-label">Email</label>
                                                <input type="email" name="email" class="form-control form-control-sm" value="{{old('email')}}" oninput="this.value = this.value.toLowerCase()" id="input-email" placeholder="e.g xxxxx@gmail.com" autocomplete="off" required>
                                                <span class="text-danger" role="alert"> {{ $errors->first('email') }}</span>
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
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-1" class="control-label">Scheme joining date</label>
                                                <input type="text" name="joining_date" class="form-control form-control-sm humanfd-datepicker" value="{{old('joining_date')}}" placeholder="Date of Birth">
                                                <span class="text-danger" role="alert"> {{ $errors->first('joining_date') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-1" class="control-label">Service start Date</label>
                                                <input type="text" name="service_date" class="form-control form-control-sm humanfd-datepicker" value="{{old('service_date')}}" placeholder="Date of Birth">
                                                <span class="text-danger" role="alert"> {{ $errors->first('service_date') }}</span>
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
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-4" class="control-label">ID number</label>
                                                <input type="text" name="id_number" id="id-number" class="form-control form-control-sm" value="{{old('id_number')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="ID number" required readonly>
                                                <span class="text-danger" role="alert"> {{ $errors->first('id_number') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Contributor Details</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="field-1" class="control-label">Contributor</label>
                                                <select class="form-control" name="contributor_name" data-toggle="select2">
                                                    <option value="0">-- Select Contributor --</option>
                                                    @foreach($contributors as $contributor)
                                                    <option value="{{$contributor->id}}">{{$contributor->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" role="alert"> {{ $errors->first('contributor_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-4" class="control-label">Section</label>
                                                <input type="text" name="section" id="section" class="form-control form-control-sm" value="{{old('section')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="District" required readonly>
                                                <span class="sectionErrorTxt text-danger" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-4" class="control-label">District</label>
                                                <input type="text" name="district" id="district" class="form-control form-control-sm" value="{{old('district')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="District" required readonly>
                                                <span class="districtErrorTxt text-danger" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-5" class="control-label">Zone</label>
                                                <input type="text" name="zone" id="zone" class="form-control form-control-sm" value="{{old('zone')}}" oninput="this.value = this.value.toUpperCase()" id="field-5" placeholder="Zone" required readonly>
                                                <span class="zoneErrorTxt text-danger" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-5" class="control-label">Monthly income</label>
                                                <input type="text" name="zone" id="monthly_income" class="form-control form-control-sm autonumber" value="{{old('monthly_income')}}" placeholder="Monthly Income" data-a-sign="TZS. " placeholder="Enter Income" autocomplete="off" required>
                                                <span class="text-danger" role="alert"> {{ $errors->first('contributor_name') }}</span>
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
                                                    <input id="avatar-1" name="avatar-1" type="file" required>
                                                </div>
                                            </div>
                                            <div class="kv-avatar-hint">
                                                <small>Select file < 1500 KB</small>
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- <div class="form-group"> -->
                                            <label for="field-1" class="control-label">Member Signature</label>

                                            <div class="kv-avatar">
                                                <div class="file-loading">
                                                    <input id="avatar-1" name="digital_signature" type="file" required>
                                                </div>
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- <div class="form-group"> -->
                                            <label for="field-1" class="control-label">Member Photo</label>

                                            <div class="kv-avatar">
                                                <div class="file-loading">
                                                    <input id="avatar-1" name="avatar-1" type="file" required>
                                                </div>
                                            </div>
                                            <div class="kv-avatar-hint">
                                                <small>Select file < 1500 KB</small>
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                                <div class="col-md-12 px-4">
                                    <button type="submit" class="btn btn-info waves-effect waves-light float-right">Submit</button>
                                </div>
                            </div>
                        </div>

                    </form>



                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

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
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.js')}}"></script>


<!-- Datatables init -->
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- Datatables init -->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
<script type="text/javascript">
    $('input[data-provide="datepicker"]').datepicker({
        endDate: "-18Y"
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
        $('.sectionSelect option[value=0]').prop('selected', true);
        $('#district').val('');
        $('#zone').val('');
    });
    //END:: ON PAGE load

    //START:: On event
    $('.sectionSelect').change(function() {
        var section_id = $(this).find(":selected").val();
        if (section_id == 0) {
            $("#sectionError").html('Kindly, select a Section');
            $('#district').val('');
            $('#zone').val('');
        } else {
            $("#sectionError").html('');
            $.ajax({
                url: "{{url('/ajax/get/section/data')}}",
                type: 'POST',
                data: {
                    section_id: section_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.sectionDataArr.code == 201) {
                        $('.districtErrorTxt').html('');
                        $('.zoneErrorTxt').html('');
                        $('#district').val(response.sectionDataArr.district);
                        $('#zone').val(response.sectionDataArr.zone);
                    } else {
                        $('.districtErrorTxt').html(response.sectionDataArr.district_message)
                        $('.zoneErrorTxt').html(response.sectionDataArr.zone_message)
                        $("#sectionError").html('Kindly select a Section');
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
        browseIcon: '<i class="bi-folder2-open"> </i> <span class"font-12"> Member Photo</span>',
        removeIcon: '<i class="bi-x-lg"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        // defaultPreviewContent: '<img src="/samples/default-avatar-male.png" alt="Your Avatar">',
        layoutTemplates: {
            main2: '{preview} ' + ' {remove} {browse}'
        },
        allowedFileExtensions: ["jpg","jpeg", "png", "gif"],

    });
</script>
@endsection