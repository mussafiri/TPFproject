
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
                                            <li class="breadcrumb-item"><a href="{{url('users/list/'.Crypt::encryptString('ACTIVE'))}}">Users</a></li>
                                            <li class="breadcrumb-item active">User Profile</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">User Profile</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="card-box text-center">
                                    <img src="{{asset('assets/images/users/user-1.jpg')}}" class="rounded-circle avatar-lg img-thumbnail mt-2"
                                        alt="profile-image">

                                    <h4 class="mb-0 mt-2">{{$userData->fname.' '.$userData->mname.' '.$userData->lname}}</h4>
                                    <p class="text-muted">{{'@'.$userData->designation->name}}</p>


                                    <div class="text-left mt-4">
                                        <h4 class="font-13 text-uppercase mb-2">About {{$userData->fname.' '.$userData->mname.' '.$userData->lname}}</h4>
                                        <div class="row text-muted mb-2 mt-2 font-13">
                                            <div class="col-md-4"><strong>Full Name :</strong></div> <div class="col-md-8"><span class="ml-2">{{$userData->fname.' '.$userData->mname.' '.$userData->lname}}</span></div>
                                        </div>
                                        <div class="row text-muted mb-2 font-13">
                                            <div class="col-md-4"><strong>Mobile :</strong></div> <div class="col-md-8"><span class="ml-2">{{$userData->phone}}</span></div>
                                        </div>
                                        <div class="row text-muted mb-2 font-13">
                                            <div class="col-md-4"><strong>Email :</strong></div> <div class="col-md-8"><span class="ml-2 ">{{$userData->email}}</span></div>
                                        </div>
                                        <div class="row text-muted mb-2 font-13">
                                            <div class="col-md-4"><strong>Department :</strong></div> <div class="col-md-8"><span class="ml-2">{{$userData->department->name}}</span></div>
                                        </div>
                                        <div class="row text-muted mb-2 font-13">
                                            <div class="col-md-4"><strong>Designation :</strong></div> <div class="col-md-8"><span class="ml-2">{{$userData->designation->name}}</span></div>
                                        </div>
                                    </div>
                                </div> <!-- end card-box -->
                                

                            </div> <!-- end col-->

                            <div class="col-lg-8 col-xl-8">
                                <div class="card-box">
                                    <div class="tab-content">
                                        <div class="tab-pane  {{$errors->any()?"":"active"}}" id="aboutme">

                                            <h5 class="mb-4"><i class="mdi mdi-briefcase mr-1"></i>
                                                More Details</h5>

                                            <ul class="list-unstyled timeline-sm">
                                                <li class="timeline-sm-item">
                                                    <span class="timeline-sm-date">{{date('d M Y', strtotime($userData->created_at))}}</span>
                                                    <h5 class="mt-0 mb-1">Registration</h5>
                                                    <p><strong>By: </strong>{{$userData->creator->fname.' '.$userData->creator->mname.' '.$userData->creator->lname}}</p>
                                                    <p class="text-muted mt-2"></p>

                                                </li>
                                                <li class="timeline-sm-item">
                                                    <span class="timeline-sm-date">{{date('d M Y', strtotime($userData->updated_at))}}</span>
                                                    <h5 class="mt-0 mb-1">Updated Details</h5>
                                                    <p><strong>By: </strong>{{$userData->updated_by > 0?$userData->updator->fname.' '.$userData->updator->mname.' '.$userData->updator->lname:'N/A'}}</p>
                                                    <p class="text-muted mt-2"></p>
                                                </li>
                                                <li class="timeline-sm-item">
                                                    <span class="timeline-sm-date">{{date('d M Y', strtotime($userData->last_login))}}</span>
                                                    <h5 class="mt-0 mb-1">Last Login</h5>
                                                    <p></p>
                                                    <p class="text-muted mt-2 mb-0"></p>
                                                </li>
                                                <li class="timeline-sm-item">
                                                    <span class="timeline-sm-date">{{date('d M Y', strtotime($userData->password_changed_at))}}</span>
                                                    <h5 class="mt-0 mb-1">Last Password Changed</h5>
                                                    <p></p>
                                                    <p class="text-muted mt-2 mb-0"></p>
                                                </li>
                                            </ul>
                                        </div> <!-- end tab-pane -->
                                        <!-- end about me section content -->
                                    </div> <!-- end tab-content -->
                                </div> <!-- end card-box-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->


@endsection
