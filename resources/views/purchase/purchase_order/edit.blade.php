@extends('layouts.master')
@section('style')
    <style>
        select.form-control.product {
            width: 138px !important;
        }

        input.form-control.quantity {
            width: 90px;
        }

        input.form-control.unit_price,
        input.form-control.selling_price {
            width: 130px;
        }

        th {
            text-align: center;
        }

        select.form-control {
            min-width: 120px;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            white-space: nowrap;
        }

    </style>
@endsection

@section('title')
    Purchases
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header with-border">
                    <h3 class="card-title">Purchases Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('purchase_receipt.edit',['order'=>$order->id]) }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('supplier') ? 'has-error' : '' }}">
                                    <label for="supplier">Supplier</label>
                                    <select id="supplier" class="form-control select2 supplier" style="width: 100%;"
                                            name="supplier" data-placeholder="Select Supplier">
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ old('supplier',$order->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('project') ? 'has-error' : '' }}">
                                    <label for="project">Project</label>

                                    <select id="project" class="form-control select2 project" style="width: 100%;"
                                            name="project" data-placeholder="Select Project">
                                        <option value="">Select One</option>
                                        @foreach ($projects as $project)
                                            <option  value="{{ $project->id }}" {{ old('project',$order->project_id) == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('project')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('segment') ? 'has-error' : '' }}">
                                    <label for="segment">Project Segment</label>

                                    <select id="segment" class="form-control select2 segment" style="width: 100%;"
                                            name="segment" data-placeholder="Select Segment">
                                        <option value="">Select One</option>
                                    </select>
                                    @error('segment')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                                    <label for="date">Date</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="date" name="date"
                                               value="{{ empty(old('date')) ? ($errors->has('date') ? '' : date('Y-m-d')) : old('date') }}"
                                               autocomplete="off">
                                    </div>
                                    <!-- /.input group -->
                                    @error('date')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ $errors->has('requisition_id') ? 'has-error' : '' }}">
                                    <label for="date">Requisition Id</label>

                                    <div class="input-group">
                                        <input type="number" class="form-control requisition_id" id="requisition_id" name="requisition_id"
                                               value="{{old('requisition_id',$order->requisition_id??'')}}">
                                    </div>
                                    <!-- /.input group -->
                                    @error('requisition_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                                    <label for="date">Note</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control note" id="note" name="note"
                                               value="{{old('note',$order->note)}}">
                                    </div>
                                    <!-- /.input group -->
                                    @error('note')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>

                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Product Unit</th>
                                            <th>Unit Price</th>

                                            <th>Total Cost</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody id="product-container">
                                        @if (old('product') != null && sizeof(old('product')) > 0)
                                            @foreach (old('product') as $item)
                                                <tr class="product-item">
                                                    <td>
                                                        <div
                                                            class="form-group {{ $errors->has('product.' . $loop->index) ? 'has-error' : '' }}">
                                                            <select class="form-control select2 product"
                                                                    style="width: 100%;"
                                                                    data-selected-product="{{ old('product.' . $loop->index) }}"
                                                                    name="product[]">
                                                                <option value="">Select Product</option>
                                                                @foreach ($products as $product)
                                                                    <option
                                                                        {{ old('product.' . $loop->parent->index) == $product->id ? 'selected' : '' }}
                                                                        value="{{ $product->id }}">
                                                                        {{ $product->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="form-group {{ $errors->has('quantity.' . $loop->index) ? 'has-error' : '' }}">
                                                            <input type="number" step="any"
                                                                   class="form-control quantity" name="quantity[]"
                                                                   value="{{ old('quantity.' . $loop->index) }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="form-group {{ $errors->has('unit.' . $loop->index) ? 'has-error' : '' }}">
                                                            <input type="text" step="any"  style="width: 100%;" readonly class="form-control unit"
                                                                   name="unit[]"
                                                                   value="{{ old('unit.' . $loop->index) }}">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div
                                                            class="form-group {{ $errors->has('unit_price.' . $loop->index) ? 'has-error' : '' }}">
                                                            <input type="text" step="any"  style="width: 100%;"
                                                                   class="form-control unit_price" name="unit_price[]"
                                                                   value="{{ old('unit_price.' . $loop->index) }}">
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
                                                        <select class="form-control select2 product"
                                                                style="width: 100%;" name="product[]">
                                                            <option value="">Select Product</option>
                                                            @foreach ($products as $product)
                                                                <option {{$orderProduct->product_id==$product->id?'selected':''}} value="{{ $product->id }}">{{ $product->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="form-group">
                                                        <input type="number" step="any" style="width: 80%;"
                                                               class="form-control quantity" value="{{$orderProduct->quantity}}" name="quantity[]">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" step="any" style="width: 100%;"
                                                               class="form-control unit" readonly name="unit[]">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" step="any" style="width: 100%;"
                                                               class="form-control unit_price" value="{{$orderProduct->unit_price}}" name="unit_price[]">
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
                                                <a role="button" class="btn btn-info btn-sm" id="btn-add-product">Add
                                                    Product</a>
                                            </td>
                                            <th colspan="3" class="text-right">Total Amount</th>
                                            <th id="total-amount">৳0.00</th>
                                            <td></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Payment Type</label>
                                    <select class="form-control" id="modal-pay-type" name="payment_type">
                                        <option value="1" {{ old('payment_type') == '1' ? 'selected' : '' }}>Cash
                                        </option>
                                        <option value="2" {{ old('payment_type') == '2' ? 'selected' : '' }}>Bank
                                        </option>
                                        <option value="3" {{ old('payment_type') == '3' ? 'selected' : '' }}>Mobile
                                            Banking
                                        </option>
                                    </select>
                                </div>
                                <div id="modal-bank-info">
                                    <div class="form-group {{ $errors->has('bank') ? 'has-error' : '' }}">
                                        <label>Bank</label>
                                        <select class="form-control" id="modal-bank" name="bank">
                                            <option value="">Select Bank</option>
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}"
                                                    {{ old('bank') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group {{ $errors->has('branch') ? 'has-error' : '' }}">
                                        <label>Branch</label>
                                        <select class="form-control" id="modal-branch" name="branch">
                                            <option value="">Select Branch</option>
                                        </select>
                                    </div>

                                    <div class="form-group {{ $errors->has('account') ? 'has-error' : '' }}">
                                        <label>Account</label>
                                        <select class="form-control" id="modal-account" name="account">
                                            <option value="">Select Account</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Cheque No.</label>
                                        <input class="form-control" type="text" name="cheque_no"
                                               placeholder="Enter Cheque No." value="{{ old('cheque_no') }}">
                                    </div>

                                    <div class="form-group {{ $errors->has('cheque_image') ? 'has-error' : '' }}">
                                        <label>Cheque Image</label>
                                        <input class="form-control" name="cheque_image" type="file">
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
                                        <th colspan="4" class="text-right">VAT(%)</th>
                                        <td>
                                            <div class="form-group {{ $errors->has('vat') ? 'has-error' : '' }}">
                                                <input type="text" class="form-control" name="vat" id="vat"
                                                       value="{{ old('vat',$order->vat_percentage) }}">
                                                <span id="vat_total">৳0.00</span>
                                                <input type="hidden" class="form-control" name="total_vat" id="total_vat"
                                                       value="{{ old('total_vat') }}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Discount (%)</th>
                                        <td>
                                            <div class="form-group {{ $errors->has('discount') ? 'has-error' : '' }}">
                                                <input type="text" class="form-control" name="discount" id="discount"
                                                       value="{{ old('discount',$order->discount_percentage) }}">
                                                <span id="discount_total">৳0.00</span>
                                                <input type="hidden" class="form-control" name="total_discount"
                                                       id="total_discount"
                                                       value="{{ empty(old('total_discount')) ? ($errors->has('total_discount') ? '' : '0') : old('total_discount') }}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Total</th>
                                        <th id="final-amount">৳0.00</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Paid</th>
                                        <td>
                                            <div class="form-group {{ $errors->has('paid') ? 'has-error' : '' }}">
                                                <input type="text" class="form-control" name="paid" id="paid"
                                                       value="{{ old('paid',$order->paid) }}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Due</th>
                                        <th id="due">৳0.00</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="total" id="total">
                        <input type="hidden" name="due_total" id="due_total">
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
                    <select class="form-control select2 product" style="width: 100%;" name="product[]">
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </td>

            <td>
                <div class="form-group">
                    <input type="number" step="any" style="width: 80%;" class="form-control quantity" name="quantity[]">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" step="any" style="width: 100%;" class="form-control unit" readonly name="unit[]">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" step="any" style="width: 100%;" class="form-control unit_price" name="unit_price[]">
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
        $(function() {

            //Date picker
            $('#date, #date-refund').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            var message = '{{ session('message') }}';

            if (!window.performance || window.performance.navigation.type != window.performance.navigation
                .TYPE_BACK_FORWARD) {
                if (message != '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message,
                    });
                }
            }

            $('#modal-pay-type').change(function() {
                if ($(this).val() == '1' || $(this).val() == '3' || $(this).val() == '4') {
                    $('#modal-bank-info').hide();
                } else {
                    $('#modal-bank-info').show();
                }
            });

            $('#modal-pay-type').trigger('change');

            var selectedBranch = '{{ old('branch') }}';
            var selectedAccount = '{{ old('account') }}';

            $('#modal-bank').change(function() {
                var bankId = $(this).val();
                $('#modal-branch').html('<option value="">Select Branch</option>');
                $('#modal-account').html('<option value="">Select Account</option>');

                if (bankId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branch') }}",
                        data: {
                            bankId: bankId
                        }
                    }).done(function(response) {
                        $.each(response, function(index, item) {
                            if (selectedBranch == item.id)
                                $('#modal-branch').append('<option value="' + item.id +
                                    '" selected>' + item.name + '</option>');
                            else
                                $('#modal-branch').append('<option value="' + item.id +
                                    '">' + item.name + '</option>');
                        });

                        $('#modal-branch').trigger('change');
                    });
                }

                $('#modal-branch').trigger('change');
            });

            $('#modal-branch').change(function() {
                var branchId = $(this).val();
                $('#modal-account').html('<option value="">Select Account</option>');

                if (branchId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_account') }}",
                        data: {
                            branchId: branchId
                        }
                    }).done(function(response) {
                        $.each(response, function(index, item) {
                            if (selectedAccount == item.id)
                                $('#modal-account').append('<option value="' + item.id +
                                    '" selected>' + item.account_no + '</option>');
                            else
                                $('#modal-account').append('<option value="' + item.id +
                                    '">' + item.account_no + '</option>');
                        });
                    });
                }
            });

            $('#modal-bank').trigger('change');


            // select Project
            var selectedSegment = '{{ old('segment',$order->segment_id) }}'

            $('body').on('change', '#project', function() {
                var projectId = $(this).val();
                var itemProject = $(this);
                $('#segment').html('<option value="">Select</option>');
                if (projectId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_segment') }}",
                        data: {
                            projectId: projectId
                        }
                    }).done(function(data) {
                        $.each(data, function(index, item) {
                            if (selectedSegment == item.id)
                                $('#segment').append('<option value="' + item.id +
                                    '" selected>' + item.name + '</option>');
                            else
                                $('#segment').append('<option value="' + item.id + '">' +
                                    item.name + '</option>');
                        });
                    });

                }
            });

            $('#project').trigger('change');

            // select Unit
            //  var selectedUnit = '{{ old('') }}'

            $('body').on('change', '.product', function() {
                var productId = $(this).val();
                var itemProduct = $(this);
                //  $('#segment').html('<option value="">Select</option>');
                if (productId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_unit') }}",
                        data: {
                            productId: productId
                        }
                    }).done(function(data) {

                        itemProduct.closest('tr').find('.unit').val(data);
                    });

                }
            });

            $('.product').trigger('change');




            $('#btn-add-product').click(function() {
                var html = $('#template-product').html();
                var item = $(html);

                $('#product-container').append(item);
                initProduct();

                if ($('.product-item').length >= 1) {
                    $('.btn-remove').show();
                }
            });

            $('body').on('click', '.btn-remove', function() {
                $(this).closest('.product-item').remove();
                calculate();

                if ($('.product-item').length <= 1) {
                    $('.btn-remove').hide();
                }
            });

            $('body').on('keyup', '.quantity, .unit_price,  #vat, #discount, #paid', function() {
                calculate();
            });

            if ($('.product-item').length <= 1) {
                $('.btn-remove').hide();
            } else {
                $('.btn-remove').show();
            }
            initProduct();
            calculate();
        });

        function calculate() {
            var subTotal = 0;

            var vat = $('#vat').val();
            var discount = $('#discount').val();
            var paid = $('#paid').val();

            if (vat == '' || vat < 0 || !$.isNumeric(vat))
                vat = 0;
            if (discount == '' || discount < 0 || !$.isNumeric(discount))
                discount = 0;
            if (paid == '' || paid < 0 || !$.isNumeric(paid))
                paid = 0;

            $('.product-item').each(function(i, obj) {
                var quantity = $('.quantity:eq(' + i + ')').val();
                var unit_price = $('.unit_price:eq(' + i + ')').val();

                if (quantity == '' || quantity < 0 || !$.isNumeric(quantity))
                    quantity = 0;

                if (unit_price == '' || unit_price < 0 || !$.isNumeric(unit_price))
                    unit_price = 0;

                $('.total-cost:eq(' + i + ')').html('৳' + (quantity * unit_price).toFixed(2));
                subTotal += quantity * unit_price;
            });

            var productTotalVat = (subTotal * vat) / 100;

            var productTotalDiscount = (subTotal * discount) / 100;

            $('#vat_total').html('৳' + productTotalVat.toFixed(2));
            $('#total_vat').val(productTotalVat.toFixed(2));

            $('#discount_total').html('৳' + productTotalDiscount.toFixed(2));
            $('#total_discount').val(productTotalDiscount.toFixed(2));

            $('#total-amount').html('৳' + subTotal.toFixed(2));
            $('#product-sub-total').html('৳' + subTotal.toFixed(2));


            var total = parseFloat(subTotal) + parseFloat(productTotalVat) - parseFloat(productTotalDiscount);
            var due = parseFloat(total) - parseFloat(paid);
            $('#final-amount').html('৳' + total.toFixed(2));
            $('#due').html('৳' + due.toFixed(2));
            $('#total').val(total.toFixed(2));
            $('#due_total').val(due.toFixed(2));
        }

        function initProduct() {
            $('.select2').select2();
        }


        $(document).ready(function() {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endsection
