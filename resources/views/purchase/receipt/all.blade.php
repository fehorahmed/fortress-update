@extends('layouts.master')
@section('title')
    Purchase Receipt
@endsection

@section('style')
    <style>
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            white-space: nowrap;
        }
    </style>
@endsection


@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>

                                <th>Order No</th>
                                <th>Project</th>
                                <th>Segment</th>
                                <th>Supplier</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-delivery">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Receive Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <form id="modal-form" enctype="multipart/form-data" name="modal-form">
                        <div class="form-group">
                            <label>Supplier Name</label>
                            <input class="form-control" id="modal-supplier-name" disabled>
                        </div>

                        <div class="form-group">
                            <label>Order No</label>
                            <input class="form-control" id="modal-order-no" name="order_no" type="text" readonly>
                            <input class="form-control" id="modal-order-id" name="order_id" type="hidden" >
                            <input class="form-control" id="modal-product-purchase-order-id" name="product_purchase_order_id" type="hidden" >

                        </div>

                        <div class="form-group">
                            <label>Challan no.</label>
                            <input class="form-control" id="modal-challan-no" name="challan_no" type="text" required>

                        </div>


                        <div class="form-group">
                            <label>Select Product</label>
                            <select class="form-control select2" id="modal-product" name="product">
                                <option value="">Select Product</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Total Quantity</label>
                            <input type="number" class="form-control" readonly name="total_quantity" id="modal-total-quantity">
                        </div>
                        <div class="form-group">
                            <label>Delivery Complete Quantity</label>
                            <input class="form-control" type="number" readonly name="complete_quantity" id="modal-complete-quantity">
                        </div>
                        <div class="form-group">
                            <label>Receive Quantity</label>
                            <input type="number" class="form-control" name="receive_quantity" id="modal-receive-quantity">
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" readonly class="form-control pull-right" id="date" name="date"
                                    value="{{ date('Y-m-d') }}" autocomplete="off">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Note</label>
                            <input class="form-control" name="note" id="modal-note" placeholder="Enter Note">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-btn-delivery">Confirm</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('script')
    <script>
        $(function() {
            var selectedOrderId;

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('purchase_receipt.datatable') }}',
                columns: [{
                        data: 'date',
                        name: 'date'
                    },

                    {
                        data: 'order_no',
                        name: 'order_no'
                    },

                    {
                        data: 'project',
                        name: 'project'
                    },
                    {
                        data: 'segment',
                        name: 'segment'
                    },
                    {
                        data: 'supplier',
                        name: 'supplier.name'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'paid',
                        name: 'paid'
                    },
                    {
                        data: 'due',
                        name: 'due'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, "desc"]
                ],
            });



            $('body').on('click', '.btn-delivery', function() {

                $('#modal-product').html('<option value=""> Select product</option>');
                $('#modal-total-quantity').val('');
                $('#modal-complete-quantity').val('');
                $('#modal-receive-quantity').val('');
                $('#modal-note').val('');
                var orderId = $(this).data('id');

                $.ajax({
                    method: "GET",
                    url: "{{ route('get_purchase_order') }}",
                    data: {
                        orderId: orderId
                    }
                }).done(function(response) {

                    console.log(response.order.order_no)
                    $('#modal-supplier-name').val(response.order.supplier.name);
                    $('#modal-order-no').val(response.order.order_no);
                    $('#modal-order-id').val(response.order.id);

                    $.each(response.products, function(index, item) {
                        $('#modal-product').append(
                            '<option data-productpurchaseorderid="' + item.id +
                            '" value="' + item.product_id + '">' + item.product.name +
                            '</option>');
                    });

                    $('#modal-delivery').modal('show');
                });

            });

            $('body').on('change', '#modal-product', function() {

                var productPurchaseOrderId = $(this).find('option:selected').data('productpurchaseorderid');
                $('#modal-product-purchase-order-id').val(productPurchaseOrderId);
                $.ajax({
                    method: "GET",
                    url: "{{ route('get_product_purchase_order') }}",
                    data: {
                        productPurchaseOrderId: productPurchaseOrderId
                    }
                }).done(function(response) {

                    console.log(response)

                    $('#modal-total-quantity').val(response.quantity);
                    $('#modal-complete-quantity').val(response.receive_quantity);
                    $('#modal-receive-quantity').attr('max', response.quantity - response
                        .receive_quantity);

                });

            });


            $('body').on('click', '#modal-btn-delivery', function() {

                var formData = new FormData($('#modal-form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('purchase_order_receive') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#modal-delivery').modal('hide');
                            Swal.fire(
                                'Received!',
                                response.message,
                                'success'
                            ).then((result) => {
                                location.reload();
                                //window.location.href = response.redirect_url;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    }
                });



            });


        });
    </script>
@endsection
