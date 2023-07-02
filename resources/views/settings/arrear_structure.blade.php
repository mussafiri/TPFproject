@extends('layouts.admin_main')
@section('custom_css')
<!-- third party css -->
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<!-- third party css end -->
<link href="{{asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
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
                            <li class="breadcrumb-item active">Arrears Recognition</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Arrears Recognition</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <!-- end row-->
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row mb-2">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button" class="btn btn-info mb-2 mr-1" data-toggle="modal" data-target="#add_modal"><i class="mdi mdi-plus-thick mr-2"></i> Add Department</button>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <!-- end row-->
                    <div class="row">

                        <div class="col-12">

                            <div class="tab-content">
                                <div class="tab-pane active">

                                    <div class="table-responsive">
                                        <table class="datatable-buttons table font-11 table-striped dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Grace Period</th>
                                                    <th>Status</th>
                                                    <th>Created by</th>
                                                    <th>Created at</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php $n=1; @endphp
                                                @foreach($arrearData as $data)
                                                <tr>
                                                    <td>{{$n}}.</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{$data->grace_period_days}}  <sup class="text-muted"> Days</sup></td>
                                                    <td><span class="badge badge-outline-{{$data->status=='ACTIVE'?'success':'danger'}} badge-pill">{{$data->status}}</span></td>
                                                    <td><small>{{$data->createdBy->fname.' '.$data->createdBy->mname.' '.$data->createdBy->lname}}</small></td>
                                                    <td><small>{{date('d M Y', strtotime($data->created_at))}}</small></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="btn btn-light btn-sm dropdown-item constantValueEdit" data-id="{{$data->id}}" data-toggle="modal" data-target="#edit_modal">
                                                            <i class='mdi mdi-pencil-outline mr-1'></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @php $n++; @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div>

                            </div>
                            <!-- end card-box-->

                            <!-- START:: Edit Modal modal content -->
                            <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h4 class="modal-title" id="myCenterModalLabel">Edit Arrear Structure</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>

                                        <form method="POST" action="{{url('configs/edit/arrear/structure/submit')}}">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <div class="row">
                                                    <div class="col-12"><span class="text-danger" id="edit_value_fetchError"></span></div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Arrear Grace Period <sup class="text-muted">Days</sup></label>
                                                            <input type="hidden" class="form-control" id="data_id" name="data_id">
                                                            <input type="text" class="form-control" id="gracePeriod" name="gracePeriod" value="{{ old('gracePeriod') }}"  oninput="this.value = this.value.toUpperCase()">
                                                            @if ($errors->editDepartment->has('gracePeriod')) <span class="text-danger" role="alert"> <strong>{{ $errors->editDepartment->first('gracePeriod') }}</strong></span>@endif
                                                        </div>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-info waves-effect waves-light">Submit Updates</button>
                                                    <button type="button" class="btn btn-danger waves-effect float-right" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form> <!-- /.modal-content -->
                                    </div>
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <!-- START:: Edit Modal modal content -->

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
@if($errors->hasBag('addDepartment'))
<script>
    $(document).ready(function() {
        $('#add_modal').modal({
            show: true
        });
    });
</script>
@endif
@if($errors->hasBag('editDepartment'))
<script>
    $(document).ready(function() {
        $('#edit_modal').modal({
            show: true
        });
    });

    $(document).ready(function(){
    // Bind the keydown event to the input field
        $('#gracePeriod').on('keydown', function(e){
            // Allow: backspace, delete, tab, escape, enter, decimal point and minus sign
            if (e.keyCode == 46 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 27 || e.keyCode == 13 ||
                (e.keyCode == 65 && e.ctrlKey === true) ||
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // Allow key press
                    return true;
            }
            else {
                // Prevent key press if not a number
                if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    });


</script>
@endif


<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(1000, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 6000);

</script>

<script>
    $('.constantValueEdit').on('click', function() {
        var data_id = $(this).attr('data-id');
        $('#data_id').val(data_id);
        $.ajax({
            type: 'POST' , 
            url: "{{url('/ajax/get/arrear/data')}}", 
            data: {
                data_id: data_id, 
                _token: '{{ csrf_token() }}'
            }, 
            dataType: 'json', 
            success: function(response) {
                if (response.arrearDataArr.status == 'success') {
                    $('#edit_value_fetchError').html('');
                    $('#gracePeriod').val(response.arrearDataArr.grace_period_days);
                } else {
                    $('#gracePeriod').val(0);
                    $('#edit_value_fetchError').html(response.arrearDataArr.message);
                }
            }
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
