
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
                                    <li class="breadcrumb-item"><a href="{{url('/contributors')}}">contributors</a></li>
                                    <li class="breadcrumb-item active">Categories</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Contributor Categories</h4>
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
                                                    <button type="button" class="btn btn-info mb-2 mr-1" data-toggle="modal" data-target="#add_modal"><i class="mdi mdi-plus-circle mr-2"></i> Add Contributor Category</button>
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
                                                    <table id="datatable-buttons" class="table font-11 table-striped dt-responsive nowrap w-100">
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
                                                        @foreach($contrCateg as $data)
                                                        @if($data->status=='ACTIVE')
                                                            <tr>
                                                                <td>{{$n}}.</td>
                                                                <td>{{$data->name}}</td>
                                                                <td><span class="badge badge-outline-{{$data->status=='ACTIVE'?'success':'danger'}} badge-pill">{{$data->status}}</span></td>
                                                                <td><small>{{$data->createdBy->fname.' '.$data->createdBy->mname.' '.$data->createdBy->lname}}</small></td>
                                                                <td><small>{{date('D M Y', strtotime($data->created_at))}}</small></td>
                                                                <td>
                                                                    <div class="dropdown float-right">
                                                                        <a href="#" class="dropdown-toggle arrow-none text-muted"
                                                                            data-toggle="dropdown" aria-expanded="false">
                                                                            <i class='mdi mdi-dots-horizontal font-18'></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a href="javascript:void(0);" class="dropdown-item contrCatEdit"  data-id="{{$data->id}}" data-toggle="modal" data-target="#edit_modal">
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
                                                    <table id="datatable-buttons" class="table font-11 table-striped dt-responsive nowrap w-100">
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
                                                        @foreach($contrCateg as $data)
                                                            @if($data->status=="SUSPENDED")
                                                                <tr>
                                                                    <td>{{$n}}.</td>
                                                                    <td>{{$data->name}}</td>
                                                                    <td><span class="badge badge-outline-{{$data->status=='ACTIVE'?'success':'danger'}} badge-pill">{{$data->status}}</span></td>
                                                                    <td><small>{{$data->createdBy->fname.' '.$data->createdBy->mname.' '.$data->createdBy->lname}}</small></td>
                                                                    <td><small>{{date('D M Y', strtotime($data->created_at))}}</small></td>
                                                                    <td>
                                                                        <div class="dropdown float-right">
                                                                            <a href="#" class="dropdown-toggle arrow-none text-muted"
                                                                                data-toggle="dropdown" aria-expanded="false">
                                                                                <i class='mdi mdi-dots-horizontal font-18'></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a href="javascript:void(0);" class="dropdown-item contrCatEdit"  data-id="{{$data->id}}" data-toggle="modal" data-target="#edit_modal">
                                                                                    <i class='mdi mdi-pencil-outline mr-1'></i>Edit
                                                                                </a>
                                                                                <div class="dropdown-divider"></div>
                                                                                <!-- item-->
                                                                                <a href="javascript:void(0);" class="dropdown-item change_category_status_swt_alert" data-id="{{$data->id}}" data-newstatus="activate">
                                                                                    <i class='mdi mdi-check-bold mr-1'></i>Activate
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

                                                 <!-- START:: ADD Modal modal content -->
                                                <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header border-bottom">
                                                                <h4 class="modal-title" id="myCenterModalLabel">Adding Contributor Category</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <form method="POST" action="{{url('submit/add/contributor/category')}}">
                                                            @csrf
                                                                <div class="modal-body p-4">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="field-1" class="control-label">Contributor Category Name</label>
                                                                                <input type="text" class="form-control" id="field-1" name="name" value="{{ old('name') }}" placeholder="Enter Contributor Category Name">
                                                                                @if ($errors->addContrCategory->has('name')) <span class="text-danger" role="alert"> <strong>{{ $errors->addContrCategory->first('name') }}</strong></span>@endif
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
                                                                <h4 class="modal-title" id="myCenterModalLabel">Edit Contributor Category</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>

                                                            <form method="POST" action="{{url('submit/edit/contributor/category')}}">
                                                            @csrf
                                                                <div class="modal-body p-4">
                                                                    <div class="row">
\
                                                                        <div class="col-12"><span class="text-danger" id="edit_contr_Category_fetchError"></span></div>

                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="field-1" class="control-label">Contributor Category Name</label>
                                                                                <input type="hidden" class="form-control" id="data_id" name="data_id">
                                                                                <input type="text" class="form-control" id="edit_name" name="name" value="{{ old('name') }}" placeholder="Enter Contributor Category Name">
                                                                                @if ($errors->editContrCategory->has('name')) <span class="text-danger" role="alert"> <strong>{{ $errors->editContrCategory->first('name') }}</strong></span>@endif
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
