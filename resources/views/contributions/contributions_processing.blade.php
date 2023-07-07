@extends('layouts.admin_main')
@section('custom_css')
<!-- kartik Fileinput-->
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fontawesome-kartik.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/bootstrap-icons.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fileinput.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.css')}}" />

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
                            <li class="breadcrumb-item active">Process Contribution</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Process Contributions</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row reconciliationBlock">
                        <h4 class="header-title mb-3 text-muted">Reconciliation Panel </h4>
                        <div class="col-12"> 
                            <div class="row px-0"> 
                                    <div class="col-sm-8"><strong>Section Name:</strong> {{$contributionData->section->name}}</div>
                                    <div class="col-sm-4"> <strong>Section Code:</strong> {{$contributionData->section->section_code}}</div>

                                    <div class="col-sm-12 mt-2 mb-3 px-0">
                                            <table class="table table-sm font-11 table-bordered table-centered mb-0 w-100">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="text-center">Scheme</th>
                                                        <th class="text-center">Contribution Date</th>
                                                        <th class="text-center">Contributors</th>
                                                        <th class="text-center">Members</th>
                                                        <th class="text-center">Monthly Contribution <sup class="text-muted font-10">TZS</sup></th>
                                                        <th class="text-center">Total Topups <sup class="text-muted font-10">TZS</sup></th>
                                                        <th class="text-center">Total Contribution <sup class="text-muted font-10">TZS</sup></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">TUMAINI PENSION FUND</td>
                                                        <td class="text-center">{{date('M Y', strtotime($contributionData->contribution_period))}}</td>
                                                        <td class="text-center">{{$contributionData->total_contributors}}</td>
                                                        <td class="text-center">{{$contributionData->total_members}}</td>
                                                        <td class="text-center">{{number_format($contributionData->sumTransaction($contributionData->id), 2)}}</td>
                                                        <td class="text-center">{{number_format($contributionData->sumTopup( $contributionData->id ), 2)}}</span></td>
                                                        <td class="text-center">{{number_format(($contributionData->sumTransaction($contributionData->id)+$contributionData->sumTopup( $contributionData->id )), 2)}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </div>
                            </div> 
                        </div> 
                        <div class="col-12 border rounded p-2" style="background-color: #f6fcff;">
                            <div class="row">

                                <div class="col-md-2 font-11"> <strong>Total Contribution</strong>
                                    <p>{{number_format($contributionData->sumTransaction($contributionData->id)+$contributionData->sumTopup( $contributionData->id ), 2)}} <sup class="text-muted">TZS</sup></p>
                                </div>
                                <div class="col-md-2 font-11"> <strong>Pay Date</strong>
                                    <p>{{date('d M, Y', strtotime($contributionData->payment_date))}} <small class="text-muted">{{date('H:i', strtotime($contributionData->payment_date))}}</small></p>
                                </div>
                                <div class="col-md-2 font-11"> <strong>Pay Mode</strong>
                                    <p>{{$contributionData->payMode->name}}</p>
                                </div>
                                <div class="col-md-2 font-11"> <strong>Pay Ref</strong>
                                    <p class="text-muted">{{$contributionData->payment_ref_no}}</p>
                                </div>
                                <div class="col-md-2 font-11"> <strong>Pay Proof</strong>
                                    <p><a class="font-14" href="{{Storage::url('contributionPaymentProof/'.$contributionData->payment_proof)}}" download="{{Storage::url('contributionPaymentProof/'.$contributionData->payment_proof)}}" download title="Download Payment Proof" target="_blank"><i class="mdi mdi-cloud-download-outline"></i></a></p>
                                </div>
                                <div class="col-md-2 font-11"> <strong>Process Status</strong>
                                    <p><span class="badge badge-outline-@if($contributionData->processing_status=="PENDING"){{"info"}} @elseif($contributionData->processing_status=="APPROVED"){{"primary"}} @elseif($contributionData->processing_status=="POSTED"){{"success"}}@elseif($contributionData->processing_status=="APPROVAL REJECTED"){{"danger"}} @elseif($contributionData->processing_status=="POSTING REJECTED"){{"pink"}} @else{{"secondary"}} @endif badge-pill">{{$contributionData->processing_status}}</span></p>
                                </div>

                                <div class="col-md-2 font-11"> <strong>Created By</strong>
                                    <p>{{ucfirst(strtolower($contributionData->createdBy->fname)).' '.ucfirst(strtolower($contributionData->createdBy->mname)).' '.ucfirst(strtolower($contributionData->createdBy->lname))}}</p>
                                </div>
                                <div class="col-md-2 font-11"> <strong>Created At</strong>
                                    <p>{{date('d M, Y', strtotime($contributionData->created_at))}} <small class="text-muted">{{date('H:i', strtotime($contributionData->created_at))}}</small></p>
                                </div>
                                <div class="col-md-2 font-11"> <strong>Approval Status</strong>
                                    <p>@if($contributionData->approved_by==0) <span class="badge badge-outline-info badge-pill">PENDING</span>@else  <i class="mdi mdi-check-bold text-success"></i> @endif</span></p>
                                </div>
                                <div class="col-md-2 font-11"> <strong>Approved By</strong>
                                    <p>@if($contributionData->approved_by==0){{'None'}} @else {{ucfirst(strtolower($contributionData->approvedBy->fname)).' '.ucfirst(strtolower($contributionData->approvedBy->mname)).' '.ucfirst(strtolower($contributionData->approvedBy->lname))}} @endif</p>
                                </div>
                                <div class="col-md-2 font-11"> <strong>Posting Status</strong>
                                    <p>@if($contributionData->posted_by==0)<span class="badge badge-outline-info badge-pill">PENDING</span> @else <i class="mdi mdi-check-bold text-success"></i> @endif</span></p>
                                </div>
                                <div class="col-md-2 font-11"> <strong>Posted By</strong>
                                    <p>@if($contributionData->posted_by==0){{'None'}} @else {{ucfirst(strtolower($contributionData->postedBy->fname)).' '.ucfirst(strtolower($contributionData->postedBy->mname)).' '.ucfirst(strtolower($contributionData->postedBy->lname))}} @endif</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
            <!-- end .table-responsive-->
        </div> <!-- end card-box-->


        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="row">
                        <h4 class="header-title mb-3 text-muted">Member Contributions </h4>
                        <div class="col-12">
                        <form method="POST" action="{{url('contributions/submit/approval/'.$contributionData->id)}}">
                        @csrf
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="btn-editable" class="new_contrinbution_recon_table table table-sm font-11 table-striped w-100 table-responsible">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:20%;">Contributor</th>
                                                <th style="width:18%;">Member Name</th>
                                                <th style="width:10%;">Monthly Income <sup class="text-muted font-10">TZS</sup></th>
                                                <th style="width:10%;">Amount <sup class="text-muted font-10">Contributor TZS</sup></th>
                                                <th style="width:10%;">Amount <sup class="text-muted font-10">Member TZS</sup></th>
                                                <th style="width:10%;">Topup <sup class="text-muted font-10">TZS</sup></th>
                                                <th class="text-center" style="width:10%;">Total <sup class="text-muted font-10">TZS</sup></th>
                                                <th style="width:5%;">Status</th>
                                                <th style="width:5%;">Confirm</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $n=1;@endphp
                                            @foreach($contributionDetails as $value)
                                            <tr>
                                                <td>{{$n}}.</td>
                                                <td>{{$value->contributor->name}}</td>
                                                <td>{{$value->member->fname.' '.$value->member->mname.' '.$value->member->lname}}</td>
                                                <td>{{number_format($value->member_monthly_income,2)}}</td>
                                                <td>{{number_format($value->contributor_contribution,2)}}</td>
                                                <td>{{number_format($value->member_contribution,2)}}</td>
                                                <td>{{number_format($value->member_topup,2)}}</td>
                                                <td>{{number_format($value->contributor_contribution+$value->member_contribution+$value->member_topup,2)}}</td>
                                                <td><span class="badge badge-outline-{{$value->status=='ACTIVE'?'success':'primary'}}">{{$value->status}}</span></td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck{{$n}}" name="confirmMembers[]">
                                                        <label class="custom-control-label" for="customCheck{{$n}}"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $n++;@endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            <!-- Start:: Rejection Warning Alert Modal -->
                                <div id="approvalModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-body p-4">
                                                <div class="text-center">
                                                    <i class="dripicons-warning h1 text-warning"></i>
                                                    <h4 class="mt-2">Confirm Contribution <span class="approvalSpanTextTitle">Approval</span></h4>
                                                    <p class="mt-3">Are you sure! <br> You are about to <span class="approvalSpanTextBody">Approve</span> Contribution Submission </p>
                                                    <input type="hidden" name="approvalType" id="approvalType" value="">
                                                    <input type="hidden" name="totalMembers" value="{{$contributionData->total_members}}">
                                                     @if ($errors->approveContribution->has('confirmMembers')) <span class="text-danger" role="alert"> <strong>{{ $errors->approveContribution->first('confirmMembers') }}</strong></span>@endif
                                                </div>

                                                <button type="submit" class="btn btn-success my-2 float-left">Yes! <span class="approvalSpanButton">Submit Approval</button>
                                                <button type="button" class="btn btn-danger my-2 float-right" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            <!-- End:: Rejection Warning Alert Modal -->

                            </div>
                            </form>
                        </div>

                        <div class="col-md-12 px-3 pt-2">

                            <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light float-right rejectionButton" data-toggle="modal" data-target="#rejectModal" data-rejectionType="@if($contributionData->approved_by==0){{'Reject Approval'}}@endif @if($contributionData->approved_by > 0 && $contributionData->posted_by==0){{'Reject Posting'}}@endif">@if($contributionData->approved_by==0){{'Reject Approval'}}@endif @if($contributionData->approved_by > 0 && $contributionData->posted_by==0){{'Reject Posting'}}@endif</a>
                            <a href="javascript:void(0);" class="btn btn-info waves-effect waves-light float-right mr-2 approvalButton" data-toggle="modal" data-target="#approvalModal"  data-approvalType="@if($contributionData->approved_by==0){{'Approve Contribution'}}@endif @if($contributionData->posted_by==0 && $contributionData->approved_by > 0){{'Post Contribution'}}@endif"> @if($contributionData->approved_by==0){{'Approve Contribution'}}@endif @if($contributionData->approved_by > 0 && $contributionData->posted_by==0){{'Post Posting'}}@endif</a>

                            <!-- Start:: Rejection Warning Alert Modal -->
                                <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <form method="POST" action="{{url('contributions/submit/rejection/'.$contributionData->id)}}">
                                            @csrf
                                                <div class="modal-body p-4 mb-3">
                                                    <div class="text-center">
                                                        <i class="dripicons-warning h1 text-warning"></i>
                                                        <h4 class="mt-2">Confirm Contribution <span class="rejectionSpanTextTitle text-success">Approval </span>Rejection</h4>
                                                        <p class="mt-3">Are you sure! <br> You are about to <span class="rejectionSpanTextBody text-success">Reject Approval </span> of the Contribution. Kindly write a rejection reason</p>
                                                        <input type="hidden" name="rejectionType" id="rejectionType" value="">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="example-textarea">Select Rejection Reason</label>
                                                        <select class="form-control reasonSelect" name="reasonSelection" data-toggle="select2" required>
                                                            @foreach($rectionReasons as $value)
                                                                <option value="{{$value->id}}"> {{$value->reason}}</option>
                                                            @endforeach
                                                                <option value="0"> Other Reason...</option>
                                                        </select>
                                                        @if ($errors->rejectionValidation->has('reasonSelection')) <span class="text-danger" role="alert"> <strong>{{ $errors->rejectionValidation->first('reasonSelection') }}</strong></span>@endif
                                                    </div>
                                                    
                                                    <div class="form-group mb-3 otherRectionReason" style="display:none;">
                                                        <label for="example-textarea">Write Rejection Reason</label>
                                                        <textarea class="form-control otherRectionReasonInput" name="rejectionReason" id="example-textarea" rows="4" placeholder="Write Rejection Reason"></textarea>
                                                        @if ($errors->rejectionValidation->has('rejectionReason')) <span class="text-danger" role="alert"> <strong>{{ $errors->rejectionValidation->first('rejectionReason') }}</strong></span>@endif
                                                    </div>

                                                    <button type="submit" class="btn btn-success my-2 float-left">Yes! Submit <span class="rejectionSpanButton">Approval  Rejection</span></button>
                                                    <button type="button" class="btn btn-danger my-2 float-right mb-3" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            <!-- End:: Rejection Warning Alert Modal -->

                        </div> <!-- end col -->
                    </div> <!-- end row -->
        </div>
        </div>
        </div>
        </div> <!-- end card-box-->
    </div> <!-- end col -->
</div>
<!-- end row -->
</div> <!-- container -->
</div> <!-- content -->
@endsection
@section('custom_script')

<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.js')}}"></script>

@if($errors->hasBag('approveContribution'))
    <script>
        $(document).ready(function(){
            $('#approvalModal').modal({show: true});
        });
    </script>
@endif

@if($errors->hasBag('rejectionValidation'))
    <script>
        $(document).ready(function(){
            $('#rejectModal').modal({show: true});
        });
    </script>
@endif

<script>
    $(".kartik-input-705").fileinput({
        theme: "explorer"
        , uploadUrl: '#'
        , allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif']
        , overwriteInitial: false
        , initialPreviewAsData: true
        , maxFileSize: 2000
        , maxTotalFileCount: 1
        , showUpload: false
        , showCancel: false
        , dropZoneTitle: '<span>Drag & Drop Proof File here to upload</span>'
        , fileActionSettings: {
            showUpload: false
            , showRemove: true
        , }
    , });

</script>

<script>
$('.approvalButton').on('click',function(){
   var approvalType = $(this).attr('data-approvalType');
   $('#approvalType').val(approvalType);

    if(approvalType =='Approve Contribution'){
        $('.approvalSpanTextTitle').html('Approval');
        $('.approvalSpanTextBody').html('Approve');
        $('.approvalSpanButton').html('Submit Approval');

    }else{
        $('.approvalSpanTextTitle').html('Posting');
        $('.approvalSpanTextBody').html('Post');
        $('.approvalSpanButton').html('Post Contribution');
    }
});

$('.rejectionButton').on('click',function(){
   var rejectionType = $(this).attr('data-rejectionType');
   $('#rejectionType').val(rejectionType);
    if(rejectionType =='Reject Approval'){
        $('rejectionSpanTextTitle').html('Approval');
        $('rejectionSpanTextBody').html('Reject Approval of');
        $('rejectionSpanButton').html('Approval  Rejection');

    }else{
        $('rejectionSpanTextTitle').html('Posting');
        $('rejectionSpanTextBody').html('Reject Posting of');
        $('rejectionSpanButton').html('Positing  Rejection');
    }
});

$('.reasonSelect').change(function(){
    var reason = $(this).find(":selected").val();
    
    if(reason == 0){
        $('.otherRectionReasonInput').prop('required', true);
        $('.otherRectionReason').show();
    }else{
        $('.otherRectionReasonInput').removeAttr('required');
        $('.otherRectionReason').hide();
    }
});

</script>

@endsection
