@extends('layouts.master')

@section('title')
    Supplier Payment Edit
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header with-border">
                    <h3 class="card-title"> Supplier Payment Edit Information</h3>
                </div>

                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('purchase_receipt.payment_edit',['payment' => $payment->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Name *</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" readonly
                                       value="{{ old('name',$payment->supplier->name??'') }}">
                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('supplier_due') ? 'has-error' :'' }}">
                            <label for="supplier_due" class="col-sm-2 control-label">Supplier Due *</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="supplier_due" readonly
                                       value="{{ old('supplier_due', $payment->supplier->due) }}">
                                @error('supplier_due')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('segment') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Segment *</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="segment" id="segment" required>
                                    <option value="">Select Segment</option>
                                    @foreach($segments as $segment)
                                        <option value="{{ $segment->id }}" {{ old('segment', $payment->segment_id) == $segment->id ? 'selected' : '' }}>{{ $segment->name }}</option>
                                    @endforeach
                                </select>
                                @error('segment')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('payment_type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Payment Type *</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="payment_type" id="payment_type" required>
                                    <option value="1" {{ old('payment_type',$payment->transaction_method) == '1' ? 'selected' : '' }}>Cash</option>
                                    <option value="2" {{ old('payment_type',$payment->transaction_method) == '2' ? 'selected' : '' }}>Bank</option>
                                </select>
                                @error('payment_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                                <div id="modal-order-info"
                                     style="background-color: lightgrey; padding: 10px; border-radius: 3px;margin-top: 10px"></div>
                            </div>
                        </div>

                        <div id="bank-info">
                            <div class="form-group row {{ $errors->has('bank') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Bank & Account*</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="account" id="account">
                                        <option value="">Select Bank</option>
                                        @foreach($bankAccounts as $bankAccount)
                                            <option value="{{ $bankAccount->id }}" {{ old('account',$payment->bank_account_id) == $bankAccount->id ? 'selected' : '' }}>{{ $bankAccount->bank->name }}-{{ $bankAccount->branch->name }}-{{ $bankAccount->account_no }}</option>
                                        @endforeach
                                    </select>
                                    @error('account')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('cheque_no') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Cheque No</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ old('cheque_no',$payment->cheque_no) }}" name="cheque_no" placeholder="Enter Cheque No.">
                                    @error('cheque_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('cheque_image') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Cheque Image</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="cheque_image">
                                    @error('cheque_image')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('cheque_date') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Cheque Date *</label>
                                <div class="col-sm-10">
                                    <div class="input-group date">
                                        <input type="text" class="form-control pull-right"
                                               name="cheque_date" value="{{old('Y-m-d',date('Y-m-d',strtotime($payment->cheque_date)))}}" autocomplete="off">
                                    </div>
                                    @error('cheque_date')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group row {{ $errors->has('amount') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Amount *</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="amount" placeholder="Enter Amount" value="{{ old('amount',$payment->amount) }}">
                                @error('amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('date') ? 'has-error' :'' }}">
                            <label for="date" class="col-sm-2 control-label">Date *</label>
                            <div class="col-sm-10">
                                <div class="input-group date">
                                    <input type="text" class="form-control pull-right" name="date" value="{{old('Y-m-d',date('Y-m-d',strtotime($payment->date)))}}" autocomplete="off">
                                </div>
                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('note') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Note</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="note" placeholder="Enter Note" value="{{ old('note',$payment->note) }}">
                                @error('note')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- bootstrap datepicker -->

    <script>
        $(function () {
            var accountHeadTypeSelected = '{{ old('account_head_type',$payment->account_head_type_id) }}';
            var accountHeadSubTypeSelected = '{{ old('account_head_sub_type',$payment->account_head_sub_type_id) }}';
            var branchSelected = '{{ old('branch') }}';
            var accountSelected = '{{ old('account') }}';

            //Date picker
            $('#cheque_date,#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('#type').change(function () {
                var type = $(this).val();

                $('#account_head_type').html('<option value="">Select Account Head</option>');
                $('#account_head_sub_type').html('<option value="">Select Account Sub Head</option>');

                if (type != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_account_head_type') }}",
                        data: { type: type }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (accountHeadTypeSelected == item.id)
                                $('#account_head_type').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#account_head_type').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });

                        $('#account_head_type').trigger('change');
                    });

                    if (type == '2')
                        $('#location').show();
                    else
                        $('#location').hide();
                } else {
                    $('#location').hide();
                }
            });

            $('#type').trigger('change');

            $('#account_head_type').change(function () {
                var typeId = $(this).val();

                $('#account_head_sub_type').html('<option value="">Select Account Sub Head</option>');

                if (typeId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_account_head_sub_type') }}",
                        data: { typeId: typeId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (accountHeadSubTypeSelected == item.id)
                                $('#account_head_sub_type').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#account_head_sub_type').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                    });
                }
            });

            $('#payment_type').change(function () {

                var projectId = '{{\Illuminate\Support\Facades\Auth::user()->project_id}}';
                $('#modal-order-info').html("");

                if ($(this).val() == '1'){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_cash_info') }}",
                        data: {projectId: projectId}
                    }).done(function (response) {
                        $('#modal-order-info').html('<strong>Total: </strong>৳' + parseFloat(response.amount).toFixed(2)) ;
                        //$('#modal-order-info').show();
                    });
                }
                if ($(this).val() == '2'){
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_amount_info') }}",
                        data: {projectId: projectId}
                    }).done(function (response) {
                        $('#modal-order-info').html('<strong>Total: </strong>৳' + parseFloat(response).toFixed(2)) ;
                        //$('#modal-order-info').show();
                    });
                }
                if ($(this).val() == '1' || $(this).val() == '3') {
                    $('#bank-info').hide();
                } else {
                    $('#bank-info').show();
                }
            });

            $('#payment_type').trigger('change');

            $('#bank').change(function () {
                var bankId = $(this).val();
                $('#branch').html('<option value="">Select Branch</option>');
                $('#account').html('<option value="">Select Account</option>');

                if (bankId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branch') }}",
                        data: { bankId: bankId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (branchSelected == item.id)
                                $('#branch').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#branch').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });

                        $('#branch').trigger('change');
                    });
                }

                $('#branch').trigger('change');
            });

            $('#bank').trigger('change');

            $('#branch').change(function () {
                var branchId = $(this).val();
                $('#account').html('<option value="">Select Account</option>');

                if (branchId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_account') }}",
                        data: { branchId: branchId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (accountSelected == item.id)
                                $('#account').append('<option value="'+item.id+'" selected>'+item.account_no+'</option>');
                            else
                                $('#account').append('<option value="'+item.id+'">'+item.account_no+'</option>');
                        });
                    });
                }
            });
        });
    </script>
@endsection
