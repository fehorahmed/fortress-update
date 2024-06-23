@extends('layouts.master')

@section('title')
    Cash Add
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
                    <h3 class="card-title">Add Cash Information </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('cash_add') }}">
                    @csrf

                    <div class="card-body">
                        {{-- @if (empty($cash)) --}}
                            {{-- <div class="form-group row {{ $errors->has('opening_balance') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Opening Balance <span style="color: red">*</span></label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Opening Balance"
                                        name="opening_balance" value="{{ old('opening_balance') }}">
                                    @error('opening_balance')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}
                        {{-- @else --}}
                            {{-- <div class="form-group row {{ $errors->has('amount') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Balance <span style="color: red">*</span></label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Blance"
                                        name="amount">
                                    @error('amount')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="form-group row {{ $errors->has('opening_balance') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Opening Blance <span style="color: red">*</span></label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Opening Blance"
                                        name="opening_balance">
                                    @error('opening_balance')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        {{-- @endif --}}

                    </div>
                    <!-- /.box-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"> Save </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
