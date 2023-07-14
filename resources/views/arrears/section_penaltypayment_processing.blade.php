
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
                                    <li class="breadcrumb-item active"> Section Penalty Payments</li>
                                </ol>
                            </div>
                            <h4 class="page-title"> Section Penalty Payments</h4>
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
                                                <a href="{{url('arrears/sectionpayments/'.Crypt::encryptString('PENDING'))}}" aria-expanded="false" class="nav-link @if($status=='PENDING') {{'active'}} @endif">
                                                    Pending
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('arrears/sectionpayments/'.Crypt::encryptString('APPROVED'))}}" aria-expanded="true" class="nav-link @if($status=='APPROVED') {{'active'}} @endif">
                                                    Approved
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{url('arrears/sectionpayments/'.Crypt::encryptString('APPROVAL REJECTED'))}}" aria-expanded="true" class="nav-link @if($status=='APPROVAL REJECTED') {{'active'}} @endif">
                                                    Rejected
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="active">
                                                    <div class="table-responsive">
                                                        <table class="datatable-buttons table font-11 table-striped w-100">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th class="text-center">Section</th>
                                                                    <th class="text-center">Arrear Period</th>
                                                                {{--<th class="text-center">Age </th>
                                                                    <th class="text-center">Contributors</th>
                                                                    <th class="text-center">Members</th> --}}
                                                                    <th class="text-center">Arrear <sup class="text-muted font-10">TZS</sup></th>
                                                                    <th class="text-center">Penalty <sup class="text-muted font-10">TZS</sup></th>
                                                                    <th class="text-center">Paid <sup class="text-muted font-10">TZS</sup></th>
                                                                    <th class="text-center">Type</th>
                                                                    <th class="text-center">Pay Date</th>
                                                                    <th class="text-center">Pay Ref</th>
                                                                    <th class="text-center">Proof</th>
                                                                    <th class="text-center">Status</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php $n=1; @endphp
                                                            @foreach($sectionPenaltyPayments as $data)
                                                                @php
                                                                    if($data->arrear->status =='ACTIVE' || $data->arrear->status=='ON PAYMENT'){
                                                                        $arrearDate = ($data->arrear->status =='ACTIVE')? date('Y-m-d'): date('Y-m-d', strtotime($data->arrear->closed_at));
                                                                    }else{
                                                                        $arrearDate = ($data->arrear->status =='SUSPENDED')? date('Y-m-d', strtotime($data->arrear->suspended_at)): date('Y-m-d', strtotime($data->arrear->closed_at));
                                                                    }
                                                                @endphp
                                                                <tr>
                                                                    <td class="">{{$n}}.</td>
                                                                    <td class="">{{$data->section->name}}</td>
                                                                    <td class="">{{date('M, Y', strtotime($data->arrear->arrear_period))}}</td>
                                                                {{--<td class="">{{$data->arrear->arrearAge($data->arrear_id, $arrearDate)}} <sup class="text-muted"><small>Days</small></sup></td>
                                                                     <td class="">{{$data->arrear->totalContributors($data->arrear->section_id)}}</td>
                                                                    <td class="">{{$data->arrear->totalMembers($data->arrear->section_id)}}</td> --}}
                                                                    <td class="">{{number_format($data->arrear->arrearTotalContributionExpected($data->arrear->section_id, $data->arrear->arrear_period),2)}}</td>
                                                                    <td class="text-danger">{{number_format($data->arrear->arrearTotalPenaltyExpected($data->arrear->arrearTotalContributionExpected($data->arrear->section_id, $data->arrear->arrear_period), $data->arrear_id, $arrearDate),2)}}</td>
                                                                    <td class="text-success">{{number_format($data->pay_amount ,2)}}</td>
                                                                    <td class=""><span class="badge badge-xs badge-outline-{{$data->type == 'SECTION PAY'?'primary':'secondary'}}"> {{$data->type}}</span></td>
                                                                    <td class="">{{date('d M, Y', strtotime($data->payment_date))}}</td>
                                                                    <td class="text-muted">{{$data->payment_ref_no}}</td>
                                                                    <td class="text-center"><a class="font-16 text-info" href="{{Storage::url('penaltyPaymentProof/'.$data->payment_proof)}}" target="_blank"><i class="mdi mdi-cloud-download-outline"></i></a></td>
                                                                    <td class=""><span class="badge badge-xs badge-outline-{{($data->status == 'PENDING')?'info':($data->status == 'COMPLETED'?'success':'danger')}}"> {{$data->status}}</span></td>
                                                                    <td class="float-left py-1">
                                                                        <div class="btn-group dropdown float-right">
                                                                            <a href="#" class="dropdown-toggle arrow-none text-muted btn btn-sm  btn-xs" data-toggle="dropdown" aria-expanded="false">
                                                                                <i class="mdi mdi-dots-horizontal font-18"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a href="{{url('arrears/viewarrears/'.Crypt::encryptString($data->id))}}"  class="dropdown-item">
                                                                                    <i class='mdi mdi-eye-outline mr-1'></i>View
                                                                                </a>
                                                                                <a href="{{url('arrears/sectionarrears/pay/'.Crypt::encryptString($data->id))}}" class="dropdown-item paySectionArrear" data-rowID="{{$n}}">
                                                                                    <i class='flaticon-give-money-1 mr-1 font-18'></i>Approve Payment
                                                                                </a>
                                                                                <a href="{{url('arrears/processingarrears/'.Crypt::encryptString('PAY MEMBER ARREAR').'/'.Crypt::encryptString($data->id))}}" class="dropdown-item">
                                                                                    <i class='mdi mdi-account-cash mr-1'></i>Reject Payment
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @php $n++; @endphp
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive-->

                                                    <div class="col-12 mt-3 px-0">
                                                    <a href="javascript:void(0);" class="btn btn-info waves-effect waves-light float-right waiveBulkArrears border-top" data-toggle="modal" data-target="#waiveBulkArrearPenalties" > Waive Bulk Arrears</a>
                                                   
                                                    <!--- START:: Waive All Arrear Penalties -->
                                                        <div id="waiveBulkArrearPenalties" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                                            <div class="modal-dialog modal-md">
                                                                <div class="modal-content">
                                                                    <div class="modal-body p-4">
                                                                        <div class="text-center">
                                                                            <i class="dripicons-warning h1 text-warning"></i>
                                                                            <h4 class="mt-2">Confirm Waiving all checked Arrear Penalties</h4>
                                                                            <p class="mt-3">Are you sure! <br> You are about to waive all the Arrear Penalties. You can <span class="text-info">cancel</span> to review Arrears before Waiving all</p>
                                                                            <input type="hidden" name="memberCounter" value="">
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
