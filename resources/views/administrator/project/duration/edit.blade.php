@extends('layouts.master')

@section('title')
    Project Duration Edit
@endsection

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Project Duration Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST"
                      action="{{ route('duration.edit', ['budget' => $budget->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('name') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Name *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" readonly
                                       name="name" value="{{ $budget->project->name??''}}">

                                @error('name')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('budget') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Budget </label>

                            <div class="col-sm-10">
                                <input type="number" class="form-control"
                                       name="budget"  value="{{  $budget->budget??'' }}">

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
                                        <input type="radio" name="status" value="1" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($budget->status == '1' ? 'checked' : '')) :
                                            (old('status') == '1' ? 'checked' : '') }}>
                                        Active
                                    </label>
                                </div>

                                <div class="radio" style="display: inline">
                                    <label>
                                        <input type="radio" name="status" value="0" {{ empty(old('status')) ? ($errors->has('status') ? '' : ($budget->status == '0' ? 'checked' : '')) :
                                            (old('status') == '0' ? 'checked' : '') }}>
                                        Inactive
                                    </label>
                                </div>

                                @error('status')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
{{--                        <div class="form-group row {{ $errors->has('duration_start') ? 'has-error' :'' }}">--}}
{{--                            <label class="col-sm-2 control-label">Start </label>--}}

{{--                            <div class="col-sm-10">--}}
{{--                                <input type="date" class="form-control"--}}
{{--                                       name="duration_start" id="duration_start"--}}
{{--                                       value="{{ empty(old('duration_start')) ? ($errors->has('duration_start') ? '' : $project->duration_start) : old('duration_start') }}">--}}

{{--                                @error('duration_start')--}}
{{--                                <span class="help-block">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row {{ $errors->has('duration_end') ? 'has-error' :'' }}">--}}
{{--                            <label class="col-sm-2 control-label">End </label>--}}

{{--                            <div class="col-sm-10">--}}
{{--                                <input type="date" class="form-control"--}}
{{--                                       name="duration_end" id="duration_end"--}}
{{--                                       value="{{ empty(old('duration_end')) ? ($errors->has('duration_end') ? '' : $project->duration_end) : old('duration_end') }}">--}}

{{--                                @error('duration_end')--}}
{{--                                <span class="help-block">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row {{ $errors->has('total') ? 'has-error' :'' }}">--}}
{{--                            <label class="col-sm-2 control-label">Total Month </label>--}}

{{--                            <div class="col-sm-10">--}}
{{--                                <input type="text" class="form-control"--}}
{{--                                       name="total" id="total" readonly>--}}

{{--                                @error('total')--}}
{{--                                <span class="help-block">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

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
        $(function (){

            $('#duration_start,#duration_end').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });



           $('#duration_end').change(function (){
                   var start = new Date($('#duration_start').val());
                   var end = new Date($('#duration_end').val());
                  // alert(start)
               if ((start !='' && start != 'Invalid Date') && (end!='Invalid Date' && end != '')){
                   if (monthDiff(start,end)<=0){
                       Swal.fire(
                           'Please Select more then 1 Month',

                           '!!'
                       );
                       $('#total').val(0);
                   }else {
                       $('#total').val(monthDiff(start,end));
                   }
               }else {

                   Swal.fire(
                       'date Must be fill in',

                       '!!'
                   )
                  // alert('date Must be filled');
               }

           });
           $('#duration_end').trigger('change');

            $('#duration_start').change(function (){
                var start = new Date($('#duration_start').val());
                var end = new Date($('#duration_end').val());
                // alert(start)
                if ((start !='' && start != 'Invalid Date') && (end!='Invalid Date' && end != '')){
                    if (monthDiff(start,end)<=0){
                        Swal.fire(
                            'Please Select more then 1 Month',

                            '!!'
                        );
                        $('#total').val(0);
                    }else {
                        $('#total').val(monthDiff(start,end));
                    }

                }

            });
            $('#duration_start').trigger('change');

        });

        function monthDiff(start, end) {
            var months;
            months = (end.getFullYear() - start.getFullYear()) * 12;
            months -= start.getMonth();
            months += end.getMonth();
            return months <= 0 ? 0 : months;
        }

    </script>

@endsection
