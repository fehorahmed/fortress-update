@extends('layouts.master')

@section('title')
    Purchase Product Edit
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header with-border">
                    <h3 class="card-title">Product Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('purchase_product.edit', ['product' => $product->id]) }}">
                    @csrf

                    <div class="card-body">

                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Name *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Name"
                                       name="name" value="{{ empty(old('name')) ? ($errors->has('name') ? '' : $product->name) : old('name') }}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('unit') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Unit *</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="unit">
                                    <option value="">Select Unit</option>

                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ empty(old('unit')) ? ($errors->has('unit') ? '' : ($product->unit_id == $unit->id ? 'selected' : '')) :
                                            (old('unit') == $unit->id ? 'selected' : '') }}>{{ $unit->name }}</option>
                                    @endforeach
                                </select>

                                @error('unit')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('code') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Code</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Code"
                                       name="code" value="{{ empty(old('code')) ? ($errors->has('code') ? '' : $product->code) : old('code') }}">

                                @error('code')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('estimate_cost') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Estimate Cost</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Estimate Cost"
                                       name="estimate_cost" value="{{ empty(old('estimate_cost')) ? ($errors->has('estimate_cost') ? '' : $product->estimate_cost) : old('estimate_cost') }}">

                                @error('estimate_cost')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('description') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Description</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Description"
                                       name="description" value="{{ empty(old('description')) ? ($errors->has('description') ? '' : $product->description) : old('description') }}">

                                @error('description')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('status') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Status *</label>

                            <div class="col-sm-10">

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" value="1" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($product->status == '1' ? 'checked' : '')) :
                                            (old('status') == '1' ? 'checked' : '') }}>
                                        Active
                                    </label>
                                </div>

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" value="0" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($product->status == '0' ? 'checked' : '')) :
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
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
