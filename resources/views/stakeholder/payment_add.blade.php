@extends('layouts.master')

@section('title')
    Stake Holder Installment
@endsection

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <button class="pull-right btn btn-primary" onclick="getprint('prinarea')">Print</button>
                    <div class="table-responsive" id="prinarea">
                        <div class="row" id="heading_area" style="margin-bottom: 10px!important;display: none">
                            <div class="col-sm-12 text-center" style="font-size: 16px">
                                <h2 style="margin-bottom: 0 !important;"><img width="75px"
                                                                              src="{{ asset('img/logo.jpeg') }}" alt="">
                                    <strong
                                        style="border-bottom: 2px dotted #000;"><i>{{ config('app.name') }}</i></strong>
                                </h2>
                                <strong style="border: 2px solid #000;padding: 1px 10px;font-size: 19px;">Supplier
                                    Report</strong>
                                <p class="">Printed by: {{Auth::user()->name}}</p>
                            </div>
                            <div class="col-sm-3 col-sm-offset-9">
                                <span class="date-top">Date: <strong
                                        style="border: 1px solid #000;padding: 1px 10px;font-size: 16px;width: 100%;font-weight: normal;">{{ date('d-m-Y') }}</strong></span>
                            </div>
                        </div>
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Mobile no</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Advance</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            @php
                              $total = 0;
                              $paid = 0;
                              $due  = 0;
                              $advance = 0;

                            @endphp
                            @foreach($stackholders as $stackholder)

                                    @php
                                        $total +=  $stackholder->budget_total ?? 0;
                                        $paid +=  $stackholder->budget_paid ?? 0;
                                        $due +=  $stackholder->budget_due ?? 0;
                                        if($stackholder->paid > $stackholder->total){
                                            $advance += $stackholder->paid + $stackholder->total;
                                            return number_format($advance, 2);
                                        }
                                        $advance += number_format(0, 2);
                                    @endphp
                            @endforeach
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th>{{ number_format($total  ?? 0, 2); }}</th>
                                <th>{{ number_format($paid  ?? 0, 2); }}</th>
                                <th>{{ number_format($due  ?? 0, 2); }}</th>
                                <th>{{ number_format(abs($advance)  ?? 0, 2); }}</th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
    <div class="modal fade" id="modal-pay">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">

                    <h4 class="modal-title">Payment Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modal-form" enctype="multipart/form-data" name="modal-form">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" id="modal-name" disabled>
                        </div>

                        <input type="number" name="stakeholder_id" id="stakeholder_id" hidden>

                        <div class="form-group">
                            <label>Total Due</label>
                            <input type="text" class="form-control" id="total_due"
                                   name="total_due" readonly>
                        </div>

                        <div class="form-group">
                            <label>Segment</label>
                            <select class="form-control" name="segment">
                                <option value="">Select Segment</option>
                                @foreach($segments as $segment)
                                    <option
                                        value="{{ $segment->id }}" {{ request()->get('segment') == $segment->id ? 'selected' : '' }}>{{ $segment->name}}</option>
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
                                <label>Bank & Account</label>
                                <select class="form-control modal-bank" name="account">
                                    <option value="">Select Bank</option>
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
                            <input class="form-control" name="amount" id="amount" placeholder="Enter Amount" >
                        </div>

                        <div class="form-group">
                            <label>Payment Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" name="date" value="" autocomplete="off">
                            </div>
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
@endsection

@section('script')
    <script>
          var APP_URL = '{!! url()->full()  !!}';

    function getprint(prinarea) {
        $('#heading_area').show();
        $('body').html($('#' + prinarea).html());
        window.print();
        window.location.replace(APP_URL)
    }

        $(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('stakeholder.payment.datatable') }}',
                columns: [
                    {data: 'name', name: 'name'},
                    // {data: 'project', name: 'project'},
                    {data: 'address', name: 'address'},
                    {data: 'mobile_no', name: 'mobile_no'},
                    {data: 'total', name: 'total'},
                    {data: 'paid', name: 'paid'},
                    {data: 'due', name: 'due'},
                    {data: 'advance', name: 'advance'},
                    {data: 'action', name: 'action', orderable: false},
                ]
            });

            //Date picker
            $('#date, #next-payment-date, #date-refund').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('body').on('click', '.btn-pay', function () {
                $('#modal_project_payment_type').empty();
                 var stakeholderId = $(this).data('id');
                var stakeholderName = $(this).data('name');
                var totalDue = $(this).data('due');
                $('#stakeholder_id').val(stakeholderId);
                $('#modal-name').val(stakeholderName);
                $('#total_due').val(totalDue);
                $('#modal-pay').modal('show');
            });

            $('#modal-btn-pay').click(function () {
                var formData = new FormData($('#modal-form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('stakeholder_payment.make_payment') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $('#modal-pay').modal('hide');
                            Swal.fire(
                                'Paid!',
                                response.message,
                                'success'
                            ).then((result) => {
                                // location.reload();
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
                if ($(this).val() == '1' || $(this).val() == '3') {
                    $('#modal-bank-info').hide();
                } else {
                    $('#modal-bank-info').show();
                }
            });

            $('#modal-pay-type').trigger('change');

            $('.modal-bank').change(function () {
                var bankId = $(this).val();
                $('.modal-branch').html('<option value="">Select Branch</option>');
                $('.modal-account').html('<option value="">Select Account</option>');

                if (bankId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branch') }}",
                        data: {bankId: bankId}
                    }).done(function (response) {
                        $.each(response, function (index, item) {
                            $('.modal-branch').append('<option value="' + item.id + '">' + item.name + '</option>');
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
                        data: {branchId: branchId}
                    }).done(function (response) {
                        $.each(response, function (index, item) {
                            $('.modal-account').append('<option value="' + item.id + '">' + item.account_no + '</option>');
                        });
                    });
                }
            });


        });

        function checkNextPayment() {
            var paid = $('#amount').val();

            if (paid == '' || paid < 0 || !$.isNumeric(paid))
                paid = 0;

            if (parseFloat(paid) >= due)
                $('#fg-next-payment-date').hide();
            else
                $('#fg-next-payment-date').show();
        }

    </script>
@endsection
