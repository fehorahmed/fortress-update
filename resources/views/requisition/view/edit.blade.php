@extends('layouts.master')
@section('title')
    Requisition Edit
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
                    <h3 class="card-title">Requisition Information</h3>
                    {{--                    @if($errors->any())--}}
                    {{--                        {{ implode('', $errors->all('<div>:message</div>')) }}--}}
                    {{--                    @endif--}}
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('requisition.view.edit', ['requisition' => $requisition->id]) }}">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('project') ? 'has-error' :'' }}">
                                    <label> Project</label>

                                    <select class="form-control select2" style="width: 100%;" id="project" name="project" data-placeholder="Select  Project">
                                        <option value="{{$requisition->project->id ??''}}">{{$requisition->project->name??''}}</option>
                                    </select>

                                    @error('project')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('segment') ? 'has-error' :'' }}">
                                    <label>Segment </label>

                                    <select class="form-control select2" style="width: 100%;" id="segment" name="segment" data-placeholder="Select segment">
                                        <option value="{{$requisition->segment->id??''}}">{{$requisition->segment->name??''}}</option>

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
                                        <input type="text" class="form-control pull-right" name="date" value="{{   date('d-m-Y',strtotime($requisition->date)) }}" autocomplete="off">
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
                                        <input type="text" class="form-control" id="note" name="note" value="{{old('note',$requisition->note)}}">
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
                                    <th>Available</th>
                                    <th>Product Unit</th>
                                    <th width="15%">Quantity</th>
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
                                                <div class="form-group {{ $errors->has('available.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text"  name="available[]" class="form-control available" value="{{ old('available.'.$loop->index) }}" >
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('unit.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text" class="form-control unit" name="unit[]" value="{{ old('unit.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('quantity.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="number" class="form-control quantity" name="quantity[]" value="{{ old('quantity.'.$loop->index) }}">
                                                </div>
                                            </td>


                                            <td class="total-cost">৳ 0.00</td>
                                            <td class="text-center">
                                                <a role="button" class="btn btn-danger btn-sm btn-remove">X</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($requisition->products as $product)
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
                                                <div class="form-group {{ $errors->has('available.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text"  readonly name="available[]" class="form-control available" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('unit.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text"  name="unit[]" class="form-control unit" value="{{$product->product->unit->name}}" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('quantity.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="number" class="form-control quantity" name="quantity[]" value="{{$product->quantity}}">
                                                </div>
                                            </td>

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
                                    <th class="text-right" colspan="2">Total</th>
                                    <th id="total-amount"> ৳ 0.00 </th>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="card-footer">
                        <input type="hidden" name="total" id="total">
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
                    <input type="text" name="available[]" class="form-control available" readonly>
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
    <!-- Select2 -->
    <script>

        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

            //Date picker
            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('body').on('change', '.product', function () {
                var productId = $(this).val();
                var projectId = $('#project').val();
                var segmentId = $('#segment').val();
                var requisitionId = '{{$requisition->id}}';
                var itemProduct = $(this);

                itemProduct.closest('tr').find('.available').val(0);
                // var selectedProduct = itemCategory.closest('tr').find('.product').attr("data-selected-product");
                if (productId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('estimate_product.json.edit') }}",
                        data: {
                            productId: productId,
                            projectId: projectId,
                            segmentId: segmentId,
                            requisitionId: requisitionId
                        }
                    }).done(function (response) {

                        itemProduct.closest('tr').find('.unit').val(response.unit);
                        itemProduct.closest('tr').find('.available').val(response.available);
                        itemProduct.closest('tr').find('.quantity').attr('max',response.available);

                    });

                }
            });

            $('.product').trigger('change');

            $('#btn-add-product').click(function () {
                var html = $('#template-product').html();
                var item = $(html);

                $('#product-container').append(item);

                $('.product').select2();

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

            $('#total-amount').html(' ' + total.toFixed(2));
        }



        // function initProduct() {
        //     $('.product').select2();
        // }
    </script>
@endsection



