
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
                                                                <label for="field-3" class="control-label">Section</label>
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
                                                                <label for="field-1" class="control-label">Contribution Date</label>
                                                                <input type="text" name="contributionDate" class="form-control form-control-sm p-1 contributionDate" value="{{old('contributionDate')}}"  data-provide="datepicker" data-date-autoclose="true" data-date-format="M yyyy"  data-date-min-view-mode="1" placeholder="Pick Contribution Date">
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
                                        <div class="row">
                                            <h4 class="header-title mb-3 text-muted">Reconciliation Panel </h4>

                                            <div class="col-12 mb-3 border rounded p-2" style="background-color: #f6fcff;">
                                                <div class="row">
                                                    <div class="col-sm-8"><strong>Section Name:</strong> <span id="sectionName"></span></div> <div class="col-sm-4"> <strong>Section Code:</strong> <span id="sectionCode"></span></div>

                                                    <div class="col-sm-12 mt-2">
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-bordered table-centered mb-0">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th>Scheme</th>
                                                                        <th>Contribution Date</th>
                                                                        <th>Contributors</th>
                                                                        <th>Members</th>
                                                                        <th>Monthly Contribution <sup class="text-muted font-10">TZS</sup></th>
                                                                        <th>Total Contribution <sup class="text-muted font-10">TZS</sup></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>TUMAINI PENSION FUND</td>
                                                                        <td class="text-center"><span id="contributionDate"></span></td>
                                                                        <td class="text-center"><span id="no_contributors"></span><input type="hidden" value="" name="totalContributors" id="totalContributors"></td>
                                                                        <td class="text-center"><span id="no_members"></span><input type="hidden" value="" name="totalMembers" id="totalMembers"></td>
                                                                        <td class="text-center"><span class="monthlyContribution"></span></td>
                                                                        <td class="text-center"><span class="totalContribution"></span></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h4 class="header-title mb-3 text-muted">Member Contributions </h4>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <table id="btn-editable" class="contrinbution_recon_table table table-sm font-11 table-striped w-100 table-responsible">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:3%;">#</th>
                                                                    <th style="width:19%;">Contributor</th>
                                                                    <th style="width:18%;">Member Name</th>
                                                                    <th style="width:10%;">Monthly Income <sup class="text-muted font-10">TZS</sup></th>
                                                                    <th style="width:10%;">Amount <sup class="text-muted font-10">Member (TZS)</sup></th>
                                                                    <th style="width:10%;">Amount <sup class="text-muted font-10">Contributor (TZS)</sup></th>
                                                                    <th style="width:10%;">Topup <sup class="text-muted font-10">TZS</sup></th>
                                                                    <th style="width:10%;">Total <sup class="text-muted font-10">TZS</sup></th>
                                                                    <th style="width:6%;">Status</th>
                                                                    <th style="width:4%;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>

                                            <h4 class="header-title mb-3 text-muted">Transaction Proofs </h4>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="field-4" class="control-label">Total Contribution Amount</label>
                                                                    <input type="text" name="contributionAmount" id="contributionAmount" class="form-control form-control-sm totalContributionInput contriInput autonumber" value="{{old('contributionAmount')}}" oninput="this.value = this.value.toUpperCase()"  id="field-4" placeholder="Total Contribution">
                                                                    <span class="text-danger" role="alert"> {{ $errors->first('contributionAmount') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="field-4" class="control-label">Payment Date</label>
                                                                    <input type="text" name="paymentDate" id="basic-datepicker" data-date-format="d M, Y" class="form-control form-control-sm contriInput"  value="{{old('paymentDate')}}" oninput="this.value = this.value.toUpperCase()"  id="field-4" placeholder="Pick Payment Date" >
                                                                     <span class="text-danger" role="alert"> {{ $errors->first('paymentDate') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="field-1" class="control-label">Payment Mode</label>
                                                                    <select class="form-control contriInput" name="paymentMode" data-toggle="select2">
                                                                        @foreach($paymentMode as $value)
                                                                        <option  value="{{$value->id}}" {{old ('paymentMode') == $value->id ? 'selected' : ''}}>{{$value->name}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                   <span class="text-danger" role="alert"> {{ $errors->first('paymentMode') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="field-4" class="control-label">Transaction Reference</label>
                                                                    <input type="text" name="transactionReference" id="transaction" class="form-control form-control-sm contriInput"  value="{{old('transaction')}}" oninput="this.value = this.value.toUpperCase()"  id="field-4" placeholder="Transaction Reference" >
                                                                   <span class="text-danger" role="alert"> {{ $errors->first('transactionReference') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="field-3" class="control-label">Transaction Proof</label>
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
        <!-- Table Editable plugin-->
        <script src="../assets/libs/jquery-tabledit/jquery.tabledit.min.js"></script>

        <!-- Table editable init-->
        <script src="../assets/js/pages/tabledit.init.js"></script>

        <script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
        <script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.js')}}"></script>

<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 6000);
</script>

<script>


     $(".kartik-input-705").fileinput({
        theme: "explorer",
        uploadUrl: '#',
        allowedFileExtensions: ['jpg', 'jpeg','png', 'gif'],
        overwriteInitial: false,
        initialPreviewAsData: true,
        maxFileSize: 2000,
        maxTotalFileCount: 1,
        showUpload : false,
        showCancel : false,
        dropZoneTitle:'<span>Drag & Drop Proof File here to upload</span>',
        fileActionSettings: {
                showUpload: false,
                showRemove: true,
                },
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
    loadingSectionContributorsMembers();
});
$('.sectionSelect').change(function(){
    if($('.contributionDate').val()!==''){
        loadingSectionContributorsMembers();
    }else{
        $('#contributionDateError').html('Kindly, Pick Date');
    }
});

$('.contributionDate').change(function(){
    var section_id = $('.sectionSelect').find(":selected").val();
    if(section_id > 0){
        loadingSectionContributorsMembers();
    }else{
        $('#sectionError').html('Kindly, Select Section');
    }
});

$(".searchButton").click(function() {
    loadingSectionContributorsMembers();
});

function loadingSectionContributorsMembers(){
    var section_id = $('.sectionSelect').find(":selected").val();
    var contribution_date = $('.contributionDate').val();

        if (section_id !== 0 && contribution_date!== "") {
            $('#contributionDate').html(contribution_date);

            $("#sectionError").html('');
            $("#contributionDateError").html('');

            $.ajax({
                url: "{{url('/ajax/get/section/contribution/data')}}",
                type: 'POST',
                data: {
                    section_id: section_id,
                    contribution_date: contribution_date,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.sectionContributionDataArr.memberList !== "") {
                        //Start:: put section Data
                        $('#sectionName').html(response.sectionContributionDataArr.sectionData.name);
                        $('#sectionCode').html(response.sectionContributionDataArr.sectionData.section_code);
                        $('#no_contributors').html(response.sectionContributionDataArr.totalContributors);
                        $('#no_members').html(response.sectionContributionDataArr.totalMembers);
                        $('#no_contributors').html(response.sectionContributionDataArr.totalContributors);
                        $('#no_members').html(response.sectionContributionDataArr.totalMembers);
                        //End:: put section Data

                        $(".contrinbution_recon_table tbody").empty();
                        $(".contrinbution_recon_table").prepend(response.sectionContributionDataArr.memberList);

                        calculateItems(); // Prior Items Caluculation

                        //START:: Suspend  Member Contribution
                        $('.suspendContribution').click(function(){
                            var rowID=$(this).attr('data-rowID');
                            suspendMemberContribution(rowID);
                        });
                        //END:: Suspend  Member Contribution

                    } else {
                        alert('assss');
                    }
                }
            });

        }
}

function suspendMemberContribution(rowID){
    $('.memberContributionInput'+rowID).val(0);
    var a = parseInt($('.contributorContributionInput'+rowID).val().replace(/,/g, ''), 10);
    var b = parseInt($('.topupInput'+rowID).val().replace(/,/g, ''), 10);
    $('.totalInput'+rowID).val(a+b);
    $('.totalSpan'+rowID).html((a+b).toLocaleString()+'.00');

    calculateItems(); // reset all the values
}

function calculateItems(){
    var totalMemberContribution = 0;
    $(".total").each(function() {
        if ($(this).val() !== ""){
            totalMemberContribution += parseInt($(this).val().replace(/,/g, ''), 10);
        }
    });

    //putting a subtotal
    //alert('monthlyContribution ====> '+totalMemberContribution);
    $('.monthlyContribution').html(totalMemberContribution.toLocaleString()+'.00');
    $('.totalContribution').html(totalMemberContribution.toLocaleString()+'.00');
    $('.totalContributionInput').val(totalMemberContribution.toLocaleString()+'0.00');
}
</script>

@endsection
