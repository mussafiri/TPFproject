
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
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title mb-3 text-muted">Contribution Details</h4>
                                        <div class="row">
                                            <div class="col-12">
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
                                    <h4 class="header-title mb-3 text-muted">Reconciliation Panel </h4>
                                        <!-- end row-->
                                        <div class="row">
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
                                                                        <th>Arrears <sup class="text-muted font-10">TZS</sup></th>
                                                                        <th>Total Contribution <sup class="text-muted font-10">TZS</sup></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>TUMAINI PENSION FUND</td>
                                                                        <td><span id="contributionDate"></span></td>
                                                                        <td><span id="no_contributors"></span></td>
                                                                        <td><span id="no_members"></span></td>
                                                                        <td><span id="monthlyContribution"></span></td>
                                                                        <td><span id="Arrears"></span></td>
                                                                        <td><span id="totalContribution"></span></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="table-responsive">
                                                            <table id="contrinbution_recon_table" class="datatable-buttons table font-11 table-striped dt-responsive nowrap w-100">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Contributor</th>
                                                                        <th>Member Name</th>
                                                                        <th>Monthly Income</th>
                                                                        <th>Amount <sup class="text-muted font-10">Member (TZS)</sup></th>
                                                                        <th>Amount <sup class="text-muted font-10">Contributor (TZS)</sup></th>
                                                                        <th>Topup<sup class="text-muted font-10">TZS</sup></th>
                                                                        <th>Total<sup class="text-muted font-10">TZS</sup></th>
                                                                        <th>Status</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div>
                                    <!-- end row -->
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

<script type="text/javascript">
$(".searchButton").click(function() {

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
                    if (response.sectionContributionDataArr.code == 201) {
                        //Start:: put section Data
                        $('#sectionName').html(response.sectionContributionDataArr.sectionData.name);
                        $('#sectionCode').html(response.sectionContributionDataArr.sectionData.section_code);
                        $('#no_contributors').html(response.sectionContributionDataArr.totalContributors);
                        $('#no_members').html(response.sectionContributionDataArr.totalMembers);
                        //End:: put section Data

                        $("#contrinbution_recon_table").prepend(response.sectionContributionDataArr.memberList);

                    } else {
                        console.log('Error');
                    }
                }
            });

        }else{
            if(section_id==0){
                $("#sectionError").html('Kindly, select a Section');
            }

            if(contribution_date==""){
                $("#contributionDateError").html('Kindly, pick Date');
            }
        }
});
</script>
@endsection