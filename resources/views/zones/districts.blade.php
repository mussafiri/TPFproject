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
                            <li class="breadcrumb-item active">Districts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Districts</h4>
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
                            <h4 class="header-title mb-3">List of Districts</h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button" data-toggle="modal" data-target="#add-district-modal-lg" class="btn btn-sm btn-blue waves-effect waves-light font-weight-bold"><i class="mdi mdi-plus-thick mr-1  "></i>Add District</button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <!-- District for the MOdal View -->
                    <div id="view-district-modal-lg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-full-width modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">District Details</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="header-title mb-3"> Information</h4>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                                <h5 class="font-family-primary font-weight-semibold">District Information</h5>
                                                                <p class="mb-2"><span class="font-weight-semibold mr-2">District name:</span><span class="font-12" id="district-name"> </span> </p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">District code:</span> <span id="district-code" class="font-12"></span></p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Physical address:</span> <span id="district-physical_address" class="font-12"></span></p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Postal Address:</span><span id="district-postal_address" class="font-12"></span> </p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Phone:</span><span id="district-phone" class="font-12"></span></p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Email:</span><span id="district-email" class="font-12"></span></p>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                                <h5 class="font-family-primary font-weight-semibold">Zone Information</h5>
                                                                <p class="mb-2"><span class="font-weight-semibold mr-2">Zone:</span><span class="font-12" id="zone-name"> </span> </p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Physical address:</span> <span id="zone-physical_address" class="font-12"></span></p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Postal Address:</span><span id="zone-postal_address" class="font-12"></span> </p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Phone:</span><span id="zone-phone" class="font-12"></span></p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Email:</span><span id="zone-email" class="font-12"></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end card -->
                                            </div> <!-- end col -->
                                            <div class="col-4">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="header-title mb-3 text-center">Summary Info</h4>
                                                        <div class="text-center">
                                                            <i class="flaticon flaticon-donation h2"></i>
                                                            <h5><b><span data-plugin="counterup" class="district-total_contributors"></span></b></h5>
                                                            <p class="mb-1"><span class="font-weight-semibold">CONTRIBUTORS</span> </p>
                                                           
                                                        </div>
                                                        <div class="dropdown-divider"></div>
                                                        <div class="text-center">
                                                            <i class="flaticon flaticon-notes-1 h2"></i>
                                                            <h5><b><span data-plugin="counterup" class="district-total_sections"></span></b></h5>
                                                            <p class="mb-1"><span class="font-weight-semibold">SECTIONS</span> </p>
                                                          
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- end col-4 -->
                                        </div><!-- end card row -->
                                    </div>
                                </div>
                                <div class="modal-footer" style="margin-top:-2rem;">
                                    <button type="button" class="btn btn-danger ml-auto" data-dismiss="modal">Close</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <!-- District for the MOdal View -->
                    <!-- Register District modal content -->
                    <div id="add-district-modal-lg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <form class="" method="POST" action="{{url('/district/register')}}">
                            @csrf
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h4 class="modal-title" id="myCenterModalLabel">Register New District</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-box">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">District Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="district_name" value="{{old('district_name')}}" class="form-control form-control-sm" placeholder="e.g : DODOMA KATI " oninput="this.value = this.value.toUpperCase()" autocomplete="off" required>
                                                        @if ($errors->registerDistrict->has('district_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerDistrict->first('district_name') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Zone <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="zone" data-toggle="select2" required>
                                                            <option value="0"> -- Select Zone --</option>
                                                            @foreach($zones as $value)
                                                            <option value="{{$value->id}}">{{$value->name}} </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->registerDistrict->has('zone')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerDistrict->first('zone') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-reference">Physical Address <span class="text-danger">*</span></label>
                                                        <input type="text" id="physical-address" name="physicalAddress" oninput="this.value = this.value.toUpperCase()" value="{{old('physicalAddress')}}" class="form-control form-control-sm" placeholder="e.g : MIUJI JUU" autocomplete="off" required>
                                                        @if ($errors->registerDistrict->has('physicalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerDistrict->first('physicalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                </div> <!-- end col -->
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Postal Address </label>
                                                        <input type="text" name="postalAddress" oninput="this.value = this.value.toUpperCase()" value="{{old('postalAddress')}}" class="form-control form-control-sm" placeholder="e.g : P.O.BOX 324566 MIUJI" autocomplete="off">
                                                        @if ($errors->registerDistrict->has('postalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerDistrict->first('postalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Phone <span class="text-danger">*</span></label>
                                                        <input type="text" name="phone" value="{{old('phone')}}" class="form-control form-control-sm" placeholder="e.g : (255)717-000-000" data-toggle="input-mask" data-mask-format="(000) 000-000-000" autocomplete="off">
                                                        @if ($errors->registerDistrict->has('phone')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerDistrict->first('phone') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-reference">Email Address<span class="text-danger"></span></label>
                                                        <input type="text" name="email" value="{{old('email')}}" class="form-control form-control-sm" placeholder="e.g :xxx@gmail.com" autocomplete="off">
                                                        @if ($errors->registerDistrict->has('email')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerDistrict->first('email') }}</small></strong></span>@endif
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
                    <!-- Edit District Modal content -->
                    <div id="updateDistrictModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <form class="" method="POST" action="{{url('/district/edit')}}">
                            @csrf
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h4 class="modal-title" id="myCenterModalLabel">Update District Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-box">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">District name <span class="text-danger">*</span></label>
                                                        <input type="text" name="district_name" value="{{old('district_name')}}" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm" placeholder="e.g : DODOMA KATI" id="input-district" autocomplete="off">
                                                        @if ($errors->updateDistrict->has('district_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateDistrict->first('district_name') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="zone-name">Zone <span class="text-danger">*</span></label>
                                                        <select class="form-control zonesSelect" name="zone_name" data-toggle="select2">
                                                          
                                                        </select>
                                                        @if ($errors->updateDistrict->has('zone_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateDistrict->first('zone_name') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-reference">Physical Address <span class="text-danger">*</span></label>
                                                        <input type="text" id="input-physical_address" name="physicalAddress" value="{{old('physicalAddress')}}" class="form-control form-control-sm" placeholder="e.g : KIBAIGWA JUU" oninput="this.value = this.value.toUpperCase()" autocomplete="off">
                                                        @if ($errors->updateDistrict->has('physicalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateDistrict->first('physicalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-group mb-3">
                                                        <label for="product-description">Postal Address</label>
                                                        <input type="text" id="input-postal_address" class="form-control form-control-sm" name="postalAddress" value="{{old('postalAddress')}}" placeholder="e.g : P.O.BOX 324566 KIBAIGWA" oninput="this.value = this.value.toUpperCase()" autocomplete="off">
                                                        @if ($errors->updateDistrict->has('postalAddress')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateDistrict->first('postalAddress') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-summary">Phone</label>
                                                        <input type="text" class="form-control form-control-sm" id="input-phone" name="phone" value="{{old('phone')}}" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(000) 000-000-000" autocomplete="off">
                                                        @if ($errors->updateDistrict->has('phone')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateDistrict->first('phone') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-summary">Email address</label>
                                                        <input type="text" class="form-control form-control-sm" id="input-email" name="email" value="{{old('email')}}" placeholder="e.g xxxxx@gmail.com" autocomplete="off">
                                                        @if ($errors->updateDistrict->has('email')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateDistrict->first('email') }}</small></strong></span>@endif
                                                    </div>
                                                    <input type="hidden" class="form-control form-control-sm" id="editdistrict_id" name="district_id">

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
                            <a href="{{url('zones/districts/'.Crypt::encryptString('ACTIVE'))}}" class="nav-link {{$status=='ACTIVE'? 'active':''}}">
                                Active
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('zones/districts/'.Crypt::encryptString('SUSPENDED'))}}" class="nav-link {{$status=='SUSPENDED'? 'active':''}}">
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
                                            <th>District</th>
                                            <th>Zone</th>
                                            <th>Postal Address</th>
                                            <th>Phone</th>
                                            <th>Created By</th>
                                            <th>Created</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach ($districts as $data)
                                        <tr>
                                            <td>{{$x}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->zone->name}}</td>
                                            <td>{{$data->postal_address}}</td>
                                            <td>{{$data->phone}}</td>
                                            <td>{{$data->createdBy->fname." ".$data->createdBy->lname}}</td>
                                            <td>{{date('d M Y', strtotime($data->created_at))}}&nbsp;<span class="text-muted font-8">{{date('H:i', strtotime($data->created_at))}}</span></td>
                                            <td><span class="badge badge-outline-{{$data->status=='ACTIVE'?'success':'danger';}}">{{$data->status}}</span></td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item districtViewModal" href="#" data-toggle="modal" data-target="#view-district-modal-lg" data-districtview_id ="{{$data->id}}"><i class="mdi mdi-eye-outline mr-2 text-muted font-18 vertical-middle"></i>View</a>
                                                        <a class="dropdown-item districtEditModalDataLink" href="#" data-toggle="modal" data-target="#updateDistrictModal" data-districtid="{{$data->id}}"><i class="mdi mdi-pencil-outline mr-2 text-muted font-18 vertical-middle"></i>Edit</a>
                                                        <a class="dropdown-item district_statusChangeLink" data-district="{{$data->id}}" data-new_status="{{$data->status=='ACTIVE' ? 'Suspend':'Activate';}}" data-district_name="{{$data->name}}" href="#"><i class="{{$status=='ACTIVE'?'mdi mdi-close-thick':'mdi mdi-check-all';}} mr-2 text-muted font-18 vertical-middle"></i>Suspend</a>
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
        @if($errors->hasBag('registerDistrict'))
            $('#add-district-modal-lg').modal({
                show: true
            });
        @elseif($errors->hasBag('updateDistrict'))

            //START::fetch zone collections
            var oldZOneID="{{old('zone_name')}}";
            $.ajax({
                type: 'GET',
                url: "{{url('/ajax/get/zone/old/data')}}",
                data: {},
                dataType: 'json',
                success: function(response) {
                    if(response.getZoneDataArr.status == 'success'){
                        // Prepare for district selections options
                        var zones = response.getZoneDataArr.data;
                        var zones_len = response.getZoneDataArr.data.length;
                        $(".zonesSelect").empty();
                        $(".zonesSelect").append("<option value=0> ..Select zones.. </option>");
                        for( var x = 0; x < zones_len; x++){

                            var zone_id  = zones[x].id;
                            var zone_name= zones[x].name;

                            if(oldZOneID == zone_id){
                                $(".zonesSelect").append("<option value='"+zone_id+"' selected >"+zone_name+"</option>");
                            }else{ 
                                $(".zonesSelect").append("<option value='"+zone_id+"'>"+zone_name+"</option>");
                            }
                        }
                    } else {
                        $('#edit_inputMaterial').val('');
                        $('#edit_fetchError').html(response.getZoneDataArr.message);
                    }
                }
            });
            //END::fetch zone collections
            
            $('#updateDistrictModal').modal({
                show: true
            });
        @endif
    });
</script>
<script>
    $('.districtEditModalDataLink').on('click', function() {
        var district = $(this).attr('data-districtid');
        $.ajax({
            type: 'POST',
            url: "{{url('/ajax/get/district/data')}}",
            data: {
                district_id: district,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                if(response.districtJSONData.status == 'success'){
                    $('#edit_fetchError').html('');
                    $('#input-district').val(response.districtJSONData.data.name);
                    $('#input-physical_address').val(response.districtJSONData.data.physical_address);
                    $('#input-postal_address').val(response.districtJSONData.data.postal_address);
                    $('#input-phone').val(response.districtJSONData.data.phone);
                    $('#input-email').val(response.districtJSONData.data.email);
                    $('#editdistrict_id').val(district);

                    // Prepare for district selections options
                    var zones = response.districtJSONData.zones_collection;
                    var zones_len = response.districtJSONData.zones_collection.length;
                    $(".zonesSelect").empty();
                    $(".zonesSelect").append("<option value=0> ..Select zones.. </option>");
                    var districtZoneID = response.districtJSONData.data.zone_id;
                    for( var x = 0; x < zones_len; x++){

                        var zone_id  = zones[x].id;
                        var zone_name= zones[x].name;

                        if(districtZoneID == zone_id){
                            $(".zonesSelect").append("<option value='"+zone_id+"' selected >"+zone_name+"</option>");
                        }else{ 
                            $(".zonesSelect").append("<option value='"+zone_id+"'>"+zone_name+"</option>");
                        }
                    }
                } else {
                    $('#edit_inputMaterial').val('');
                    $('#edit_fetchError').html(response.districtJSONData.message);
                }
            }
        });

    });
</script><!-- SCRIPT FOR Editing Modal  -->
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
    $('.districtViewModal').on('click', function() {
        $('#view-district-modal-lg').modal({show: true});
        var district = $(this).attr('data-districtview_id');
        $.ajax({
            type: 'POST',
            url: "{{url('/ajax/get/district/data/view')}}",
            data: {
                district_id: district,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                if (response.districtJSONData.status == 'success') {
                    // section data fetched 
                    $('#district-name').html(response.districtJSONData.data.name);
                    $('#district-physical_address').html(response.districtJSONData.data.physical_address);
                    $('#district-postal_address').html(response.districtJSONData.data.postal_address);
                    $('#district-phone').html(response.districtJSONData.data.phone);
                    $('#district-email').html(response.districtJSONData.data.email);
                    $('#district-code').html(response.districtJSONData.data.district_code);
                    $('.district-total_contributors').html(response.districtJSONData.total_contributors);
                    $('.district-total_sections').html(response.districtJSONData.total_sections);

                    // District data fetched 
                    $('#zone-name').html(response.districtJSONData.data.name);
                    $('#zone-physical_address').html(response.districtJSONData.data.zone_physical_address);
                    $('#zone-postal_address').html(response.districtJSONData.data.zone_postal_address);
                    $('#zone-phone').html(response.districtJSONData.data.zone_phone);
                    $('#zone-email').html(response.districtJSONData.data.zone_email);
                    $('#zone-code').html(response.districtJSONData.data.zone_code);

                } else {
                    $('#edit_inputMaterial').val('');
                    $('#edit_fetchError').html(response.districtJSONData.message);
                }
            }
        });

    });
</script><!-- SCRIPT FOR View Modal  -->
@endsection