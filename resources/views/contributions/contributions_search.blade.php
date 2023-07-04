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
                            <h4 class="header-title mb-3 text-muted">Summary </h4>

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
                            <div class="row existingContrinbutionBlock">
                                <div class="col-12 mb-3 p-2">
                                        <h4 class="header-title mb-3 text-muted">Contributions </h4>
                                        <div class="table-responsive">
                                            <table class="existing_contrinbution_recon_table table table-bordered font-11 table-striped w-100">
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
                                       
                                </div>
                            </div>
                            <!-- END:: Existing Contributions -->

                            <!-- START:: noDataErrorBlock-->
                            <div class="row noDataErrorBlock">
                                 <div class="col-12 alert alert-danger" role="alert">
                                        <i class="mdi mdi-block-helper mr-2"></i> <strong>No data found! </strong> <span class="noDataErrorSpan"></span>
                                </div>
                            </div>
                            <!-- END:: noDataErrorBlock-->

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
                url: "{{url('/ajax/get/old/membercontribution')}}"
                , type: 'POST'
                , data: {
                    section_id: section_id
                    , contribution_date: contribution_date
                    , _token: '{{ csrf_token() }}'
                }
                , dataType: 'json'
                , success: function(response) {
                    //Start:: check old contribution first
                    if(response.sectionOldContributionDataArr.oldContributions!==''){

                        $('#sectionName').html(response.sectionOldContributionDataArr.sectionData.name);
                        $('#sectionCode').html(response.sectionOldContributionDataArr.sectionData.section_code);
                        $('#no_contributorsSpan').html(response.sectionOldContributionDataArr.totalContributors);
                        $('#no_membersSpan').html(response.sectionOldContributionDataArr.totalMembers);
                        //End:: put section Data

                        $('.monthlyContribution').html(parseFloat(response.sectionOldContributionDataArr.totalContributions.replace(/,/g, ''), 10).toLocaleString() + '.00');
                        $('.totalContribution').html(parseFloat(response.sectionOldContributionDataArr.totalContributions.replace(/,/g, ''), 10).toLocaleString() + '.00');

                        $('.noDataErrorBlock').hide();
                        $(".existing_contrinbution_recon_table tbody").empty();
                        $(".existing_contrinbution_recon_table").append(response.sectionOldContributionDataArr.oldContributions);

                        //Start:: block display control
                         $('.reconciliationBlock').show();
                        $('.existingContrinbutionBlock').show();
                        //End:: block display control

                    }else{
                        //Start:: block display control
                        $('.reconciliationBlock').hide();
                        $('.noDataErrorSpan').html('Kindly, Select <u>Section</u> and pick <u>Contribtuion Date</u> to get the data.');
                        $('.noDataErrorBlock').show();
                        $('.existingContrinbutionBlock').hide();
                        //End:: block display control
                    }
                    //End:: check old contribution first
                }
            });

        }else{
            $('.reconciliationBlock').hide();
            $('.noDataErrorSpan').html(' Kindly, Select <u>Section</u> and pick <u>Contribtuion Date</u> to get the data.');
            $('.noDataErrorBlock').show();
            $('.existingContrinbutionBlock').hide();
        }
    }
</script>

@endsection
