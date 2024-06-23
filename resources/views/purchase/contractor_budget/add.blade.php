@extends('layouts.master')

@section('title')
    Contractor Budget Add
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header with-border">
                    <h3 class="card-title">Contractor Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('contractor_budget.add') }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('contractor') ? 'has-error' : '' }}">
                                <label class="col-sm-2 control-label">Contractor *</label>

                            <div class="col-sm-10">
                                <select class="form-control select2" style="width: 100%;"
                                        name="contractor" data-placeholder="Select Contractor">
                                    <option value="">Select Contractor</option>
                                    @foreach ($contractors as $contractor)
                                        <option value="{{ $contractor->id }}"
                                            {{ old('contractor') == $contractor->id ? 'selected' : '' }}>
                                            {{ $contractor->name }}</option>
                                    @endforeach
                                </select>

                                @error('contractor')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('segment') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">Segment *</label>

                            <div class="col-sm-10">
                                <select class="form-control select2" style="width: 100%;"
                                        name="segment" data-placeholder="Select Segment">
                                    <option value="">Select Segment</option>
                                    <option value="0">All</option>
                                    @foreach ($segments as $segment)
                                        <option value="{{ $segment->id }}"
                                            {{ old('segment') == $segment->id ? 'selected' : '' }}>
                                            {{ $segment->name }}</option>
                                    @endforeach
                                </select>

                                @error('segment')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('budget') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Budget * </label>

                            <div class="col-sm-10">
                                <input type="number" class="form-control" placeholder="Enter Budget"
                                       name="budget" value="{{ old('budget') }}">

                                @error('budget')
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
