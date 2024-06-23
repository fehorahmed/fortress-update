@extends('layouts.master')

@section('title')
    Account Head Add
@endsection

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Account Head Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('account_head.type.add') }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('type') ? 'has-error' :'' }}">

                                <label class="col-sm-2 control-label">Type <span class="text-danger">*</span></label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="type">
                                        <option value="">Select Type</option>
                                        <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Income</option>
                                        <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Expense</option>
                                    </select>

                                    @error('type')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                        </div>

{{--                        <div class="form-group row {{ $errors->has('project') ? 'has-error' :'' }}">--}}
{{--                            <label class="col-sm-2 control-label">Project *</label>--}}
{{--                            <div class="col-sm-10">--}}
{{--                                <select class="form-control" name="project" id="project">--}}
{{--                                    <option value="">Select Project</option>--}}

{{--                                    @foreach($projects as $project)--}}
{{--                                        <option value="{{ $project->id }}" {{ old('project') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}

{{--                                @error('project')--}}
{{--                                <span class="help-block">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">

                                <label class="col-sm-2 control-label">Name <span class="text-danger">*</span> </label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Enter Name"
                                           name="name" value="{{ old('name') }}">

                                    @error('name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                        </div>

                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">

                                <label class="col-sm-2 control-label">Status <span class="text-danger">*</span></label>

                                <div class="col-sm-10">

                                    <div class="radio" style="display: inline">
                                        <label>
                                            <input type="radio" name="status"
                                                   value="1" {{ old('status') == '1' ? 'checked' : '' }}>
                                            Active
                                        </label>
                                    </div>

                                    <div class="radio" style="display: inline">
                                        <label>
                                            <input type="radio" name="status"
                                                   value="0" {{ old('status') == '0' ? 'checked' : '' }}>
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
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection
