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
                            <li class="breadcrumb-item active">Constant Values</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Constant Values</h4>
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
                                                    <th>Constant Value</th>
                                                    <th>Unit Type</th>
                                                    <th>Status</th>
                                                    <th>Created by</th>
                                                    <th>Created at</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php $n=1; @endphp
                                                @foreach($constantValues as $data)
                                                <tr>
                                                    <td>{{$n}}.</td>
                                                    <td>{{$data->item_type}}</td>
                                                    <td>{{$data->amount}}</td>
                                                    <td>{{$data->unit_type}}</td>
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
                                            <h4 class="modal-title" id="myCenterModalLabel">Edit Department</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>

                                        <form method="POST" action="{{url('cofigs/edit/constantvalue/submit')}}">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <div class="row">
                                                    <div class="col-12"><span class="text-danger" id="edit_value_fetchError"></span></div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">Constant Value Name</label>
                                                            <input type="hidden" class="form-control" id="data_id" name="data_id">
                                                            <input type="text" class="form-control" id="edit_constantValueName" name="constantValueName" value="{{ old('constantValueName') }}"  oninput="this.value = this.value.toUpperCase()">
                                                            @if ($errors->editDepartment->has('constantValueName')) <span class="text-danger" role="alert"> <strong>{{ $errors->editDepartment->first('constantValueName') }}</strong></span>@endif
                                                        </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-1" class="control-label">Department Name</label>
                                                                <input type="text" class="form-control" id="edit_value" name="consantValue" value="{{ old('consantValue') }}"  oninput="this.value = this.value.toUpperCase()" placeholder="Enter Department Name">
                                                                @if ($errors->editDepartment->has('consantValue')) <span class="text-danger" role="alert"> <strong>{{ $errors->editDepartment->first('consantValue') }}</strong></span>@endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="field-1" class="control-label">Unity Type</label>
                                                                <input type="text" class="form-control" id="unit_type" name="unitType" value="{{ old('unitType') }}" readonly>
                                                                @if ($errors->editDepartment->has('consantValue')) <span class="text-danger" role="alert"> <strong>{{ $errors->editDepartment->first('consantValue') }}</strong></span>@endif
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
            url: "{{url('/ajax/get/constantvalue/data')}}", 
            data: {
                data_id: data_id, 
                _token: '{{ csrf_token() }}'
            }, 
            dataType: 'json', 
            success: function(response) {
                if (response.consantValueDataArr.status == 'success') {
                    $('#edit_value_fetchError').html('');
                    $('#edit_constantValueName').val(response.consantValueDataArr.data.item_type);
                    $('#edit_value').val(response.consantValueDataArr.data.amount);
                    $('#unit_type').val(response.consantValueDataArr.data.unit_type);
                } else {
                    $('#edit_value').val('');
                    $('#edit_value_fetchError').html(response.consantValueDataArr.message);
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
