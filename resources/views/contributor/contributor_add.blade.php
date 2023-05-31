
@extends('layouts.admin_main')
@section('custom_css')
<!-- kartik Fileinput-->
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fontawesome-kartik.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/bootstrap-icons.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fileinput.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.css')}}" />
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
                                    <li class="breadcrumb-item active">Categories</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Contributors</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <!-- end row-->
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                                        <div class="row">
                                            <div class="col-sm-4">

                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-right">
                                                    <a href="{{url('contributors')}}" class="btn btn-info mb-2 mr-1"><i class="mdi mdi-plus-circle mr-2"></i> Back</a>
                                                </div>
                                            </div><!-- end col-->
                                        </div>

                                        <!-- end row-->
                                        <div class="row">
                                        <div class="col-12 px-2">
                                                <form method="POST" enctype="multipart/form-data" action="{{url('submit/add/contributor')}}">
                                                @csrf
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="field-1" class="control-label">Contributor Name</label>
                                                                            <input type="text" name="name" class="form-control form-control-sm" value="{{old('name')}}" oninput="this.value = this.value.toUpperCase()" id="field-1" placeholder="Contributor Name">
                                                                            <span class="text-danger" role="alert"> <strong>{{ $errors->first('name') }}</strong></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-1" class="control-label">Contributor Type</label>
                                                                            <select class="form-control" name="contributorType" data-toggle="select2">
                                                                                <option value="0"> -- Select Contributor Type --</option>
                                                                                @foreach($contrTypes as $value)
                                                                                <option  value="{{$value->id}}">{{$value->name}} </option>
                                                                                @endforeach
                                                                            </select>
                                                                                <span class="text-danger" role="alert"> <strong>{{ $errors->first('contributorType') }}</strong></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-3" class="control-label">Section</label>
                                                                            <select class="form-control sectionSelect" name="section" data-toggle="select2">
                                                                                <option value="0"> -- Select Section --</option>
                                                                                @foreach($sections as $value)
                                                                                <option value="{{$value->id}}">{{$value->name}} </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span class="text-danger" id="sectionError" role="alert"></span>
                                                                            <span class="text-danger" role="alert"> <strong>{{ $errors->first('section') }}</strong></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-4" class="control-label">District</label>
                                                                            <input type="text" name="district" id="district" class="form-control form-control-sm"  value="{{old('district')}}" oninput="this.value = this.value.toUpperCase()"  id="field-4" placeholder="District" required readonly>
                                                                            <span class="districtErrorTxt text-danger" role="alert"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-5" class="control-label">Zone</label>
                                                                            <input type="text" name="zone" id="zone" class="form-control form-control-sm"  value="{{old('zone')}}" oninput="this.value = this.value.toUpperCase()"  id="field-5" placeholder="Zone" required readonly>
                                                                            <span class="zoneErrorTxt text-danger" role="alert"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-3" class="control-label">Postal Address</label>
                                                                            <input type="text" name="postalAddress" class="form-control form-control-sm"  value="{{old('postalAddress')}}" oninput="this.value = this.value.toUpperCase()"  id="field-4" placeholder="Postal Address" required>
                                                                            <span class="text-danger" role="alert"> <strong>{{ $errors->first('postalAddress') }}</strong></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-4" class="control-label">Physical Address</label>
                                                                            <input type="text" name="physicalAddress" class="form-control form-control-sm"  value="{{old('physicalAddress')}}" oninput="this.value = this.value.toUpperCase()"  id="field-4" placeholder="Physical Address" required>
                                                                            <span class="text-danger" role="alert"> <strong>{{ $errors->first('physicalAddress') }}</strong></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-5" class="control-label">Phone</label>
                                                                            <input type="text" name="phone" class="form-control form-control-sm" id="field-5" value="{{old('phone')}}" placeholder="Phone" required>
                                                                            <span class="text-danger" role="alert"> <strong>{{ $errors->first('phone') }}</strong></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-5" class="control-label">Email</label>
                                                                            <input type="email" name="email" class="form-control form-control-sm" value="{{old('email')}}" oninput="this.value = this.value.toLowerCase()" id="field-5" placeholder="Email" required>
                                                                            <span class="text-danger" role="alert"> <strong>{{ $errors->first('email') }}</strong></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="field-3" class="control-label">Registration Form</label>
                                                                            <input type="file" class="form-control kartik-input-705" name="regFormAttachment" id="field-4" placeholder="District" required>
                                                                                @if ($errors->has('regFormAttachment')) <span class="text-danger" role="alert"> <strong>{{ $errors->first('regFormAttachment') }}</strong></span>@endif
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="col-md-12 px-4">
                                                            <button type="submit" class="btn btn-info waves-effect waves-light float-right">Submit</button>
                                                        </div>
                                                </form>
                                        </div> <!-- end col -->
                                        </div>
                                    <!-- end row -->

                                </div> <!-- container -->

                            </div> <!-- content -->
                         <!-- end .table-responsive-->
                        </div> <!-- end card-box-->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
@endsection
@section('custom_script')
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.js')}}"></script>

<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 6000);
</script>

<script>
     $(".kartik-input-705").fileinput({
        theme: "explorer",
        uploadUrl: '#',
        allowedFileExtensions: ['jpg', 'jpeg','png', 'gif'],
        overwriteInitial: false,
        initialPreviewAsData: true,
        maxFileSize: 2000,
        maxTotalFileCount: 1,
        showUpload : false,
        showCancel : false,
        dropZoneTitle:'<span>Drag & Drop images here to upload</span>',
        fileActionSettings: {
                showUpload: false,
                showRemove: true,
                },

    });
</script>

<script>
//START:: On page load set defautl selection
    $(document).ready(function(){
        $('.sectionSelect option[value=0]').prop('selected', true);
        $('#district').val('');
        $('#zone').val('');
    });
//END:: ON PAGE load

//START:: On event
    $('.sectionSelect').change(function() {
        var section_id = $(this).find(":selected").val();
        if (section_id ==0) {
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
                    if(response.sectionDataArr.code==201){
                        $('.districtErrorTxt').html('');
                        $('.zoneErrorTxt').html('');
                        $('#district').val(response.sectionDataArr.district);
                        $('#zone').val(response.sectionDataArr.zone);
                    }else{
                        $('.districtErrorTxt').html(response.sectionDataArr.district_message)
                        $('.zoneErrorTxt').html(response.sectionDataArr.zone_message)
                        $("#sectionError").html('Kindly select a Section');
                    }
                }
            });
        }
    });
</script>
@endsection
