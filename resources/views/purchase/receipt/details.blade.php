@extends('layouts.master')

@section('title')
    Purchase Receipt Details
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="#" role="button" onclick="getprint('print-area')" class="btn btn-primary btn-sm"><i
                                    class="fa fa-print"></i> Print</a>
                        </div>
                    </div>

                    <hr>

                    <div class="table-responsive" id="print-area">
                        <div id="heading_area" style="margin-bottom: 10px!important;display: none">
                            <div style="padding:10px; width:100%; text-align:center;">
                                <h2>{{ env('APP_NAME') }} Holdings Ltd.</h2>
                                <h4>Rupayan Tower, (12th Floor),
                                    Sayem Sobhan Anvir Rd, <br> Plot: 02, Dhaka 1229, Bangladesh.</h4>
                                <h4>Tel: +88 02 8432643-4, Mob: 01313 714089.</h4>
                                <h4>E-mail:scm@company.com.bd Web: www.company.com.bd</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Order No.</th>
                                        <td>{{ $order->order_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Date</th>
                                        <td>{{ $order->date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Project</th>
                                        <td>{{ $order->project->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Segment</th>
                                        <td>{{ $order->segment->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td>{{ $order->note ?? '' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan="2" class="text-center">Supplier Info</th>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $order->supplier->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td>{{ $order->supplier->mobile ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Company Name</th>
                                        <td>{{ $order->supplier->company_name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td style="white-space: break-spaces;">{{ $order->supplier->address ?? '' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Product</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($order->products as $product)
                                                <tr>
                                                    <td>{{ $product->id }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->product->unit->name ?? '' }}</td>
                                                    <td class="text-right">{{ $product->quantity }}</td>
                                                    <td class="text-right">
                                                        ৳{{ number_format($product->unit_price, 2) }}</td>
                                                    <td class="text-right">৳{{ number_format($product->total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="offset-md-8 col-md-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Sub Total Amount</th>
                                        <th class="text-right">৳{{ number_format($order->sub_total, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>Vat ({{ $order->vat_percentage }}%)</th>
                                        <th class="text-right">৳{{ number_format($order->vat, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>Discount ({{ $order->discount_percentage }}%)</th>
                                        <th class="text-right">৳{{ number_format($order->discount, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        <th class="text-right">৳{{ number_format($order->total, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>Paid</th>
                                        <th class="text-right">৳{{ number_format($order->paid, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th>Due</th>
                                        <th class="text-right">৳{{ number_format($order->due, 2) }}</th>
                                    </tr>

                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table id="table-payments" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Transaction Method</th>
                                            <th>Bank</th>
                                            <th>Branch</th>
                                            <th>Account</th>
                                            <th>Cheque No</th>
                                            <th>Amount</th>
                                            <th>Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($order->payments as $payment)
                                            <tr>
                                                <td>{{ $payment->date }}</td>
                                                <td>
                                                    @if ($payment->type == 1)
                                                        Pay
                                                    @elseif($payment->type == 2)
                                                        Refund
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($payment->transaction_method == 1)
                                                        Cash
                                                    @elseif($payment->transaction_method == 3)
                                                        Mobile Banking
                                                    @else
                                                        Bank
                                                    @endif
                                                </td>
                                                <td>{{ $payment->bank ? $payment->bank->name : '' }}</td>
                                                <td>{{ $payment->branch ? $payment->branch->name : '' }}</td>
                                                <td>{{ $payment->account ? $payment->account->account_no : '' }}</td>
                                                <td>{{ $payment->cheque_no ?? '' }}</td>
                                                <td>৳{{ number_format($payment->amount, 2) }}</td>
                                                <td>{{ $payment->note }}</td>
                                                <td>

                                                    <a href="{{ route('purchase_receipt.payment_details', ['payment' => $payment->id]) }}"
                                                        class="btn btn-primary btn-sm">Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var APP_URL = '{!! url()->full() !!}';

        function getprint(print) {
            $('.extra_column').remove();
            $('#heading_area').show();
            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }


        $(function() {
            $('#table-payments').DataTable({
                "order": [
                    [0, "desc"]
                ],
            });

        });
    </script>
@endsection
