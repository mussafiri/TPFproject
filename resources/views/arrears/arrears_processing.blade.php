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
                            <li class="breadcrumb-item active">Processs Arrear</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Processs Arrear</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <form method="POST" action="{{url('contributions/submit/member/arrearpenalty/waive')}}">
                    @csrf
                    <div class="row">
                        <h4 class="header-title mb-3 text-muted">Details Panel </h4>

                        <div class="col-12 mb-3 border rounded p-2" style="background-color: #f6fcff;">
                            <div class="row">
                                <div class="col-sm-8"><strong>Section Name:</strong> <span id="sectionName">{{$arrearDetails->section->name}}</span></div>
                                <div class="col-sm-4"> <strong>Section Code:</strong> <span id="sectionCode">{{$arrearDetails->section->section_code}}</span></div>

                                <div class="col-sm-12 mt-2">
                                    <div class="table-responsive">
                                        <table class="table table-sm font-11 table-bordered table-centered mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="text-center">Scheme</th>
                                                    <th class="text-center">Contribution Date</th>
                                                    <th class="text-center">Contributors</th>
                                                    <th class="text-center">Members</th>
                                                    <th class="text-center">Monthly Contribution <sup class="text-muted font-10">TZS</sup></th>
                                                    <th class="text-center">Arrers Age </th>
                                                    <th class="text-center">Total Arrear Penalty <sup class="text-muted font-10">TZS</sup></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">TUMAINI PENSION FUND</td>
                                                    <td class="text-center">{{date('M Y', strtotime($arrearDetails->arrear_period))}}</td>
                                                    <td class="text-center">{{$arrearDetails->totalContributors($arrearDetails->section_id)}}</td>
                                                    <td class="text-center">{{$arrearDetails->totalMembers($arrearDetails->section_id)}}</td>
                                                    <td class="text-center">{{number_format($arrearDetails->arrearTotalContributionExpected($arrearDetails->section_id, $arrearDetails->arrear_period),2)}}</td>
                                                    <td class="text-center">{{$arrearDetails->arrearAge($arrearDetails->id, $arrearPeriod)}} <sup class="text-muted"><small>Days</small></sup></td>
                                                    <td class="text-center text-danger ">{{number_format($arrearDetails->arrearTotalPenaltyExpected($arrearDetails->arrearTotalContributionExpected($arrearDetails->section_id, $arrearDetails->arrear_period),$arrearDetails->id, $arrearPeriod),2)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-12">
                                <h4 class="header-title mb-3 text-muted">Members Arrears</h4>
                                <div class="table-responsive">
                                    <table class="datatable-buttons table font-11 table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:15%;">Contributor</th>
                                                <th style="width:18%;">Member Name</th>
                                                <th style="width:10%;">Monthly Income <sup class="text-muted font-10">TZS</sup></th>
                                                <th style="width:10%;">Amount <sup class="text-muted font-10">Contributor TZS</sup></th>
                                                <th style="width:10%;">Amount <sup class="text-muted font-10">Member TZS</sup></th>
                                                <th style="width:10%;">Total <sup class="text-muted font-10">TZS</sup></th>
                                                <th style="width:10%;">Arrear Penalty <sup class="text-muted font-10">TZS</sup></th>
                                                <th style="width:5%;">Status</th>
                                                <th style="width:5%;">
                                                    <div class="row pl-2"> 
                                                        <div class="col-4 pl-2"> 
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input sectionArrearCheckBoxParent" id="customCheck1" name="confirmMembers[]">
                                                                <label class="custom-control-label" for="customCheck1"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-8">Action</div>
                                                    </div>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $n=2; $counter = 1; @endphp
                                            @foreach( $arrearDetailsData AS $arrearData )
                                            @php 
                                            $totalMemberContribution = $arrearData->getMemberContributionAmount( $arrearData->contributor_id, $arrearData->member_id ) + $arrearData->getContributorContributionAmount( $arrearData->contributor_id, $arrearData->member_id ); 
                                            $totalMemberArrearPenalty = $arrearData->totalMemberArrearPenaltyExpected($totalMemberContribution, $arrearData->arrear_id, $arrearPeriod);
                                            if($arrearData->status=="ACTIVE"){ $badgeText = "info";}else if ( $arrearData->status=="ON PAYMENT"){ $badgeText = "primary"; }elseif($arrearData->status == "CLOSED"){ $badgeText = "success"; }else{$badgeText = "danger";}
                                            @endphp
                                            <tr>
                                                <td>{{$counter}}.</td>
                                                <td class="font-9 px-0">{{$arrearData->contributor->name}}</td>
                                                <td> {{$arrearData->member->fname.' '.$arrearData->member->mname.' '.$arrearData->member->lname}}</td>
                                                <td> {{number_format( $arrearData->getMemberMonthlyIncome( $arrearData->member_id ), 2 )}}</td>
                                                <td> {{number_format( $arrearData->getContributorContributionAmount( $arrearData->contributor_id, $arrearData->member_id ), 2 )}}</td>
                                                <td> {{number_format( $arrearData->getMemberContributionAmount( $arrearData->contributor_id, $arrearData->member_id ), 2 )}}</td>
                                                <td> {{number_format( ($totalMemberContribution), 2 )}}</td>
                                                <td class="text-danger text-center"> {{number_format( $totalMemberArrearPenalty,2)}}</td>
                                                <td> <span class="badge badge-outline-{{$badgeText}}">{{$arrearData->status=='SUSPENDED'?'WAIVED':$arrearData->status}}</span></td>
                                                <td class="py-1">
                                                    <div class="btn-group dropdown float-right">
                                                        @if($arrearData->status !='SUSPENDED' && $arrearData->status !='CLOSED')
                                                            <a class="btn btn-light btn-xs">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input memberArrearCheckBox" id="customCheck{{$n}}" value="{{$arrearData->id}}" name="selectedMembers[]">
                                                                    <label class="custom-control-label" for="customCheck{{$n}}"></label>
                                                                </div>
                                                            </a>
                                                        @endif

                                                        <a href="#" class="dropdown-toggle arrow-none text-muted btn btn-light btn-xs" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="mdi mdi-dots-horizontal font-18"></i>
                                                        </a>

                                                        @if($arrearData->processing_status=='ACTIVE')
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="javascript:void(0)"; class="dropdown-item payMemberArrearPenalty" data-arrearDetailID="{{$arrearData->id}}" data-arrearPenaltyAmount="{{$totalMemberArrearPenalty}}" data-contributorName="{{$arrearData->contributor->name}}" data-memberName="{{$arrearData->member->fname.' '.$arrearData->member->mname.' '.$arrearData->member->lname}}">
                                                                    <i class='flaticon-give-money-1 mr-1 font-18'></i><span>Pay Member Arrear Penalty</span>
                                                                </a>
                                                            </div> <!-- end drop down menu-->
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $n++; $counter++; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 px-3 pt-2 waiveActionBlock">
                                @if($action=='WAIVE MEMBER ARREAR')
                                <a href="javascript:void(0);" class="btn btn-info waves-effect waves-light float-right memberWaiveAcciton" data-actionTitle="Member Arrear Penalty Waive" data-actionIntro="Waive Member Arrear Penalties" data-toggle="modal" data-target="#actionProcessing">Submit Member Arrear Penalty Waive</a>
                                @endif

                                <!-- Start:: Warning Alert Modal -->
                                <div id="actionProcessing" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-body p-4">
                                                <div class="text-center">
                                                    <i class="dripicons-warning h1 text-warning"></i>
                                                    <h4 class="mt-2">Confirm <span class="modalTitleSpan text-info"></span></h4>
                                                    <p class="mt-3">Are you sure! <br> You are about to <span class="modalIntroSpan text-info"></span>. You can cancel to review arrear to review </p>
                                                    <input type="hidden" name="totalMembers" value="{{$counter-1}}" required>

                                                    @if ($errors->memberArrearPenaltyWaive->has('selectedMembers')) <span class="text-danger" role="alert"> <strong>{{ $errors->memberArrearPenaltyWaive->first('selectedMembers') }}</strong></span>@endif
                                                </div>
                                                <button type="submit" class="btn btn-success my-2 float-left">Yes! Submit</button>
                                                <button type="button" class="btn btn-danger my-2 float-right" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- End:: Warning Alert Modal -->
                            </div> <!-- end col -->

                            <div class="col-12 arrearPenaltyPayementBlock" style="display:none;">
                                <h4 class="header-title mb-3 text-muted">Transaction Proofs</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field-4" class="control-label">Total Arrear Paid  <span class="text-danger">*</span></label>
                                                    <input type="text" name="contributionAmount" id="contributionAmount" class="form-control form-control-sm totalContributionInput contriInput autonumber" value="{{old('contributionAmount' )}}" id="field-4" placeholder="Total Contribution">
                                                    <span class="text-danger" role="alert"> {{ $errors->first('contributionAmount') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field-4" class="control-label">Payment Date  <span class="text-danger">*</span></label>
                                                    <input type="text" name="paymentDate" id="basic-datepicker" data-date-format="d M, Y" class="form-control form-control-sm contriInput" value="{{old('paymentDate')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Pick Payment Date">
                                                    <span class="text-danger" role="alert"> {{ $errors->first('paymentDate') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field-1" class="control-label">Payment Mode  <span class="text-danger">*</span></label>
                                                    <select class="form-control contriInput" name="paymentMode" data-toggle="select2">
                                                        @foreach($paymentMode as $value)
                                                        <option value="{{$value->id}}" {{old ('paymentMode') == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" role="alert"> {{ $errors->first('paymentMode') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field-4" class="control-label">Transaction Reference  <span class="text-danger">*</span></label>
                                                    <input type="text" name="transactionReference" id="transaction" class="form-control form-control-sm contriInput" value="{{old('transaction')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Transaction Reference">
                                                    <span class="text-danger" role="alert"> {{ $errors->first('transactionReference') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="field-3" class="control-label">Transaction Proof  <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control kartik-input-705 kv-fileinput-dropzone contriInput" name="transactionProof" id="field-4" required>
                                                <span class="text-danger" role="alert"> {{ $errors->first('transactionProof') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-info waves-effect waves-light float-right">Submit Arrear Penalty Pay</button>
                                    </div>
                                </div>
                            </div>
                    </div> <!-- end row -->

                        </form>
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

<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.js')}}"></script>

<script type="text/javascript">
    //START:: Suspend  Member Contribution
    $('.waveArrear').click(function() {
        let rowID = $(this).attr('data-id');
        $('.memberContributionInput' + rowID).val('0.00');
        let newMemberContribution = $('.memberContributionInput' + rowID).val();
        let memberID = $(this).attr('data-memberID');
        let contributorID = $(this).attr('data-contributorID');
    });
    //END:: Suspend  Member Contribution 

</script>
@if($errors->hasBag('memberArrearPenaltyWaive'))
<script>
    $(document).ready(function() {
        $('#actionProcessing').modal({
            show: true
        });
    });

</script>
@endif

<script>
    $('.sectionArrearCheckBoxParent').on('click', function() {
        if ($(this).is(':checked')) {
            $('.memberArrearCheckBox').prop('checked', true);

            $('.waiveBulkArrears').show();
        } else {
            $('.memberArrearCheckBox').prop('checked', false);

            $('.waiveBulkArrears').hide();
        }
    });

    $('.memberArrearCheckBox').on('click', function() {
        if ($('.memberArrearCheckBox').is(':checked')) {
            // At least one checkbox is checked
            $('.sectionArrearCheckBoxParent').prop('checked', true);
            $('.waiveBulkArrears').show();
        } else {
            // No checkbox is checked
            $('.waiveBulkArrears').hide();
            $('.sectionArrearCheckBoxParent').prop('checked', false);
        }
    });


$('.memberWaiveAcciton').on('click', function(){
    $('.modalTitleSpan').html($(this).attr('data-actionTitle'));
    $('.modalIntroSpan').html($(this).attr('data-actionIntro'));
});
</script>
@endsection
