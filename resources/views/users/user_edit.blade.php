
@extends('layouts.admin_main')
@section('custom_css')
<!-- kartik Fileinput-->
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fontawesome-kartik.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/bootstrap-icons.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fileinput.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.css')}}" />

<link href="{{asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
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
                                    <li class="breadcrumb-item active">Users</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Update User</h4>
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
                                                    <a href="{{url('users/list/'.Crypt::encryptString('ACTIVE'))}}" class="btn btn-info mb-2 mr-1"><i class="mdi mdi-arrow-left-thick mr-2"></i> Back</a>
                                                </div>
                                            </div><!-- end col-->
                                        </div>

                                        <!-- end row-->
                                        <div class="row">
                                        <div class="col-12 px-2">
                                                <form method="POST" enctype="multipart/form-data" action="{{url('users/edit/submit/'.$userData->id)}}">
                                                @csrf
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">  

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-1" class="control-label">First Name</label>
                                                                            <input type="text" name="fname" class="form-control form-control-sm" value="{{old('fname', $userData->fname)}}" oninput="this.value = this.value.toUpperCase()" id="field-1" placeholder="First Name">
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('fname') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-1" class="control-label">Middle Name</label>
                                                                            <input type="text" name="mname" class="form-control form-control-sm" value="{{old('mname', $userData->mname)}}" oninput="this.value = this.value.toUpperCase()" id="field-1" placeholder="Middle Name">
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('mname') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-1" class="control-label">Last Name</label>
                                                                            <input type="text" name="lname" class="form-control form-control-sm" value="{{old('lname', $userData->lname)}}" oninput="this.value = this.value.toUpperCase()" id="field-1" placeholder="Last Name">
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('lname') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-1" class="control-label">Gender</label>
                                                                            <select class="form-control" name="gender" data-toggle="select2">
                                                                                <option value="MALE" @if(old ('gender') == 'MALE' || $userData->gender=='MALE') {{'selected'}} @endif >MALE</option>
                                                                                <option value="FEMALE" @if(old ('gender') == 'FEMALE' || $userData->gender=='FEMALE') {{'selected'}} @endif >FEMALE</option>
                                                                            </select>
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('gender') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-5" class="control-label">Phone</label>
                                                                            <input type="text" name="phone" class="form-control form-control-sm" id="input-phone" value="{{old('phone', $userData->phone)}}"  placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(000) 000-000-000" autocomplete="off" required>
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('phone') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-5" class="control-label">Email</label>
                                                                            <input type="email" name="email" class="form-control form-control-sm" value="{{old('email', $userData->email)}}" oninput="this.value = this.value.toLowerCase()" id="input-email" placeholder="e.g xxxxx@gmail.com" autocomplete="off" required>
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('email') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-1" class="control-label">Department</label>
                                                                            <select class="form-control departmentSelect" name="department" data-toggle="select2">
                                                                                <option value="0"> -- Select Department --</option>
                                                                                @foreach($departmentData as $data)
                                                                                <option  value="{{$data->id}}" @if( old('department') == $data->id || $userData->department_id == $data->id) {{'selected'}} @endif >{{$data->name}} </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span class="text-danger" id="departmentError" role="alert"> {{ $errors->first('department') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-3" class="control-label">Designation</label>
                                                                            <select class="form-control designation" name="designation" data-toggle="select2">
                                                                                <option value="0"> -- Select Designation --</option>
                                                                                @foreach($designations as $value)
                                                                                <option  value="{{$value->id}}" @if( old('designation') == $value->id || $userData->designation_id == $value->id) {{'selected'}} @endif >{{$value->name}} </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('designation') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-3" class="control-label">Date of Birth</label>
                                                                            <input type="text" name="dateOfBirth" class="form-control form-control-sm" data-provide="datepicker" data-date-autoclose="true" data-date-format="dd M, yyyy" placeholder="Pick Date of Birth" value="{{old('dateOfBirth', date('d M, Y', strtotime($userData->dob)))}}" id="field-4" required>
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('dateOfBirth') }}</span>
                                                                        </div>
                                                                    </div>  
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-3" class="control-label">Postal Address</label>
                                                                            <input type="text" name="postalAddress" class="form-control form-control-sm"  value="{{old('postalAddress', $userData->postal_address)}}" oninput="this.value = this.value.toUpperCase()"  id="field-4" placeholder="Postal Address" required>
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('postalAddress') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-4" class="control-label">Physical Address</label>
                                                                            <input type="text" name="physicalAddress" class="form-control form-control-sm"  value="{{old('physicalAddress', $userData->physical_address)}}" oninput="this.value = this.value.toUpperCase()"  id="field-4" placeholder="Physical Address" required>
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('physicalAddress') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="field-3" class="control-label">User Photo</label>
                                                                            <input type="file" class="form-control kartik-input-705" name="photoAttachment" id="field-4">
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('photoAttachment') }}</span>
                                                                        </div>
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

<!-- Init js-->
<script src="{{asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-pickers.init.js')}}"></script>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 6000);
</script>

<script>
 $(function () {
   var bindDatePicker = function() {
		$(".date").datetimepicker({
        format:'YYYY-MM-DD',
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			}
		}).find('input:first').on("blur",function () {
			// check if the date is correct. We can accept dd-mm-yyyy and yyyy-mm-dd.
			// update the format if it's yyyy-mm-dd
			var date = parseDate($(this).val());

			if (! isValidDate(date)) {
				//create date based on momentjs (we have that)
				date = moment().format('YYYY-MM-DD');
			}

			$(this).val(date);
		});
	}
   
   var isValidDate = function(value, format) {
		format = format || false;
		// lets parse the date to the best of our knowledge
		if (format) {
			value = parseDate(value);
		}

		var timestamp = Date.parse(value);

		return isNaN(timestamp) == false;
   }
   
   var parseDate = function(value) {
		var m = value.match(/^(\d{1,2})(\/|-)?(\d{1,2})(\/|-)?(\d{4})$/);
		if (m)
			value = m[5] + '-' + ("00" + m[3]).slice(-2) + '-' + ("00" + m[1]).slice(-2);

		return value;
   }
   
   bindDatePicker();
 });
</script>
<script type="text/javascript">
    $(function() {
        $('.date-picker').daterangepicker({
            autoUpdateInput: false,
            autoApply: true,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('.date-picker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD MMM,Y') + ' to ' + picker.endDate.format('DD MMM,Y'));
        });

        $('.date-picker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
</script>

<script>
$(document).ready(function() {
        var filePath = '{{$fileInputArr["filePath"]}}';
        var fileName = '{{$fileInputArr["finaleName"]}}';
        var fileSize = '{{$fileInputArr["fileSize"]}}';
        if(fileSize > 0){
            $(".kartik-input-705").fileinput({
                theme: "explorer",
                uploadUrl: '#',
                allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif', 'PDF'],
                showUpload : false,
                showCancel : false,
                showRemove : false,
                maxFileSize: 2000,
                maxTotalFileCount: 1,
                fileActionSettings: {
                    showUpload: false,
                    showRemove: true,
                },
                initialPreviewAsData: true,
                initialPreview: [filePath],
                initialPreviewConfig: [{ type:"pdf",caption:fileName, downloadUrl:filePath, description: fileName, size: fileSize, width: "70px"}],
                overwriteInitial: true,
                maxFileSize: 2000,
            });
        }else{
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
        }
});
</script>

<script>
//START:: On page load set defautl selection
    $(document).ready(function(){
        $('.departmentSelect option[value=0]').prop('selected', true);
        $('#district').val('');
        $('#zone').val('');
    });
//END:: ON PAGE load

//START:: On event
    $('.departmentSelect').change(function() {
        var data_id = $(this).find(":selected").val();
        if (data_id ==0) {
            $("#departmentError").html('Kindly, select a Section');
        } else {
            $("#departmentError").html('');
            $.ajax({
                url: "{{url('/ajax/get/designations')}}",
                type: 'POST',
                data: {
                    data_id: data_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if(response.designationsDataArr.code==201){
                        var len = response.designationsDataArr.data.length;
                            $(".designation").empty();
                            $(".designation").append('<option value="0"> ...Select Designation... </option>');
                            for( var a = 0; a<len; a++){
                                $(".designation").append("<option value='"+response.designationsDataArr.data[a].id+"' '{{old ('designation') == $value->id ? 'selected' : ''}}'>"+response.designationsDataArr.data[a].name+"</option>");
                            }
                    }else{
                        $("#departmentError").html('Kindly select a Section');
                    }
                }
            });
        }
    });
</script>
@endsection
