@extends('layouts.master')

@section('title')
    Costing
@endsection

@section('style')
    <style>
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            white-space: nowrap;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header with-border">
                    <h3 class="card-title">Costing Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('costing.add') }}">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('estimate_project_id') ? 'has-error' :'' }}">
                                    <label>Estimating Project</label>

                                    <select class="form-control select2" style="width: 100%;" name="estimate_project_id" id="estimate_project_id" data-placeholder="Select Estimating Project">
                                        <option value="">Select Project</option>
                                        @foreach($estimateProjects as $estimate_project)
                                            <option value="{{ $estimate_project->id }}" {{ old('estimate_project_id') == $estimate_project->id ? 'selected' : '' }}>{{ $estimate_project->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('estimate_project_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('costing_type_id') ? 'has-error' :'' }}">
                                    <label>Costing Type</label>

                                    <select class="form-control select2" style="width: 100%;" id="costing_type_id" name="costing_type_id" data-placeholder="Select Costing Type">
                                        <option value="">Select Costing Type</option>

                                    </select>

                                    @error('costing_type_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group {{ $errors->has('date') ? 'has-error' :'' }}">
                                    <label>Date</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" name="date" value="" autocomplete="off">
                                    </div>
                                    <!-- /.input group -->

                                    @error('date')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('note') ? 'has-error' :'' }}">
                                    <label>Note</label>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="note" name="note" value="{{ old('note') }}">
                                    </div>
                                    <!-- /.input group -->

                                    @error('note')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Estimate Product Name</th>
                                    <th width="15%">Unit Price</th>
                                    <th width="15%">Product Unit</th>
                                    <th width="15%">Quantity</th>
                                    <th width="15%">Costing Type</th>
                                    <th>Total Cost</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody id="product-container">
                                @if (old('product') != null && sizeof(old('product')) > 0)
                                    @foreach(old('product') as $item)
                                        <tr class="product-item">
                                            <td>
                                                <div class="form-group {{ $errors->has('product.'.$loop->index) ? 'has-error' :'' }}">
                                                    <select class="form-control select2 product" style="width: 100%;" name="product[]" data-placeholder="Select Product" required>
                                                        <option value="">Select Product</option>
                                                        @foreach($purchaseProducts as $purchaseProduct)
                                                            <option {{ old('product.'.$loop->parent->index) == $purchaseProduct->id ? 'selected' : '' }} value="{{$purchaseProduct->id}}">{{$purchaseProduct->name}}</option>
                                                        @endforeach

                                                    </select>
                                                    <input type="hidden" name="product-name[]" class="product-name" value="{{ old('product-name.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('unit_price.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text"  name="unit_price[]" class="form-control unit_price" value="{{ old('unit_price.'.$loop->index) }}" >
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('unit.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text"  name="unit[]" class="form-control unit" value="{{ old('unit.'.$loop->index) }}" readonly>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group {{ $errors->has('quantity.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text" class="form-control quantity" name="quantity[]" value="{{ old('quantity.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('cost_type.'.$loop->index) ? 'has-error' :'' }}">
                                                    <select class="form-control cost_type" style="width: 100%;" name="cost_type[]"  required>
                                                        <option value="1" {{old('cost_type.'.$loop->index)==1 ? 'selected' : ''}}>Material</option>
                                                        <option value="2" {{old('cost_type.'.$loop->index)==2 ? 'selected' : ''}}>Working</option>
                                                    </select>
                                                </div>
                                            </td>

                                            <td class="total-cost">৳ 0.00</td>
                                            <td class="text-center">
                                                <a role="button" class="btn btn-danger btn-sm btn-remove">X</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="product-item">
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control select2 product" style="width: 100%;" name="product[]" data-placeholder="Select Product" required>
                                                    <option value="">Select Product</option>
                                                    @foreach($purchaseProducts as $purchaseProduct)
                                                        <option value="{{$purchaseProduct->id}}">{{$purchaseProduct->name}}</option>
                                                    @endforeach
                                                </select>

                                                <input type="hidden" name="product-name[]" class="product-name">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="unit_price[]" class="form-control unit_price" >
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="unit[]" class="form-control unit" readonly>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control quantity" name="quantity[]">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control cost_type" style="width: 100%;" name="cost_type[]"  required>
                                                    <option value="1" >Material</option>
                                                    <option value="2" >Working</option>
                                                </select>
                                            </div>
                                        </td>

                                        <td class="total-cost">৳ 0.00</td>
                                        <td class="text-center">
                                            <a role="button" class="btn btn-danger btn-sm btn-remove">X</a>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>

                                <tfoot>
                                <tr>
                                    <td>
                                        <a role="button" class="btn btn-info btn-sm" id="btn-add-product">Add More</a>
                                    </td>
                                    <th colspan="4" class="text-right">Total Amount</th>
                                    <th id="total-amount"> ৳ 0.00 </th>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
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

    <template id="template-product">
        <tr class="product-item">
            <td>
                <div class="form-group">
                    <select class="form-control select2 product" style="width: 100%;" name="product[]" data-placeholder="Select Product" required>
                        <option value="">Select Product</option>
                        @foreach($purchaseProducts as $purchaseProduct)
                            <option value="{{$purchaseProduct->id}}">{{$purchaseProduct->name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="product-name[]" class="product-name">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" name="unit_price[]" class="form-control unit_price" >
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" name="unit[]" class="form-control unit" readonly>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control quantity" name="quantity[]">
                </div>
            </td>
            <td>
                <div class="form-group ">
                    <select class="form-control cost_type" style="width: 100%;" name="cost_type[]"  required>
                        <option value="1" >Material</option>
                        <option value="2" >Working</option>
                    </select>
                </div>
            </td>

            <td class="total-cost">৳ 0.00</td>
            <td class="text-center">
                <a role="button" class="btn btn-danger btn-sm btn-remove">X</a>
            </td>
        </tr>
    </template>
@endsection

@section('script')

    <script>

        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();


            //Date picker
            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('#btn-add-product').click(function () {
                var html = $('#template-product').html();
                var item = $(html);

                $('#product-container').append(item);
                $('.select2').select2();
                // initProduct();

                if ($('.product-item').length >= 1 ) {
                    $('.btn-remove').show();
                }
            });

            $('body').on('click', '.btn-remove', function () {
                $(this).closest('.product-item').remove();
                calculate();

                if ($('.product-item').length <= 1 ) {
                    $('.btn-remove').hide();
                }
            });

            $('body').on('keyup', '.quantity', function () {
                calculate();
            });

            if ($('.product-item').length <= 1 ) {
                $('.btn-remove').hide();
            } else {
                $('.btn-remove').show();
            }

            // initProduct();
            calculate();
        });

        function calculate() {
            var total = 0;

            $('.product-item').each(function(i, obj) {
                var quantity = $('.quantity:eq('+i+')').val();
                var unit_price = $('.unit_price:eq('+i+')').val();

                if (quantity == '' || quantity < 0 || !$.isNumeric(quantity))
                    quantity = 0;
                if (unit_price == '' || unit_price < 0 || !$.isNumeric(unit_price))
                    unit_price = 0;

                $('.total-cost:eq('+i+')').html('৳ ' + parseFloat(quantity * unit_price).toFixed(2));
                total += parseFloat(quantity * unit_price);
            });

            $('#total-amount').html('৳ ' + total.toFixed(2));
        }


        $('body').on('change','.product', function () {
            var productId = $(this).val();
            var itemProduct = $(this);

            itemProduct.closest('tr').find('.unit_price').html('0');
            // var selectedProduct = itemCategory.closest('tr').find('.product').attr("data-selected-product");
            if (productId != '') {
                $.ajax({
                    method: "GET",
                    url: "{{ route('get_unit') }}",
                    data: {productId:productId}
                }).done(function( response ) {

                    itemProduct.closest('tr').find('.unit').val(response);
                });

            }
        });

        $('.product').trigger('change');

        var selectCostingType ='{{old('costing_type_id')}}';

        $('body').on('change','#estimate_project_id', function () {
            var projectId = $(this).val();

            $('#costing_type_id').html('<option value="">Select Costing Type</option>');
            // var selectedProduct = itemCategory.closest('tr').find('.product').attr("data-selected-product");
            if (projectId != '') {
                $.ajax({
                    method: "GET",
                    url: "{{ route('get_costing_segment') }}",
                    data: {projectId:projectId}
                }).done(function( response ) {
                    $.each(response, function( index, item ) {
                    //    console.log(response);
                        if (selectCostingType == item.id)
                            $('#costing_type_id').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                        else
                            $('#costing_type_id').append('<option value="'+item.id+'">'+item.name+'</option>');
                    });

                });

            }
        });

        $('#estimate_project_id').trigger('change');



        {{--function initProduct() {--}}
        {{--    $('.product').select2({--}}
        {{--        ajax: {--}}
        {{--            url: "{{ route('estimate_product.json') }}",--}}
        {{--            type: "get",--}}
        {{--            dataType: 'json',--}}
        {{--            delay: 250,--}}
        {{--            data: function (params) {--}}
        {{--                return {--}}
        {{--                    searchTerm: params.term // search term--}}
        {{--                };--}}
        {{--            },--}}
        {{--            processResults: function (response) {--}}
        {{--                return {--}}
        {{--                    results: response--}}
        {{--                };--}}
        {{--            },--}}
        {{--            cache: true--}}
        {{--        }--}}
        {{--    });--}}

        {{--    $('.product').on('select2:select', function (e) {--}}
        {{--        var data = e.params.data;--}}

        {{--        var index = $(".product").index(this);--}}
        {{--        $('.product-name:eq('+index+')').val(data.text);--}}
        {{--        $('.unit_price:eq('+index+')').val(data.unit_price);--}}
        {{--        $('.unit:eq('+index+')').val(data.unit);--}}
        {{--    });--}}
        {{--}--}}
    </script>
@endsection
