@extends('layouts.admin_main')
@section('custom_css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

<!-- third party css end -->
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
                            <li class="breadcrumb-item"><a href="{{url('/zones/list')}}">Zones</a></li>
                            <li class="breadcrumb-item active">Sections</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Sections</h4>
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
                            <h4 class="header-title mb-3">List of Sections</h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button" data-toggle="modal" data-target="#add-section-modal-lg" class="btn btn-sm btn-blue waves-effect waves-light font-weight-bold"><i class="mdi mdi-plus-thick mr-1  "></i>Add Section</button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <!-- Register Section modal content -->
                    <div id="add-section-modal-lg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <form class="" method="POST" action="{{url('/section/register')}}">
                            @csrf
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h4 class="modal-title" id="myCenterModalLabel">Register New Section</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-box">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Section Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="section_name" value="{{old('section_name')}}" class="form-control form-control-sm" placeholder="e.g : BAHI " oninput="this.value = this.value.toUpperCase()" autocomplete="off" required>
                                                        @if ($errors->registerSection->has('section_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerSection->first('section_name') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">District <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="district" data-toggle="select2" required>
                                                            <option value="0"> -- Select District --</option>
                                                            @foreach($districts as $value)
                                                            <option value="{{$value->id}}">{{$value->name}} </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->registerSection->has('district')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerSection->first('district') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-reference">Physical Address <span class="text-danger">*</span></label>
                                                        <input type="text" id="physical-address" name="physicalAddress" oninput="this.value = this.value.toUpperCase()" value="{{old('physicalAddress')}}" class="form-control form-control-sm" placeholder="e.g : MIUJI JUU" autocomplete="off" required>
                                                        @if ($errors->registerSection->has('physicalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerSection->first('physicalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                </div> <!-- end col -->
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Postal Address </label>
                                                        <input type="text" name="postalAddress" oninput="this.value = this.value.toUpperCase()" value="{{old('postalAddress')}}" class="form-control form-control-sm" placeholder="e.g : P.O.BOX 324566 MIUJI" autocomplete="off">
                                                        @if ($errors->registerSection->has('postalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerSection->first('postalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Phone <span class="text-danger">*</span></label>
                                                        <input type="text" name="phone" value="{{old('phone')}}" class="form-control form-control-sm" data-toggle="input-mask" data-mask-format="(000) 000-000-000" placeholder="e.g : (255)717 000 000" autocomplete="off">
                                                        @if ($errors->registerSection->has('phone')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerSection->first('phone') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-reference">Email Address<span class="text-danger"></span></label>
                                                        <input type="text" name="email" value="{{old('email')}}" class="form-control form-control-sm" placeholder="e.g :xxx@gmail.com" autocomplete="off">
                                                        @if ($errors->registerSection->has('email')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerSection->first('email') }}</small></strong></span>@endif
                                                    </div>

                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                        </div><!-- end card-box -->
                                    </div>
                                    <div class="modal-footer" style="margin-top:-2rem;">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <button type="button" class="btn btn-danger ml-auto" data-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </form>
                    </div><!-- /.modal -->
                    <!-- Edit Section Modal content -->
                    <div id="UpdateSectionModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <form class="" method="POST" action="{{url('/section/edit')}}">
                            @csrf
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h4 class="modal-title" id="myCenterModalLabel">Update Section Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-box">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Section name <span class="text-danger">*</span></label>
                                                        <input type="text" name="section_name" value="{{old('section_name')}}" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm" placeholder="e.g : DODOMA KATI" id="input-section" autocomplete="off">
                                                        @if ($errors->updateSection->has('section_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateSection->first('section_name') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="district-name">District <span class="text-danger">*</span></label>
                                                        <select class="form-control districtSelect" name="district_name" data-toggle="select2">
                                                          
                                                        </select>
                                                        @if ($errors->updateSection->has('district_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateSection->first('district_name') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-reference">Physical Address <span class="text-danger">*</span></label>
                                                        <input type="text" id="input-physical_address" name="physicalAddress" value="{{old('physicalAddress')}}" class="form-control form-control-sm" placeholder="e.g : KIBAIGWA JUU" oninput="this.value = this.value.toUpperCase()" autocomplete="off">
                                                        @if ($errors->updateSection->has('physicalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateSection->first('physicalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="product-description">Postal Address</label>
                                                        <input type="text" id="input-postal_address" class="form-control form-control-sm" name="postalAddress" value="{{old('postalAddress')}}" placeholder="e.g : P.O.BOX 324566 KIBAIGWA" oninput="this.value = this.value.toUpperCase()" autocomplete="off">
                                                        @if ($errors->updateSection->has('postalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateSection->first('postalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-summary">Phone</label>
                                                        <input type="text" class="form-control form-control-sm" id="input-phone" name="phone" value="{{old('phone')}}" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(000) 000-000-000" autocomplete="off">
                                                        @if ($errors->updateSection->has('phone')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateSection->first('phone') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-summary">Email address</label>
                                                        <input type="text" class="form-control form-control-sm" id="input-email" name="email" value="{{old('email')}}" placeholder="e.g xxxxx@gmail.com" autocomplete="off">
                                                        @if ($errors->updateSection->has('email')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateSection->first('email') }}</small></strong></span>@endif
                                                    </div>
                                                    <input type="hidden" class="form-control form-control-sm" id="editsection_id" name="section_id">

                                                </div> <!-- end col-lg-6 -->
                                            </div> <!-- end row  -->
                                        </div><!-- end card-box -->
                                    </div> <!-- end modal-body -->
                                    <div class="modal-footer" style="margin-top:-2rem;">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <button type="button" class="btn btn-danger ml-auto" data-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </form>
                    </div><!-- /.modal -->

                    <!-- /.end edit-modal -->
                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="{{url('zones/sections/'.Crypt::encryptString('ACTIVE'))}}" class="nav-link {{$status=='ACTIVE'? 'active':''}}">
                                Active
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('zones/sections/'.Crypt::encryptString('SUSPENDED'))}}" class="nav-link {{$status=='SUSPENDED'? 'active':''}}">
                                Dormant
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" >
                            <div class="table-responsive">
                                <table class="table table-sm font-12 table-striped w-100 datatable-buttons table-responsible">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="width:12%">Section</th>
                                            <th style="width:15%">District</th>
                                            <th style="width:12%">Postal Address</th>
                                            <th style="width:8%">Phone</th>
                                            <th style="width:15%">Created By</th>
                                            <th style="width:10%">Created</th>
                                            <th style="width:8%">Status</th>
                                            <th style="width:6%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach ($sections as $data)
                                        <tr>
                                            <td>{{$x}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->district->name}}</td>
                                            <td>{{$data->postal_address}}</td>
                                            <td>{{$data->phone}}</td>
                                            <td>{{$data->createdBy->fname." ".$data->createdBy->lname}}</td>
                                            <td>{{date('d M Y', strtotime($data->created_at))}}&nbsp;<span class="text-muted font-8">{{date('H:i', strtotime($data->created_at))}}</span></td>
                                            <td><span class="badge badge-outline-{{$data->status=='ACTIVE'?'success':'danger';}}">{{$data->status}}</span></td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item sectionEditModalDataLink" href="#" data-toggle="modal" data-target="#UpdateSectionModal" data-sectionid="{{$data->id}}"><i class="mdi mdi-pencil-outline mr-2 text-muted font-18 vertical-middle"></i>Edit</a>
                                                        <a class="dropdown-item district_statusChangeLink" data-section="{{$data->id}}" data-new_status="{{$data->status=='ACTIVE' ? 'Suspend':'Activate';}}" data-section_name="{{$data->name}}" href="#"><i class="{{$status=='ACTIVE'?'mdi mdi-close-thick':'mdi mdi-check-all';}} mr-2 text-muted font-18 vertical-middle"></i> {{$data->status=='ACTIVE'?'Suspend':'Activate';}}</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $x++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div><!-- end .tab-pane active-->
                    </div><!-- end .tab-content-->
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

<!-- Datatables init -->
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- Datatables init -->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
<script>
    $(document).ready(function() {
        @if($errors->hasBag('registerSection'))
            $('#add-section-modal-lg').modal({
                show: true
            });
        @elseif($errors->hasBag('updateSection'))

            //START::fetch district collections
            var oldDistrictID="{{old('district_name')}}";
            $.ajax({
                type: 'GET',
                url: "{{url('/ajax/get/district/old/data')}}",
                dataType: 'json',
                success: function(response) {
                    if(response.getDistrictDataArr.status == 'success'){
                        // Prepare for section selections options
                        var districts = response.getDistrictDataArr.data;
                        var district_len = response.getDistrictDataArr.data.length;
                        $(".districtSelect").empty();
                        $(".districtSelect").append("<option value=0> ..Select districts.. </option>");
                        for( var x = 0; x < district_len; x++){

                            var district_id  = districts[x].id;
                            var district_name= districts[x].name;

                            if(oldDistrictID == district_id){
                                $(".districtSelect").append("<option value='"+district_id+"' selected >"+district_name+"</option>");
                            }else{ 
                                $(".districtSelect").append("<option value='"+district_id+"'>"+district_name+"</option>");
                            }
                        }
                    } else {
                        $('#edit_inputMaterial').val('');
                        $('#edit_fetchError').html(response.getDistrictDataArr.message);
                    }
                }
            });
            //END::fetch district collections
            
            $('#UpdateSectionModal').modal({
                show: true
            });
        @endif
    });
</script>
<script>
    $('.sectionEditModalDataLink').on('click', function() {
        var section = $(this).attr('data-sectionid');
        $.ajax({
            type: 'POST',
            url: "{{url('/ajax/get/section/data/edit')}}",
            data: {
                section_id: section,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                if(response.sectionJSONData.status == 'success'){
                    $('#edit_fetchError').html('');
                    $('#input-section').val(response.sectionJSONData.data.name);
                    $('#input-physical_address').val(response.sectionJSONData.data.physical_address);
                    $('#input-postal_address').val(response.sectionJSONData.data.postal_address);
                    $('#input-phone').val(response.sectionJSONData.data.phone);
                    $('#input-email').val(response.sectionJSONData.data.email);
                    $('#editsection_id').val(section);

                    // Prepare for section selections options
                    var districts = response.sectionJSONData.district_collection;
                    var district_len = response.sectionJSONData.district_collection.length;
                    $(".districtSelect").empty();
                    $(".districtSelect").append("<option value=0> ..Select districts.. </option>");
                    var districtZoneID = response.sectionJSONData.data.district_id;
                    for( var x = 0; x < district_len; x++){

                        var district_id  = districts[x].id;
                        var district_name= districts[x].name;

                        if(districtZoneID == district_id){
                            $(".districtSelect").append("<option value='"+district_id+"' selected >"+district_name+"</option>");
                        }else{ 
                            $(".districtSelect").append("<option value='"+district_id+"'>"+district_name+"</option>");
                        }
                    }
                } else {
                    $('#edit_inputMaterial').val('');
                    $('#edit_fetchError').html(response.sectionJSONData.message);
                }
            }
        });

    });
</script><!-- SCRIPT FOR Editing Modal  -->
<script type="text/javascript">
    $(".district_statusChangeLink").click(function() {
        var section_id = $(this).attr("data-section");
        var new_status = $(this).attr("data-new_status");
        var section_name = $(this).attr("data-section_name");
        new_status = new_status.toLowerCase();
        Swal.fire({
            title: "Are you sure?",
            html: 'You want to <span class="text-danger">' + new_status + '</span> <span class="text-info">' + section_name + ' </span> Section!',
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
                    url: "{{url('/ajax/update/section/status')}}",
                    data: {
                        section: section_id,
                        status: new_status,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

                    success: function(t) {
                        var district_status = t.statSectionJSONArr.message_status
                        Swal.fire({
                            title: "Success!",
                            html: t.statSectionJSONArr.message + " " + district_status.toLowerCase(),
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