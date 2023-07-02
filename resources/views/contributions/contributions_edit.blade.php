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
        <!-- end row-->

        <form id="contributionForm" method="POST" action="{{url('contributions/submit/edit/'.$contributionData->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                            <div class="row">
                                <h4 class="header-title mb-3 text-muted">Details Panel </h4>

                                <div class="col-12 mb-3 border rounded p-2" style="background-color: #f6fcff;">
                                    <div class="row">
                                        <div class="col-sm-8"><strong>Section Name:</strong> <span id="sectionName">{{$contributionData->section->name}}</span></div>
                                        <div class="col-sm-4"> <strong>Section Code:</strong> <span id="sectionCode">{{$contributionData->section->section_code}}</span></div>

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
                                                            <th class="text-center">Total Contribution <sup class="text-muted font-10">TZS</sup></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">TUMAINI PENSION FUND</td>
                                                            <td class="text-center"><span id="contributionDate">{{date('M Y', strtotime($contributionData->contribution_period))}}</span></td>
                                                            <td class="text-center"><span id="no_contributorsSpan">{{$contributionData->total_contributors}}</span><input type="hidden" value="{{$contributionData->total_contributors}}" name="totalContributors" id="no_contributorsInput"></td>
                                                            <td class="text-center"><span id="no_membersSpan">{{$contributionData->total_members}}</span><input type="hidden" value="{{$contributionData->total_members}}" name="totalMembers" id="no_membersInput"></td>
                                                            <td class="text-center"><span class="monthlyContribution">{{number_format($contributionData->contribution_amount,2)}}</span></td>
                                                            <td class="text-center"><span class="totalContribution">{{number_format($contributionData->contribution_amount,2)}}</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <h4 class="header-title mb-3 text-muted">Member Contributions </h4>
                            <div class="col-12">
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
                                                    <th style="width:10%;">Topup <sup class="text-muted font-10">TZS</sup></th>
                                                    <th class="text-center" style="width:10%;">Total <sup class="text-muted font-10">TZS</sup></th>
                                                    <th style="width:5%;">Status</th>
                                                    <th style="width:4%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php  $counter = 1; @endphp

                                            @foreach( $contributionDetail AS $memberData )
                                               
                                                    <tr>
                                                    <td>{{$counter}}</td>
                                                        <td class="font-9 px-0">{{$memberData->contributor->name}}<input type="hidden" name="contributor[]" value="{{$memberData->contributor_id}}"></td>
                                                        <td>{{$memberData->member->fname.' '.$memberData->member->mname.' '.$memberData->member->lname}}<input type="hidden" name="member[]" value="{{$memberData->member_id}}"></td>
                                                        <td> <span class="monthlyIncomeSpan{{$counter}}">{{number_format( $memberData->getMemberMonthlyIncome( $memberData->member_id ), 2 )}}</span> <input type="hidden" class="monthlyIncomeInput{{$counter}}" data-id="{{$counter}}" name="memberMonthlyIncome[]" value="{{number_format( $memberData->getMemberMonthlyIncome( $memberData->member_id ), 2 )}}" required>  <input type="hidden" class="contributorMonthlyIncomeInput{{$counter}}" data-id="{{$counter}}" name="contributorMonthlyIncome[]" value="{{$memberData->getContributorMonthlyIncome( $memberData->contributor_id )}}" required></td>
                                                        <td> <span class="contributorContributionSpan{{$counter}}">{{number_format( $memberData->getContributorContributionAmount( $memberData->contributor_id, $memberData->member_id ), 2 )}}</span> <input type="hidden" class="contributorContributionInput{{$counter}} col-sm-12 px-1 border-1 border-light rounded contributorContrInput autonumber" data-id="{{$counter}}" data-memberID="{{$memberData->member_id}}" data-contributorID="{{$memberData->contributor_id}}" name="contributorContribution[]" value="{{$memberData->getContributorContributionAmount( $memberData->contributor_id, $memberData->member_id )}}" required></td>
                                                        <td> <input type="text" class="memberContributionInput{{$counter}} col-sm-12 px-1 border-1 border-light rounded memberContrInput autonumber" data-id="{{$counter}}" data-memberID="{{$memberData->member_id}}" data-contributorID="{{$memberData->contributor_id}}" name="memberContribution[]" value="{{number_format( $memberData->getMemberContributionAmount( $memberData->contributor_id, $memberData->member_id ), 2 )}}" required></td>
                                                        <td> <input type="text" class="topupInput{{$counter}} col-sm-12 px-1 border-1 border-light rounded contrInputsTopup autonumber" data-id="{{$counter}}" data-memberID="{{$memberData->member_id}}" data-contributorID="{{$memberData->contributor_id}}" name="topup[]" value="{{number_format( 0, 2 )}}" required></td>
                                                        <td class="text-center"> <span class="totalSpan{{$counter}}">{{number_format( ($memberData->getMemberContributionAmount( $memberData->contributor_id, $memberData->member_id )+$memberData->getContributorContributionAmount( $memberData->contributor_id, $memberData->member_id )), 2 )}}</span> <input type="hidden" class="total totalInput{{$counter}} border-light rounded" data-id="{{$counter}}" name="total[]" value="{{number_format( ($memberData->getMemberContributionAmount( $memberData->contributor_id, $memberData->member_id )+$memberData->getContributorContributionAmount( $memberData->contributor_id, $memberData->member_id )), 2 )}}" required></td>
                                                        <td> <span id="status{{$counter}}" class="badge badge-outline-{{$memberData->status == 'ACTIVE'?'success':'danger';}} badge-pill">{{$memberData->status}}</span></td>
                                                        <td>
                                                            <div class="float-right">
                                                                <a href="javascript:void(0);" class="text-blue btn btn-light btn-sm suspendContribution editButton{{$counter}}"  data-id="{{$counter}}" data-memberID="{{$memberData->member_id}}" data-contributorID="{{$memberData->contributor_id}}" aria-expanded="false" data-rowID="{{$counter}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Suspend User Contribution">
                                                                    <i class="mdi mdi-close-thick mr-1"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                            @php  $counter++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <h4 class="header-title mb-3 text-muted">Transaction Proofs</h4>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="field-4" class="control-label">Total Contribution Amount  <span class="text-danger">*</span></label>
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
        </form>
    </div> <!-- end col -->
</div>
<!-- end row -->
</div> <!-- container -->
</div> <!-- content -->
@endsection
@section('custom_script')

<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.js')}}"></script>

<script>
  $(document).ready(function() {
        var initpriview = "{{$paymentProofArr['filePath']}}";
        var fileName = "{{$paymentProofArr['fileName']}}";
        var fileSize = "{{$paymentProofArr['fileSize']}}";
        if(fileSize > 0){
            $(".kartik-input-705").fileinput({
                theme: "explorer",
                uploadUrl: "#",
                allowedFileExtensions: ['jpg', 'jpeg','png', 'gif', 'pdf'],
                showUpload : false,
                showCancel : false,
                showRemove : false,
                initialPreview: [initpriview],
                initialPreviewAsData: true,
                fileActionSettings: {
                    showUpload:false,
                    showRemove:true,
                },
                initialPreviewConfig: [{ type:"pdf",caption:fileName, downloadUrl:initpriview, description: fileName, size:fileSize, width: "120px"}],
                overwriteInitial: true,
                maxFileSize: 2000,
            });

        }else{

            $(".kartik-input-705").fileinput({
                theme: "explorer",
                uploadUrl: '#',
                allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif', 'PDF'],
                overwriteInitial: true,
                initialPreviewAsData: true,
                maxFileSize: 2000,
                maxTotalFileCount: 1,
                showUpload: false,
                showCancel: false,
                showRemove: false,
                fileActionSettings: {
                    showUpload: false,
                    showRemove: true,
                },
            });
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        calculateItems();
    });


    //Start:: Contribution Inputs
    $('.memberContrInput').on('keyup', function() {
        let rowID = $(this).attr('data-id');
        let newMemberContribution = $(this).val();
        let memberID      = $(this).attr('data-memberID');
        let contributorID = $(this).attr('data-contributorID');
        
        reverseContributioComputation(rowID,newMemberContribution,memberID, contributorID);
    });
    //End:: Contribution Inputs

    //Start:: contrInputsTopup edit
    $('.contrInputsTopup').on('keyup', function() {
        var rowID = $(this).attr('data-id');
        var topupVal = parseInt($(this).val().replace(/,/g, ''), 10);
        var memberContributionInput = parseInt(($('.memberContributionInput' + rowID).val()).replace(/,/g, ''), 10);
        var contributorContributionInput = parseInt(($('.contributorContributionInput' + rowID).val()).replace(/,/g, ''), 10);
        var total = memberContributionInput + contributorContributionInput + topupVal;
        $('.totalSpan' + rowID).html(total.toLocaleString() + '.00');
        $('.totalInput' + rowID).val(total);

        calculateItems(); // reset all the values
    });
    //End:: contrInputsTopup edit

    //START:: Suspend  Member Contribution
    $('.suspendContribution').click(function() {
        let rowID = $(this).attr('data-id');
        $('.memberContributionInput'+rowID).val('0.00');
        let newMemberContribution = $('.memberContributionInput'+rowID).val();
        let memberID      = $(this).attr('data-memberID');
        let contributorID = $(this).attr('data-contributorID');

        reverseContributioComputation(rowID,newMemberContribution,memberID, contributorID);

    });
    //END:: Suspend  Member Contribution


    //START:: reverser Computation
    function reverseContributioComputation(rowID,newMemberContribution,memberID, contributorID){
            //START:: reverse computation
            $.ajax({
                    url: "{{url('/ajax/compute/edit/membercontribution')}}",
                    type: 'POST',
                    data: {
                        newContribution: parseInt(newMemberContribution.replace(/,/g, ''), 10),
                        memberID: memberID,
                        contributorID: contributorID,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        var topupValue = parseInt($('.topupInput'+rowID).val().replace(/,/g, ''), 10);
                        var memberContribution = parseInt(newMemberContribution.replace(/,/g, ''), 10);
                        // var contributorMonthlyIncome = response.getContributionStructure.contributor_monthly_income;
                        var contributorContribution = response.getContributionStructure.contributor_contribution;

                        var total = memberContribution+contributorContribution+topupValue;
                        
                        $('.monthlyIncomeSpan'+rowID).html((response.getContributionStructure.monthly_income).toLocaleString() + '.00');
                        $('.monthlyIncomeInput'+rowID).html(response.getContributionStructure.monthly_income);
                        $('.memberContributionInput'+rowID).html();
                        
                        $('.contributorContributionSpan'+rowID).html(contributorContribution.toLocaleString() + '.00');
                        $('.contributorContributionInput'+rowID).val(contributorContribution);
                        $('.totalSpan'+rowID).html(total.toLocaleString() + '.00');
                        $('.totalInput'+rowID).val(total); 

                        calculateItems(); // Prior Items Caluculation
                    }
                });
            //START:: reverse computation
    }
    //END:: reverser Computation

    function suspendMemberContribution(rowID) {
        $('.memberContributionInput' + rowID).val(0.00);
        var a = parseInt($('.contributorContributionInput' + rowID).val().replace(/,/g, ''), 10);
        var b = parseInt($('.topupInput' + rowID).val().replace(/,/g, ''), 10);
        $('.totalInput' + rowID).val(a + b);
        $('.totalSpan' + rowID).html((a + b).toLocaleString() + '.00');

        calculateItems(); // reset all the values
    }

    function calculateItems() {
        var totalMemberContribution = 0;
        $(".total").each(function() {
            if ($(this).val() !== "") {
                totalMemberContribution += parseInt($(this).val().replace(/,/g, ''), 10);
            }
        });

        //putting a subtotal
        $('.monthlyContribution').html(totalMemberContribution.toLocaleString() + '.00');
        $('.totalContribution').html(totalMemberContribution.toLocaleString() + '.00');
        $('.totalContributionInput').val(totalMemberContribution.toLocaleString() + '.00');
    }
</script>
@endsection
