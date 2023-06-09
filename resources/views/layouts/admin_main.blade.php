<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>TPF | Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- Plugins css -->
    <link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{asset('assets/css/bootstrap-dark.min.css')}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{asset('assets/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/fonts/flaticon_tpf_mcc.css')}}" rel="stylesheet" type="text/css" />
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/libs/daterangepicker/css/daterangepicker.css')}}" type="text/css" />

    <!-- Start::date range picker -->
    <!-- End::date range picker -->

    @yield('custom_css')
</head>

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">

        @include('layouts.top_bar')

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="h-100" data-simplebar>

                <!-- User box -->

                <!--- Sidemenu -->
                @include('layouts.side_menu')
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left --> 

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            @yield('content')
            <!-- Footer Start -->
            @include('layouts.footer')
            <!-- end Footer -->
        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->

        <!-- /Right-bar -->

        <!-- Right bar overlay-->

        <!-- Vendor js -->
        <script src="{{asset('assets/js/vendor.min.js')}}"></script>

        <!-- Plugins js-->
        <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
        <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <script src="{{asset('assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>
        
        <script src="{{asset('assets/libs/jquery-mask-plugin/jquery.mask.min.js')}}"></script>
        <script src="{{asset('assets/libs/autonumeric/autoNumeric-min.js')}}"></script>
        <script src="{{asset('assets/libs/daterangetimepicker/moment.js')}}"></script>
        <script src="{{asset('assets/libs/daterangetimepicker/daterangepicker.js')}}"></script>   
        <script src="{{asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script><!--Bootstrap daterange picker  -->
        
        <!-- Dashboar 1 init js-->
        <script src="{{asset('assets/js/pages/dashboard-1.init.js')}}"></script>
        
        
        <script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <!-- Init js-->
        <script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script>
        <script src="{{asset('assets/js/pages/form-pickers.init.js')}}"></script>
        <!-- Init js-->
        <script src="{{asset('assets/js/pages/form-masks.init.js')}}"></script>

        <!-- App js-->

        <!-- Tippy js-->
        <script src="{{asset('assets/libs/tippy.js/tippy.all.min.js')}}"></script>

        <script src="{{asset('assets/js/app.min.js')}}"></script>

        @yield('custom_script')
</body>

</html>