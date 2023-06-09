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
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Users</h4>
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
                                <a href="{{url('users/add')}}" class="btn btn-info mb-2 mr-1"><i class="mdi mdi-plus-thick mr-2"></i> Add User</a>
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

                        <div class="col-12">
                            <ul class="nav nav-tabs nav-bordered">
                                <li class="nav-item">
                                    <a href="{{url('users/list/'.Crypt::encryptString('ACTIVE'))}}" aria-expanded="false" class="nav-link @if($status=='ACTIVE') {{'active'}} @endif">
                                        Active
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('users/list/'.Crypt::encryptString('BLOCKED'))}}" aria-expanded="true" class="nav-link @if($status=='BLOCKED') {{'active'}} @endif">
                                        Blocked
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="active">
                                    <div class="table-responsive">
                                        <table class="datatable-buttons table font-11 table-striped dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Full Name</th>
                                                    <th>Gender</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Department</th>
                                                    <th>Designation</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php $n=1; @endphp
                                                @foreach($getUsers as $data)
                                                <tr>
                                                    <td>{{$n}}.</td>
                                                    <td>{{strtoupper($data->fname.' '.$data->mname.' '.$data->lname)}}</td>
                                                    <td>{{$data->gender}}</td>
                                                    <td>{{$data->email}}</td>
                                                    <td>{{$data->phone}}</td>
                                                    <td>{{strtoupper($data->department->name)}}</td>
                                                    <td>{{strtoupper($data->designation->name)}}</td>
                                                    <td><span class="badge badge-outline-{{$data->status=='ACTIVE'?'success':'danger'}} badge-pill">{{$data->status}}</span></td>
                                                    <td>
                                                        <div class="btn-group dropdown float-right">
                                                            <a href="#" class="dropdown-toggle arrow-none text-muted btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false">
                                                                <i class='mdi mdi-dots-horizontal font-18'></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="{{url('users/view/'.Crypt::encryptString($data->id))}}" class="dropdown-item">
                                                                    <i class='mdi mdi-eye-outline mr-1'></i>View
                                                                </a>
                                                                <a href="{{url('users/edit/'.Crypt::encryptString($data->id))}}" class="dropdown-item">
                                                                    <i class='mdi mdi-pencil-outline mr-1'></i>Edit
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <!-- item-->
                                                                <a href="javascript:void(0);" class="dropdown-item change_user_status_swt_alert" data-id="{{$data->id}}" data-newstatus="@if($data->status=='ACTIVE'){{'Block'}} @else {{'Activate'}}@endif" data-name="{{$data->fname.' '.$data->lname}}">
                                                                    @if($data->status=='ACTIVE')
                                                                    <i class='mdi mdi-close-thick mr-1'></i>Block
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
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 6000);

</script>

<script type="text/javascript">
    $(".change_user_status_swt_alert").click(function() {
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
                    type: 'POST',
                    url: "{{url('/ajax/change/user/status')}}",
                    data: {
                        data_id: data_id,
                        new_status: new_status,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

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
