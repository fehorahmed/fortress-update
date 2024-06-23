@extends('admin.layouts.admin')
@section('style')
    <style>

        select.form-control.product {
            width: 138px !important;
        }
        input.form-control.quantity {
            width: 90px;
        }
        input.form-control.unit_price,input.form-control.selling_price{
            width: 130px;
        }
        th {
            text-align: center;
        }
        select.form-control {
            min-width: 120px;
        }
    </style>
@endsection

@section('title')
    Purchase Edit
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Order Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('purchase_receipt.edit', ['order' => $order->id]) }}">
                    @csrf

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('supplier') ? 'has-error' :'' }}">
                                    <label>Supplier</label>
                                    <select class="form-control select2" style="width: 100%;" name="supplier" data-placeholder="Select Supplier">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ empty(old('supplier')) ? ($errors->has('supplier') ? '' : ($order->supplier_id == $supplier->id ? 'selected' : '')) :
                                            (old('supplier') == $supplier->id ? 'selected' : '') }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('supplier')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('warehouse') ? 'has-error' :'' }}">
                                    <label>Warehouse</label>
                                    <select class="form-control select2" style="width: 100%;" name="warehouse" data-placeholder="Select Warehouse">
                                        <option value="">Select Warehouse</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ empty(old('warehouse')) ? ($errors->has('warehouse') ? '' : ($order->warehouse_id == $warehouse->id ? 'selected' : '')) :
                                            (old('warehouse') == $warehouse->id ? 'selected' : '') }}>{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('warehouse')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('lc_no') ? 'has-error' :'' }}">
                                    <label for="lc_no">LC No.</label>
                                    <input type="text" placeholder="LC No." class="form-control" id="lc_no" name="lc_no" value="{{ $order->lc_no }}">
                                    @error('lc_no')
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
                                        <input type="text" class="form-control pull-right" id="date" name="date" value="{{ empty(old('date')) ? ($errors->has('date') ? '' : $order->date->format('Y-m-d')) : old('date') }}" autocomplete="off">
                                    </div>
                                    <!-- /.input group -->

                                    @error('date')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('hide_show') ? 'has-error' :'' }}">
                                    <label for="hide_show"></label>
                                    <div class="checkbox">
                                        <label>
                                            <input {{ $order->hide_show == 1 ? 'checked' : '' }} type="checkbox" name="hide_show" value="1"> <span class="text-danger text-bold">Status</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Brand</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Selling Price</th>
                                    <th>Total Cost</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody id="product-container">
                                @if (old('category') != null && sizeof(old('category')) > 0)
                                    @foreach(old('category') as $item)
                                        <tr class="product-item">
                                            <td >
                                                <div class="form-group {{ $errors->has('category.'.$loop->index) ? 'has-error' :'' }}">
                                                    <select class="form-control select2 category" style="width: 100%;" name="category[]" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ old('category.'.$loop->parent->index) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('product.'.$loop->index) ? 'has-error' :'' }}">
                                                    <select class="form-control select2 product" style="width: 100%;" data-selected-product="{{ old('product.'.$loop->index) }}" name="product[]" required>
                                                        <option value="">Select Product</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="serial[]" class="serial" value="{{ old('serial.'.$loop->index) }}">
                                            </td>
                                            <td >
                                                <div class="form-group {{ $errors->has('brand.'.$loop->index) ? 'has-error' :'' }}">
                                                    <select class="form-control select2 brand" style="width: 100%;" name="brand[]" required>
                                                        <option value="">Select Brand</option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{ $brand->id }}" {{ old('brand.'.$loop->parent->index) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('quantity.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="number" step="any" class="form-control quantity" name="quantity[]" value="{{ old('quantity.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('unit_price.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text" class="form-control unit_price" name="unit_price[]" value="{{ old('unit_price.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('selling_price.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text" class="form-control selling_price" name="selling_price[]" value="{{ old('selling_price.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td class="total-cost">৳0.00</td>
                                            <td class="text-center">
                                                <a role="button" class="btn btn-danger btn-sm btn-remove">X</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($order->products as $orderProduct)
                                        <tr class="product-item">
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control select2 category" style="width: 100%;" name="category[]" >
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $category->id == $orderProduct->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control select2 product" style="width: 100%;" data-selected-product="{{ $orderProduct->pivot->product_id }}" name="product[]" >
                                                        <option value="">Select Product</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control select2 brand" style="width: 100%;" name="brand[]" >
                                                        <option value="">Select Brand</option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{ $brand->id }}" {{ $brand->id == $orderProduct->pivot->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="number" step="any" class="form-control quantity" name="quantity[]" value="{{ $orderProduct->pivot->quantity }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control unit_price" name="unit_price[]" value="{{ $orderProduct->pivot->unit_price }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" class="form-control selling_price" name="selling_price[]" value="{{ $orderProduct->pivot->selling_price }}">
                                                </div>
                                            </td>

                                            <td class="total-cost">৳0.00</td>
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
                                        <a role="button" class="btn btn-info btn-sm" id="btn-add-product">Add Product</a>
                                    </td>
                                    <th colspan="4" class="text-right">Total Amount</th>
                                    <th class="text-right" id="total-amount">৳0.00</th>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="payment-option">
                                    <div class="form-group">
                                        <label>Payment Type</label>
                                        <select class="form-control" id="modal-pay-type" name="payment_type">
                                            <option value="1" {{ old('payment_type') == '1' ? 'selected' : '' }}>Cash</option>
                                            <option value="2" {{ old('payment_type') == '2' ? 'selected' : '' }}>Bank</option>
                                            <option value="3" {{ old('payment_type') == '3' ? 'selected' : '' }}>Mobile Banking</option>
                                        </select>
                                    </div>
                                    <div id="modal-bank-info">
                                        <div class="form-group {{ $errors->has('bank') ? 'has-error' :'' }}">
                                            <label>Bank</label>
                                            <select class="form-control" id="modal-bank" name="bank">
                                                <option value="">Select Bank</option>

                                                @foreach($banks as $bank)
                                                    <option value="{{ $bank->id }}" {{ old('bank') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group {{ $errors->has('branch') ? 'has-error' :'' }}">
                                            <label>Branch</label>
                                            <select class="form-control" id="modal-branch" name="branch">
                                                <option value="">Select Branch</option>
                                            </select>
                                        </div>

                                        <div class="form-group {{ $errors->has('account') ? 'has-error' :'' }}">
                                            <label>Account</label>
                                            <select class="form-control" id="modal-account" name="account">
                                                <option value="">Select Account</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Cheque No.</label>
                                            <input class="form-control" type="text" name="cheque_no" placeholder="Enter Cheque No." value="{{ old('cheque_no') }}">
                                        </div>

                                        <div class="form-group {{ $errors->has('cheque_image') ? 'has-error' :'' }}">
                                            <label>Cheque Image</label>
                                            <input class="form-control" name="cheque_image" type="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan="4" class="text-right">Sub Total</th>
                                        <th id="product-sub-total">৳0.00</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">VAT (%)</th>
                                        <td>
                                            <div class="form-group {{ $errors->has('vat') ? 'has-error' :'' }}">
                                                <input type="text" class="form-control" name="vat" id="vat" value="{{ empty(old('vat')) ? ($errors->has('vat') ? '' : $order->vat_percentage) : old('vat') }}">
                                                <span id="vat_total">৳0.00</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Discount(%) </th>
                                        <td>
                                            <div class="form-group {{ $errors->has('discount') ? 'has-error' :'' }}">
                                                <input type="text" class="form-control" name="discount" id="discount" value="{{ empty(old('discount')) ? ($errors->has('discount') ? '' : $order->discount_percentage) : old('discount') }}">
                                                <span id="discount_total">৳0.00</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Total</th>
                                        <th id="final-amount">৳0.00</th>
                                    </tr>
                                    <tr id="paid-area">
                                        <th colspan="4" class="text-right">New Paid</th>
                                        <td>
                                            <div class="form-group {{ $errors->has('paid') ? 'has-error' :'' }}">
                                                <input autocomplete="off" type="text" class="form-control"  name="paid" id="new_paid" value="{{ old('paid',0) }}">
                                            </div>
                                        </td>
                                    </tr>
                                    @if($order->paid > 0)
                                        <tr>
                                            <th colspan="4" class="text-right">Old Paid</th>
                                            <th id="paid">৳{{ number_format($order->paid) }}</th>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th colspan="4" class="text-right">Due</th>
                                        <th id="due">৳0.00</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Refund</th>
                                        <th id="refund_view">৳0.00</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <input type="hidden" name="total" id="total">
                        <input type="hidden" name="due_total" id="due_total">
                        <input type="hidden" name="refund" id="refund">
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
                    <select class="form-control select2 category" style="width: 100%;" name="category[]" >
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <select class="form-control select2 product" style="width: 100%;" name="product[]">
                        <option value="">Select Product</option>
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <select class="form-control select2 brand" style="width: 100%;" name="brand[]" >
                        <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td >
                <div class="form-group">
                    <input type="number" step="any" class="form-control quantity" name="quantity[]">
                </div>
            </td>
            <td >
                <div class="form-group">
                    <input type="text" step="any" class="form-control unit_price" name="unit_price[]">
                </div>
            </td>
            <td >
                <div class="form-group">
                    <input type="text" step="any" class="form-control selling_price" name="selling_price[]">
                </div>
            </td>

            <td  class="total-cost">৳ 0.00</td>
            <td class="text-center">
                <a role="button" class="btn btn-danger btn-sm btn-remove">X</a>
            </td>
        </tr>
    </template>
@endsection

@section('script')
    <script>
        $(function () {

            $('.supplier').select2();
            $('.warehouse').select2();

            $('#modal-pay-type').change(function () {
                if ($(this).val() == '1' || $(this).val() == '3' || $(this).val() == '4') {
                    $('#modal-bank-info').hide();
                } else {
                    $('#modal-bank-info').show();
                }
            });

            $('#modal-pay-type').trigger('change');

            var selectedBranch = '{{ old('branch') }}';
            var selectedAccount = '{{ old('account') }}';

            $('#modal-bank').change(function () {
                var bankId = $(this).val();
                $('#modal-branch').html('<option value="">Select Branch</option>');
                $('#modal-account').html('<option value="">Select Account</option>');

                if (bankId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branch') }}",
                        data: { bankId: bankId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (selectedBranch == item.id)
                                $('#modal-branch').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#modal-branch').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });

                        $('#modal-branch').trigger('change');
                    });
                }

                $('#modal-branch').trigger('change');
            });

            $('#modal-branch').change(function () {
                var branchId = $(this).val();
                $('#modal-account').html('<option value="">Select Account</option>');

                if (branchId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_account') }}",
                        data: { branchId: branchId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (selectedAccount == item.id)
                                $('#modal-account').append('<option value="'+item.id+'" selected>'+item.account_no+'</option>');
                            else
                                $('#modal-account').append('<option value="'+item.id+'">'+item.account_no+'</option>');
                        });
                    });
                }
            });

            $('#modal-bank').trigger('change');

            // select Category

            $('body').on('change','.category', function () {
                var categoryID = $(this).val();
                var itemCategory = $(this);
                itemCategory.closest('tr').find('.subcategory').html('<option value="">Select Sub Category</option>');
                var selected = itemCategory.closest('tr').find('.subcategory').attr("data-selected-subcategory");

                if (categoryID != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_subCategory') }}",
                        data: { categoryID: categoryID }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (selected == item.id)
                                itemCategory.closest('tr').find('.subcategory').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                itemCategory.closest('tr').find('.subcategory').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                        itemCategory.closest('tr').find('.subcategory').trigger('change');
                    });
                }

            });


            // select Sub Category
            $('body').on('change','.subcategory', function () {
                var subcategoryID = $(this).val();
                var itemSubCategory = $(this);
                itemSubCategory.closest('tr').find('.sub_sub_category').html('<option value="">Select Sub Sub Category</option>');
                var subSubCategorySelected = itemSubCategory.closest('tr').find('.sub_sub_category').attr("data-selected-sub-sub-category");

                if (subcategoryID != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_subSubCategory') }}",
                        data: { subCategoryID: subcategoryID }
                    }).done(function( data ) {

                        $.each(data, function( index, item ) {
                            if (subSubCategorySelected == item.id)
                                itemSubCategory.closest('tr').find('.sub_sub_category').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                itemSubCategory.closest('tr').find('.sub_sub_category').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                        itemSubCategory.closest('tr').find('.sub_sub_category').trigger('change');
                    });
                }

            });


            $('body').on('change','.category', function () {
                var categoryId = $(this).val();
                var itemCategory = $(this);

                itemCategory.closest('tr').find('.product').html('<option value="">Select Product</option>');
                var selectedProduct = itemCategory.closest('tr').find('.product').attr("data-selected-product");

                if (categoryId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_product_purchase') }}",
                        data: {categoryId:categoryId}
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (selectedProduct == item.id)
                                itemCategory.closest('tr').find('.product').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                itemCategory.closest('tr').find('.product').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                    });

                }
            });

            $('.category').trigger('change');


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
                $this = $(this);

                $(this).closest('.product-item').remove();
                calculate();

                // if ($('.product-item').length <= 1 ) {
                //     $('.btn-remove').hide();
                // }
            });

            $('body').on('keyup', '.quantity, .unit_price,  #vat, #discount, #paid,#new_paid', function () {
                calculate();
            });

            // if ($('.product-item').length <= 1 ) {
            //     $('.btn-remove').hide();
            // } else {
            //     $('.btn-remove').show();
            // }

            initProduct();
            calculate();
        });

        function calculate() {
            var subTotal = 0;

            var new_paid = $('#new_paid').val();
            var vat = $('#vat').val();
            var discount = $('#discount').val();
            var paid = parseFloat('{{ $order->paid }}').toFixed(2);
            var refund = 0;

            if (vat == '' || vat < 0 || !$.isNumeric(vat))
                vat = 0;

            if (discount == '' || discount < 0 || !$.isNumeric(discount))
                discount = 0;

            if (new_paid == '' || new_paid < 0 || !$.isNumeric(new_paid))
                new_paid = 0;

            $('.product-item').each(function(i, obj) {
                var quantity = $('.quantity:eq('+i+')').val();
                var unit_price = $('.unit_price:eq('+i+')').val();

                if (quantity == '' || quantity < 0 || !$.isNumeric(quantity))
                    quantity = 0;

                if (unit_price == '' || unit_price < 0 || !$.isNumeric(unit_price))
                    unit_price = 0;

                $('.total-cost:eq('+i+')').html('৳' + (quantity * unit_price).toFixed(2) );
                subTotal += quantity * unit_price;
            });

            $('#total-amount').html('৳' + subTotal.toFixed(2));


            var productTotalVat = (subTotal * vat) / 100;
            var productTotalDiscount = (subTotal * discount) / 100;

            $('#product-sub-total').html('৳' + subTotal.toFixed(2));
            $('#vat_total').html('৳' + productTotalVat.toFixed(2));
            $('#discount_total').html('৳' + productTotalDiscount.toFixed(2));

            var total = parseFloat(subTotal) +
                parseFloat(productTotalVat) - parseFloat(productTotalDiscount);

            var due = parseFloat(total) - parseFloat(paid) -parseFloat(new_paid);

            if (due < 0) {
                var previousDue = due;
                due -= previousDue;
                refund = paid - total - due;
                $("#paid-area").hide();
            }



            $('#final-amount').html('৳' + total.toFixed(2));
            $('#due').html('৳' + due.toFixed(2));
            $('#total').val(total.toFixed(2));
            $('#due_total').val(due.toFixed(2));
            $('#refund').val(refund.toFixed(2));
            $('#refund_view').html('৳' + refund.toFixed(2));
        }

        function initProduct() {
            $('.select2').select2();
        }

        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endsection
