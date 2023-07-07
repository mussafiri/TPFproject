@extends('layouts.admin_main')
@section('custom_css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<!-- third party css end -->
<style>
    .selectize-control.multi .selectize-dropdown,
    .selectize-control.single .selectize-dropdown {
    display: none;
    }
</style>
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
                            @if($selectize !="AVAILABLE")<li class="breadcrumb-item active">Members</li>@else <li class="breadcrumb-item"><a href="{{url('members/list')}}">Members</a></li> @endif
                            @if($selectize=='AVAILABLE')<li class="breadcrumb-item active">Filtered</li>@endif
                        </ol>
                    </div>
                    <h4 class="page-title">Members</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <!-- Filter card -->
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="inputPassword2" class="sr-only">Search</label>
                                    <select id="selectize-membersSearch" placeholder="Enter Member name or Member code..."  autocomplete="off">

                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <form action="{{url('/members/find')}}" method="POST">
                                    @csrf
                                    <input type="text" name="member_search" hidden>
                                    <div class="text-lg-right mt-3 mt-lg-0">
                                        <button type="submit" class="btn btn-info waves-effect waves-light mr-1"><i class="mdi flaticon-search mr-1"></i>Find Member</button>
                                    </div>
                                </form>
                            </div><!-- end col-->
                        </div> <!-- end row -->
                    </div> <!-- end card-box -->
                </div> <!-- end col-->
            </div><!-- End Filter Card -->
        <!-- end row-->
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h4 class="header-title mb-3">List of Members</h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a type="button" href="{{url('/members/registration')}}" class="btn btn-sm btn-blue waves-effect waves-light font-weight-bold"><i class="mdi mdi-plus-thick mr-1  "></i>Add Member</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm font-12 table-striped w-100 datatable-buttons table-responsible">
                            <thead>
                                <tr>
                                    <th style="width:4%;">#</th>
                                    <th style="width:13%;">TPF-Number</th>
                                    <th style="width:28%;">Member</th>
                                    <th style="width:12%;">Title</th>
                                    <th style="width:13%;">Contributor</th>
                                    <th style="width:12%;">Vital Status</th>
                                    <th style="width:14%;">Created</th>
                                    <th style="width:4%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $x=1; @endphp
                                @php $members_array = ($selectize=="AVAILABLE")? $members_filtered:$members;@endphp
                                    @foreach ($members_array as $data)
                                        <tr>
                                            <td>{{$x}}</td>
                                            <td>{{$data->member_code}}</td>
                                            <td>{{$data->title." ".$data->fname." ".$data->mname." ".$data->lname}}</td>
                                            <td><span class="badge badge-outline-{{$data->salutationTitle->name=='SENIOR PASTOR'?'info':'secondary';}}">{{$data->salutationTitle->name}}</span></td>
                                            <td><small><span>{{$data->contributor->name}}</span></small></td>
                                            <td><span class="badge badge-outline-{{$data->vital_status=='ALIVE'?'success':'danger';}}">{{$data->vital_status}}</span></td>
                                            <td>{{date('d M Y', strtotime($data->created_at))}}&nbsp;<span class="text-muted font-10"><small>{{date('H:i', strtotime($data->created_at))}}</small></span></td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{url('/member/view/details/'.Crypt::encryptString($data->id))}}"><i class="mdi flaticon-view mr-2 text-muted font-18 vertical-middle"></i>View</a>
                                                        <a class="dropdown-item" href="{{url('/member/edit/details/'.Crypt::encryptString($data->id))}}"><i class="mdi mdi-pencil-outline mr-2 text-muted font-18 vertical-middle"></i>Edit</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $x++; @endphp
                                    @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end .table-responsive-->
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
<!-- Init js-->
<script>
    $(document).ready(function() {
        $('#selectize-membersSearch').selectize({
            maxItems: 1,
            valueField: 'id',
            labelField: 'full_name',
            searchField: 'full_name',
            create: true,
            persist:false,// Restrict attaching the typed value to options field
            onType: function(str) {
                var upper = str.toUpperCase();
                this.setTextboxValue(upper);
                return true;
            },
            onChange: function(value) {
                // Update the value of the hidden input field whenever the Selectize input value changes
                $('input[name="member_search"]').val(value);
            },
            load: function(query, callback) {
                var self = this;
                if (query.length < 3) return callback();
                clearTimeout(self.timer);
                self.timer = setTimeout(function() {
                    $.ajax({
                        url: "{{url('/ajax/dynamic/member/selectize/options/filter')}}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            _token: '{{ csrf_token() }}',
                            q: query,
                        },
                        success: function(results) {
                            var optionsArr = results.members.data;
                            callback(optionsArr);
                        },
                        error: function() {
                            callback();
                        },    
                    });
                },500); // Wait for 500ms before making the AJAX request to reduce many ajax requests on keydown
            },
        });
        
    });

</script>
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