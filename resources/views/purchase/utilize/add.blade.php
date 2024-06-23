@extends('layouts.master')


@section('title')
    Utilize
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header with-border">
                    <h3 class="card-title">Utilize Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('purchase_product.utilize.add',['project'=>$project->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('project') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Project *</label>

                            <div class="col-sm-10">
                                <select class="form-control select2" name="project" id="project">

                                        <option value="{{ $project->id }}" selected>{{ $project->name }}</option>

                                </select>

                                @error('project')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row {{ $errors->has('segment') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Segment *</label>

                            <div class="col-sm-10">
                                <select class="form-control select2" name="segment" id="segment">
                                    <option value="">Select Segment</option>

                                </select>

                                @error('project')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('product') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Product *</label>

                            <div class="col-sm-10">
                                <select class="form-control select2" name="product" id="product">
                                    <option value="">Select Product</option>
                                </select>

                                @error('product')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('quantity') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Quantity *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Quantity"
                                       name="quantity" value="{{ old('quantity') }}">

                                @error('quantity')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('date') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Date *</label>

                            <div class="col-sm-10">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right"  name="date" value="" autocomplete="off">
                                </div>
                                <!-- /.input group -->

                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('note') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label">Note</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Enter Note"
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
        </div>
    </div>
@endsection

@section('script')
  <script>
        $(function () {
            //Date picker

            var selectedSegment= '{{old('segment')}}';
            var selectedProduct= '{{old('product')}}';

            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });


            $('body').on('change','#project', function () {
                var projectId = $(this).val();
                var itemProject = $(this);
               $('#segment').html('<option value="">Select Segment</option>');
                if (projectId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_segment') }}",
                        data: {projectId:projectId}
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (selectedSegment == item.id)
                                $('#segment').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#segment').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                        $('#segment').trigger('change');
                    });

                }
            });
            $('#project').trigger('change');

            $('body').on('change','#segment', function () {
                var segmentId = $(this).val();
                var itemProject = $(this);
                $('#product').html('<option value="">Select product</option>');
                if (segmentId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_inventory_product') }}",
                        data: {segmentId:segmentId}
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (selectedProduct == item.id)
                                $('#product').append('<option value="'+item.product_id+'" selected>'+item.product.name+'--stock-'+item.quantity+'</option>');
                            else
                                $('#product').append('<option value="'+item.product_id+'">'+item.product.name+'--stock-'+item.quantity+'</option>');
                        });
                    });

                }
            });
            $('#segment').trigger('change');

        });
    </script>
@endsection
