@extends('layouts.admin_main')
@php
    use Carbon\Carbon;
@endphp
@section('custom_css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

<!-- third party css end -->
<style type="text/css">
    .my-image {
        width:72px !important;
        height:72px !important;
        object-fit: cover; /* scale and align the image within its container */
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
                            <li class="breadcrumb-item"><a href="{{url('members/list')}}">Members</a></li>
                            <li class="breadcrumb-item active">Member Details</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Member Details</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h4 class="header-title mb-3">Member Particulars</h4>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <a type="button" href="{{url('members/list')}}" class="btn btn-sm btn-blue waves-effect waves-light font-weight-bold"><i class="mdi mdi-arrow-left-thick mr-1  "></i>Back</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Primary Contributor:</span><br><span class="font-12 text-right">{{$member_data->contributor->name}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Type:</span><span class="font-10 text-right {{$member_data->contributor->contributorType->name=='CHURCH'? 'badge badge-soft-success':($member_data->contributor->contributorType->name=='EDUCATION DEPARTMENT'?'badge badge-soft-info':($member_data->contributor->contributorType->name=='MISSIONARY DEPARTMENT'?'badge badge-soft-success':'badge badge-soft-primary'));}}">{{$member_data->contributor->contributorType->name}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Zone:</span><span class="font-12">{{$member_data->contributor->contributorSection->district->zone->name}}</span>
                            </p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">District:</span><span class="font-12 text-right">{{$member_data->contributor->contributorSection->district->name}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Section:</span><span class="font-12 text-right">{{$member_data->contributor->contributorSection->name}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Contributor Income:</span><span class="font-12 text-right">{{number_format($member_data->contributor->getContributorIncome($member_data->id),2)}}</span><sup><small>TZS</small></sup></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Scheme Joining:</span><span class="font-12 text-right">{{date('d M Y',strtotime($member_data->join_at))}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Service Date:</span><span class="font-12 text-right">{{date('d M Y',strtotime($member_data->service_start_at))}}</span></p>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Member code:</span> <span class="font-12 text-right">{{$member_data->member_code}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Occupation:</span><span class="font-12 text-right">{{$member_data->occupation}}</span> </p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Gender:</span> <span class="font-12 text-end">{{$member_data->gender}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Phone:</span><span class="font-12 text-right">{{$member_data->phone}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Email:</span><span class="font-12 text-right">{{$member_data->email}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-1">Physical<sup> Address</sup></span><span class="font-12 text-right">{{$member_data->physical_address}}</span></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-1">Postal <sup> Address</sup></span><br><small><span class="font-12 text-right">{{$member_data->postal_address}}</span></small></p>
                            <p class="mb-1"><span class="font-weight-semibold mr-2">Date of Birth:</span><span class="font-12 text-right">{{date('d M Y', strtotime($member_data->dob))}}</span></p>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12">
                            <div class="widget-rounded-circle card-box p-1 mb-1">
                                <div class="row align-items-center">
                                    <div class="col-auto pl-1">
                                        <div class="avatar-lg" >
                                            @if($member_data->picture =="NULL")
                                                @if($member_data->gender=="FEMALE")
                                                    <img src="{{asset('assets/images/profile/profile-woman.png')}}" class="img-fluid rounded-circle my-image" alt="user-img"  />                                      
                                                @else
                                                    <img src="{{asset('assets/images/profile/profile-man.png')}}" class="img-fluid rounded-circle my-image" alt="user-img"  />                                      
                                                @endif  
                                            @else
                                                <img src="{{asset('storage/members/photo/'.$member_data->picture)}}" class="img-fluid rounded-circle my-image" alt="user-img"  />                                      
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h5 class="mb-1 mt-2 font-12">{{$member_data? $member_data->title.". ".$member_data->fname." ".$member_data->mname." ".$member_data->lname:" ";}} </h5>
                                        <p class="mb-2 font-12 text-muted"><span class="{{$member_data->salutationTitle->name=='ASSOCIATE PASTOR' ? 'badge badge-soft-secondary':'badge badge-soft-dark';}}">{{$member_data->salutationTitle->name}}</span></p>
                                    </div>
                                </div> <!-- end row-->
                            </div> <!-- end widget-rounded-circle-->
                            @php
                                $last_login = $member_data->last_login == "NULL"? "NOT LOGGED IN" : date('d M Y',strtotime($member_data->last_login));
                                $last_changed = $member_data->password_changed_at == "NULL"? "NOT CHANGED" :"<small>".date('d M Y',strtotime($member_data->password_changed_at))."</small>";
                            @endphp
                            <p class="mb-1"><span></span><span class="font-weight-semibold mr-2">Status:</span><small><span class="text-right mr-3 {{$member_data->status=='ACTIVE' ? 'badge badge-soft-secondary':'badge badge-soft-danger';}}">{{$member_data->status}}</span></small></span>
                            <span class="float-right">
                            <span class="font-weight-semibold mr-2 ml-auto">Last login:</span><span class="font-10 text-right {{$member_data->last_login == 'NULL'? 'badge badge-soft-dark':'';}}">{{$last_login}}</span></span>
                            </p>
                            <p class="mb-1">
                                <span>
                                    <span class="font-weight-semibold mr-2">Created on:</span><span class="font-12 text-right">{{date('d M Y', strtotime($member_data->created_at))}}</span>
                                </span>
                                <span class="float-right">
                                    <span class="font-weight-semibold mr-2">Marital Status:</span><span class="font-10 text-right badge{{$member_data->marital_status == 'MARRIED' ? ' badge-soft-info':'badge-soft-secondary';}}">{{$member_data->marital_status}}</span>
                                </span>
                            </p>
                            <p class="mb-1">
                                <span>
                                    <span class="font-weight-semibold mr-2">Password <sup>Status</sup></span><span class="font-10 text-right {{$member_data->password_status == 'ACTIVE'? 'badge badge-soft-secondary':($member_data->password_status == 'DEFAULT' ? 'badge badge-soft-dark':'badge badge-soft-danger');}}">{{$member_data->password_status}}</span>
                                </span>
                                <span class="float-right">
                                    <sup class="mr-2">Last Changed</sup><span class="font-10 text-right {{$member_data->password_changed_at == 'NULL'? 'badge badge-soft-dark':'';}}">{!!$last_changed!!}</span>
                                </span>
                            </p>
                            <p class="mb-1"> <span class="font-weight-semibold mr-2">Created by:</span><span class="font-12 text-right ">{{$member_data->createdBy->fname." ".$member_data->createdBy->lname}}</span></p>
                            <p class="mb-1"><span><span class="font-weight-semibold mr-2">Vital Status:</span><small><span class="badge badge-soft-primary">{{$member_data->vital_status}}</span></small></span>
                            <span class="float-right">
                                <span class="font-weight-semibold mr-2">Monthly Income</span><br><span class="font-12 text-right">{{number_format($member_data->income,2)}}</span><sup><small>TZS</small></sup>
                            </span>
                            </p>
                        </div>

                    </div>
                    <div class="dropdown-divider col-12"></div>
                    <div class="col-12 my-2">
                        <h6 class="header-title font-16 text-muted">Attachments</h6>
                    </div>
                    <div class="col-12"><!-- File Attachment -->
                        <div class="row">
                            <div class="col-xl-4 col-lg-4  pl-0">
                                <label for="name" class="font-13">Registration Form</label>
                                <div class="card mb-1 ml-0 shadow-none border">
                                    <div class="p-1">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title badge-soft-primary text-primary rounded">
                                                        {!! $member_data->regform_attachment != "NULL"? pathinfo(Storage::url('members/reg_forms/'.$member_data->regform_attachment), PATHINFO_EXTENSION):'<i class="flaticon-paperclip font-18"></i>';!!}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col pl-0 pr-0">
                                                <a href="javascript:void(0);" class="text-muted font-weight-medium font-11">
                                                    {!!$member_data->regform_attachment == "NULL" ? '<span class="text-danger"> No Attachment</span>':$member_data->regform_attachment;!!}
                                                </a>
                                                <p class="mb-0 font-12">
                                                    {!! $member_data->regform_attachment=="NULL" ? "": convertToReadableFileSize(filesize('storage/members/reg_forms/'.$member_data->regform_attachment));!!}
                                                </p>
                                            </div>
                                            <div class="col-auto px-1">
                                                <!-- Button -->
                                                @if($member_data->regform_attachment!="NULL")
                                                    <a href="{{Storage::url('members/reg_forms/'.$member_data->regform_attachment)}}" class="btn btn-link font-16 text-muted" target="_blank">
                                                        <i class="dripicons-download"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4  pl-0">
                                <label for="name" class="font-12">{{$member_data->id_type_id == 0 ? "ID Attachment": $member_data->idAttachment->name;}} {!! $member_data->id_type_id > 0 ?'[ <small>'.$member_data->id_number.'</small> ]':'';!!}</label>
                                <div class="card mb-1 ml-0 shadow-none border">
                                    <div class="p-1">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title badge-soft-primary text-primary rounded">
                                                        {!! $member_data->id_attachment != "NULL"? pathinfo(Storage::url('members/ids/'.$member_data->id_attachment), PATHINFO_EXTENSION):'<i class="flaticon-paperclip font-18"></i>';!!}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col pl-0">
                                                <a href="javascript:void(0);" class="text-muted font-weight-bold font-11">{!!$member_data->id_attachment=="NULL"?'<span class="text-danger"> No Attachment</span>'  :$member_data->id_attachment;!!}</a>
                                                <p class="mb-0 font-12">{!! $member_data->id_attachment=="NULL"? "": convertToReadableFileSize(filesize('storage/members/ids/'.$member_data->id_attachment));!!} </p>
                                            </div>
                                            <div class="col-auto">
                                                <!-- Button -->
                                                @if($member_data->id_attachment!="NULL")
                                                <a href="{{Storage::url('members/ids/'.$member_data->id_attachment)}}" target="_blank" class="btn btn-link font-16 text-muted">
                                                    <i class="dripicons-download"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4  pl-0">
                                <label for="name" class="font-13">Signature</label>
                                <div class="card mb-1 ml-0 shadow-none border">
                                    <div class="p-1">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title badge-soft-primary text-primary rounded">
                                                        {!! $member_data->member_signature != "NULL"? pathinfo(Storage::url('members/signatures/'.$member_data->member_signature), PATHINFO_EXTENSION):'<i class="flaticon-paperclip font-18"></i>';!!}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col pl-0 pr-0">
                                                <a href="javascript:void(0);" class="text-muted font-weight-bold font-11">
                                                    {!!$member_data->member_signature=="NULL"?'<span class="text-danger"> No Attachment</span>':$member_data->member_signature;!!}
                                                </a>
                                                <p class="mb-0 font-12"> {!! $member_data->member_signature=="NULL"? "": convertToReadableFileSize(filesize('storage/members/signatures/'.$member_data->member_signature));!!} </p>
                                            </div>
                                            <div class="col-auto">
                                                <!-- Button -->
                                                @if($member_data->member_signature!="NULL")
                                                    <a href="{{Storage::url('members/signatures/'.$member_data->member_signature)}}" target="_blank" class="btn btn-link font-16 text-muted">
                                                        <i class="dripicons-download"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col -->
    </div><!-- end Member Particulars row -->

    <div class="row"><!-- Summary Reports -->
        <div class="col-12">
            <div class="card-box">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h4 class="header-title mb-3">Other Details</h4>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-right">
                        </div>
                    </div><!-- end col-->
                </div>
                <div class="row">
                    <ul class="nav nav-tabs nav-bordered col-12">
                        <li class="nav-item">
                            <a href="#contributionsPane" data-toggle="tab" class="nav-link active">
                                <i class="flaticon-transaction-history"></i>
                                Contributions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#transferHistoryPane" data-toggle="tab" class="nav-link ">
                                <i class="flaticon-data-transfer-1"></i>
                                Transfer History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#memberDependantsPane" data-toggle="tab" class="nav-link ">
                                <i class="flaticon-leader"></i>
                                    Dependants
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content col-12">
                        <div class="tab-pane" id="memberDependantsPane">
                            <div class="table-responsive">
                                <table class="table table-sm font-12 table-striped w-100 datatable-buttons table-responsible">
                                    <thead>
                                        <tr>
                                            <th style="width:2%;">#</th>
                                            <th style="width:26%;">Name</th>
                                            <th style="width:5%;">Relationship</th>
                                            <th style="width:5%;">Gender</th>
                                            <th style="width:8%;">Occupation</th>
                                            <th style="width:5%;">Phone</th>
                                            <th style="width:5%;">Age</th>
                                            <th style="width:10%;">Attachments</th>
                                            <th style="width:10%;">Vital </th>
                                            <th style="width:6%;">status</th>
                                            <th style="width:18%;">Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $dep=1; @endphp
                                        @foreach ($dependants as $dep_data)
                                            @php
                                                $picture              = $dep_data->picture == "NULL" ? '': '<span data-toggle="tooltip" data-placement="top" title="Picture" data-original-title="Tooltip on top"><a href="'.Storage::url('members/dependants/photo/'.$dep_data->picture).'" target="_blank"><i class="font-14 mdi flaticon-image mr-1"></i></a></span>';                                        
                                                $marriagecertificate  = $dep_data->marriagecert == "NULL" ? '': '<span data-toggle="tooltip" data-placement="top" title="Marriage Certificate" data-original-title="Tooltip on top"><a href="'.Storage::url('members/dependants/certificates/'.$dep_data->marriagecert).'" target="_blank"><i class="mdi flaticon-wedding-contract mr-1"></i></a></span>';                                        
                                                $birthcertificate     = $dep_data->birthcert == "NULL" ? '': '<span data-toggle="tooltip" data-placement="top" title="Birth Certificate" data-original-title="Tooltip on top"><a href="'.Storage::url('members/dependants/certificates/'.$dep_data->birthcert).'" target="_blank"><i class="mdi flaticon-bill-2 mr-1"></i></a></span>'; 
                                                $attached_attachment  = $picture.$marriagecertificate.$birthcertificate;
                                                $attachment           = ($dep_data->picture == "NULL" && $dep_data->marriagecert == "NULL" && $dep_data->birthcert == "NULL") ? '<a data-toggle="tooltip" data-placement="top" title="No Attachment" data-original-title="Tooltip on top"><i class="font-14 text-secondary mdi mdi-alert-circle-outline"></i></a>':$attached_attachment;
                                            @endphp                                     
                                        <tr>
                                            <td>{{$dep}}</td>
                                            <td>{{$dep_data->fname." ".$dep_data->mname." ".$dep_data->lname}}</td>
                                            <td><span class="badge badge-soft-{{$dep_data->relationship =='PARENT'? 'default':'success';}}">{{$dep_data->relationship}}</span></td>
                                            <td><span class="badge badge-soft-{{$dep_data->gender =='MALE'? 'info':'blue';}}">{{$dep_data->gender}}</span></td>
                                            <td>{{$dep_data->occupation}}</td>
                                            <td>{{$dep_data->phone}}</td>
                                            <td>{!!$dep_data->dob != "NULL"? Carbon::parse($dep_data->dob)->age:'<span class="badge badge-soft-dark"> NOT DETERMINED</span>';!!}</td>
                                            <td class="text-center">{!!$attachment!!}</td>
                                            <td><span class="{{$dep_data->vital_status == 'ALIVE' ? 'badge badge-soft-success':'badge badge-soft-danger';}}">{{$dep_data->vital_status}}</span></td>
                                            <td><span class="{{$dep_data->status == 'ACTIVE' ? 'badge badge-soft-success':'badge badge-soft-danger';}}">{{$dep_data->status}}</span></td>
                                            <td>{{$dep_data->createdBy->fname." ".$dep_data->createdBy->lname}}</td>
                                        </tr>
                                        @php $dep++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div><!-- end .tab-pane active-->
                        <div class="tab-pane" id="transferHistoryPane">
                            <div class="table-responsive">
                                <table class="table table-sm font-12 table-striped w-100 datatable-buttons table-responsible" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th style="width:3%;">#</th>
                                            <th style="width:35%;">Contributor</th>
                                            <th style="width:16%;">From</th>
                                            <th style="width:16%;">To</th>
                                            <th style="width:10%;">status</th>
                                            <th style="width:20%;">Transfered by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $t=1; @endphp
                                        @foreach ($transfers as $trans_data)
                                        @php $end_date = $trans_data->end_date == "NULL" ? '<small><span class="badge badge-outline-blue">CURRENT</span></small> ' : date('d M Y', strtotime($trans_data->end_date)); @endphp
                                        <tr>
                                            <td>{{$t}}</td>
                                            <td>{{$trans_data->contributor->name}}</td>
                                            <td>{{date('d M Y', strtotime($trans_data->start_date))}}</td>
                                            <td>{!!$end_date!!}</td>
                                            <td><span class="$data->status == ACTIVE ? 'badge badge-soft-success':'badge badge-soft-success';">{{$trans_data->status}}</span></td>
                                            <td>{{$trans_data->transferedBy->fname." ".$trans_data->transferedBy->lname}}</td>
                                        </tr>
                                        @php $t++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div><!-- end .tab-pane active-->
                        <div class="tab-pane active" id="contributionsPane">
                            <div class="table-responsive">
                                <table class="table table-sm font-12 table-striped w-100 datatable-buttons table-responsible">
                                    <thead>
                                        <tr>
                                            <th style="width:4%;">#</th>
                                            <th style="width:19%;">Contributor</th>
                                            <th style="width:14%;">Monthly Income <sup class="text-muted font-10">TZS</sup></th>
                                            <th style="width:10%;">Amount <sup class="text-muted font-10">Contributor TZS</sup></th>
                                            <th style="width:10%;">Amount <sup class="text-muted font-10">Member TZS</sup></th>
                                            <th style="width:10%;">Topup <sup class="text-muted font-10">TZS</sup></th>
                                            <th style="width:10%;">Total <sup class="text-muted font-10">TZS</sup></th>
                                            <th style="width:6%;">Payment date</th>
                                            <th style="width:6%;">status</th>
                                            <th style="width:4%;">Posted by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $x=1; @endphp
                                        @foreach ($member_contributions as $data)
                                        @php
                                        $contri_status = $data->status == ACTIVE ? "POSTED" :"WITHDRAWN";
                                        $total = $data->member_topup + $data->member_contribution + $data->member_monthly_income;
                                        @endphp
                                        <tr>
                                            <td>{{$x}}</td>
                                            <td>{{$data->contributor->name}}</td>
                                            <td>{{number_format($data->member_monthly_income,2)}}</td>
                                            <td>{{number_format($data->member_contribution,2)}}</td>
                                            <td>{{number_format($data->member_topup,2)}}</td>
                                            <td>{{number_format($total,2)}}</td>
                                            <td>{{date('d M Y', strtotime($data->contribution->payment_date))}}</td>
                                            <td><span class="$data->status == ACTIVE ? 'badge badge-soft-success':'badge badge-soft-success';"></span>{{$contri_status}}</td>
                                            <td>{{$data->createdBy->fname." ".$data->createdBy->lname}}</td>
                                        </tr>
                                        @php $x++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end .table-responsive-->
                        </div><!-- end .tab-pane active-->
                    </div><!-- end .tab-content-->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col -->
    </div>

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