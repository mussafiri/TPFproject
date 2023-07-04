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
                            <li class="breadcrumb-item">Members</li>
                            <li class="breadcrumb-item active">Member Details</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Member Details</h4>
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
                            <h4 class="header-title mb-3">Member Details</h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a type="button" href="{{url()->previous()}}" class="btn btn-sm btn-blue waves-effect waves-light font-weight-bold"><i class="mdi mdi-arrow-left-thick mr-1  "></i>Back</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Name:</span><br><span class="font-12 text-end">{{$member_data? $member_data->title." ".$member_data->fname." ".$member_data->mname." ".$member_data->lname:" ";}} </span> </p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Member code:</span> <span class="font-12 text-right">{{$member_data->member_code}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Salutation:</span><span class="{{$member_data->salutationTitle->name=='ASSOCIATE PASTOR'? 'badge badge-soft-secondary':'badge badge-soft-dark';}}">{{$member_data->salutationTitle->name}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Occupation:</span><span class="font-12 text-right">{{$member_data->occupation}}</span> </p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Gender:</span> <span class="font-12 text-end">{{$member_data->gender}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Phone:</span><span class="font-12 text-right">{{$member_data->phone}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Date of Birth:</span><span class="font-12 text-right">{{date('d M Y', strtotime($member_data->dob))}}</span></p>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Marital Status:</span><span class="font-12 text-right">{{$member_data->marital_status}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Postal Address:</span><span class="font-12 text-right">{{$member_data->postal_address}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Physical Address:</span><span class="font-12 text-right">{{$member_data->physical_address}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Email:</span><span class="font-12 text-right">{{$member_data->email}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Vital Status:</span><small><span class="badge badge-soft-primary">{{$member_data->vital_status}}</span></small></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Monthly Income:</span><span class="font-12 text-right">{{number_format($member_data->income,2)}}</span></p>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Status:</span><small><span class="text-right {{$member_data->status=='ACTIVE' ? 'badge badge-soft-secondary':'badge badge-soft-danger';}}">{{$member_data->status}}</span></small></p>
                            @php
                            $last_login = $member_data->last_login == "NULL"? "NOT LOGGED IN" : $member_data->last_login;
                            $last_changed = $member_data->password_changed_at == "NULL"? "NOT CHANGED" : $member_data->password_changed_at;
                            @endphp
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Last login:</span><span class="font-10 text-right {{$member_data->last_login == 'NULL'? 'badge badge-soft-dark':'';}}">{{$last_login}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Created on:</span><span class="font-12 text-right">{{date('d M Y', strtotime($member_data->created_at))}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Created by:</span><span class="font-12 text-right ">{{$member_data->createdBy->fname." ".$member_data->createdBy->lname}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Password Status:</span><span class="text-right {{$member_data->password_status == 'ACTIVE'? 'badge badge-soft-secondary':($member_data->password_status == 'DEFAULT' ? 'badge badge-soft-dark':'badge badge-soft-danger');}}">{{$member_data->password_status}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Last Changed:</span><span class="text-right {{$member_data->password_changed_at == 'NULL'? 'badge badge-soft-dark':'';}}">{{$last_changed}}</span></p>
                        </div>
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
        <div class="row"><!-- Summary Reports -->
            <div class="col-12">
                <div class="card-box">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h4 class="header-title mb-3">Member Details</h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a type="button" href="{{url()->previous()}}" class="btn btn-sm btn-blue waves-effect waves-light font-weight-bold"><i class="mdi mdi-arrow-left-thick mr-1  "></i>Back</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <div class="row">
                        <ul class="nav nav-tabs nav-bordered">
                            <li class="nav-item">
                                <a href="{{url('zones/sections/'.Crypt::encryptString('ACTIVE'))}}" class="nav-link ">
                                    Active
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('zones/sections/'.Crypt::encryptString('SUSPENDED'))}}" class="nav-link active">
                                    Contributions
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <div class="table-responsive">
                                    <table class="table table-sm font-12 table-striped w-100 datatable-buttons table-responsible">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:19%;">Contributor</th>
                                                <th style="width:10%;">Monthly Income <sup class="text-muted font-10">TZS</sup></th>
                                                <th style="width:10%;">Amount <sup class="text-muted font-10">Contributor TZS</sup></th>
                                                <th style="width:10%;">Amount <sup class="text-muted font-10">Member TZS</sup></th>
                                                <th style="width:10%;">Topup <sup class="text-muted font-10">TZS</sup></th>
                                                <th style="width:10%;">Total <sup class="text-muted font-10">TZS</sup></th>
                                                <th style="width:6%;">Payment date</th>
                                                <th style="width:6%;">status</th>
                                                <th style="width:4%;">Posted by</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $x=1; @endphp
                                            @foreach ($member_contributions as $data)
                                            @php $contri_status = $data->status == ACTIVE ? "POSTED" :"WITHDRAWN"; @endphp
                                            <tr>
                                                <td>{{$x}}</td>
                                                <td>{{$data->contributor->name}}</td>
                                                <td>{{number_format($data->member_monthly_income,2)}}</td>
                                                <td>{{number_format($data->member_contribution,2)}}</td>
                                                <td>{{number_format($data->member_topup,2)}}</td>
                                                <td>{{number_format($total,2)}}</td>
                                                <td>{{date('d M Y', strtotime($data->contribution->payment_date))}}</td>
                                                <td><span class="$data->status == ACTIVE ? 'badge badge-soft-success':'badge badge-soft-success';"></span>{{$contri_status}}</td>
                                                <td>{{$data->createdBy->fname." ".$data->createdBy->lname}}</td>
                                            </tr>
                                            @php $x++; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end .table-responsive-->
                            </div><!-- end .tab-pane active-->
                        </div><!-- end .tab-content-->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>

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
@endsection