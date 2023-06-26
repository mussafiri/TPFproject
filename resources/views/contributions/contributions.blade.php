
@extends('layouts.admin_main')
@section('custom_css')
   <!-- third party css -->
        <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- third party css end -->
        <link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
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
                                    <li class="breadcrumb-item active">Contributions</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Contributions</h4>
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
                                                    <a href="{{url('contributions/add')}}" class="btn btn-info mb-2 mr-1"><i class="mdi mdi-plus-thick mr-2"></i> Add Contribution</a>
                                                </div>
                                            </div><!-- end col-->
                                        </div>

                                        <!-- end row-->
                                        <div class="row">

                                        <div class="col-12">
                                         <ul class="nav nav-tabs nav-bordered">
                                            <li class="nav-item">
                                                <a href="{{url('contributions/transactions/'.Crypt::encryptString('PENDING'))}}" aria-expanded="false" class="nav-link @if($status=='PENDING') {{'active'}} @endif">
                                                    Pending
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('contributions/transactions/'.Crypt::encryptString('APPROVED'))}}" aria-expanded="true" class="nav-link @if($status=='APPROVED') {{'active'}} @endif">
                                                    Approved
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('contributions/transactions/'.Crypt::encryptString('POSTED'))}}" aria-expanded="true" class="nav-link @if($status=='POSTED') {{'active'}} @endif">
                                                    Posted
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('contributions/transactions/'.Crypt::encryptString('APPROVAL REJECTED'))}}" aria-expanded="true" class="nav-link @if($status=='APPROVAL REJECTED') {{'active'}} @endif">
                                                    Approval Rejected
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('contributions/transactions/'.Crypt::encryptString('POSTING REJECTED'))}}" aria-expanded="true" class="nav-link @if($status=='POSTING REJECTED') {{'active'}} @endif">
                                                    Approved
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="active">
                                                <div class="table-responsive">
                                                    <table class="datatable-buttons table font-11 table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th style="width:14%">Section</th>
                                                                <th style="width:10%">Date</th>
                                                                <th>Amount <sup class="text-muted"><small>TZS</small></sup></th>
                                                                <th>Pay Mode</th>
                                                                <th>Contributors</th>
                                                                <th>Members</th>
                                                                <th>Pay Proof</th>
                                                                <th>Process Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                        @php $n=1; @endphp
                                                        @foreach($contributions as $data)
                                                            <tr>
                                                                <td>{{$n}}.</td>
                                                                <td class="text-muted font-9">{{$data->section->name}}</td>
                                                                <td>{{date('M, Y', strtotime($data->contribution_period))}}</td>
                                                                <td>{{number_format($data->contribution_amount,2)}}</td>
                                                                <td><small>{{$data->payMode->name}}</small></td>
                                                                <td class="text-center">{{$data->total_contributors}}</td>
                                                                <td class="text-center">{{$data->total_members}}</td>
                                                                <td class="text-center"> <a class="font-14" href="{{Storage::url('contributionPaymentProof/'.$data->payment_proof)}}" download="{{Storage::url('contributionPaymentProof/'.$data->payment_proof)}}" download title="Download Payment Proof" target="_blank"><i class="mdi mdi-cloud-download-outline"></i></a> </td>
                                                                <td><span class="badge badge-outline-{{$data->processing_status=='ACTIVE'?'success':'info'}} badge-pill">{{$data->processing_status}}</span></td>
                                                                <td>
                                                                    <div class="btn-group dropdown float-right">
                                                                        <a href="#" class="dropdown-toggle arrow-none text-muted btn btn-light btn-sm"
                                                                            data-toggle="dropdown" aria-expanded="false">
                                                                            <i class='mdi mdi-dots-horizontal font-18'></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a href="{{url('contributions/details/'.Crypt::encryptString($data->id))}}" class="dropdown-item">
                                                                                <i class='mdi mdi-eye-outline mr-1'></i>View
                                                                            </a>
                                                                            @if($data->processing_status =='PENDING')
                                                                            <a href="{{url('contributions/process/'.Crypt::encryptString($data->id).'/'.Crypt::encryptString('APPROVE'))}}" class="dropdown-item">
                                                                                <i class='mdi mdi-check-bold mr-1'></i>Approve
                                                                            </a>
                                                                            @endif
                                                                            @if($data->processing_status =='PENDING'|| $data->processing_status =='APPROVAL REJECTED' || $data->processing_status =='POSTING REJECTED')
                                                                            <a href="{{url('contributions/edit/'.Crypt::encryptString($data->id))}}" class="dropdown-item">
                                                                                <i class='mdi mdi-pencil-outline mr-1'></i>Edit
                                                                            </a>
                                                                            @endif
                                                                            @if($data->processing_status =='APPROVED')
                                                                            <a href="{{url('contributions/process/'.Crypt::encryptString($data->id).'/'.Crypt::encryptString('APPROVE'))}}" class="dropdown-item">
                                                                                <i class='mdi mdi-file-check-outline mr-1'></i>Post
                                                                            </a>
                                                                            @endif
                                                                            <div class="dropdown-divider"></div>
                                                                            <!-- item-->
                                                                            <a href="javascript:void(0);" class="dropdown-item change_contributor_status_swt_alert" data-id="{{$data->id}}" data-newstatus="@if($data->status=='ACTIVE'){{'Suspend'}} @else {{'Activate'}}@endif" data-name="{{$data->name}}">
                                                                                @if($data->status=='ACTIVE')
                                                                                <i class='mdi mdi-close-thick mr-1'></i>Suspend
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

<script>
    $('.contrCatEdit').on('click', function() {
        var data_id = $(this).attr('data-id');
        $('#data_id').val(data_id);
         $.ajax({
            type: 'POST',
            url: "{{url('/ajax/get/contri/category/data')}}",
            data: {
                data_id: data_id,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                if (response.categoryDataArr.status == 'success') {
                    $('#edit_contr_Category_fetchError').html('');
                    $('#edit_name').val(response.categoryDataArr.data.name);
                } else {
                    $('#edit_name').val('');
                    $('#edit_contr_Category_fetchError').html(response.categoryDataArr.message);
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(".change_contributor_status_swt_alert").click(function() {
        var data_id = $(this).attr("data-id");
        var new_status = $(this).attr("data-newstatus");
        var data_name = $(this).attr("data-name");
        Swal.fire({
            title: "Are you sure?",
            html: 'You want to <span class="text-danger">' + new_status + '</span> <span class="text-info">' + data_name + ' </span>!',
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
                    url: "{{url('/ajax/change/contri/status')}}",
                    data: {
                        data_id: data_id,
                        new_status: new_status,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

                    success: function(t) {
                        Swal.fire({
                            title: "Success!",
                            html: "You have successfully <span class='text-success'> " + new_status + "ed</span> " + data_name + ".",
                            type: "success"
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
