@extends('layouts.admin_main')
@section('custom_css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<!-- third party css end -->
<link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
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
                            <li class="breadcrumb-item"><a href="{{url('users/list/'.Crypt::encryptString('ACTIVE'))}}">Users</a></li>
                            <li class="breadcrumb-item active">Departments</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Departments</h4>
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

                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button" class="btn btn-info mb-2 mr-1" data-toggle="modal" data-target="#add_modal"><i class="mdi mdi-plus-thick mr-2"></i> Add Department</button>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <!-- end row-->
                    <div class="row">
                        <div class="col-lg-12 mt-2 mb-2">
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

                        <div class="col-12">
                            <ul class="nav nav-tabs nav-bordered">
                                <li class="nav-item">
                                    <a href="{{url('users/departments/'.Crypt::encryptString('ACTIVE'))}}" aria-expanded="false" class="nav-link @if($status=='ACTIVE') {{'active'}} @endif">
                                        Active
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('users/departments/'.Crypt::encryptString('INACTIVE'))}}" aria-expanded="true" class="nav-link @if($status=='INACTIVE') {{'active'}} @endif">
                                        Suspended
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active">

                                    <div class="table-responsive">
                                        <table class="datatable-buttons table font-11 table-striped dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Created by</th>
                                                    <th>Created at</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php $n=1; @endphp
                                                @foreach($departmentData as $data)
                                                <tr>
                                                    <td>{{$n}}.</td>
                                                    <td>{{$data->name}}</td>
                                                    <td><span class="badge badge-outline-{{$data->status=='ACTIVE'?'success':'danger'}} badge-pill">{{$data->status}}</span></td>
                                                    <td><small>{{$data->createdBy->fname.' '.$data->createdBy->mname.' '.$data->createdBy->lname}}</small></td>
                                                    <td><small>{{date('d M Y', strtotime($data->created_at))}}</small></td>
                                                    <td>
                                                        <div class="btn-group dropdown float-right">
                                                            <a href="#" class="dropdown-toggle arrow-none text-muted btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false">
                                                                <i class='mdi mdi-dots-horizontal font-18'></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                @if($status=='ACTIVE')
                                                                <a href="javascript:void(0);" class="dropdown-item departmentEdit" data-id="{{$data->id}}" data-toggle="modal" data-target="#edit_modal">
                                                                    <i class='mdi mdi-pencil-outline mr-1'></i>Edit
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                @endif
                                                                <!-- item-->

                                                                <a href="javascript:void(0);" class="dropdown-item change_department_status_swt_alert" data-id="{{$data->id}}" data-newstatus="@if($data->status=='ACTIVE'){{'Deactivate'}} @else {{'Activate'}}@endif" data-name="{{$data->name}}">
                                                                    @if($data->status=='ACTIVE')
                                                                    <i class='mdi mdi-close-thick mr-1'></i>Deactivate
                                                                    @else
                                                                    <i class='mdi mdi-check-bold mr-1'></i>Activate
                                                                    @endif
                                                                </a>
                                                            </div> <!-- end dropdown menu-->
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php $n++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div>

                            </div>
                            <!-- end card-box-->

                            <!-- START:: ADD Modal modal content -->
                            <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h4 class="modal-title" id="myCenterModalLabel">Adding Department</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <form method="POST" action="{{url('users/departments/add/submit')}}">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Department Name</label>
                                                            <input type="text" class="form-control" id="field-1" name="name" value="{{ old('name') }}"  oninput="this.value = this.value.toUpperCase()" placeholder="Enter Department Name">
                                                            @if ($errors->addDepartment->has('name')) <span class="text-danger" role="alert"> <strong>{{ $errors->addDepartment->first('name') }}</strong></span>@endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-info waves-effect waves-light">Submit</button>
                                                    <button type="button" class="btn btn-secondary waves-effect float-right" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <!-- START:: ADD Modal modal content -->

                            <!-- START:: Edit Modal modal content -->
                            <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h4 class="modal-title" id="myCenterModalLabel">Edit Department</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>

                                        <form method="POST" action="{{url('users/department/edit/submit')}}">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <div class="row">
                                                    <div class="col-12"><span class="text-danger" id="edit_department_fetchError"></span></div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Department Name</label>
                                                            <input type="hidden" class="form-control" id="data_id" name="deptID">
                                                            <input type="text" class="form-control" id="edit_name" name="department" value="{{ old('department') }}"  oninput="this.value = this.value.toUpperCase()" placeholder="Enter Department Name">
                                                            @if ($errors->editDepartment->has('department')) <span class="text-danger" role="alert"> <strong>{{ $errors->editDepartment->first('department') }}</strong></span>@endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-info waves-effect waves-light">Submit Updates</button>
                                                    <button type="button" class="btn btn-secondary waves-effect float-right" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form> <!-- /.modal-content -->
                                    </div>
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <!-- START:: Edit Modal modal content -->

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
@if($errors->hasBag('addDepartment'))
<script>
    $(document).ready(function() {
        $('#add_modal').modal({
            show: true
        });
    });

</script>
@endif
@if($errors->hasBag('editDepartment'))
<script>
    $(document).ready(function() {
        $('#edit_modal').modal({
            show: true
        });
    });

</script>
@endif


<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 6000);

</script>

<script>
    $('.departmentEdit').on('click', function() {
        var data_id = $(this).attr('data-id');
        $('#data_id').val(data_id);
        $.ajax({
            type: 'POST'
            , url: "{{url('/ajax/get/department/data')}}"
            , data: {
                data_id: data_id
                , _token: '{{ csrf_token() }}'
            }
            , dataType: 'json'
            , success: function(response) {
                if (response.departmentData.status == 'success') {
                    $('#edit_department_fetchError').html('');
                    $('#edit_name').val(response.departmentData.data.name);
                } else {
                    $('#edit_name').val('');
                    $('#edit_department_fetchError').html(response.departmentData.message);
                }
            }
        });
    });

</script>

<script type="text/javascript">
    $(".change_department_status_swt_alert").click(function() {
        var data_id = $(this).attr("data-id");
        var new_status = $(this).attr("data-newstatus");
        var data_name = $(this).attr("data-name");
        Swal.fire({
            title: "Are you sure?"
            , html: 'You want to <span class="text-danger">' + new_status + '</span> <span class="text-info">' + data_name + ' </span>!'
            , type: "warning"
            , showCancelButton: !0
            , confirmButtonText: "Yes, " + new_status + " it!"
            , cancelButtonText: "No, Cancel!"
            , confirmButtonClass: "btn btn-success mt-2"
            , cancelButtonClass: "btn btn-danger ml-2 mt-2"
            , buttonsStyling: !1
        , }).then(function(t) {
            t.value ?
                $.ajax({
                    type: 'POST'
                    , url: "{{url('/ajax/change/department/status')}}"
                    , data: {
                        data_id: data_id
                        , new_status: new_status
                        , _token: '{{ csrf_token() }}'
                    }
                    , dataType: 'json',

                    success: function(t) {
                        Swal.fire({
                            title: "Success!"
                            , html: "You have successfully <span class='text-success'> " + new_status + "ed </span> <span class='text-info'> " + data_name + ".</span>"
                            , type: "success"
                        }).then(function() {
                            location.reload();
                        });
                    }
                }) :
                t.dismiss === Swal.DismissReason.cancel;
        });
    });

</script>

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
@endsection
