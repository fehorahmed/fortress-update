@extends('layouts.master')

@section('title')
    লোন এডিট
@endsection
@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"> লোনের তথ্যাবলী </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('loan.edit',$loan->id) }}">
                    @csrf

                    <div class="box-body">
                        <div class="form-group {{ $errors->has('loan_holder') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> লোন হোল্ডার *</label>

                            <div class="col-sm-10">
                                <select name="loan_holder" class="form-control">
                                    <option value=""> লোন হোল্ডার নির্বাচন করুন </option>
                                    @foreach($holders as $holder)
                                        <option value="{{$holder->id}}" {{old('loan_holder', $loan->loan_holder_id)==$holder->id?'selected':''}}>{{$holder->name}}</option>
                                    @endforeach
                                </select>

                                @error('loan_holder')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="form-group {{ $errors->has('loan_number') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Loan Number</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Loan Number"
                                       name="loan_number" value="{{ old('loan_number',$loan->loan_number) }}">

                                @error('loan_number')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}
                        {{-- <div class="form-group {{ $errors->has('title') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Loan Title</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Loan Title"
                                       name="title" value="{{old('title',$loan->title)}}">
                                @error('title')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="form-group {{ $errors->has('payment_type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">পেমেন্টের ধরণ *</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="payment_type" id="payment_type">
                                    <option value="1" {{ old('payment_type', $loan->transaction_method) == '1' ? 'selected' : '' }}>ক্যাশ</option>
                                    <option value="2" {{ old('payment_type', $loan->transaction_method) == '2' ? 'selected' : '' }}>ব্যাংক</option>
                                </select>

                                @error('payment_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div id="bank-info">
                            <div class="form-group {{ $errors->has('bank') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">ব্যাংক *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="bank" id="bank">
                                        <option value=""> ব্যাংক নির্বাচন করুন </option>

                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ old('bank', $transaction->bank->name??'') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('bank')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('branch') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">ব্রাঞ্চ *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="branch" id="branch">
                                        <option value=""> ব্রাঞ্চ নির্বাচন করুন </option>
                                    </select>

                                    @error('branch')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('account') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> একাউন্ট *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="account" id="account">
                                        <option value=""> একাউন্ট নির্বাচন করুন </option>
                                    </select>

                                    @error('account')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('cheque_no') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> চেক নাম্বার </label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cheque_no" value="{{ old('cheque_no', $transaction->cheque_no) }}" placeholder="Enter Cheque No.">

                                    @error('cheque_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('cheque_image') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> চেকের ছবি </label>

                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="cheque_image">

                                    @error('cheque_image')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('cheque_date') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> চেকের তারিখ *</label>

                                <div class="col-sm-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="cheque_date" name="cheque_date" value="{{ empty(old('date')) ? ($errors->has('cheque_date') ? '' : date('Y-m-d')) : old('cheque_date') }}" autocomplete="off">
                                    </div>
                                    <!-- /.input group -->

                                    @error('cheque_date')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="form-group {{ $errors->has('amount') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> এমাউন্ট </label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder=""
                                       name="amount" value="{{ old('amount', $loan->total) }}">

                                @error('amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="form-group {{ $errors->has('duration') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Loan Duration</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Duration"
                                       name="duration" value="{{ old('duration', $loan->duration) }}">

                                @error('duration')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="form-group {{ $errors->has('note') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> নোট *</label>

                            <div class="col-sm-10">

                                <input type="text" class="form-control" placeholder="Enter Note"
                                       name="note" value="{{ old('note', $loan->note) }}">

                                @error('note')
                                <span class="help-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('date') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">তারিখ *</label>

                            <div class="col-sm-10">

                                <input type="text" id="date" class="form-control"
                                       name="date" value="{{ old('date', date('Y-m-d', strtotime($loan->date))) }}" autocomplete="off">

                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"> সেভ </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- bootstrap datepicker -->
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $(function () {
            //Date picker
            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });

    </script>
    <script>
        $(function () {
            var accountHeadTypeSelected = '{{ old('account_head_type') }}';
            var accountHeadSubTypeSelected = '{{ old('account_head_sub_type') }}';
            var branchSelected = '{{ old('branch') }}';
            var accountSelected = '{{ old('account') }}';

            //Date picker
            $('#date,#cheque_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('#type').change(function () {
                var type = $(this).val();

                $('#account_head_type').html('<option value="">Select Account  Head Name</option>');
                $('#account_head_sub_type').html('<option value="">Select Account Sub Head Name</option>');

                if (type != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_account_head_type_trx') }}",
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

                $('#account_head_sub_type').html('<option value="">Select Account Sub Head Name</option>');

                if (typeId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_account_head_sub_type_trx') }}",
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
                if ($(this).val() == '1' || $(this).val() == '3') {
                    $('#bank-info').hide();
                } else {
                    $('#bank-info').show();
                }
            });

            $('#payment_type').trigger('change');

            $('#bank').change(function () {
                var bankId = $(this).val();
                $('#branch').html('<option value="{{ $transaction->branch_id }}"> {{ $transaction->branch->name??"Select Branch" }} </option>');
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
                $('#account').html('<option value="{{ $transaction->bank_account_id }}">{{ $transaction->account->account_no??"Select Account" }}</option>');

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
