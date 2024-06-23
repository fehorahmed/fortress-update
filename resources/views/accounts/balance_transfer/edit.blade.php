@extends('layouts.master')

@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    Balance Transfer edit
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
                <div class="card-header with-border">
                    <h3 class="card-title">Balance Transfer Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('balance_transfer.edit', $balance_transfer->id) }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Type *</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="type" id="type">
                                    <option value="">Select Type</option>
                                    <option value="1" {{  $balance_transfer->type == '1' ? 'selected' : '' }}>Bank To Cash</option>
                                    <option value="2" {{  $balance_transfer->type == '2' ? 'selected' : '' }}>Cash To Bank</option>
                                    <option value="3" {{  $balance_transfer->type == '3' ? 'selected' : '' }}>Bank To Bank</option>
                                    <option value="4" {{  $balance_transfer->type == '4' ? 'selected' : '' }}>Cheque To Bank</option>
                                    <option value="5" {{  $balance_transfer->type == '5' ? 'selected' : '' }}>Cheque To Cach</option>

                                </select>

                                @error('type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div id="source-bank-info">
                            <div class="form-group row {{ $errors->has('source_bank') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Source Bank *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="source_bank" id="source_bank">
                                        <option value="">Select Bank</option>

                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ old('source_bank', $balance_transfer->source_bank_id) == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('source_bank')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('source_branch') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Source Branch *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="source_branch" id="source_branch">
                                        <option value="">Select Branch</option>
                                    </select>

                                    @error('source_branch')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('source_account') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Source Account *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="source_account" id="source_account">
                                        <option value="">Select Account</option>
                                    </select>

                                    @error('source_account')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('source_cheque_no') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Source Cheque No</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="source_cheque_no" value="{{ old('source_cheque_no', $balance_transfer->source_cheque_no) }}">

                                    @error('source_cheque_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('source_cheque_image') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Source Cheque Image</label>

                                <div class="col-sm-10">
                                    <p>
                                        <a href="{{ url('public/'.$balance_transfer->source_cheque_image) }}" target="_blank"> Show Previous Cheque Image </a>
                                    </p>
                                    <input type="file" class="form-control" name="source_cheque_image">

                                    @error('source_cheque_image')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="target-bank-info">
                            <div class="form-group row {{ $errors->has('target_bank') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Target Bank *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="target_bank" id="target_bank">
                                        <option value="">Select Bank</option>

                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ old('target_bank', $balance_transfer->target_bank_id) == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('target_bank')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('target_branch') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Target Branch *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="target_branch" id="target_branch">
                                        <option value="">Select Branch</option>
                                    </select>

                                    @error('target_branch')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('target_account') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Target Account *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="target_account" id="target_account">
                                        <option value="">Select Account</option>
                                    </select>

                                    @error('target_account')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('target_cheque_no') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Target Cheque No</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="target_cheque_no" value="{{ old('target_cheque_no', $balance_transfer->target_cheque_no) }}">

                                    @error('target_cheque_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('target_cheque_image') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Target Cheque Image</label>

                                <div class="col-sm-10">
                                    <p>
                                        <a href="{{ url('public/'.$balance_transfer->target_cheque_image) }}" target="_blank"> Show Previous Cheque Image </a>
                                    </p>
                                    <input type="file" class="form-control" name="target_cheque_image">

                                    @error('target_cheque_image')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('amount') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Amount *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="amount" placeholder="Enter Amount" value="{{ old('amount',$balance_transfer->amount) }}">

                                @error('amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('date') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Date *</label>

                            <div class="col-sm-10">
                                <div class="input-group ">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" name="date" value="{{ empty(old('date')) ? ($errors->has('date') ? '' : date('d-m-Y', strtotime($balance_transfer->date))) : old('date', date('d-m-Y', strtotime($balance_transfer->date))) }}" autocomplete="off">
                                </div>
                                <!-- /.input group -->

                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('note') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Note</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="note" placeholder="Enter Note" value="{{ old('note',$balance_transfer->note) }}">

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
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function () {
            var sourceBranchSelected = '{{ old('source_branch') }}';
            var sourceAccountSelected = '{{ old('source_account') }}';
            var targetBranchSelected = '{{ old('target_branch') }}';
            var targetAccountSelected = '{{ old('target_account') }}';

            //Date picker
            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('#type').change(function () {
                var type = $(this).val();

                $('#account_head_type').html('<option value="">Select Account Head Type</option>');
                $('#account_head_sub_type').html('<option value="">Select Account Head Sub Type</option>');

                if (type != '') {
                    if (type == '1') {
                        $('#source-bank-info').show();
                        $('#target-bank-info').hide();
                    } else if (type == '2') {
                        $('#source-bank-info').hide();
                        $('#target-bank-info').show();
                    } else if (type == '3')  {
                        $('#source-bank-info').show();
                        $('#target-bank-info').show();
                    }else if (type == '4')  {
                        $('#source-bank-info').hide();
                        $('#target-bank-info').show();
                    }else if (type == '5')  {
                        $('#source-bank-info').hide();
                        $('#target-bank-info').hide();
                    }
                } else {
                    $('#source-bank-info').hide();
                    $('#target-bank-info').hide();
                }
            });

            $('#type').trigger('change');

            $('#source_bank').change(function () {
                var bankId = $(this).val();
                $('#source_branch').html('<option value="{{ $balance_transfer->source_branch_id }}">{{ $balance_transfer->source_branch->name??"" }}</option>');
                $('#source_account').html('<option value="">Select Account</option>');

                if (bankId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branch') }}",
                        data: { bankId: bankId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (sourceBranchSelected == item.id)
                                $('#source_branch').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#source_branch').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });

                        $('#source_branch').trigger('change');
                    });
                }

                $('#source_branch').trigger('change');
            });

            $('#source_bank').trigger('change');

            $('#source_branch').change(function () {
                var branchId = $(this).val();
                $('#source_account').html('<option value="{{ $balance_transfer->source_bank_account_id }}">{{ $balance_transfer->source_bank_account->account_no??"" }}</option>');

                if (branchId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_account') }}",
                        data: { branchId: branchId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (sourceAccountSelected == item.id)
                                $('#source_account').append('<option value="'+item.id+'" selected>'+item.account_no+'</option>');
                            else
                                $('#source_account').append('<option value="'+item.id+'">'+item.account_no+'</option>');
                        });
                    });
                }
            });

            $('#target_bank').change(function () {
                var bankId = $(this).val();
                $('#target_branch').html('<option value="{{ $balance_transfer->target_branch_id }}"> {{ $balance_transfer->target_branch->name??"" }} </option>');
                $('#target_account').html('<option value="">Select Account</option>');

                if (bankId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branch') }}",
                        data: { bankId: bankId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (targetBranchSelected == item.id)
                                $('#target_branch').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#target_branch').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });

                        $('#target_branch').trigger('change');
                    });
                }

                $('#target_branch').trigger('change');
            });

            $('#target_bank').trigger('change');

            $('#target_branch').change(function () {
                var branchId = $(this).val();
                $('#target_account').html('<option value="{{ $balance_transfer->target_bank_account_id }}">{{ $balance_transfer->target_bank_account->account_no??"" }}</option>');

                if (branchId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_account') }}",
                        data: { branchId: branchId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (targetAccountSelected == item.id)
                                $('#target_account').append('<option value="'+item.id+'" selected>'+item.account_no+'</option>');
                            else
                                $('#target_account').append('<option value="'+item.id+'">'+item.account_no+'</option>');
                        });
                    });
                }
            });
        });
    </script>
@endsection
