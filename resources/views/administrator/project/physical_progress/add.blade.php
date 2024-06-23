@extends('layouts.master')

@section('title')
     Physical Progress
@endsection

@section('content')
@if(Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Project Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('physical_progress.add') }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('segment') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Secment *</label>

                            <div class="col-sm-10">
                                <select name="segment" id="segment" class="form-control select2">
                                    <option value="">Select One</option>
                                    @foreach($segments as $segment)
                                        <option {{old('segment')==$segment->id?'selected':''}} value="{{$segment->id}}">{{$segment->name}}</option>
                                    @endforeach
                                </select>

                                @error('segment')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
{{--                        <div class="form-group row {{ $errors->has('segment') ? 'has-error' :'' }}">--}}
{{--                            <label class="col-sm-2 control-label">Segment *</label>--}}

{{--                            <div class="col-sm-10">--}}
{{--                                <select name="segment" id="segment" class="form-control select2">--}}
{{--                                    <option value="">Select One</option>--}}
{{--                                </select>--}}

{{--                                @error('segment')--}}
{{--                                <span class="help-block">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="form-group row {{ $errors->has('date') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Date </label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="date" value="">

                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label"> Segment Percentage </label>

                            <div class="col-sm-2 ">
                                <input type="number" class="form-control row"
                                       name="segment_percentage" id="segment_percentage" readonly value="{{ old('segment_percentage') }}">

                                @error('segment_percentage')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="col-sm-2 control-label"> % </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Total Unit </label>

                            <div class="col-sm-2">
                                <input type="number" class="form-control"
                                       name="total_unit" id="total_unit" readonly value="{{ old('total_unit') }}">

                                @error('total_unit')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="col-sm-2 control-label">Total Complete </label>

                            <div class="col-sm-2">
                                <input type="number" class="form-control"
                                       name="unit_complete" id="unit_complete" readonly value="{{ old('unit_complete') }}">

                                @error('unit_complete')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row {{ $errors->has('progress') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Unit Done</label>

                            <div class="col-sm-10">
                                <input type="number" class="form-control"
                                       name="progress" value="{{ old('progress') }}">

                                @error('progress')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('note') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Note </label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       name="note" value="{{ old('note') }}">

                                @error('note')
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


@section('script')
    <script>
        $(function () {
            //Date picker
            $('#date, #date-refund').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
            var selectCostingType ='{{old('segment')}}';

            {{--$('body').on('change','#segment', function () {--}}
            {{--    var segmentId = $(this).val();--}}

            {{--    $('#segment').html('<option value="" >Select One</option>');--}}
            {{--    // var selectedProduct = itemCategory.closest('tr').find('.product').attr("data-selected-product");--}}
            {{--    if (segmentId != '') {--}}
            {{--        $.ajax({--}}
            {{--            method: "GET",--}}
            {{--            url: "{{ route('get_segment') }}",--}}
            {{--            data: {segmentId:segmentId}--}}
            {{--        }).done(function( response ) {--}}
            {{--           // $('#segment').append('Select Segment');--}}
            {{--            $.each(response, function( index, item ) {--}}
            {{--                //    console.log(response);--}}
            {{--                if (selectCostingType == item.id)--}}
            {{--                    $('#segment').append('<option value="'+item.id+'" selected>'+item.name+'</option>');--}}
            {{--                else--}}
            {{--                    $('#segment').append('<option value="'+item.id+'">'+item.name+'</option>');--}}
            {{--            });--}}

            {{--        });--}}
            {{--      //  $('#segment').trigger('change');--}}
            {{--    }--}}
            {{--});--}}

            {{--$('#segment').trigger('change');--}}

            $('body').on('change','#segment', function () {
                var segmentId = $(this).val();
                  if (segmentId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_segment_data') }}",
                        data: {segmentId:segmentId}
                    }).done(function( response ) {
                        $('#segment_percentage').val(response.segment_percentage );
                        $('#total_unit').val(response.total_unit);
                        $('#unit_complete').val(response.unit_done);

                    });

                }
            });
           // $('#segment').trigger('change');

        });
    </script>
@endsection

