<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--Favicon-->
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('themes/backend/dist/css/adminlte.min.css') }}">
    <style>
        #receipt-content {
            font-size: 18px;
        }

        .table-bordered>thead>tr>th,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>tbody>tr>td,
        .table-bordered>tfoot>tr>td {
            border: 1px solid black !important;
        }

        .bottom-title {
            border-top: 2px solid #000;
            text-align: center;
        }
    </style>

    <style>
        #receipt-content {
            font-size: 18px;
        }

        .table-bordered>thead>tr>th,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>tbody>tr>td,
        .table-bordered>tfoot>tr>td {
            border: 1px solid black !important;
        }

        .img-overlay {
            position: absolute;
            left: 0;
            top: -5px;
            width: 100%;
            height: 100%;
            overflow: hidden;
            text-align: center;
            z-index: 9;
            opacity: 0.2;
        }

        .img-overlay img {
            width: 350px;
            height: auto;
        }
    </style>

</head>

<body>
    <div class="box">
        <div id="prinarea">
            @if ($transaction->transaction_type == 2)
                <div class="container"
                    style="padding: 10px !important;margin-top: 130px !important;width: 700px !important;">
                    <div class="row">
                        <div style="padding:10px; width:100%; text-align:center;">
                            <h2>{{ env('APP_NAME') }} Holdings Ltd.</h2>
                            <h4>Rupayan Tower, (12th Floor),
                                Sayem Sobhan Anvir Rd, <br> Plot: 02, Dhaka 1229, Bangladesh.</h4>
                            <h4>Tel: +88 02 8432643-4, Mob: 01313 714089.</h4>
                            <h4>E-mail:scm@company.com.bd Web: www.company.com.bd</h4>

                        </div>
                    </div>
                    {{-- <div class="row">
                    <div class="col-sm-12 text-center">
                        <span class="text-center" style="font-size: 18px;font-weight: bold;margin-top: 15px">Payment</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="text-left">
                            <span  style="border: 1px solid #999;padding: 5px">Voucher No:</span>
                            <span  style="border: 1px solid #999;padding: 5px">PV#{{$transaction->receipt_no}}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right">
                            <span  style="border: 1px solid #999;padding: 5px">Date :</span>
                            <span  style="border: 1px solid #999;padding: 5px">{{ $transaction->date->format('d-m-Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 10px;border: 2px solid #000;margin-top: 20px !important;">
                    <div class="col-sm-3"><strong>Accounts Head</strong></div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3 text-right"><strong>Debit(in BDT)</strong></div>
                    <div class="col-sm-3 text-right"><strong>Credit(in BDT)</strong></div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
                    <div class="col-sm-6">{{ $transaction->accountHeadSubType->name }}</div>
                    <div class="col-sm-3 text-right">{{ number_format($transaction->amount, 2) }}</div>
                    <div class="col-sm-3 text-right">0.00</div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
                    <div class="col-sm-6">{{ $transaction->transaction_method == 1 ? 'Cash' : 'Cheque Received' }}</div>
                    <div class="col-sm-3 text-right">0.00</div>
                    <div class="col-sm-3 text-right">{{ number_format($transaction->amount, 2) }}</div>
                </div>
                @if ($transaction->transaction_method == 2)
                    <div class="row" style="padding: 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
                        <div class="col-sm-3">Chq. No.: {{ $transaction->cheque_no }}</div>
                        <div class="col-sm-3">Date: {{ $transaction->cheque_date }}</div>
                        <div class="col-sm-5">Drawn On : {{ $transaction->bank->name }}</div>
                    </div>
                @endif
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3"><strong>Total:</strong></div>
                    <div class="col-sm-3 text-right"><strong>{{ number_format($transaction->amount, 2) }}</strong></div>
                    <div class="col-sm-3 text-right"><strong>{{ number_format($transaction->amount, 2) }}</strong></div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">

                    <div class="col-sm-12"><strong>Amount In Word (in BDT):</strong> {{ $transaction->amount_in_word }}</div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-12"><strong>Narration:</strong> {{ $transaction->note }}</div>
                </div>
                <div class="row" style="margin-top: 20px !important;">
                    <div class="col-sm-3" style="margin-top: 25px;">
                        <div class="text-left" style="margin-left: 10px;">
                            <h5 class="bottom-title">Received By</h5>
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 25px">
                        <div class="text-center">
                            <h5 class="bottom-title" style="text-align: center!important;">Prepared By</h5>
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 25px">
                        <div class="text-right">
                            <h5 class="bottom-title">Checked By</h5>
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 25px">
                        <div class="text-right">
                            <h5 class="bottom-title">Approved By</h5>
                        </div>
                    </div>
                </div> --}}
                    <div class="col-sm-12">
                        <div class="img-overlay">
                            <img src="{{ asset('img/logo.jpeg') }}">
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td width="80%" style="border-bottom: 1px solid #fff !important;" colspan="7">
                                        Being the amount paid to:
                                        <strong>{{ $transaction->accountHeadType->name ?? ('' . ' - ' . $transaction->accountHeadSubType->name ?? '') }}</strong>
                                        <p style="border-bottom: 1px dotted #000;margin-left: 190px;"></p>
                                    </td>
                                    <td width="20%" class="text-center"><strong>Amount</strong></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #fff !important;" colspan="7">Purpose of:
                                        <strong>{{ $transaction->note }}</strong>
                                        <p style="border-bottom: 1px dotted #000;margin-left: 81px;"></p>
                                    </td>
                                    <td rowspan="2" class="text-right">৳ {{ number_format($transaction->amount, 2) }}
                                    </td>

                                </tr>

                                <tr>
                                    <td style="padding-bottom: 0;" colspan="7">
                                        <p style="border-bottom: 1px dotted #000;padding: 6px 0;"></p>
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="6" style="border-right: none !important;" class="text-right"><strong
                                            class="text-right">Total: </strong></td>
                                    <td colspan="2" class="text-right" style="border-left: none !important;">
                                        <strong>৳ {{ number_format($transaction->amount, 2) }}</strong>
                                    </td>

                                </tr>
                                <tr>
                                    <td style="border-right:1px solid #fff !important;border-bottom: 1px solid #fff !important;"
                                        colspan="6">Pay order/Cheque no./By Cash:
                                        @if ($transaction->transaction_method == 2)
                                            <strong>{{ $transaction->cheque_no }}</strong>
                                        @elseif($transaction->transaction_method == 1)
                                            <strong>Cash</strong>
                                        @else
                                            <strong>Mobile Banking</strong>
                                        @endif
                                        <p style="border-bottom: 1px dotted #000;margin-left: 225px;"></p>
                                    </td>
                                    <td style="border-left:1px solid #fff !important;border-bottom: 1px solid #fff !important;"
                                        colspan="2">Date: {{ date('d-m-Y', strtotime($transaction->cheque_date)) }}
                                        <p style="border-bottom: 1px dotted #000;margin-left: 38px;"></p>
                                    </td>

                                </tr>
                                <tr>

                                    <td style="border-bottom: 1px solid #fff !important;" colspan="8">
                                        <div style="width: 33.33%;float: left;text-align: left" class="three-half">Bank
                                            Name: <strong>
                                                @if (!empty($transaction->bank->name))
                                                    {{ $transaction->bank->name }}
                                                @endif
                                            </strong>
                                            <p style="border-bottom: 1px dotted #000;margin-left: 85px;"></p>
                                        </div>
                                        <div style="width: 33.33%;float: left;text-align: left" class="three-half">
                                            Branch: <strong>
                                                @if (!empty($transaction->branch->name))
                                                    {{ $transaction->branch->name }}
                                                @endif
                                            </strong>
                                            <p style="border-bottom: 1px dotted #000;margin-left: 52px;"></p>
                                        </div>
                                        <div style="width: 33.33%;float: left;text-align: left" class="three-half">
                                            Account No.: <strong>
                                                @if (!empty($transaction->account->account_no))
                                                    {{ $transaction->account->account_no }}
                                                @endif
                                            </strong>
                                            <p style="border-bottom: 1px dotted #000;margin-left: 84px;"></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 0;" colspan="8">Amount in word:
                                        <strong>{{ $transaction->amount_in_word }}</strong>
                                        <p style="border-bottom: 1px dotted #000;margin-left: 117px;"></p>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr style="margin-top: 50px !important;">
                                    <th style="border:0px solid !important;border: 0px solid !important;padding-top: 58px;padding-bottom: 27px;text-align: center"
                                        width="25%" colspan="2">Sig. of Receiver <p
                                            style="border-top: 1px solid #000;margin-top: -26px;margin-left: 30px;margin-right: 30px;">
                                        </p>
                                    </th>
                                    <th style="border:0px solid !important;padding-top: 58px;padding-bottom: 27px;text-align: center"
                                        width="25%" colspan="2">Prepared By <p
                                            style="border-top: 1px solid #000;margin-top: -26px;margin-left: 40px;margin-right: 40px;">
                                        </p>
                                    </th>
                                    <th style="border:0px solid !important;padding-top: 58px;padding-bottom: 27px;text-align: center"
                                        width="25%" colspan="2">Checked By <p
                                            style="border-top: 1px solid #000;margin-top: -26px;margin-left: 45px;margin-right: 45px;">
                                        </p>
                                    </th>
                                    <th style="border:0px solid !important;padding-top: 58px;padding-bottom: 27px;text-align: center"
                                        width="25%" colspan="2">Authorised By <p
                                            style="border-top: 1px solid #000;margin-top: -26px;margin-left: 35px;margin-right: 35px;">
                                        </p>
                                    </th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
            @else
                <div class="container"
                    style="padding: 10px !important;margin-top: 130px !important;width: 700px !important;">
                    <div class="row">
                        <div style="padding:10px; width:100%; text-align:center;">
                            <h2>{{ env('APP_NAME') }} Holdings Ltd.</h2>
                            <h4>Rupayan Tower, (12th Floor),
                                Sayem Sobhan Anvir Rd, Plot: 02, <br> Dhaka 1229, Bangladesh.</h4>
                            <h4>Tel: +88 02 8432643-4, Mob: 01313 714089.</h4>
                            <h4>E-mail:scm@company.com.bd Web: www.company.com.bd</h4>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="img-overlay">
                            <img src="{{ asset('img/logo.jpeg') }}">
                        </div>
                        <h4>Voucher No: #{{ $transaction->receipt_no }}</h4>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td style="border-bottom: 1px solid #fff !important;" colspan="7">Received from:
                                        <strong>{{ $transaction->accountHeadType->name ?? ('' . ' - ' . $transaction->accountHeadSubType->name ?? '') }}</strong>
                                        <p style="border-bottom: 1px dotted #000;margin-left: 165px;"></p>
                                        </th>
                                    <td class="text-center"><strong>Amount</strong></th>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #000 !important;" colspan="7">Being the
                                        amount received: <strong>{{ $transaction->note }}</strong>
                                        <p style="border-bottom: 1px dotted #000;margin-left: 198px;"></p>
                                    </td>
                                    <td rowspan="2" class="text-right">{{ number_format($transaction->amount, 2) }}
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="6" style="border-right: none !important;" class="text-right">
                                        <strong>Total:</strong>
                                    </td>
                                    <td colspan="2" style="border-left: none !important;" class="text-right">
                                        <strong> {{ number_format($transaction->amount, 2) }}</strong>
                                    </td>

                                </tr>
                                <tr>
                                    <td style="border-right:1px solid #fff !important;border-bottom: 1px solid #fff !important;"
                                        colspan="6">Pay order/Cheque no./By Cash:
                                        <strong>{{ $transaction->cheque_no }}</strong>
                                        <p style="border-bottom: 1px dotted #000;margin-left: 225px;"></p>
                                    </td>
                                    <td style="border-left:1px solid #fff !important;border-bottom: 1px solid #fff !important;"
                                        colspan="2">Date: {{ date('d-m-Y', strtotime($transaction->cheque_date)) }}
                                        <p style="border-bottom: 1px dotted #000;margin-left: 38px;"></p>
                                    </td>

                                </tr>
                                <tr>

                                    <td style="border-bottom: 1px solid #fff !important;" colspan="8">
                                        <div style="width: 33.33%;float: left;text-align: left" class="three-half">
                                            Bank Name: <strong>
                                                @if (!empty($transaction->bank->name))
                                                    {{ $transaction->bank->name }}
                                                @endif
                                            </strong>
                                            <p style="border-bottom: 1px dotted #000;margin-left: 85px;"></p>
                                        </div>
                                        <div style="width: 33.33%;float: left;text-align: left" class="three-half">
                                            Branch: <strong>
                                                @if (!empty($transaction->branch->name))
                                                    {{ $transaction->branch->name }}
                                                @endif
                                            </strong>
                                            <p style="border-bottom: 1px dotted #000;margin-left: 52px;"></p>
                                        </div>
                                        <div style="width: 33.33%;float: left;text-align: left" class="three-half">
                                            Account No.: <strong>
                                                @if (!empty($transaction->account->account_no))
                                                    {{ $transaction->account->account_no }}
                                                @endif
                                            </strong>
                                            <p style="border-bottom: 1px dotted #000;margin-left: 84px;"></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 0;" colspan="8">Amount in word:
                                        <strong>{{ $transaction->amount_in_word }}</strong>
                                        <p style="border-bottom: 1px dotted #000;margin-left: 117px;"></p>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr style="margin-top: 50px !important;">
                                    <td style="border:0px solid !important;padding-left: 54px;"></td>
                                    <th style="border:0px solid !important;padding-top: 58px;padding-bottom: 27px;text-align: center"
                                        width="33.33%" colspan="2">Prepared By <p
                                            style="border-top: 1px solid #000;margin-top: -26px;margin-left: 40px;margin-right: 40px;">
                                        </p>
                                    </th>
                                    <th style="border:0px solid !important;padding-top: 58px;padding-bottom: 27px;text-align: center"
                                        width="33.33%" colspan="2">Checked By <p
                                            style="border-top: 1px solid #000;margin-top: -26px;margin-left: 45px;margin-right: 45px;">
                                        </p>
                                    </th>
                                    <th style="border:0px solid !important;padding-top: 58px;padding-bottom: 27px;text-align: center"
                                        width="33.33%" colspan="2">Authorised By <p
                                            style="border-top: 1px solid #000;margin-top: -26px;margin-left: 35px;margin-right: 35px;">
                                        </p>
                                    </th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
            @endif
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
