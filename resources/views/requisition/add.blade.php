@extends('layouts.master')

@section('title')
    Requisition
@endsection

@section('style')
    <style>
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            white-space: nowrap;
        }
        .input-group-addon i{
            padding-top:10px;
            padding-right: 10px;
            border: 1px solid #cecccc;
            padding-bottom: 10px;
            padding-left: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header with-border">
                    <h3 class="card-title">Requisition Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{route('requisition.add',['costing'=>$costing->id])}}">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('project') ? 'has-error' :'' }}">
                                    <label> Project</label>

                                    <select class="form-control select2" style="width: 100%;" name="project"
                                            id="project" data-placeholder="Select Estimating Project">
                                        <option
                                            value="{{$costing->estimate_project_id}}">{{$costing->project->name}}</option>

                                    </select>

                                    @error('project')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('segment') ? 'has-error' :'' }}">
                                    <label>Segment</label>
                                    <select class="form-control select2" style="width: 100%;" id="segment"
                                            name="segment" data-placeholder="Select Segment">
                                        <option
                                            value="{{$costing->costing_type_id}}">{{$costing->segment->name}}</option>

                                    </select>

                                    @error('segment')
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
                                        <input type="text" class="form-control pull-right" name="date"
                                               value="{{ empty(old('date')) }}"
                                               autocomplete="off">
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
                                        <input type="text" class="form-control" id="note" name="note"
                                               value="{{ old('note') }}">
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
                                    <th width="15%">Available</th>
                                    <th width="15%">Product Unit</th>
                                    <th width="15%">Quantity</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody id="product-container">
                                @if (old('product') != null && sizeof(old('product')) > 0)
                                    @foreach(old('product') as $item)
                                        <tr class="product-item">
                                            <td>
                                                <div
                                                    class="form-group {{ $errors->has('product.'.$loop->index) ? 'has-error' :'' }}">
                                                    <select class="form-control select2 product" style="width: 100%;"
                                                            name="product[]" data-placeholder="Select Product" required>
                                                        <option value="">Select Product</option>
                                                        @foreach($purchaseProducts as $purchaseProduct)
                                                            <option
                                                                {{ old('product.'.$loop->parent->index) == $purchaseProduct->id ? 'selected' : '' }} value="{{$purchaseProduct->id}}">{{$purchaseProduct->name}}</option>
                                                        @endforeach

                                                    </select>
                                                    <input type="hidden" name="product-name[]" class="product-name"
                                                           value="{{ old('product-name.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="form-group {{ $errors->has('available.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text" readonly name="available[]"
                                                           class="form-control available"
                                                           value="{{ old('available.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="form-group {{ $errors->has('unit.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text" name="unit[]" class="form-control unit"
                                                           value="{{ old('unit.'.$loop->index) }}" readonly>
                                                </div>
                                            </td>

                                            <td>
                                                <div
                                                    class="form-group {{ $errors->has('quantity.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="number" class="form-control quantity" name="quantity[]"
                                                           value="{{ old('quantity.'.$loop->index) }}">
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <a role="button" class="btn btn-danger btn-sm btn-remove">X</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="product-item">
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control select2 product" style="width: 100%;"
                                                        name="product[]" data-placeholder="Select Product" required>
                                                    <option value="">Select Product</option>
                                                    @foreach($purchaseProducts as $purchaseProduct)
                                                        <option
                                                            value="{{$purchaseProduct->id}}">{{$purchaseProduct->name}}</option>
                                                    @endforeach
                                                </select>

                                                <input type="hidden" name="product-name[]" class="product-name">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                <input type="text" readonly name="available[]"
                                                       class="form-control available">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="unit[]" class="form-control unit" readonly>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control quantity" name="quantity[]" >
                                            </div>
                                        </td>


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
                                    <th colspan="2">Total Amount</th>
                                    <th id="total-amount"> ৳ 0.00</th>
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
                    <select class="form-control select2 product" style="width: 100%;" name="product[]"
                            data-placeholder="Select Product" required>
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
                    <input type="text" readonly name="available[]" class="form-control available">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" name="unit[]" class="form-control unit" readonly>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control quantity" name="quantity[]">
                </div>
            </td>


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

                if ($('.product-item').length >= 1) {
                    $('.btn-remove').show();
                }
            });

            $('body').on('click', '.btn-remove', function () {
                $(this).closest('.product-item').remove();
                calculate();

                if ($('.product-item').length <= 1) {
                    $('.btn-remove').hide();
                }
            });

            $('body').on('keyup', '.quantity', function () {
                calculate();
            });


            if ($('.product-item').length <= 1) {
                $('.btn-remove').hide();
            } else {
                $('.btn-remove').show();
            }

            // initProduct();
            calculate();
        });

        function calculate() {
            var total = 0;

            $('.product-item').each(function (i, obj) {
                var quantity = $('.quantity:eq(' + i + ')').val();
                var available = $('.available:eq(' + i + ')').val();
                if (quantity == '' || quantity < 0 || !$.isNumeric(quantity))
                    quantity = 0;

                total += parseFloat(quantity);
            });

            $('#total-amount').html('৳ ' + total.toFixed(2));
        }


        $('body').on('change', '.product', function () {
            var productId = $(this).val();
            var projectId = $('#project').val();
            var segmentId = $('#segment').val();
            var itemProduct = $(this);

            itemProduct.closest('tr').find('.available').val(0);
            // var selectedProduct = itemCategory.closest('tr').find('.product').attr("data-selected-product");
            if (productId != '') {
                $.ajax({
                    method: "GET",
                    url: "{{ route('estimate_product.json') }}",
                    data: {
                        productId: productId,
                        projectId: projectId,
                        segmentId: segmentId
                    }
                }).done(function (response) {

                    itemProduct.closest('tr').find('.unit').val(response.unit);
                    itemProduct.closest('tr').find('.available').val(response.available);
                    itemProduct.closest('tr').find('.quantity').attr('max',response.available);

                });

            }
        });

        $('.product').trigger('change');


    </script>
@endsection
