@extends('layouts.master')

@section('title')
    Supplier Add
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header with-border">
                    <h3 class="card-title">Supplier Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('supplier.add') }}">
                    @csrf

                    <div class="card-body">

{{--                        <div class="form-group row {{ $errors->has('project') ? 'has-error' :'' }}">--}}
{{--                            <label class="col-sm-2 control-label">Project *</label>--}}

{{--                            <div class="col-sm-10">--}}
{{--                                <select class="form-control select2" style="width: 100%;" name="project">--}}
{{--                                    <option value="">Select Project</option>--}}
{{--                                    @foreach($projects as $project)--}}
{{--                                        <option value="{{ $project->id }}"  {{ old('project') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}

{{--                                @error('project')--}}
{{--                                <span class="help-block">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Name *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Name"
                                       name="name" value="{{ old('name') }}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('company_name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Company Name </label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Company Name"
                                       name="company_name" value="{{ old('company_name') }}">

                                @error('company_name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('mobile') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Mobile Number * </label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Mobile number"
                                       name="mobile" value="{{ old('mobile') }}">

                                @error('mobile')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('alternative_mobile') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Alternative Mobile Number  </label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Mobile number"
                                       name="alternative_mobile" value="{{ old('alternative_mobile') }}">

                                @error('alternative_mobile')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('email') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Email  </label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Email"
                                       name="email" value="{{ old('email') }}">

                                @error('email')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('address') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Address  *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Address"
                                       name="address" value="{{ old('address') }}">

                                @error('address')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Status *</label>

                            <div class="col-sm-10">

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" value="1" {{ old('status') == '1' ? 'checked' : '' }}>
                                        Active
                                    </label>
                                </div>

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }}>
                                        Inactive
                                    </label>
                                </div>

                                @error('status')
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
