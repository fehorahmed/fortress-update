@extends('layouts.master')

@section('title')
    Bank Edit
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header with-border">
                    <h3 class="card-title">Bank Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('bank.edit', ['bank' => $bank->id]) }}">
                    @csrf

                    <div class="card-body">
{{--                        <div class="form-group row {{ $errors->has('project') ? 'has-error' :'' }}">--}}
{{--                            <label class="col-sm-2 control-label">Project *</label>--}}

{{--                            <div class="col-sm-10">--}}
{{--                                <select class="form-control select2" style="width: 100%;" name="project">--}}
{{--                                    <option value="">Select Project</option>--}}
{{--                                    @foreach($projects as $project)--}}
{{--                                        <option value="{{ $project->id }}"  {{ empty(old('project')) ? ($errors->has('project') ? '' : ($bank->project_id == $project->id ? 'selected' : '')) :--}}
{{--                                            (old('project') == $project->id ? 'selected' : '') }}>{{ $project->name }}</option>--}}
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
                                       name="name" value="{{ empty(old('name')) ? ($errors->has('name') ? '' : $bank->name) : old('name') }}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Status *</label>

                            <div class="col-sm-10">

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" value="1" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($bank->status == '1' ? 'checked' : '')) :
                                            (old('status') == '1' ? 'checked' : '') }}>
                                        Active
                                    </label>
                                </div>

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" value="0" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($bank->status == '0' ? 'checked' : '')) :
                                            (old('status') == '0' ? 'checked' : '') }}>
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
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
