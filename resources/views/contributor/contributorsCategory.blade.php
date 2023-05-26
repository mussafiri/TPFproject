
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
                                    <h4 class="page-title">Contributors Category</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <!-- end row-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>

                                    <h4 class="header-title mb-3">Contributor Categories</h4>

                                    <div class="table-responsive">
                                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
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
                                            @foreach($contrCateg AS $data)
                                                <tr>
                                                    <td>{{$n}}.</td>
                                                    <td>{{$data->name}}</td>
                                                    <td><span class="badge badge-outline-{{$data->status=='ACTIVE'?'success':'danger'}} badge-pill">{{$data->status}}</span></td>
                                                    <td><small>{{$data->created_by->fname.' '.$data->created_by->mname.' '.$data->created_by->lname}}</small></td>
                                                    <td><small>{{date('D M Y', strtotime($data->created_at))}}</small></td>
                                                    <td>
                                                         <div class="dropdown float-right">
                                                            <a href="#" class="dropdown-toggle arrow-none text-muted"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                                <i class='mdi mdi-dots-horizontal font-18'></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="javascript:void(0);" class="dropdown-item">
                                                                    <i class='mdi mdi-pencil-outline mr-1'></i>Edit
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <!-- item-->
                                                                <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                                    <i class='mdi mdi-close-thick mr-1'></i>Suspend
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
        <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
@endsection
