@extends('layouts.master')

@section('title')
    Stake Holder Add
@endsection

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Stakeholder Information</h3>

{{--                    @if($errors->any())--}}
{{--                        {{ implode('', $errors->all('<div>:message</div>')) }}--}}
{{--                    @endif--}}


                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('stakeholder.add') }}">
                    @csrf


                    <div class="card-body">
                        <div class="row">
{{--                            <div class="col-sm-6">--}}
{{--                                <div class="form-group row {{ $errors->has('project') ? 'has-error' :'' }}">--}}
{{--                                    <label class="col-sm-3 control-label">Project <span--}}
{{--                                            class="text-danger">*</span></label>--}}

{{--                                    <div class="col-sm-9">--}}
{{--                                        <select name="project" id="" class="form-control project">--}}

{{--                                            <option value="">Select one</option>--}}
{{--                                            @foreach($projects as $project)--}}
{{--                                                <option--}}
{{--                                                    {{old('project')==$project->id ?'selected':''}} value="{{$project->id}}">{{$project->name}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}

{{--                                        @error('project')--}}
{{--                                        <span class="help-block">{{ $message }}</span>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-sm-6">
                                <div class="form-group row {{ $errors->has('stakeholder_type') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label">Type <span
                                            class="text-danger">*</span></label>

                                    <div class="col-sm-9">
                                        <select name="stakeholder_type" id="stakeholder_type"
                                                class="form-control stakeholder_type">
                                            <option {{old('stakeholder_type')== 2 ?'selected':''}} value="2">New</option>
                                            <option {{old('stakeholder_type')== 1 ?'selected':''}} value="1">Old</option>

                                        </select>

                                        @error('stakeholder_type')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6" id="stakeholder_area">
                                <div class="form-group row {{ $errors->has('stakeholder_id') ? 'has-error' :'' }}">
                                    <label class="col-sm-3 control-label">Stakeholder <span
                                            class="text-danger">*</span></label>

                                    <div class="col-sm-9">
                                        <select name="stakeholder_id" id="" class="form-control stakeholder select2">

                                            <option value="">Select one</option>
                                            @foreach($stakeholders as $stakeholder)
                                                <option
                                                    {{old('stakeholder_id')==$stakeholder->id ?'selected':''}} value="{{$stakeholder->id}}">{{$stakeholder->name}}</option>
                                            @endforeach
                                        </select>

                                        @error('stakeholder_id')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div id="new_area1">

                                    <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                                        <label class="col-sm-3 control-label">Name <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                   name="name" value="{{ old('name') }}">

                                            @error('name')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('father_name') ? 'has-error' :'' }}">
                                        <label class="col-sm-3 control-label">Father Name</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Enter Father Name"
                                                   name="father_name" value="{{ old('father_name') }}">

                                            @error('father_name')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('address') ? 'has-error' :'' }}">
                                        <label class="col-sm-3 control-label">Address</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Enter Address"
                                                   name="address" value="{{ old('address') }}">

                                            @error('address')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('nid') ? 'has-error' :'' }}">
                                        <label class="col-sm-3 control-label">Nid </label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Enter Nid Number"
                                                   name="nid" value="{{ old('nid') }}">

                                            @error('nid')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row {{ $errors->has('mobile_no') ? 'has-error' :'' }}">
                                        <label class="col-sm-3 control-label">Phone No <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Enter Phone No"
                                                   name="mobile_no" value="{{ old('mobile_no') }}">

                                            @error('mobile_no')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="new_area2">
                                    <div class="form-group row {{ $errors->has('email') ? 'has-error' :'' }}">
                                        <label class="col-sm-3 control-label">Email<span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Enter Email "
                                                   name="email" value="{{ old('email') }}">

                                            @error('email')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
{{--                                    <div class="form-group row {{ $errors->has('username') ? 'has-error' :'' }}">--}}
{{--                                        <label class="col-sm-3 control-label">User Name <span--}}
{{--                                                class="text-danger">*</span></label>--}}

{{--                                        <div class="col-sm-9">--}}
{{--                                            <input type="text" class="form-control" placeholder="Enter Username "--}}
{{--                                                   name="username" value="{{ old('username') }}">--}}

{{--                                            @error('username')--}}
{{--                                            <span class="help-block">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="form-group row {{ $errors->has('password') ? 'has-error' :'' }}">
                                        <label class="col-sm-3 control-label"> Password <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" placeholder="Enter Password "
                                                   name="password" value="{{ old('password') }}">

                                            @error('password')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div
                                        class="form-group row {{ $errors->has('password_confirmation') ? 'has-error' :'' }}">
                                        <label class="col-sm-3 control-label"> Confirm Password <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-9">
                                            <input type="password" class="form-control"
                                                   placeholder="Enter Password Again"
                                                   name="password_confirmation"
                                                   value="{{ old('password_confirmation') }}">

                                            @error('password_confirmation')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
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

@section('script')
    <script>
        $(document).ready(function () {
            $('.project').select2();
        });

        $('#new_area1').hide();
        $('#new_area2').hide();

        $(function () {
            $('body').on('change', '#stakeholder_type', function () {
                var typeId = $('#stakeholder_type').val();
                if (typeId == 1) {
                    $('#stakeholder_area').show();
                    $('#new_area1').hide();
                    $('#new_area2').hide();
                } else if (typeId == 2) {
                    $('#stakeholder_area').hide();
                    $('#new_area1').show();
                    $('#new_area2').show();
                }else {
                    $('#stakeholder_area').show();
                    $('#new_area1').hide();
                    $('#new_area2').hide();
                }

            });

            $('#stakeholder_type').trigger('change');
        });


    </script>
@endsection
