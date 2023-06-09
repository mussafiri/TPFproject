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
                            <li class="breadcrumb-item"><a href="{{url('/contributors')}}">Contributors</a></li>
                            <li class="breadcrumb-item active">Zones</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Zones</h4>
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
                            <h4 class="header-title mb-3">List of Zones</h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button" data-toggle="modal" data-target="#bs-example-modal-lg" class="btn btn-sm btn-blue waves-effect waves-light font-weight-bold"><i class="mdi mdi-map-marker-plus mr-1  "></i>Add Zone</button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <!-- Zone for the MOdal View -->
                    <div id="view-zone-modal-lg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-full-width modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel">Zone Details</h4>
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
                                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                                <h5 class="font-family-primary font-weight-semibold">Zone Information</h5>
                                                                <p class="mb-2"><span class="font-weight-semibold mr-2">Zone name:</span><span class="font-12" id="zone-name"> </span> </p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Zone code:</span> <span id="zone-code" class="font-12"></span></p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Physical address:</span> <span id="zone-physical_address" class="font-12"></span></p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Postal Address:</span><span id="zone-postal_address" class="font-12"></span> </p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Phone:</span><span id="zone-phone" class="font-12"></span></p>
                                                                <p class="mb-0"><span class="font-weight-semibold mr-2">Email:</span><span id="zone-email" class="font-12"></span></p>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <div class="mb-1"></div>
                                                                <div class="text-center">
                                                                    <i class="flaticon flaticon-address h2" style="color:#5f7d95"></i>
                                                                    <h5><b><span data-plugin="counterup" class="zone-total_districts"></span></b></h5>
                                                                    <p class="mb-1"><span class="font-weight-semibold">DISTRICTS</span> </p>
                                                                </div>
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
                                                            <i class="flaticon flaticon-donation h2" style="color:#5f7d95"></i>
                                                            <h5><b><span data-plugin="counterup" class="zone-total_contributors"></span></b></h5>
                                                            <p class="mb-1"><span class="font-weight-semibold">CONTRIBUTORS</span> </p>

                                                        </div>
                                                        <div class="dropdown-divider"></div>
                                                        <div class="text-center">
                                                            <i class="flaticon flaticon-notes-1 h2" style="color:#5f7d95"></i>
                                                            <h5><b><span data-plugin="counterup" class="zone-total_sections"></span></b></h5>
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
                    <!-- Zone for the MOdal View -->
                    <!-- Register Zone modal content -->
                    <div id="bs-example-modal-lg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <form class="" method="POST" action="{{url('/zone/register')}}">
                            @csrf
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h4 class="modal-title" id="myCenterModalLabel">Register New Zone</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="card-box">
                                                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">General Information</h5>

                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Zone Name <span class="text-danger">*</span></label>
                                                        <input type="text" id="zone-name" name="zone_name" value="{{old('zone_name')}}" class="form-control form-control-sm" placeholder="e.g : CENTRAL" autocomplete="off">
                                                        @if ($errors->registerZone->has('zone_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerZone->first('zone_name') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Zone Code <span class="text-danger">*</span></label>
                                                        <input type="text" id="zone-name" name="code" value="{{old('code')}}" class="form-control form-control-sm" placeholder="e.g : CT" autocomplete="off">
                                                        @if ($errors->registerZone->has('code')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerZone->first('code') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-reference">Physical Address <span class="text-danger">*</span></label>
                                                        <input type="text" id="product-reference" name="phy_address" value="{{old('phy_address')}}" class="form-control form-control-sm" placeholder="e.g : KIBAIGWA JUU" autocomplete="off">
                                                        @if ($errors->registerZone->has('phy_address')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerZone->first('phy_address') }}</small></strong></span>@endif
                                                    </div>

                                                </div> <!-- end card-box -->
                                            </div> <!-- end col -->
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="card-box">
                                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Contact Details</h5>
                                                    <div class="form-group mb-3">
                                                        <label for="product-description">Postal Address</label>
                                                        <input type="text" class="form-control form-control-sm" name="po_address" value="{{old('po_address')}}" placeholder="e.g : P.O.BOX 324566 KIBAIGWA  " autocomplete="off">
                                                        @if ($errors->registerZone->has('po_address')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerZone->first('po_address') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-summary">Phone</label>
                                                        <input type="text" class="form-control form-control-sm" name="phone" value="{{old('phone')}}" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(000) 000-000-000" autocomplete="off">
                                                        @if ($errors->registerZone->has('phone')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerZone->first('phone') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-summary">Email address</label>
                                                        <input type="text" class="form-control form-control-sm" name="email" value="{{old('email')}}" placeholder="e.g xxxxx@gmail.com" autocomplete="off">
                                                        @if ($errors->registerZone->has('email')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->registerZone->first('email') }}</small></strong></span>@endif
                                                    </div>
                                                </div> <!-- end card-box -->
                                            </div> <!-- end col-->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <div class="modal-footer" style="margin-top:-2rem;">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <button type="button" class="btn btn-danger ml-auto" data-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </form>
                    </div><!-- /.modal -->
                    <!-- Edit Zone Modal content -->
                    <div id="updateZoneModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <form class="" method="POST" action="{{url('/zone/edit')}}">
                            @csrf
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h4 class="modal-title" id="myCenterModalLabel">Update Zone Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="card-box">
                                                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">General Information</h5>

                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Zone Name <span class="text-danger">*</span></label>
                                                        <input type="text" id="input-zone" name="zone_name" value="{{old('zone_name')}}" class="form-control form-control-sm" placeholder="e.g : CENTRAL" autocomplete="off">
                                                        @if ($errors->updateZone->has('zone_name')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateZone->first('zone_name') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-name">Zone Code <span class="text-danger">*</span></label>
                                                        <input type="text" id="input-zone_code" name="zone_code" value="{{old('zone_code')}}" class="form-control form-control-sm" placeholder="e.g : CT" autocomplete="off">
                                                        @if ($errors->updateZone->has('zone_code')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateZone->first('zone_code') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-reference">Physical Address <span class="text-danger">*</span></label>
                                                        <input type="text" id="input-physical_address" name="phy_address" value="{{old('phy_address')}}" class="form-control form-control-sm" placeholder="e.g : KIBAIGWA JUU" autocomplete="off">
                                                        @if ($errors->updateZone->has('phy_address')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateZone->first('phy_address') }}</small></strong></span>@endif
                                                    </div>

                                                </div> <!-- end card-box -->
                                            </div> <!-- end col -->
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="card-box">
                                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Contact Details</h5>
                                                    <div class="form-group mb-3">
                                                        <label for="product-description">Postal Address</label>
                                                        <input type="text" id="input-postal_address" class="form-control form-control-sm" name="po_address" value="{{old('po_address')}}" placeholder="e.g : P.O.BOX 324566 KIBAIGWA  " autocomplete="off">
                                                        @if ($errors->updateZone->has('po_address')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateZone->first('po_address') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-summary">Phone</label>
                                                        <input type="text" class="form-control form-control-sm" id="input-phone" name="phone" value="{{old('phone')}}" placeholder="e.g 255 717 000 052" data-toggle="input-mask" data-mask-format="(000) 000-000-000" autocomplete="off">
                                                        @if ($errors->updateZone->has('phone')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateZone->first('phone') }}</small></strong></span>@endif
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="product-summary">Email address</label>
                                                        <input type="text" class="form-control form-control-sm" id="input-email" name="email" value="{{old('email')}}" placeholder="e.g xxxxx@gmail.com" autocomplete="off">
                                                        @if ($errors->updateZone->has('email')) <span class="text-danger" role="alert"> <strong><small>{{ $errors->updateZone->first('email') }}</small></strong></span>@endif
                                                    </div>
                                                    <input type="hidden" class="form-control form-control-sm" id="editzone_id" name="zone_id">

                                                </div> <!-- end card-box -->
                                            </div> <!-- end col-->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <div class="modal-footer" style="margin-top:-2rem;">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <button type="button" class="btn btn-danger ml-auto" data-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </form>
                    </div><!-- /.end edit-modal -->
                    <ul class="nav nav-tabs nav-bordered my-2">
                        <li class="nav-item">
                            <a href="#active-zones" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                Active
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/zones/dormant/list')}}" class="nav-link ">
                                Dormant
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="active-zones">
                            <div class="table-responsive">
                                <table class="table table-sm font-12 table-striped nowrap w-100 datatable-buttons">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Postal Address</th>
                                            <th>Physical Address</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Created</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach ($zones as $data)
                                        @if($data->status=="ACTIVE")
                                        <tr>
                                            <td>{{$x}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->postal_address}}</td>
                                            <td>{{$data->physical_address}}</td>
                                            <td>{{$data->phone}}</td>
                                            <td>{{$data->email}}</td>
                                            <td>{{date('d M Y', strtotime($data->created_at))}}&nbsp;<span class="text-muted font-8">{{date('H:i', strtotime($data->created_at))}}</span></td>
                                            <td><span class="badge badge-soft-{{$data->status=='ACTIVE'?'success':'danger';}}">{{$data->status}}</span></td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item zoneViewModal" href="#" data-toggle="modal" data-target="#view-zone-modal-lg" data-zoneview_id="{{$data->id}}"><i class="mdi mdi-eye-outline mr-2 text-muted font-18 vertical-middle"></i>View</a>
                                                        <a class="dropdown-item zoneEditModalDataLink" href="#" data-toggle="modal" data-target="#updateZoneModal" data-zoneid="{{$data->id}}"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Edit</a>
                                                        <a class="dropdown-item zone_statusChangeLink" data-zone="{{$data->id}}" data-new_status="{{$data->status=='ACTIVE' ? 'Suspend':'Activate';}}" data-zone_name="{{$data->name}}" href="#"><i class="mdi mdi-close-thick mr-2 text-muted font-18 vertical-middle"></i>Suspend</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @php $x++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div><!-- end .tab-pane active-->
                        <div class="tab-pane" id="suspended-zones">
                            <!-- <div class="table-responsive"> -->
                            <table class="table table-sm font-12 table-striped nowrap w-100 datatable-buttons">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Postal Address</th>
                                        <th>Physical Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Created</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sn=1; @endphp
                                    @foreach ($zones as $data)
                                    @if($data->status!="ACTIVE")
                                    <tr>
                                        <td>{{$sn}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->postal_address}}</td>
                                        <td>{{$data->physical_address}}</td>
                                        <td>{{$data->phone}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>{{date('d M Y', strtotime($data->created_at))}}&nbsp;<span class="text-muted font-8">{{date('H:i', strtotime($data->created_at))}}</span></td>
                                        <td><span class="badge badge-soft-{{$data->status=='ACTIVE'?'success':'danger';}}">{{$data->status}}</span></td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item zoneEditModalDataLink" href="#" data-toggle="modal" data-target="#updateZoneModal" data-zoneid="{{$data->id}}"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Edit</a>
                                                    <a class="dropdown-item zone_statusChangeLink" data-zone="{{$data->id}}" data-new_status="{{$data->status=='ACTIVE' ? 'Suspend':'Activate';}}" data-zone_name="{{$data->name}}" href="#"><i class="mdi mdi-close-thick mr-2 text-muted font-18 vertical-middle"></i>Suspend</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $sn++; @endphp
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- </div> end .table-responsive-->
                        </div><!-- end .tab-pane suspended -->
                    </div>
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
        @if($errors -> hasBag('registerZone'))
        $('#bs-example-modal-lg').modal({
            show: true
        });
        @elseif($errors -> hasBag('updateZone'))
        $('#updateZoneModal').modal({
            show: true
        });
        @endif
    });
</script>
<script>
    $('.zoneEditModalDataLink').on('click', function() {
        var zone = $(this).attr('data-zoneid');
        $.ajax({
            type: 'POST',
            url: "{{url('/ajax/get/zone/data')}}",
            data: {
                zone_id: zone,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                if (response.zoneJSONData.status == 'success') {
                    $('#edit_fetchError').html('');
                    $('#input-zone').val(response.zoneJSONData.data.name);
                    $('#input-zone_code').val(response.zoneJSONData.data.zone_code);
                    $('#input-physical_address').val(response.zoneJSONData.data.physical_address);
                    $('#input-postal_address').val(response.zoneJSONData.data.postal_address);
                    $('#input-phone').val(response.zoneJSONData.data.phone);
                    $('#input-email').val(response.zoneJSONData.data.email);
                    $('#editzone_id').val(zone);
                } else {
                    $('#edit_inputMaterial').val('');
                    $('#edit_fetchError').html(response.zoneJSONData.message);
                }
            }
        });

    });
</script><!-- SCRIPT FOR Editing Modal  -->
<script type="text/javascript">
    $(".zone_statusChangeLink").click(function() {
        var zone_id = $(this).attr("data-zone");
        var new_status = $(this).attr("data-new_status");
        var zone_name = $(this).attr("data-zone_name");
        new_status = new_status.toLowerCase();
        Swal.fire({
            title: "Are you sure?",
            html: 'You want to <span class="text-danger">' + new_status + '</span> <span class="text-info">' + zone_name + ' </span> Zone!',
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
                    url: "{{url('/ajax/update/zone/status')}}",
                    data: {
                        zone: zone_id,
                        status: new_status,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

                    success: function(t) {
                        var zone_status = t.statZoneJSONArr.message_status
                        Swal.fire({
                            title: "Success!",
                            html: t.statZoneJSONArr.message + " " + zone_status.toLowerCase(),
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
    $('.zoneViewModal').on('click', function() {
        $('#view-zone-modal-lg').modal({
            show: true
        });
        var zone = $(this).attr('data-zoneview_id');
        $.ajax({
            type: 'POST',
            url: "{{url('/ajax/get/zone/data/view')}}",
            data: {
                zone_id: zone,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                if (response.zoneJSONData.status == 'success') {
                    // zone data fetched 
                    var total_contributions = response.zoneJSONData.total_contributors.toLocaleString();
                    $('#zone-name').html(response.zoneJSONData.data.name);
                    $('#zone-physical_address').html(response.zoneJSONData.data.physical_address);
                    $('#zone-postal_address').html(response.zoneJSONData.data.postal_address);
                    $('#zone-phone').html(response.zoneJSONData.data.phone);
                    $('#zone-email').html(response.zoneJSONData.data.email);
                    $('#zone-code').html(response.zoneJSONData.data.district_code);
                    $('.zone-total_contributors').html(total_contributions);
                    $('.zone-total_sections').html(response.zoneJSONData.total_sections.toLocaleString());
                    $('.zone-total_districts').html(response.zoneJSONData.total_districts.toLocaleString());
                    // District data fetched 

                } else {
                    $('#edit_inputMaterial').val('');
                    $('#edit_fetchError').html(response.zoneJSONData.message);
                }
            }
        });

    });
</script><!-- SCRIPT FOR View Modal  -->

@endsection