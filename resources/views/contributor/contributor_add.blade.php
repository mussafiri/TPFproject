
@extends('layouts.admin_main')
@section('custom_css')
<!-- kartik Fileinput-->
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fontawesome-kartik.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/bootstrap-icons.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fileinput.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer-fa/theme.css')}}" />
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
                                                    <button type="button" class="btn btn-info mb-2 mr-1" data-toggle="modal" data-target="#add_modal"><i class="mdi mdi-plus-circle mr-2"></i> Add Contributors</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>

                                        <!-- end row-->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                @if ($errors->any())
                                                <div class="example-alert">
                                                    <div class="alert alert-danger alert-icon" role="alert">
                                                        <em class="icon ni ni-cross-circle"></em>
                                                        <strong>{{ $errors->first() }}</strong>
                                                    </div>
                                                </div>
                                                @endif
                                                @if(session()->has('success'))
                                                <div class="example-alert">
                                                    <div class="alert alert-success alert-icon">
                                                        <em class="icon ni ni-check-circle"></em>
                                                        <strong>{{ session()->get('success') }}</strong>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>

                                        <div class="col-12 px-2">
                                                <form method="POST" action="{{url('submit/add/contributor')}}">
                                                @csrf
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="field-1" class="control-label">Contributor Name</label>
                                                                            <input type="text" name="name" class="form-control form-control-sm" id="field-1" placeholder="Contributor Name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-1" class="control-label">Contributor Type</label>
                                                                            <select class="form-control" name="contributorType" data-toggle="select2">
                                                                                <option value="0"> -- Select Contributor Type --</option>
                                                                                @foreach($contrTypes as $value)
                                                                                <option value="{{$value->id}}">{{$value->name}} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-3" class="control-label">Section</label>
                                                                            <select class="form-control" name="section" data-toggle="select2">
                                                                                <option value="0"> -- Select Section --</option>
                                                                                @foreach($sections as $value)
                                                                                <option value="{{$value->id}}">{{$value->name}} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-4" class="control-label">District</label>
                                                                            <input type="text" id="district" class="form-control form-control-sm" id="field-4" placeholder="District" required readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-5" class="control-label">Zone</label>
                                                                            <input type="text" id="zone" class="form-control form-control-sm" id="field-5" placeholder="Zone" required readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-3" class="control-label">Postal Address</label>
                                                                            <input type="text" name="postalAddress" class="form-control form-control-sm" id="field-4" placeholder="Postal Address" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-4" class="control-label">Physical Address</label>
                                                                            <input type="text" name="physicalAddress" class="form-control form-control-sm" id="field-4" placeholder="Physical Address" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-5" class="control-label">Phone</label>
                                                                            <input type="text" name="phone" class="form-control form-control-sm" id="field-5" placeholder="Phone" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-5" class="control-label">Email</label>
                                                                            <input type="email" name="email" class="form-control form-control-sm" id="field-5" placeholder="Email" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
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
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer-fa/theme.js')}}"></script>

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
        allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif', 'PDF'],
        overwriteInitial: true,
        initialPreviewAsData: true,
        maxFileSize: 2000,
        maxTotalFileCount: 1,
        showUpload: false,
        showCancel: false,
        showRemove: false,
        fileActionSettings: {
            showUpload: false,
            showRemove: true,
        },
    });
</script>
@endsection
