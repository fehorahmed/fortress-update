@extends('layouts.master')

@section('title')
    Stakeholder Edit
@endsection

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Stakeholder Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('stakeholder.edit', ['stakeholder' => $stakeholder->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group row {{ $errors->has('id_no') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label">Id No <span class="text-danger">*</span></label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control"
                                               name="id_no" value="{{ old('id_no',$stakeholder->id_no) }}" readonly>

                                        @error('id_no')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label">Name <span class="text-danger">*</span></label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Enter Name"
                                               name="name" value="{{ old('name',$stakeholder->name) }}">

                                        @error('name')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('father_name') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label">Father Name</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Enter Father Name"
                                               name="father_name" value="{{ old('father_name',$stakeholder->father_name) }}">

                                        @error('father_name')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('address') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label">Address</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Enter Address"
                                               name="address" value="{{ old('address',$stakeholder->address) }}">

                                        @error('address')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('nid') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label">Nid</label>

                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" placeholder="Enter Nid Number"
                                               name="nid" value="{{ old('nid',$stakeholder->nid) }}">

                                        @error('nid')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('mobile_no') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label">Phone No <span class="text-danger">*</span></label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Enter Phone No"
                                               name="mobile_no" value="{{ old('mobile_no',$stakeholder->mobile_no) }}">

                                        @error('mobile_no')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row {{ $errors->has('email') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label">Email <span class="text-danger">*</span></label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Enter Email "
                                               name="email" value="{{ old('email',$user->email ??0) }}" readonly>

                                        @error('email')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
{{--                                <div class="form-group row {{ $errors->has('username') ? 'has-error' :'' }}">--}}
{{--                                    <label class="col-sm-3 control-label">User Name <span class="text-danger">*</span></label>--}}

{{--                                    <div class="col-sm-9">--}}
{{--                                        <input type="text" class="form-control" placeholder="Enter Username "--}}
{{--                                               name="username" value="{{ old('username',$user->username) }}" readonly>--}}

{{--                                        @error('username')--}}
{{--                                        <span class="help-block">{{ $message }}</span>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="form-group row {{ $errors->has('password') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label"> Password <span class="text-danger">*</span></label>

                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" placeholder="Enter Password "
                                               name="password" value="{{ old('password') }}" readonly>

                                        @error('password')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('password_confirmation') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label"> Confirm Password <span class="text-danger">*</span></label>

                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" placeholder="Enter Password Again"
                                               name="password_confirmation" value="{{ old('password_confirmation') }}" readonly>

                                        @error('password_confirmation')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection
