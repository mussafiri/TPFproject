<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Log In | TPF Platform</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

		<!-- App css -->
		<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

		<link href="{{asset('assets/css/bootstrap-dark.min.css')}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
		<link href="{{asset('assets/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

		<!-- icons -->
		<link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    </head>

    <body class="loading authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="card bg-pattern">

                            <div class="card-body p-4">

                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="{{ url('/') }}" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="https://www.tpf.or.tz/images/logo.jpg" alt="" height="70">
                                            </span>
                                        </a>
                    
                                        <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="https://www.tpf.or.tz/images/logo.jpg" alt="" height="70">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3 text-warning">We kindly advice you to change password, a Default Password isn't secure</p>
                                </div>
                                
                                <form method="post" action="{{ route('password.update') }}">
                                @csrf
                                @method('put')

                                                    {{-- <div class="col-6 mx-auto"> --}}
                                                        <div class="row">
                                                            <div class="form-group col-12">
                                                                <label for="password">Current Password</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input class="form-control" type="password" id="current_password"  name="current_password" required autocomplete="current-password" />
                                                                    <div class="input-group-append" data-password="false">
                                                                        <div class="input-group-text">
                                                                            <span class="password-eye"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <x-input-error :messages="$errors->get('current_password')" class="mt-2 text-danger" />
                                                            </div>

                                                            <div class="form-group col-12">
                                                                <label for="password">New Password</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input class="form-control" type="password" id="password"  name="password" required autocomplete="new-password" />
                                                                    <div class="input-group-append" data-password="false">
                                                                        <div class="input-group-text">
                                                                            <span class="password-eye"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                                                            </div>
                                                            <div class="form-group col-12">
                                                                <label for="password">Confirm Password</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input class="form-control" type="password" id="password"  name="password_confirmation" required autocomplete="new-password" />
                                                                    <div class="input-group-append" data-password="false">
                                                                        <div class="input-group-text">
                                                                            <span class="password-eye"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
                                                            </div> <!-- end col -->

                                                            <div class="form-group col-12">
                                                            <button type="submit" class="form-control col-12 btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Submit Change Password</button>
                                                            </div>
                                                        </div> <!-- end row -->
                                                {{-- </div> --}}
                                            </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <!-- end row -->

    
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <footer class="footer footer-alt">
            2019 - <script>document.write(new Date().getFullYear())</script> &copy; Tumaini Pension Fund (TPF) <a href="" class="text-white-50">Claritas International</a> 
        </footer>

        <!-- Vendor js -->
        <script src="{{asset('assets/js/vendor.min.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('assets/js/app.min.js')}}"></script>
        
    </body>
</html>