@extends('layouts.master')

@section('title')
    Stock Details - {{ $product->name }}
@endsection

@section('content')
{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="card card-outline card-primary">--}}
{{--                <div class="card-header with-border">--}}
{{--                    <h3 class="card-title">Filter</h3>--}}
{{--                </div>--}}
{{--                <!-- /.box-header -->--}}

{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-4">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>Date</label>--}}

{{--                                <div class="input-group">--}}
{{--                                    <div class="input-group-addon">--}}
{{--                                        <i class="fa fa-calendar"></i>--}}
{{--                                    </div>--}}
{{--                                    <input type="text" class="form-control pull-right" id="date" autocomplete="off">--}}
{{--                                </div>--}}
{{--                                <!-- /.input group -->--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-4">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>Type</label>--}}

{{--                                <select class="form-control" id="type">--}}
{{--                                    <option value="">All Type</option>--}}
{{--                                    <option value="1">Purchase In</option>--}}
{{--                                    <option value="5">Transfer Out</option>--}}
{{--                                    <option value="6">Transfer In</option>--}}
{{--                                    <option value="2">Sale Out</option>--}}
{{--                                    <option value="3">Sales Return</option>--}}
{{--                                    <option value="4">Purchase Return</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Supplier</th>
                        </tr>
                        </thead>
                        @foreach($logs as $inventory)
                        <tr>
                            <td>{{$inventory->date}}</td>
                            <td>
                                @if($inventory->type==1)
                                    <div class="badge badge-success">In</div>
                                @else
                                    <div class="badge badge-danger">Out</div>
                                @endif
                            </td>
                            <td>{{$inventory->quantity}}</td>
                            <td>{{$inventory->unit_price}}</td>
                            <td>{{$inventory->supplier->name ?? ''}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(function () {
             $('#table').DataTable();
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        ajax: {--}}
        {{--            url: "{{ route('purchase_inventory.details.datatable') }}",--}}
        {{--            data: function (d) {--}}
        {{--                d.product_id = {{ $product->id }}--}}
        {{--                d.date = $('#date').val()--}}
        {{--                d.type = $('#type').val()--}}
        {{--            }--}}
        {{--        },--}}
        {{--        columns: [--}}
        {{--            {data: 'date', name: 'date'},--}}
        {{--            {data: 'type', name: 'type'},--}}
        {{--            {data: 'quantity', name: 'quantity'},--}}
        {{--            {data: 'unit_price', name: 'unit_price'},--}}
        {{--            {data: 'supplier', name: 'supplier.name'},--}}
        {{--            {data: 'purchase_order', name: 'purchase_order.order_no'},--}}
        {{--        ],--}}
        {{--        order: [[ 0, "desc" ]],--}}
            });

        {{--    //Date range picker--}}
        {{--    $('#date').daterangepicker({--}}
        {{--        autoUpdateInput: false,--}}
        {{--        locale: {--}}
        {{--            cancelLabel: 'Clear'--}}
        {{--        }--}}
        {{--    });--}}

        {{--    $('#date').on('apply.daterangepicker', function(ev, picker) {--}}
        {{--        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));--}}
        {{--        table.ajax.reload();--}}
        {{--    });--}}

        {{--    $('#date').on('cancel.daterangepicker', function(ev, picker) {--}}
        {{--        $(this).val('');--}}
        {{--        table.ajax.reload();--}}
        {{--    });--}}

        {{--    $('#date, #type').change(function () {--}}
        {{--        table.ajax.reload();--}}
        {{--    });--}}
        {{--})--}}
    </script>
@endsection
