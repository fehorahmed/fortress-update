@extends('layouts.master')


@section('title')
    Costing Edit
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
                <form method="POST" action="{{ route('requisition.edit', ['costing' => $costing->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('estimate_project_id') ? 'has-error' :'' }}">
                                    <label>Estimate Project</label>

                                    <select class="form-control select2" style="width: 100%;" name="estimate_project_id" data-placeholder="Select Estimate Project">
                                        <option value="">Select Estimate Project</option>

                                        @foreach($estimateProjects as $estimate_project)
{{--                                            <option value="{{ $estimate_project->id }}" {{ $costing->estimate_project_id == $estimate_project->id ? 'selected' : '' }}>{{ $estimate_project->name }}</option>--}}
                                            <option value="{{ $estimate_project->id }}" {{ empty(old('estimate_project_id')) ? ($errors->has('estimate_project_id') ? '' : ($costing->estimate_project_id == $estimate_project->id ? 'selected' : '')) :
                                            (old('estimate_project_id') == $estimate_project->id ? 'selected' : '') }}>{{ $estimate_project->name }}</option>
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

                                    <select class="form-control select2" style="width: 100%;" name="costing_type_id" data-placeholder="Select Costing Type">
                                        <option value="">Select Costing Type</option>

                                        @foreach($costingTypes as $costingType)
                                            <option value="{{ $costingType->id }}" {{ empty(old('costing_type_id')) ? ($errors->has('costing_type_id') ? '' : ($costing->costing_type_id == $costingType->id ? 'selected' : '')) :
                                            (old('costing_type_id') == $costingType->id ? 'selected' : '') }}>{{ $costingType->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('costing_type_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('date') ? 'has-error' :'' }}">
                                    <label>Date</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="date" name="date" value="{{   date('Y-m-d',strtotime($costing->date)) }}" autocomplete="off">
                                    </div>
                                    <!-- /.input group -->

                                    @error('date')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('note') ? 'has-error' :'' }}">
                                    <label>Note</label>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="note" name="note" value="{{ empty(old('note')) ? ($errors->has('note') ? '' : $costing->note) : old('note') }}">
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
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Unit</th>
                                    <th width="15%">Costing Amount</th>
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
                                                    <select class="form-control select2 product" style="width: 100%;" name="product[]" required>
                                                        <option value="">Select Product</option>

                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" {{ old('product.'.$loop->parent->index) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" name="product-name[]" class="product-name" value="{{ old('product-name.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('unit_price.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text"  name="unit_price[]" class="form-control unit_price" value="{{ old('unit_price.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('unit.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text" class="form-control unit" name="unit[]" value="{{ old('unit.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('quantity.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text" class="form-control quantity" name="quantity[]" value="{{ old('quantity.'.$loop->index) }}">
                                                </div>
                                            </td>


                                            <td class="total-cost">৳ 0.00</td>
                                            <td class="text-center">
                                                <a role="button" class="btn btn-danger btn-sm btn-remove">X</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($costing->estimateProducts as $product)
                                        <tr class="product-item">
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control select2 product " style="width: 100%;" name="product[]" required>
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $item)
                                                            <option value="{{$item->id}}" {{$product->purchase_product_id == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="product-name[]" class="product-name">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group ">
                                                    <input type="text"  name="unit_price[]" class="form-control unit_price" value="{{$product->unit_price}}" >
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text"  name="unit[]" class="form-control unit" value="{{$product->product->unit->name}}" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control quantity" name="quantity[]" value="{{$product->quantity}}">
                                                </div>
                                            </td>

                                            <td class="total-cost">৳ 0.00</td>
                                            <td class="text-center">
                                                <a role="button" class="btn btn-danger btn-sm btn-remove">X</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>

                                <tfoot>
                                <tr>
                                    <td>
                                        <a role="button" class="btn btn-info btn-sm" id="btn-add-product">Add More</a>
                                    </td>
                                    <th class="text-right" colspan="3">Total</th>
                                    <th id="total-amount" colspan="2"> ৳ 0.00 </th>

                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="card-footer">
                        <input type="hidden" name="total" id="total">
                        <button type="submit" class="btn btn-primary">Save to Requisition
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="template-product">
        <tr class="product-item">
            <td>
                <div class="form-group">
                    <select class="form-control select2 product" style="width: 100%;" name="product[]" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
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

            $('body').on('change', '.product', function (e) {
                var productId = $(this).val();
                var productHtml = $(this);

                if (productId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('estimate_product.details') }}",
                        data: { productId: productId }
                    }).done(function( response ) {
                        if (response.success) {

                            console.log(response);
                            productHtml.closest('tr').find('.unit').val(response.unit_name);
                            calculate();
                        }
                    });
                }
            });

            $('.product').trigger('change');

            $('#btn-add-product').click(function () {
                var html = $('#template-product').html();
                var item = $(html);

                $('#product-container').append(item);

                initProduct();

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

            $('.btn-remove').show();

            initProduct();
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

                $('.total-cost:eq('+i+')').html('৳ ' + parseFloat(quantity * unit_price).toFixed(2) );
                total += parseFloat(quantity * unit_price);
            });

            $('#total').val(total.toFixed(2));
            $('#total-amount').html('৳ ' + total.toFixed(2));
        }


    </script>
@endsection
