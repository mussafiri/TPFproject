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

                    <h4 class="header-title mb-3">List of Zones</h4>

                    <div class="table-responsive">
                        <table class="table table-sm font-12 table-striped dt-responsive nowrap w-100 datatable-buttons">
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
                                @php  $x=1;  @endphp
                                @foreach ($zones as $data)
                                    <tr>
                                        <td>{{$x}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->postal_address}}</td>
                                        <td>{{$data->physical_address}}</td>
                                        <td>{{$data->phone}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>{{date('d M Y', strtotime($data->created_at))}}&nbsp;<span class="text-muted font-8">{{date('H:i', strtotime($data->created_at))}}</span></td>
                                        <td><span class="badge badge-soft-{{$data->status=='ACTIVE'?'success':'danger';}}">{{$data->status}}</span></td>
                                        <td></td>
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
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
@endsection