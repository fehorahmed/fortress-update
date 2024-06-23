@extends('layouts.master')
@section('style')
    <style>
        select.form-control.equipment {
            width: 138px !important;
        }
        input.form-control.quantity {
            width: 90px;
        }
        input.form-control.unit_price,input.form-control.selling_price{
            width: 130px;
        }
        th {
            text-align: center;
        }
        select.form-control {
            min-width: 120px;
        }
    </style>
@endsection

@section('title')
    Add Bank Loan
@endsection

@section('style')
    <!-- bootstrap datepicker -->
    {{-- <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"> --}}

@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Bank Loan Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('loan.add') }}">
                    @csrf
                    <div class="box-body">

                        <div class="form-group {{ $errors->has('bank') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Bank Name <span style="color: red">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="bank" placeholder="Bank Name">

                                @error('bank')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('loan_type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Loan Type*</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="loan_type" id="loan_type">
                                    <option value=""> Select Loan Type </option>
                                    <option value="1" {{ old('loan_type') == '1' ? 'selected' : '' }}>Taken </option>
                                    <option value="2" {{ old('loan_type') == '2' ? 'selected' : '' }}> Given </option>
                                </select>

                                @error('loan_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('payment_type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Payment type*</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="payment_type" id="payment_type">
                                    <option value="1" {{ old('payment_type') == '1' ? 'selected' : '' }}> Cash </option>
                                    <option value="2" {{ old('payment_type') == '2' ? 'selected' : '' }}>  Bank </option>
                                </select>

                                @error('payment_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div id="modal-cash-info" style="background-color: lightgrey; padding: 10px; border-radius: 3px;"></div>

                        <div id="bank-info">
                            <div class="form-group {{ $errors->has('bank') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Bank *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="bank" id="bank">
                                        <option value=""> Select Bank </option>

                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ old('bank') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('bank')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('branch') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Branch <span style="color: red"> *</span></label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="branch" id="branch">
                                        <option value=""> Select Branch</option>
                                    </select>

                                    @error('branch')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('account') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Account <span style="color: red"> *</span></label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="account" id="account">
                                        <option value=""> Select Account</option>
                                    </select>

                                    @error('account')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('cheque_no') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Cheque Number </label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cheque_no" placeholder="Cheque Number">

                                    @error('cheque_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('cheque_image') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Cheque Image</label>

                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="cheque_image">

                                    @error('cheque_image')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('cheque_date') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Cheque Date *</label>

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
                            <label class="col-sm-2 control-label"> Amount <span style="color: red">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder=""
                                       name="amount" value="{{ old('amount') }}">

                                @error('amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('bank') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Loan Percentage % <span style="color: red">*</span></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="bank" placeholder="Loan Percentage">

                                @error('bank')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('duration') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Loan Duration <span style="color: red">*</span></label>

                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="duration" placeholder="Enter duration by month">

                                @error('duration')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group {{ $errors->has('date') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Date <span style="color: red"> *</span></label>

                            <div class="col-sm-10">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                <input type="text" id="date" class="form-control"
                                       name="date" value="{{ old('date') }}" autocomplete="off">
                                </div>

                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary"> Save </button>
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
            var branchSelected = '{{ old('branch') }}';
            var accountSelected = '{{ old('account') }}';

            //Date picker
            $('#date,#cheque_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
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
                $('#branch').html('<option value=""> ব্রাঞ্চ নির্বাচন করুন </option>');
                $('#account').html('<option value=""> একাউন্ট নির্বাচন করুন </option>');

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
                $('#account').html('<option value=""> একাউন্ট নির্বাচন করুন </option>');

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
