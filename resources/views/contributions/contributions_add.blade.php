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
                            <li class="breadcrumb-item active">Add Contribution</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Add Contributions</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <!-- end row-->

        <form id="contributionForm" method="POST" action="{{url('contributions/add/submit')}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="header-title mb-3 text-muted">Contribution Filters</h4>
                                <div class="col-12"> </div>
                                <div class="row px-3">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="field-3" class="control-label">Section <span class="text-danger">*</span></label>
                                            <select class="form-control sectionSelect" name="section" data-toggle="select2">
                                                <option value="0"> -- Select Section --</option>
                                                @foreach($sections as $value)
                                                <option value="{{$value->id}}" {{old ('section') == $value->id ? 'selected' : ''}}>{{'District: '.$value->district->name.' Section: '.$value->name}} </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger font-9" role="alert" id="sectionError"> {{ $errors->first('section') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">Contribution Date <span class="text-danger">*</span></label>
                                            <input type="text" name="contributionDate" class="form-control form-control-sm p-1 contributionDate" value="{{old('contributionDate')}}" data-provide="datepicker" data-date-autoclose="true" data-date-format="M yyyy" data-date-min-view-mode="1" data-date-end-date="0d" data-date-orientation="bottom" onkeydown="return false" placeholder="Pick Contribution Date">
                                            <span class="text-danger font-9" role="alert" id="contributionDateError"> {{ $errors->first('contributionDate') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label mt-3"><br></label>
                                            <button type="button" class="btn btn-sm btn-success mt-2 waves-effect waves-light searchButton"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- container -->
                </div> <!-- content -->
                <!-- end .table-responsive-->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                            <div class="row reconciliationBlock">
                                <h4 class="header-title mb-3 text-muted">Reconciliation Panel </h4>

                                <div class="col-12 mb-3 border rounded p-2" style="background-color: #f6fcff;">
                                    <div class="row">
                                        <div class="col-sm-8"><strong>Section Name:</strong> <span id="sectionName"></span></div>
                                        <div class="col-sm-4"> <strong>Section Code:</strong> <span id="sectionCode"></span></div>

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
                                                            <td class="text-center"><span id="contributionDate"></span></td>
                                                            <td class="text-center"><span id="no_contributorsSpan"></span><input type="hidden" value="" name="totalContributors" id="no_contributorsInput"></td>
                                                            <td class="text-center"><span id="no_membersSpan"></span><input type="hidden" value="" name="totalMembers" id="no_membersInput"></td>
                                                            <td class="text-center"><span class="monthlyContribution"></span></td>
                                                            <td class="text-center"><span class="totalContribution"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- START:: Existing Contributions -->
                            <div class="row existingContrinbutionBlock" style="display:none; background-color: #fbfbfb;">
                                <div class="col-12 mb-3 border rounded p-2">
                                        <h4 class="header-title mb-3 text-muted">Posted Contributions </h4>
                                        <div class="table-responsive">
                                            <table class="existing_contrinbution_recon_table table table-sm font-11 table-bordered table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th class="text-center">Section</th>
                                                        <th class="text-center">Contribution Month</th>
                                                        <th class="text-center">Contributors</th>
                                                        <th class="text-center">Members</th>
                                                        <th class="text-center">Total Contribution <sup class="text-muted font-10">TZS</sup></th>
                                                        <th class="text-center">Process Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody> </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-2">
                                            <a href="javascript:void(0);" class="btn btn-success my-2 float-right addContribution">Add Another Contribution</a>
                                            {{-- <a href="javascript:void(0);" class="btn btn-warning my-2 float-right mr-2">Cancel</a> --}}
                                        </div>
                                </div>
                            </div>
                            <!-- END:: Existing Contributions -->
                            <!-- START:: blocked New Transaction -->
                            <div class="row addNewContributoionErrorBlock"  style="display:none;">
                                 <div class="col-12 alert alert-danger" role="alert">
                                        <i class="mdi mdi-block-helper mr-2"></i> <span class="addNewContributoionErrorSpan"></span>
                                </div>
                            </div>
                            <!-- END:: blocked New Transaction -->

                            <!-- START:: noDataErrorBlock-->
                            <div class="row noDataErrorBlock"  style="display:none;">
                                 <div class="col-12 alert alert-danger" role="alert">
                                        <i class="mdi mdi-block-helper mr-2"></i> <strong>No data found! </strong> <span class="noDataErrorSpan"></span>
                                </div>
                            </div>
                            <!-- END:: noDataErrorBlock-->

                            <div class="row newContributionBlock" style="display:none;">
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
                                            <tbody></tbody>
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
                                                    <input type="text" name="contributionAmount" id="contributionAmount" class="form-control form-control-sm totalContributionInput contriInput autonumber" value="{{old('contributionAmount')}}" id="field-4" placeholder="Total Contribution">
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
                                                <input type="file" class="form-control kartik-input-705 kv-fileinput-dropzone contriInput" name="transactionProof" id="field-4" placeholder="District" required>
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
                                                    <h4 class="mt-2">Confirm Contribution Submission</h4>
                                                    <p class="mt-3">Are you sure! <br> You are about to submit Section Contribution. You can cancel to review contribtions before submission</p>
                                                </div>
                                                <button type="submit" class="btn btn-success my-2 float-left">Yes! Submit</button>
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

<script type="text/javascript">
$('.addContribution').on('click', function(){ // adding new contribution
    $('.existingContrinbutionBlock').hide();
    $('.reconciliationBlock').show();
    $('.newContributionBlock').show();
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        loadingSectionContributorsMembers();
    });

    $('.sectionSelect').change(function() {
        if ($('.contributionDate').val() !== '') {
            loadingSectionContributorsMembers();
        } else {
            $('#contributionDateError').html('Kindly, Pick Date');
        }
    });

    $('.contributionDate').change(function() {
        var section_id = $('.sectionSelect').find(":selected").val();
        if (section_id > 0) {
            loadingSectionContributorsMembers();
        } else {
            $('#sectionError').html('Kindly, Select Section');
        }
    });

    $(".searchButton").click(function() {
        loadingSectionContributorsMembers();
    });

    function loadingSectionContributorsMembers() {
        var section_id = $('.sectionSelect').find(":selected").val();
        var contribution_date = $('.contributionDate').val();
        if (section_id !== 0 && contribution_date !== "") {

            $('#contributionDate').html(contribution_date);

            $("#sectionError").html('');
            $("#contributionDateError").html('');

            $.ajax({
                url: "{{url('/ajax/get/section/contribution/data')}}"
                , type: 'POST'
                , data: {
                    section_id: section_id
                    , contribution_date: contribution_date
                    , _token: '{{ csrf_token() }}'
                }
                , dataType: 'json'
                , success: function(response) {
                    //Start:: check old contribution first
                    if(response.sectionContributionDataArr.oldContributions!==''){
                        $('.addNewContributoionErrorBlock').hide();

                        // START:: control new contributio entry
                             $('.addContribution').show();
                            if(response.sectionContributionDataArr.onProcessContributions > 0){
                                $('.addNewContributoionErrorSpan').html('You still have <b>Unattended Contribution(s)</b> on the same <b>Contribtuion Period</b> Kindly! Process it to be able to add a new contribution.');
                                $('.addNewContributoionErrorBlock').show();
                                $('.addContribution').hide(); // prevent Adding new contribution
                            }

                        // END:: control new contributio entry

                        $('.noDataErrorBlock').hide();
                        $(".existing_contrinbution_recon_table tbody").empty();
                        $(".existing_contrinbution_recon_table").prepend(response.sectionContributionDataArr.oldContributions);

                        //Start:: block display control
                        $('.existingContrinbutionBlock').show();
                        $('.newContributionBlock').hide();
                        $('.reconciliationBlock').hide();
                        //End:: block display control

                    }else{
                        //Start:: block display control
                        $('.existingContrinbutionBlock').hide();
                        $('.newContributionBlock').show();
                        $('.addNewContributoionErrorBlock').hide();
                        //End:: block display control
                    }
                    //End:: check old contribution first

                    if (response.sectionContributionDataArr.memberList !== "") {
                        $('.noDataErrorBlock').hide();
                        $('.reconciliationBlock').show();
                        //Start:: put section Data
                        $('#sectionName').html(response.sectionContributionDataArr.sectionData.name);
                        $('#sectionCode').html(response.sectionContributionDataArr.sectionData.section_code);
                        $('#no_contributorsSpan').html(response.sectionContributionDataArr.totalContributors);
                        $('#no_membersSpan').html(response.sectionContributionDataArr.totalMembers);
                        $('#no_membersInput').val(response.sectionContributionDataArr.totalMembers);
                        $('#no_contributorsInput').val(response.sectionContributionDataArr.totalContributors);
                        //End:: put section Data

                        $(".new_contrinbution_recon_table tbody").empty();
                        $(".new_contrinbution_recon_table").prepend(response.sectionContributionDataArr.memberList);

                        calculateItems(); // Prior Items Caluculation

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

                    } else {
                        $('.reconciliationBlock').hide();
                        $('.noDataErrorSpan').html(' Section has neither Contributors nor members assigned on a specified date.');
                        $('.noDataErrorBlock').show();
                        $('.existingContrinbutionBlock').hide();
                        $('.newContributionBlock').hide();
                    }
                }
            });

        }else{
            $('.reconciliationBlock').hide();
            $('.noDataErrorSpan').html(' Kindly, select <b>Section</b> and pick <b>Contribtuion Period</b> to get the data.');
            $('.noDataErrorBlock').show();
            $('.existingContrinbutionBlock').hide();
            $('.newContributionBlock').hide();
        }
    }

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
