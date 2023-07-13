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
                            <li class="breadcrumb-item active">View Arrear</li>
                        </ol>
                    </div>
                    <h4 class="page-title">View Arrear</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                            <div class="row">
                                <h4 class="header-title mb-3 text-muted">Details Panel </h4>

                                <div class="col-12 mb-3 border rounded p-2" style="background-color: #f6fcff;">
                                    <div class="row">
                                        <div class="col-sm-8"><strong>Section Name:</strong> <span id="sectionName">{{$arrearDetails->section->name}}</span></div>
                                        <div class="col-sm-4"><strong>Section Code:</strong> <span id="sectionCode">{{$arrearDetails->section->section_code}}</span></div>

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
                                                            <td class="text-center">{{date('M, Y', strtotime($arrearDetails->arrear_period))}}</td>
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
                            <h4 class="header-title mb-3 text-muted">Members Arrears </h4>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="btn-editable" class="new_contrinbution_recon_table table table-sm font-11 table-striped w-100 table-responsible">
                                            <thead>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:15%;">Contributor</th>
                                                    <th style="width:18%;">Member Name</th>
                                                    <th style="width:10%;">Monthly Income <sup class="text-muted font-10">TZS</sup></th>
                                                    <th style="width:10%;">Contributor <sup class="text-muted font-10">TZS</sup></th>
                                                    <th style="width:10%;">Member <sup class="text-muted font-10">TZS</sup></th>
                                                    <th style="width:10%;">Total <sup class="text-muted font-10">TZS</sup></th>
                                                    <th style="width:10%;">Arrear Penalty <sup class="text-muted font-10">TZS</sup></th>
                                                    <th style="width:5%;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $counter = 1; @endphp
                                            @foreach( $arrearDetailsData AS $arrearData )
                                            @php 
                                            $totalMemberContribution = $arrearData->getMemberContributionAmount( $arrearData->contributor_id, $arrearData->member_id ) + $arrearData->getContributorContributionAmount( $arrearData->contributor_id, $arrearData->member_id ); 
                                            
                                            if($arrearData->status=="ACTIVE"){ $badgeText = "info";}else if ( $arrearData->status=="ON PAYMENT"){ $badgeText = "primary"; }elseif($arrearData->status == "CLOSED"){ $badgeText = "success"; }else{$badgeText = "danger";}
                                            @endphp
                                                <tr>
                                                    <td> {{$counter}} </td>
                                                    <td class="font-9 px-0">{{$arrearData->contributor->name}}</td>
                                                    <td> {{$arrearData->member->fname.' '.$arrearData->member->mname.' '.$arrearData->member->lname}}</td>
                                                    <td> {{number_format( $arrearData->getMemberMonthlyIncome( $arrearData->member_id ), 2 )}}</td>
                                                    <td> {{number_format( $arrearData->getContributorContributionAmount( $arrearData->contributor_id, $arrearData->member_id ), 2 )}}</td>
                                                    <td> {{number_format( $arrearData->getMemberContributionAmount( $arrearData->contributor_id, $arrearData->member_id ), 2 )}}</td>
                                                    <td> {{number_format( $totalMemberContribution, 2 )}}</td>
                                                    <td class="text-danger text-center"> {{number_format( $arrearData->totalMemberArrearPenaltyExpected($totalMemberContribution, $arrearData->arrear_id, $arrearPeriod),2)}}</td>
                                                    <td> <span class="badge badge-outline-{{$badgeText}}">{{$arrearData->status == 'SUSPENDED'?'WAIVED':$arrearData->status}}</span></td>
                                                </tr>
                                            @php $counter++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- end row -->

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

        $('.memberContributionInput'+rowID).val('0.00');
        let newMemberContribution = $('.memberContributionInput'+rowID).val();
        let memberID      = $(this).attr('data-memberID');
        let contributorID = $(this).attr('data-contributorID');
    });
    //END:: Suspend  Member Contribution
</script>
@endsection
