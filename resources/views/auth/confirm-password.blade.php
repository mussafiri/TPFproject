
@extends('layouts.admin_main')
@section('content')
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                    
                                    </div>
                                    <h4 class="page-title">COnfirm Password </h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card-box">
                        <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                            <div class="row">
                            <div class="col-xl-6 mx-auto">
                                
                                <div class="text-center w-75 m-auto">
                                    <p class="text-muted mb-4 mt-3">This is a secure area of the application. Please confirm your password before continuing.</p>
                                </div>
                                    <div class="form-group col-12">
                                        <label for="password">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input class="form-control" type="password" id="password"  name="password"
                                            required autocomplete="current-password" />

                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            <div class="input-group-append" data-password="false">
                                                <div class="input-group-text">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group mb-0 text-center px-2">
                                        <button class="btn btn-primary btn-block" type="submit"> Confirm </button>
                                    </div>
                            </div>
                            </div>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        </form>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->


@endsection
