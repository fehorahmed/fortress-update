<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--    <title>Cash_Voucher_{{$receiptPayment->receipt_payment_no}}</title> --}}

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('themes/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('themes/backend/dist/css/adminlte.min.css') }}">
    <style>
        /*html { background-color: #ffd21b; }*/
        body {
            margin: 50px;
            /*background-color: #ffd21b;*/
        }

        table,
        .table,
        table td,
        /*table th{background-color: #ffd21b !important;}*/
        .table-bordered {
            border: 1px solid #000000;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #000000 !important;
            /*background-color: #ffd21b !important;*/
        }

        .table.body-table td,
        .table.body-table th {
            padding: 2px 7px;
        }

        @page {
            margin: 0;
        }
    </style>
</head>
<style>
    /*html { background-color: #ffd21b; }*/
    body {
        margin: 50px;
        /*background-color: #ffd21b;*/
    }

    table,
    .table,
    table td,
    /*table th{background-color: #ffd21b !important;}*/
    .table-bordered {
        border: 1px solid #000000;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #000000 !important;
        /*background-color: #ffd21b !important;*/
    }

    .table.body-table td,
    .table.body-table th {
        padding: 2px 7px;
    }

    @page {
        margin: 0;
    }
</style>

<body>
    <div class="container-fluid">
        <div style="padding:10px; width:100%; text-align:center;">
            <h2>{{ env('APP_NAME') }} Holdings Ltd.</h2>
            <h4>Rupayan Tower, (12th Floor),
                Sayem Sobhan Anvir Rd, <br> Plot: 02, Dhaka 1229, Bangladesh.</h4>
            <h4>Tel: +88 02 8432643-4, Mob: 01313 714089.</h4>
            <h4>E-mail:scm@company.com.bd Web: www.company.com.bd</h4>
            <h4><strong>Stake Holder Payment Report</strong></h4>
            <h4><strong>Stake Holder Name:</strong> {{ $stakeholder->name ?? '' }}</h4>

        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="table-payments" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Payment Id</th>
                                <th>Transaction Method</th>
                                <th>Project</th>
                                <th>Bank</th>
                                <th>Branch</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Note</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($payments as $payment)
                                @php
                                    $total += $payment->total;
                                @endphp
                                <tr>
                                    <td>{{ $payment->date }}</td>
                                    <td>{{ $payment->payment_id }}</td>
                                    <td>
                                        @if ($payment->transaction_method == 1)
                                            Cash
                                        @else
                                            Bank
                                        @endif
                                    </td>
                                    <td>{{ $payment->project->name }}</td>
                                    <td>{{ $payment->bank ? $payment->bank->name : '' }}</td>
                                    <td>{{ $payment->branch ? $payment->branch->name : '' }}</td>
                                    <td>{{ $payment->account ? $payment->account->account_no : '' }}</td>
                                    <td>৳ {{ number_format($payment->total, 2) }}</td>
                                    <td>{{ $payment->note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6"></td>
                                <td><b>Total</b></td>
                                <td><b>{{ number_format($total, 2) }}</b></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.print();
        window.onafterprint = function() {
            window.close()
        };
    </script>
</body>

</html>
