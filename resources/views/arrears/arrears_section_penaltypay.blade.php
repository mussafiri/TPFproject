
@extends('layouts.admin_main')@section('custom_css')
        <!-- kartik Fileinput-->
        <link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fontawesome-kartik.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/bootstrap-icons.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/css/fileinput.min.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.css')}}" />

        <!-- third party css -->
        <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- third party css end -->
        <link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
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
                                    <li class="breadcrumb-item active">Section Arrears Penalty Payment</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Section Arrears Penalty Payment</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <!-- end row-->
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">

                                        <!-- end row-->
                                        <div class="row">

                                        <div class="col-12">

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="active">
                                                <div class="col-12 p-1">
                                                    <h4 class="header-title mb-3 text-muted"> Section Details</h4>
                                                    <div class="col-sm-12 mt-2">
                                                        <div class="table-responsive">
                                                            @php 
                                                                if($arrearData->status =='ACTIVE' || $arrearData->status=='ON PAYMENT'){
                                                                    $arrearPeriod = ($arrearData->status =='ACTIVE')? date('Y-m-d'): date('Y-m-d', strtotime($arrearData->closed_at));
                                                                }else{
                                                                    $arrearPeriod = ($arrearData->status =='SUSPENDED')? date('Y-m-d', strtotime($arrearData->suspended_at)): date('Y-m-d', strtotime($arrearData->closed_at));
                                                                }

                                                                $totalSectionContribution = $arrearData->arrearTotalContributionExpected($arrearData->section_id, $arrearData->arrear_period);

                                                                $totalPenalty = $arrearData->arrearTotalPenaltyExpected($totalSectionContribution, $arrearData->id, $arrearPeriod);
                                                                 
                                                                 $penaltyPaid = $arrearData->sectionPenatyPaid($arrearData->id, $arrearData->section_id);
                                                                    
                                                                    //Start::payment cumputations
                                                                    $refund = 0;
                                                                    $penaltyBalance = 0;

                                                                    if($penaltyPaid >= $totalPenalty ){
                                                                        $refund = $penaltyPaid - $totalPenalty;
                                                                    }else{
                                                                        $penaltyBalance = $totalPenalty - $penaltyPaid;
                                                                    }
                                                                    //End::payment cumputations

                                                            @endphp
                                                            <table class="table table-sm font-11 table-bordered table-centered mb-0">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th class="text-center">Section</th>
                                                                        <th class="text-center">Arrear Period</th>
                                                                        <th class="text-center">Contributors</th>
                                                                        <th class="text-center">Members</th>
                                                                        <th class="text-center">Total Arrear <sup class="text-muted font-10">TZS</sup></th>
                                                                        <th class="text-center">Penalty<sup class="text-muted font-10">TZS</sup></th>
                                                                        <th class="text-center">Paid <sup class="text-muted font-10">TZS</sup></th>
                                                                        <th class="text-center">Refund<sup class="text-muted font-10">TZS</sup></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-center">{{$arrearData->section->name}}</td>
                                                                        <td class="text-center">{{date('M, Y',  strtotime($arrearData->arrear_period))}}</td>
                                                                        <td class="text-center">{{$countContributors}}</td>
                                                                        <td class="text-center">{{$totalMembers}}</td>
                                                                        <td class="text-center">{{number_format($totalSectionContribution,2)}}</td>
                                                                        <td class="text-center text-danger">{{number_format($penaltyBalance,2)}}</td>
                                                                        <td class="text-center">{{number_format($penaltyPaid,2)}}</td>
                                                                        <td class="text-center text-primary">{{number_format($refund,2)}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mt-2">
                                                    <form method="POST" action="{{url('arrears/submit/section/arrearpenalty/'.$arrearData->id)}}">
                                                    @csrf
                                                        <h4 class="header-title mb-3 text-muted">Transaction Proofs</h4>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-4" class="control-label">Arrear Penalty Paid  <span class="text-danger">*</span></label>
                                                                            <input type="text" name="arrearPenalty" id="arrearPenalty" class="form-control form-control-sm totalContributionInput  autonumber" value="{{old('arrearPenalty' )}}" id="field-4" placeholder="Total Contribution">
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('arrearPenalty') }}</span>
                                                                            <span class="text-danger font-11" role="alert" id="arrearPenaltyErrorSpan"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-4" class="control-label">Payment Date  <span class="text-danger">*</span></label>
                                                                            <input type="text" name="paymentDate" id="basic-datepicker" data-date-format="d M, Y" class="form-control form-control-sm " value="{{old('paymentDate')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Pick Payment Date">
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('paymentDate') }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="field-1" class="control-label">Payment Mode  <span class="text-danger">*</span></label>
                                                                            <select class="form-control " name="paymentMode" data-toggle="select2">
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
                                                                            <input type="text" name="transactionReference" id="transactionReference" class="form-control form-control-sm " value="{{old('transactionReference')}}" oninput="this.value = this.value.toUpperCase()" id="field-4" placeholder="Transaction Reference">
                                                                            <span class="text-danger" role="alert"> {{ $errors->first('transactionReference') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="field-3" class="control-label">Transaction Proof  <span class="text-danger">*</span></label>
                                                                        <input type="file" class="form-control kartik-input-705 kv-fileinput-dropzone " name="transactionProof" id="field-4" required>
                                                                        <span class="text-danger" role="alert"> {{ $errors->first('transactionProof') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-info waves-effect waves-light float-right">Submit Penalty Payment</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                                 <!-- end card-box-->
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

<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/libs/kartik-v-bootstrap-fileinput/themes/explorer/theme.js')}}"></script>
        <!-- third party js -->
        <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
        <script src="{{asset('assets/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>
        <script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
        <script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
        <!-- third party js ends -->
        <!-- Datatables init -->
        <script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

        <!-- Datatables init -->
        <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

 <script type="text/javascript">
    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 6000);
</script>

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
@endsection
