
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
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                            <li class="breadcrumb-item active">User Profile</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">My Profile</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="card-box text-center">
                                    <img src="{{asset('assets/images/users/user-1.jpg')}}" class="rounded-circle avatar-lg img-thumbnail mt-2"
                                        alt="profile-image">

                                    <h4 class="mb-0">{{Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname}}</h4>
                                    <p class="text-muted">{{'@'.Auth::user()->designation->name}}</p>


                                    <div class="text-left mt-4">
                                        <h4 class="font-13 text-uppercase">About Me :</h4>
                                        <div class="row text-muted mb-2 font-13">
                                            <div class="col-md-4"><strong>Full Name :</strong></div> <div class="col-md-8"><span class="ml-2">{{Auth::user()->fname.' '.Auth::user()->mname.' '.Auth::user()->lname}}</span></div>
                                        </div>
                                        <div class="row text-muted mb-2 font-13">
                                            <div class="col-md-4"><strong>Mobile :</strong></div> <div class="col-md-8"><span class="ml-2">{{Auth::user()->phone}}</span></div>
                                        </div>
                                        <div class="row text-muted mb-2 font-13">
                                            <div class="col-md-4"><strong>Email :</strong></div> <div class="col-md-8"><span class="ml-2 ">{{Auth::user()->email}}</span></div>
                                        </div>
                                        <div class="row text-muted mb-2 font-13">
                                            <div class="col-md-4"><strong>Department :</strong></div> <div class="col-md-8"><span class="ml-2">{{Auth::user()->department->name}}</span></div>
                                        </div>
                                        <div class="row text-muted mb-2 font-13">
                                            <div class="col-md-4"><strong>Designation :</strong></div> <div class="col-md-8"><span class="ml-2">{{Auth::user()->designation->name}}</span></div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box -->
                                

                            </div> <!-- end col-->

                            <div class="col-lg-8 col-xl-8">
                                <div class="card-box">
                                    <ul class="nav nav-pills navtab-bg nav-justified">
                                        <li class="nav-item">
                                            <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link {{$errors->any()?"":"active"}}">
                                                About Me
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#changepassword" data-toggle="tab" aria-expanded="false" class="nav-link {{$errors->any()?"active":""}}">
                                                Change Password
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane  {{$errors->any()?"":"active"}}" id="aboutme">

                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-briefcase mr-1"></i>
                                                Experience</h5>

                                            <ul class="list-unstyled timeline-sm">
                                                <li class="timeline-sm-item">
                                                    <span class="timeline-sm-date">{{date('d M Y', strtotime(Auth::user()->created_at))}}</span>
                                                    <h5 class="mt-0 mb-1">Registered</h5>
                                                    <p><strong>By: </strong>{{Auth::user()->creator->fname.' '.Auth::user()->creator->mname.' '.Auth::user()->creator->lname}}</p>
                                                    <p class="text-muted mt-2"></p>

                                                </li>
                                                <li class="timeline-sm-item">
                                                    <span class="timeline-sm-date">{{date('d M Y', strtotime(Auth::user()->updated_at))}}</span>
                                                    <h5 class="mt-0 mb-1">Updated Your Details</h5>
                                                    <p><strong>By: </strong>{{Auth::user()->updated_by > 0?Auth::user()->updator->fname.' '.Auth::user()->updator->mname.' '.Auth::user()->updator->lname:'N/A'}}</p>
                                                    <p class="text-muted mt-2"></p>
                                                </li>
                                                <li class="timeline-sm-item">
                                                    <span class="timeline-sm-date">{{date('d M Y', strtotime(Auth::user()->password_changed_at))}}</span>
                                                    <h5 class="mt-0 mb-1">Last Password Changed</h5>
                                                    <p></p>
                                                    <p class="text-muted mt-2 mb-0"></p>
                                                </li>
                                            </ul>
                                        </div> <!-- end tab-pane -->
                                        <!-- end about me section content -->

                                        

                                        <div class="tab-pane  {{$errors->any()?"active":""}}" id="changepassword">
                                              <form method="post" action="{{ route('password.update') }}">
                                                @csrf
                                                @method('put')
                                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Changing Password</h5>

                                                    <div class="col-6 mx-auto">
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
                                                            <button type="submit" class="form-control col-12 btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save Updates</button>
                                                            </div>
                                                        </div> <!-- end row -->
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end changepassword content-->

                                    </div> <!-- end tab-content -->
                                </div> <!-- end card-box-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->


@endsection
