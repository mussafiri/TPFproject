
@extends('layouts.admin_main')
@section('custom_css')
   <!-- third party css -->
        <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
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
                                                    <a href="{{url('add/contributor')}}" class="btn btn-info mb-2 mr-1"><i class="mdi mdi-plus-thick mr-2"></i> Add Contributors</a>
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
                                                <a href="#active" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                                    Active
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#suspended" data-toggle="tab" aria-expanded="true" class="nav-link">
                                                    Suspended
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
                                                                        <th>Contributor Code</th>
                                                                        <th>Contributor Name</th>
                                                                        <th>Contributor Type</th>
                                                                        {{-- <th>Zone</th>
                                                                        <th>Distict</th> --}}
                                                                        <th>Section</th>
                                                                        <th>Status</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                @php $n=1; @endphp
                                                                @foreach($contributors as $data)
                                                                @if($data->status=='ACTIVE')
                                                                    <tr>
                                                                        <td>{{$n}}.</td>
                                                                        <td class="text-muted font-9">{{$data->contributor_code}}</td>
                                                                        <td>{{$data->name}}</td>
                                                                        <td>{{$data->contributorType->name}}</td>
                                                                        {{-- <td>{{$data->contributorSection->district->zone->name}}</td>
                                                                        <td>{{$data->contributorSection->district->name}}</td> --}}
                                                                        <td>{{$data->contributorSection->name}}</td>
                                                                        <td><span class="badge badge-outline-{{$data->status=='ACTIVE'?'success':'danger'}} badge-pill">{{$data->status}}</span></td>
                                                                        <td>
                                                                            <div class="dropdown float-right">
                                                                                <a href="#" class="dropdown-toggle arrow-none text-muted"
                                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                                    <i class='mdi mdi-dots-horizontal font-18'></i>
                                                                                </a>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    <a href="javascript:void(0);" class="dropdown-item contrEdit"  data-id="{{$data->id}}" data-toggle="modal" data-target="#edit_modal">
                                                                                        <i class='mdi mdi-pencil-outline mr-1'></i>Edit
                                                                                    </a>
                                                                                    <div class="dropdown-divider"></div>
                                                                                    <!-- item-->
                                                                                    <a href="javascript:void(0);" class="dropdown-item change_category_status_swt_alert" data-id="{{$data->id}}" data-newstatus="suspend">
                                                                                        <i class='mdi mdi-close-thick mr-1'></i>Suspend
                                                                                    </a>
                                                                                </div> <!-- end dropdown menu-->
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @php $n++; @endphp
                                                                @endif
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div> <!-- end .table-responsive-->
                                                    </div>
                                                    <div class="tab-pane" id="suspended">

                                                            <div class="table-responsive">
                                                                <table class="datatable-buttons table font-11 table-striped dt-responsive nowrap w-100">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Contributor Code</th>
                                                                        <th>Contributor Name</th>
                                                                        <th>Contributor Type</th>
                                                                        {{-- <th>Zone</th>
                                                                        <th>Distict</th> --}}
                                                                        <th>Section</th>
                                                                        <th>Status</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                @php $n=1; @endphp
                                                                @foreach($contributors as $data)
                                                                @if($data->status=='SUSPENDED')
                                                                    <tr>
                                                                        <td>{{$n}}.</td>
                                                                        <td class="text-muted"><small>{{$data->contributor_code}}</small></td>
                                                                        <td>{{$data->name}}</td>
                                                                        <td>{{$data->contributorType->name}}</td>
                                                                        {{-- <td>Zone</td>
                                                                        <td>District</td> --}}
                                                                        <td>Section</td>
                                                                        <td><span class="badge badge-outline-{{$data->status=='ACTIVE'?'success':'danger'}} badge-pill">{{$data->status}}</span></td>
                                                                        <td>
                                                                            <div class="dropdown float-right">
                                                                                <a href="#" class="dropdown-toggle arrow-none text-muted"
                                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                                    <i class='mdi mdi-dots-horizontal font-18'></i>
                                                                                </a>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    <a href="{{url('add/contributor')}}" class="dropdown-item"  data-id="{{$data->id}}">
                                                                                        <i class='mdi mdi-pencil-outline mr-1'></i>Edit
                                                                                    </a>
                                                                                    <div class="dropdown-divider"></div>
                                                                                    <!-- item-->
                                                                                    <a href="javascript:void(0);" class="dropdown-item change_category_status_swt_alert" data-id="{{$data->id}}" data-newstatus="activate">
                                                                                        <i class='mdi mdi-close-thick mr-1'></i>Activate
                                                                                    </a>
                                                                                </div> <!-- end dropdown menu-->
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @php $n++; @endphp
                                                                @endif
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
@if($errors->hasBag('addContrCategory'))
    <script>
        $(document).ready(function() {
            $('#add_modal').modal({
                show: true
            });
        });
    </script>
@endif
@if($errors->hasBag('editContrCategory'))
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

<script>
    //"use strict";  (function (NioApp, $) { 'use strict'; // Basic Sweet Alerts

    $('.change_category_status_swt_alert').on("click", function (e) {
       var data_id=$(this).attr('data-id');
       var new_status=$(this).attr('data-newstatus');

        alert(data_id+new_status);
        Swal.fire({
        title: 'Are you sure?',
        text: 'You want to '+new_status+' this Contributor Category',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, '+new_status+' it !',
        }).then(function (result) {
        if (result.value) {
                $.ajax({
                    type:'POST',
                    url:"{{url('/ajax/change/category/status')}}",
                    data: {data_id:data_id,new_status:new_status,
                    _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if(response.dataChangeStatusArr.status=='success'){
                            Swal.fire( "Success!", response.dataChangeStatusArr.message, "success" ).then(function(){
                            location.reload();
                            });
                        }else{
                            Swal.fire("Contributor Category Update Fail ! ", response.dataChangeStatusArr.message, "fail" ).then(function(){
                            location.reload();
                            });
                        }
                    }
                })
            // Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
        }
        });
        e.preventDefault();
    });
   // })(NioApp, jQuery);
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
        <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
@endsection
