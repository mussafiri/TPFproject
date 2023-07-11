
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
                                    <li class="breadcrumb-item active">Contributions Arrears</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Contributions Arrears</h4>
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
                                         <ul class="nav nav-tabs nav-bordered">
                                            <li class="nav-item">
                                                <a href="{{url('arrears/sectionarrears/'.Crypt::encryptString('ACTIVE'))}}" aria-expanded="false" class="nav-link @if($status=='ACTIVE') {{'active'}} @endif">
                                                    Active
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('arrears/sectionarrears/'.Crypt::encryptString('PENDING'))}}" aria-expanded="true" class="nav-link @if($status=='PENDING') {{'active'}} @endif">
                                                    Pending
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('arrears/sectionarrears/'.Crypt::encryptString('CLOSED'))}}" aria-expanded="true" class="nav-link @if($status=='CLOSED') {{'active'}} @endif">
                                                    Paid
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('arrears/sectionarrears/'.Crypt::encryptString('CLOSURE REJECTED'))}}" aria-expanded="true" class="nav-link @if($status=='CLOSURE REJECTED') {{'active'}} @endif">
                                                    Closure Rejected
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('arrears/sectionarrears/'.Crypt::encryptString('SUSPENDED'))}}" aria-expanded="true" class="nav-link @if($status=='SUSPENDED') {{'active'}} @endif">
                                                    Waived
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('arrears/sectionarrears/'.Crypt::encryptString('SUSPEND REJECTED'))}}" aria-expanded="true" class="nav-link @if($status=='SUSPEND REJECTED') {{'active'}} @endif">
                                                    Waives Rejected
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="active">
                                                <form method="POST" action="{{url('arrears/waive/bulk/arrears/submit')}}">
                                                @csrf
                                                    <div class="table-responsive">
                                                        <table class="datatable-buttons table font-11 table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th style="width:14%">Section</th>
                                                                    <th style="width:10%">Arrear Date</th>
                                                                    <th>Arrears Age </th>
                                                                    <th>Arrear Amount <sup class="text-muted"><small>TZS</small></sup></th>
                                                                    <th>Penalty Amount <sup class="text-muted"><small>TZS</small></sup></th>
                                                                    <th>Paid <sup class="text-muted"><small>TZS</small></sup></th>
                                                                    <th>Refund <sup class="text-muted"><small>TZS</small></sup></th>
                                                                    <th>Process Status</th>
                                                                    <th>
                                                                        <div class="row pl-2">
                                                                            <div class="col-4 pl-2">
                                                                                <div class="custom-control custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input sectioArrearParent" id="customCheck1">
                                                                                    <label class="custom-control-label" for="customCheck1"></label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-8">Action</div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                            @php $n=3; $counter=1; @endphp

                                                            @foreach($arrears as $data)
                                                                @php
                                                                    if($data->status =='ACTIVE' || $data->status=='ON PAYMENT'){
                                                                        $arrearPeriod = ($data->status =='ACTIVE')? date('Y-m-d'): date('Y-m-d', strtotime($data->closed_at));
                                                                    }else{
                                                                        $arrearPeriod = ($data->status =='SUSPENDED')? date('Y-m-d', strtotime($data->suspended_at)): date('Y-m-d', strtotime($data->closed_at));
                                                                    }

                                                                    $totalSectionContribution = $data->arrearTotalContributionExpected($data->section_id, $data->arrear_period);

                                                                    $totalPenalty = $data->arrearTotalPenaltyExpected($totalSectionContribution, $data->id, $arrearPeriod);
                                                                    $penaltyPaid = $data->sectionPenatyPaid($data->id, $data->section_id);
                                                                    
                                                                    //Start::payment cumputations
                                                                    $refund = 0;
                                                                    $penaltyBalance = 0;

                                                                    if($penaltyPaid >= $totalPenalty ){
                                                                        $refund = $penaltyPaid - $totalPenalty;
                                                                    }else{
                                                                        $penaltyBalance = $totalPenalty - $penaltyPaid;
                                                                    }
                                                                    //End::payment cumputations

                                                                    if($data->processing_status=="PENDING"){ $badgeText = "info";}else if ( $data->processing_status=="ON PAYMENT"){ $badgeText = "primary"; }elseif($data->processing_status == "CLOSED"){ $badgeText = "success"; }else if($data->processing_status=="CLOSURE REJECTED"){$badgeText = "danger";}elseif($data->processing_status=="SUSPEND REJECTED"){$badgeText = "pink";}else{$badgeText = "secondary";}
                                                                @endphp
                                                                <tr id="trID{{$n}}">
                                                                    <td>{{$counter}}.</td>
                                                                    <td class="text-muted font-9">{{$data->section->name}}</td>
                                                                    <td>{{date('M, Y', strtotime($data->arrear_period))}}</td>
                                                                    <td class="text-info">{{$data->arrearAge($data->id, $arrearPeriod)}} <sup class="text-muted"><small>Days</small></sup></td>
                                                                    <td>{{number_format($totalSectionContribution,2)}}</td>
                                                                    <td class="text-danger">{{number_format($penaltyBalance,2)}}</td>
                                                                    <td class="text-primary">{{number_format($penaltyPaid,2)}}</td>
                                                                    <td class="text-primary">{{number_format($refund,2)}}</td>
                                                                    <td><span class="badge badge-xs badge-outline-{{$badgeText}} badge-pill">{{$data->processing_status}}</span></td>
                                                                    <td class="float-left py-1">
                                                                        <div class="btn-group dropdown float-right">
                                                                            <a class="btn btn-sm btn-xs">
                                                                                <div class="custom-control custom-checkbox my-auto">
                                                                                    <input type="checkbox" class="custom-control-input memberArrearCheckBox" value="{{$data->id}}" id="customCheck{{$n}}" name="sectionArrear[]">
                                                                                    <label class="custom-control-label" for="customCheck{{$n}}"></label>
                                                                                </div>
                                                                            </a>

                                                                            <a href="#" class="dropdown-toggle arrow-none text-muted btn btn-sm  btn-xs" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="mdi mdi-dots-horizontal font-18"></i>
                                                                            </a>

                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a href="{{url('arrears/viewarrears/'.Crypt::encryptString($data->id))}}"  class="dropdown-item">
                                                                                    <i class='mdi mdi-eye-outline mr-1'></i>View
                                                                                </a>
                                                                                @if($data->processing_status=='ACTIVE')
                                                                                <a href="{{url('arrears/sectionarrears/pay/'.Crypt::encryptString($data->id))}}" class="dropdown-item paySectionArrear" data-rowID="{{$n}}">
                                                                                    <i class='flaticon-give-money-1 mr-1 font-18'></i>Pay Section Penalty
                                                                                </a>

                                                                                <a href="{{url('arrears/processingarrears/'.Crypt::encryptString('PAY MEMBER ARREAR').'/'.Crypt::encryptString($data->id))}}" class="dropdown-item">
                                                                                    <i class='mdi mdi-account-cash mr-1'></i>Pay Member Penalty
                                                                                </a>
                                                                                <a href="{{url('arrears/processingarrears/'.Crypt::encryptString('WAIVE MEMBER ARREAR').'/'.Crypt::encryptString($data->id))}}" class="dropdown-item">
                                                                                    <i class='flaticon-refund mr-1 font-18'></i>Waive Member Penalty
                                                                                </a>
                                                                                @endif
                                                                            </div> <!-- end drop down menu-->
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @php $n++; $counter++; @endphp
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive-->

                                                    <div class="col-12 mt-3 px-0">
                                                    @if($arrears->count()>0 && $status=='ACTIVE')
                                                    <a href="javascript:void(0);" class="btn btn-info waves-effect waves-light float-right waiveBulkArrears border-top" data-toggle="modal" data-target="#waiveBulkArrearPenalties" > Waive Bulk Arrears</a>
                                                    @endif
                                                    <!--- START:: Waive All Arrear Penalties -->
                                                        <div id="waiveBulkArrearPenalties" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                            <div class="modal-dialog modal-md">
                                                                <div class="modal-content">
                                                                    <div class="modal-body p-4">
                                                                        <div class="text-center">
                                                                            <i class="dripicons-warning h1 text-warning"></i>
                                                                            <h4 class="mt-2">Confirm Waiving all checked Arrear Penalties</h4>
                                                                            <p class="mt-3">Are you sure! <br> You are about to waive all the Arrear Penalties. You can <span class="text-info">cancel</span> to review Arrears before Waiving all</p>
                                                                            <input type="hidden" name="memberCounter" value="{{$counter}}">
                                                                             @if ($errors->suspendBulkArrears->has('sectionArrear')) <span class="text-danger" role="alert"> <strong>{{ $errors->suspendBulkArrears->first('sectionArrear') }}</strong></span>@endif
                                                                        </div>
                                                                        <button type="submit" class="btn btn-success my-2 float-left">Yes! Waive All Penalties</button>
                                                                        <button type="button" class="btn btn-danger my-2 float-right" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div>
                                                    <!--- END:: Waive All Arrear Penalties -->
                                                    </div>
                                                </form>

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

@if($errors->hasBag('suspendBulkArrears'))
    <script type="text/javascript">
        $(document).ready(function(){
            $('#waiveBulkArrearPenalties').modal({show: true});
        });
    </script>
@endif

<script type="text/javascript">
    $('.sectioArrearParent').on('click', function(){
        if($(this).is(':checked')){
            $('.memberArrearCheckBox').prop('checked', true);

            $('.waiveBulkArrears').show();
        }else{
            $('.memberArrearCheckBox').prop('checked', false);

            $('.waiveBulkArrears').hide();
        }
    });

    $('.memberArrearCheckBox').on('click', function(){
        if ($('.memberArrearCheckBox').is(':checked')) {
            // At least one checkbox is checked
            $('.sectioArrearParent').prop('checked', true);
            $('.waiveBulkArrears').show();
            } else {
            // No checkbox is checked
            $('.waiveBulkArrears').hide();
            $('.sectioArrearParent').prop('checked', false);
        }
    });
</script>

<script type="text/javascript">
    $(".change_contributor_status_swt_alert").click(function() {
        var data_id = $(this).attr("data-id");
        var new_status = $(this).attr("data-newstatus");
        var data_name = $(this).attr("data-name");

        Swal.fire({
            title: "Are you sure?",
            html: 'You want to <span class="text-danger">' + new_status + '</span> <span class="text-info">' + data_name + ' </span>!',
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, " + new_status + " it!",
            cancelButtonText: "No, Cancel!",
            confirmButtonClass: "btn btn-success mt-2",
            cancelButtonClass: "btn btn-danger ml-2 mt-2",
            buttonsStyling: !1,
        }).then(function(t) {
            t.value ?
                $.ajax({
                    type: 'POST',
                    url: "{{url('/ajax/change/contri/status')}}",
                    data: {
                        data_id: data_id,
                        new_status: new_status,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',

                    success: function(t) {
                        Swal.fire({
                            title: "Success!",
                            html: "You have successfully <span class='text-success'> " + new_status + "ed</span> " + data_name + ".",
                            type: "success"
                        }).then(function() {
                            location.reload();
                        });
                    }
                }) :
                t.dismiss === Swal.DismissReason.cancel;
        });

    });
</script>

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
@endsection
