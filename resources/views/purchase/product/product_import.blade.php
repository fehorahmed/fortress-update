@extends('layouts.master')

@section('title')
   Purchase Product Import
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
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title"></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('product.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group {{ $errors->has('file') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Product csv file <span class="text-danger">*</span></label>

                            <div class="col-sm-10">
                                <input type="file" class="form-control" placeholder="Enter csv file"
                                       name="file" value="{{ old('file') }}" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                                @error('file')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Import file</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
