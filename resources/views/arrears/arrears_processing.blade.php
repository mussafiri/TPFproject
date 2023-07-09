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
                            <li class="breadcrumb-item active">Edit Contribution</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Contribution</h4>
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
                                                            <td class="text-center">{{number_format($arrearDetails->arrearTotalPenaltyExpected($arrearDetails->id, $arrearDetails->arrear_period),2)}}</td>
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
                                                    <th style="width:10%;">Amount <sup class="text-muted font-10">Contributor TZS</sup></th>
                                                    <th style="width:10%;">Amount <sup class="text-muted font-10">Member TZS</sup></th>
                                                    <th class="text-center" style="width:10%;">Total <sup class="text-muted font-10">TZS</sup></th>
                                                    <th style="width:10%;">Arrear Penalty <sup class="text-muted font-10">TZS</sup></th>
                                                    <th style="width:5%;">Status</th>
                                                    <th style="width:4%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $counter = 1; @endphp
                                            @foreach( $arearDetails AS $arrearData )
                                                <tr>
                                                    <td>{{$counter}}</td>
                                                    <td class="font-9 px-0">{{$arrearData->contributor->name}}</td>
                                                    <td> {{$arrearData->member->fname.' '.$arrearData->member->mname.' '.$arrearData->member->lname}}</td>
                                                    <td> {{number_format( $arrearData->getMemberMonthlyIncome( $arrearData->member_id ), 2 )}}</td>
                                                    <td> {{number_format( $arrearData->getContributorContributionAmount( $arrearData->contributor_id, $arrearData->member_id ), 2 )}}</td>
                                                    <td> {{number_format( $arrearData->getMemberContributionAmount( $arrearData->contributor_id, $arrearData->member_id ), 2 )}}</td>
                                                    <td> {{number_format( ($arrearData->getMemberContributionAmount( $arrearData->contributor_id, $arrearData->member_id )+$arrearData->getContributorContributionAmount( $arrearData->contributor_id, $arrearData->member_id )), 2 )}}</td>
                                                    <td> {{number_format( $arrearData->totalMemberArrearPenaltyExpected($arrearDetails->id, $arrearData->member_id, $$arrearDetails->arrear_period),2)}}</td>
                                                    <td> <span id="status{{$counter}}" class="badge badge-outline-{{$arrearData->status == 'ACTIVE'?'success':'danger';}} badge-pill">{{$arrearData->status}}</span></td>
                                                    <td> 
                                                        <div class="btn-group dropdown float-right">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck{{$n}}" name="confirmMembers[]">
                                                                <label class="custom-control-label" for="customCheck{{$n}}"></label>
                                                            </div>

                                                            <a href="#" class="dropdown-toggle arrow-none text-muted btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="mdi mdi-dots-horizontal font-18"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="javascript:void(0);" class="text-blue btn btn-light btn-sm waveArrear editButton{{$counter}}" data-memberID="{{$arrearData->member_id}}" aria-expanded="false" data-rowID="{{$counter}}" data-toggle="tooltip" data-placement="top" data-original-title="Waive ">
                                                                    <i class="mdi mdi-close-thick mr-1"></i>  Waive Penalty
                                                                </a> 
                                                            </div> <!-- end dropdown menu-->
                                                        </div>
                                                    </td>
                                                </tr>
                                            @php $counter++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 arrearPenaltyPayementBlock" style="display:none;">
                            <h4 class="header-title mb-3 text-muted">Transaction Proofs</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field-4" class="control-label">Total Arrear Paid  <span class="text-danger">*</span></label>
                                                    <input type="text" name="contributionAmount" id="contributionAmount" class="form-control form-control-sm totalContributionInput contriInput autonumber" value="{{old('contributionAmount',$contributionData->contribution_amount )}}" id="field-4" placeholder="Total Contribution">
                                                    <span class="text-danger" role="alert"> {{ $errors->first('contributionAmount') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field-4" class="control-label">Payment Date  <span class="text-danger">*</span></label>
                                                    <input type="text" name="paymentDate" id="basic-datepicker" data-date-format="d M, Y" class="form-control form-control-sm contriInput" value="{{old('paymentDate', date('M Y', strtotime($contributionData->contribution_period)))}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Pick Payment Date">
                                                    <span class="text-danger" role="alert"> {{ $errors->first('paymentDate') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field-1" class="control-label">Payment Mode  <span class="text-danger">*</span></label>
                                                    <select class="form-control contriInput" name="paymentMode" data-toggle="select2">
                                                        @foreach($paymentMode as $value)
                                                        <option value="{{$value->id}}" {{$contributionData->payment_mode_id==$value->id?'selected':''}} {{old ('paymentMode') == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" role="alert"> {{ $errors->first('paymentMode') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field-4" class="control-label">Transaction Reference  <span class="text-danger">*</span></label>
                                                    <input type="text" name="transactionReference" id="transaction" class="form-control form-control-sm contriInput" value="{{old('transaction', $contributionData->payment_ref_no)}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Transaction Reference">
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
                                </div>
                            </div>

                            <div class="col-md-12 px-3 pt-2">
                                <a href="javascript:void(0);" class="btn btn-info waves-effect waves-light float-right" data-toggle="modal" data-target="#contributionSubmisionAlert">Submit Contribution</a>

                                <!-- Start:: Warning Alert Modal -->
                                <div id="contributionSubmisionAlert" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-body p-4">
                                                <div class="text-center">
                                                    <i class="dripicons-warning h1 text-warning"></i>
                                                    <h4 class="mt-2">Confirm Contribution Edit Submission</h4>
                                                    <p class="mt-3">Are you sure! <br> You are about to submit Section Contribution. You can cancel to review contribtions before submission</p>
                                                </div>
                                                <button type="submit" class="btn btn-success my-2 float-left">Yes! Update</button>
                                                <button type="button" class="btn btn-danger my-2 float-right" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- End:: Warning Alert Modal -->

                            </div> <!-- end col -->
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
