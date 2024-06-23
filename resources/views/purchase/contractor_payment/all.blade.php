@extends('layouts.master')

@section('title')
    Contractor Payment
@endsection

@section('style')
    <style>
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            white-space: nowrap;
        }
        .input-group-addon i{
            padding-top:10px;
            padding-right: 10px;
            border: 1px solid #cecccc;
            padding-bottom: 10px;
            padding-left: 10px;
        }
    </style>
@endsection

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>Contractor Name</th>
                            <th>Company Name</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
{{--                            <th>Refund</th>--}}
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($contractors as $contractor)
                            <tr>
                                <td>{{ $contractor->project->name }}</td>
                                <td>{{ $contractor->name }}</td>
                                <td>{{ $contractor->company_name }}</td>
                                <td>{{ $contractor->mobile }}</td>
                                <td>{{ $contractor->address }}</td>
                                <td>৳ {{ number_format($contractor->total, 2) }}</td>
                                <td>৳ {{ number_format($contractor->paid, 2) }}</td>
                                <td>৳ {{ number_format($contractor->due, 2) }}</td>
{{--                                <td>৳ {{ number_format($contractor->refund, 2) }}</td>--}}
                                <td>
                                    @if($contractor->total > 0)
                                    <a class="btn btn-info btn-sm btn-pay" role="button" data-id="{{ $contractor->id }}" data-name="{{ $contractor->name }}">Pay</a>
                                    @endif
                                    @if($contractor->refund > 0)
                                        <a class="btn btn-danger btn-sm btn-refund" role="button" data-id="{{ $contractor->id }}" data-name="{{ $contractor->name }}">Refund</a>
                                    @endif
                                        <a href="{{route('contractor_payment_details',['contractor'=>$contractor->id])}}" class="btn btn-primary btn-sm" >Details</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-pay">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Payment Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <form id="modal-form" enctype="multipart/form-data" name="modal-form">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" id="modal-name" disabled>
                        </div>

                        <div class="form-group">
                            <label>Project</label>
                            <select class="form-control" id="modal-order" name="project" style="width: 100%">
                                <option value="">Select Project</option>
                            </select>
                        </div>

                        <div id="modal-order-info" style="background-color: lightgrey; padding: 10px; border-radius: 3px;"></div>

                        <div class="form-group">
                            <label>Segment</label>
                            <select class="form-control" name="segment" style="width: 100%">
                                <option value="">Select Segment</option>
                                @foreach($segments as $segment)
                                    <option value="{{ $segment->id }}">{{ $segment->name ?? 0 }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label>Payment Type</label>
                            <select class="form-control" id="modal-pay-type" name="payment_type">
                                <option value="1">Cash</option>
                                <option value="2">Bank</option>
                            </select>
                        </div>

                        <div id="modal-bank-info">
                            <div class="form-group">
                                <label>Bank</label>
                                <select class="form-control modal-bank" name="account">
                                    <option value="">Select Bank Account</option>
                                    @foreach($bankAccounts as $bankAccount)
                                        <option value="{{ $bankAccount->id }}">{{ $bankAccount->bank->name }}-{{ $bankAccount->branch->name }}-{{ $bankAccount->account_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Cheque No.</label>
                                <input class="form-control" type="text" name="cheque_no" placeholder="Enter Cheque No.">
                            </div>

                            <div class="form-group">
                                <label>Cheque Image</label>
                                <input class="form-control" name="cheque_image" type="file">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Amount</label>
                            <input class="form-control" name="amount" placeholder="Enter Amount">
                        </div>

                        <div class="form-group">
                            <label>Date <strong>(The date format must be followed <span class="text-danger">*</span>)</strong></label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" name="date" value="{{ date('d-m-Y') }}" autocomplete="off">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Note</label>
                            <input class="form-control" name="note" placeholder="Enter Note">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-btn-pay">Pay</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-refund">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Refund Information</h4>
                </div>
                <div class="modal-body">
                    <form id="refund-form" enctype="multipart/form-data" name="refund-form">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" id="modal-name-refund" disabled>
                        </div>

                        <div class="form-group">
                            <label>Order</label>
                            <select class="form-control" id="modal-order-refund" name="order" style="width: 100%">
                                <option value="">Select Order</option>
                            </select>
                        </div>

                        <div id="modal-order-info-refund" style="background-color: lightgrey; padding: 10px; border-radius: 3px;"></div>

                        <div class="form-group">
                            <label>Payment Type</label>
                            <select class="form-control" id="modal-pay-type-refund" name="payment_type">
                                <option value="1">Cash</option>
                                <option value="2">Bank</option>
                            </select>
                        </div>

                        <div id="modal-bank-info-refund">
                            <div class="form-group">
                                <label>Bank</label>
                                <select class="form-control modal-bank" name="account">
                                    <option value="">Select Bank Account</option>
                                    @foreach($bankAccounts as $bankAccount)
                                        <option value="{{ $bankAccount->id }}">{{ $bankAccount->bank->name }}-{{ $bankAccount->branch->name }}-{{ $bankAccount->account_no }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Cheque No.</label>
                                <input class="form-control" type="text" name="cheque_no" placeholder="Enter Cheque No.">
                            </div>

                            <div class="form-group">
                                <label>Cheque Image</label>
                                <input class="form-control" name="cheque_image" type="file">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Amount</label>
                            <input class="form-control" name="amount" placeholder="Enter Amount">
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="date-refund" name="date" value="{{ date('Y-m-d') }}" autocomplete="off">
                            </div>
                            <!-- /.input group -->
                        </div>

                        <div class="form-group">
                            <label>Note</label>
                            <input class="form-control" name="note" placeholder="Enter Note">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-btn-refund">Refund</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
@endsection

@section('script')

    <script>
        $(function () {
            $('#table').DataTable();

            //Initialize Select2 Elements
            $('#modal-order,#modal-order-refund').select2();

            //Date picker
            $('#date, #date-refund').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('body').on('click', '.btn-pay', function () {
                var contractorId = $(this).data('id');
                // alert(contractorId);
                var contractorName = $(this).data('name');
                $('#modal-order').html('<option value="">Select Project</option>');
                $('#modal-segment').html('<option value="">Select Segment</option>');
                $('#modal-order-info').hide();
                $('#modal-name').val(contractorName);

                $.ajax({
                    method: "GET",
                    url: "{{ route('contractor_payment.get_orders') }}",
                    data: { contractorId: contractorId }
                }).done(function( response ) {
                    $.each(response, function( index, item ) {
                        // console.log(item);
                        $('#modal-order').append('<option value="'+item.id+'">'+item.project.name+'</option>');
                    });

                    $('#modal-pay').modal('show');
                });

                $.ajax({
                    method: "GET",
                    url: "{{ route('contractor_payment.get_orders') }}",
                    data: { contractorId: contractorId }
                }).done(function( response ) {
                    // console.log(response);
                    $.each(response, function( index, item ) {
                        // console.log(item);
                        if(item.segment_id == 0){
                            $('#modal-segment').append('<option value="'+item.segment_id+'">All</option>');
                        }else{
                            $('#modal-segment').append('<option value="'+item.segment_id+'">'+item.segment.name+'</option>');
                        }
                    });
                    $('#modal-pay').modal('show');
                });
            });

            $('#modal-btn-pay').click(function () {
                var formData = new FormData($('#modal-form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('contractor_payment.make_payment') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#modal-pay').modal('hide');
                            Swal.fire(
                                'Paid!',
                                response.message,
                                'success'
                            ).then((result) => {
                                //location.reload();
                                window.location.href = response.redirect_url;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    }
                });
            });

            $('#modal-pay-type').change(function () {
                if ($(this).val() == '2') {
                    $('#modal-bank-info').show();
                } else {
                    $('#modal-bank-info').hide();
                }
            });

            $('#modal-pay-type').trigger('change');

            $('#modal-order').change(function () {
                var supplierId = $(this).val();
                $('#modal-order-info').hide();

                if (supplierId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('contractor_payment.order_details') }}",
                        data: { supplierId: supplierId }
                    }).done(function( response ) {
                        $('#modal-order-info').html('<strong>Total: </strong>৳'+parseFloat(response.total).toFixed(2)+' <strong>Paid: </strong>৳'+parseFloat(response.paid).toFixed(2)+' <strong>Due: </strong>৳'+parseFloat(response.due).toFixed(2));
                        $('#modal-order-info').show();
                    });
                }
            });

            $('.modal-bank').change(function () {
                var bankId = $(this).val();
                $('.modal-branch').html('<option value="">Select Branch</option>');
                $('.modal-account').html('<option value="">Select Account</option>');

                if (bankId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branch') }}",
                        data: { bankId: bankId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            $('.modal-branch').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });

                        $('.modal-branch').trigger('change');
                    });
                }

                $('.modal-branch').trigger('change');
            });

            $('.modal-branch').change(function () {
                var branchId = $(this).val();
                $('.modal-account').html('<option value="">Select Account</option>');

                if (branchId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_account') }}",
                        data: { branchId: branchId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            $('.modal-account').append('<option value="'+item.id+'">'+item.account_no+'</option>');
                        });
                    });
                }
            });

            // Refund
            $('body').on('click', '.btn-refund', function () {
                var supplierId = $(this).data('id');
                var supplierName = $(this).data('name');
                $('#modal-order-refund').html('<option value="">Select Order</option>');
                $('#modal-order-info-refund').hide();
                $('#modal-name-refund').val(supplierName);

                $.ajax({
                    method: "GET",
                    url: "{{ route('supplier_payment.get_refund_orders') }}",
                    data: { supplierId: supplierId }
                }).done(function( response ) {
                    $.each(response, function( index, item ) {
                        $('#modal-order-refund').append('<option value="'+item.id+'">'+item.order_no+'</option>');
                    });

                    $('#modal-refund').modal('show');
                });
            });

            $('#modal-pay-type-refund').change(function () {
                if ($(this).val() == '2') {
                    $('#modal-bank-info-refund').show();
                } else {
                    $('#modal-bank-info-refund').hide();
                }
            });

            $('#modal-pay-type').change(function () {
                if ($(this).val() == '2') {
                    $('#modal-bank-info').show();
                } else {
                    $('#modal-bank-info').hide();
                }
            });

            $('#modal-pay-type-refund').trigger('change');

            $('#modal-order-refund').change(function () {
                var orderId = $(this).val();
                $('#modal-order-info-refund').hide();

                if (orderId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('supplier_payment.order_details') }}",
                        data: { orderId: orderId }
                    }).done(function( response ) {
                        $('#modal-order-info-refund').html('<strong>Total: </strong>৳'+response.total.toFixed(2)+' <strong>Paid: </strong>৳'+response.paid.toFixed(2)+' <strong>Due: </strong>৳'+response.due.toFixed(2)+' <strong>Refund: </strong>৳'+response.refund.toFixed(2));
                        $('#modal-order-info-refund').show();
                    });
                }
            });

            $('#modal-btn-refund').click(function () {
                var formData = new FormData($('#refund-form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('supplier_payment.make_refund') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#modal-refund').modal('hide');
                            Swal.fire(
                                'Refunded!',
                                response.message,
                                'success'
                            ).then((result) => {
                                //location.reload();
                                window.location.href = response.redirect_url;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    }
                });
            });
        })
    </script>
@endsection
