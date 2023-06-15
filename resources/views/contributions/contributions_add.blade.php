
@extends('layouts.admin_main')
@section('custom_css')
<link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

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
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title mb-3 text-muted">Contribution Details</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                    <div class="col-12"> </div>
                                                    <div class="row px-3">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-3" class="control-label">Section</label>
                                                                <select class="form-control sectionSelect" name="section" data-toggle="select2">
                                                                    <option value="0"> -- Select Section --</option>
                                                                    @foreach($sections as $value)
                                                                    <option value="{{$value->id}}" {{old ('section') == $value->id ? 'selected' : ''}}>{{'District: '.$value->district->name.' Section: '.$value->name}} </option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger" role="alert" id="sectionError"> {{ $errors->first('section') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-1" class="control-label">Scheme</label>
                                                                <select class="form-control" name="scheme" data-toggle="select2">
                                                                    @foreach($schemes as $value)
                                                                    <option  value="{{$value->id}}" {{old ('scheme') == $value->id ? 'selected' : ''}}>{{$value->name}} </option>
                                                                    @endforeach
                                                                </select>
                                                                    <span class="text-danger" role="alert"> {{ $errors->first('scheme') }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-1" class="control-label">Contribution Date</label>
                                                                <input type="text" name="contributionDate" class="form-control form-control-sm"  id="reportrange" value="{{old('contributionDate')}}">
                                                                <span class="text-danger" role="alert"> {{ $errors->first('contributionDate') }}</span>
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
                                                    <div class="col-sm-8"><strong>Section Name:</strong> </div> <div class="col-sm-4"> <strong>Section Code:</strong> </div>
                                                    
                                                    <div class="col-sm-12 mt-2">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-centered mb-0">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th>Scheme</th>
                                                                        <th>Contribution Date</th>
                                                                        <th>Total Members</th>
                                                                        <th>Monthly Contribution <sup class="text-muted font-10">TZS</sup></th>
                                                                        <th>Arrears</th>
                                                                        <th>Total Contribution <sup class="text-muted font-10">TZS</sup></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Polo Navy</td>
                                                                        <td>12</td>
                                                                        <td>1</td>
                                                                        <td>39</td>
                                                                        <td>39</td>
                                                                        <td>39</td>
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
                                                            <table class="datatable-buttons table font-11 table-striped dt-responsive nowrap w-100">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Contributor</th>
                                                                        <th>Memmber Name</th>
                                                                        <th>Monthly Income</th>
                                                                        <th>Contribution <sup class="text-muted font-10">Member</sup></th>
                                                                        <th>Contribution <sup class="text-muted font-10">Contributor</sup></th>
                                                                        <th>Topup</th>
                                                                        <th>Contribution<sup class="text-muted font-10">Total</sup></th>
                                                                        <th>Status</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <tr id="contrinbution_recon_table">
                                                                        <td></td>
                                                                        <td class="text-muted font-9"></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td>
                                                                            <div class="btn-group dropdown float-right">
                                                                                <a href="#" class="dropdown-toggle arrow-none text-muted btn btn-light btn-sm"
                                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                                    <i class='mdi mdi-dots-horizontal font-18'></i>
                                                                                </a>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    <a href="" class="dropdown-item">
                                                                                        <i class='mdi mdi-pencil-outline mr-1'></i>Edit
                                                                                    </a>
                                                                                    <div class="dropdown-divider"></div>
                                                                                    <!-- item-->
                                                                                    <a href="javascript:void(0);" class="dropdown-item change_contributor_status_swt_alert" data-id="" data-newstatus="" data-name="">
                                                                                       
                                                                                        <i class='mdi mdi-close-thick mr-1'></i>Suspend
                                                                                    </a>
                                                                                </div> <!-- end dropdown menu-->
                                                                            </div>
                                                                        </td>
                                                                    </tr>
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

        <!-- third party js -->
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.js')}}"></script>

        <!-- Datatables init -->
 <script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>


<script type="text/javascript">
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
</script>
<script type="text/javascript">
    $('.sectionSelect').change(function(){
        alert(' kkkkk');
    });
</script>
@endsection
