@extends('layouts.master')

@section('style')
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
    </style>
@endsection

@section('title')
    Loan Received Details
@endsection

@section('content')
    <div class="row" id="receipt-content">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            {{--                            <button style="margin-right: 8px" class=" btn btn-primary" onclick="getprint('printarea')">Voucher Print</button> --}}
                            <a target="_blank" href="{{ route('sale_receipt.payment_print', ['loan' => $loan->id]) }}"
                                class="btn btn-primary">Receipt Print</a>
                            <br>
                            <hr>

                        </div>
                    </div>


                    <div class="row">
                        <div id="printarea">
                            <div class="col-xs-2">

                            </div>

                            <div class="col-xs-8 text-center">
                                <h2>Panama LanDev (pvt) Limited</h2>
                                <h4>Madhabdi Bazar, Narsingdi </h4>
                                <h4>Phone: 9446763, 01937 10 70 80, 01937 10 70 90</h4>
                                <h4
                                    style="display: block;font-size: 20px;font-weight: bold;text-transform: uppercase;position: relative">
                                    Credit Voucher <span
                                        style="font-weight: normal;font-size: 16px;position: absolute;text-transform: capitalize;right: -117px;"><b>Date:
                                        </b> {{ $loan->date->format('d-m-Y') }}</span></h4>
                            </div>


                            <div class="col-xs-12">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td style="border-bottom: 1px solid #fff !important;" colspan="7">Received
                                                from: <strong>{{ $loan->client->name }}</strong>
                                                <p style="border-bottom: 1px dotted #000;margin-left: 165px;"></p>
                                                </th>
                                            <td class="text-center"><strong>Amount</strong></th>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom: 1px solid #fff !important;" colspan="7">Being the
                                                amount received: <strong>{{ $loan->note }}</strong>
                                                <p style="border-bottom: 1px dotted #000;margin-left: 198px;"></p>
                                            </td>
                                            <td rowspan="4" class="text-right">{{ number_format($loan->amount, 2) }}</td>

                                        </tr>
                                        <tr>
                                            <td style="border-bottom: 1px solid #fff !important;padding: 19px 0;"
                                                colspan="7">
                                                <p style="border-bottom: 1px dotted #000;"></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td style="border-bottom: 1px solid #fff !important;padding: 19px 0;"
                                                colspan="7">
                                                <p style="border-bottom: 1px dotted #000;"></p>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 0;" colspan="7">
                                                <p style="border-bottom: 1px dotted #000;padding: 6px 0;"></p>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td colspan="6"></td>
                                            <td class="text-center"><strong>Total:</strong></td>
                                            <td class="text-right"><strong> {{ number_format($loan->amount, 2) }}</strong>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td style="border-right:1px solid #fff !important;border-bottom: 1px solid #fff !important;"
                                                colspan="6">Pay order/Cheque no./By Cash: <strong></strong>
                                                <p style="border-bottom: 1px dotted #000;margin-left: 225px;"></p>
                                            </td>
                                            <td style="border-left:1px solid #fff !important;border-bottom: 1px solid #fff !important;"
                                                colspan="2">Date: <p
                                                    style="border-bottom: 1px dotted #000;margin-left: 38px;"></p>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td style="padding-bottom: 0;" colspan="8">Amount in word:
                                                <strong>{{ $loan->amount_in_word }}</strong>
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
                                        <tr>
                                            <td style="border: 1px solid #fff !important;font-size: 12px;" colspan="8"
                                                class="text-center"><span
                                                    style="border-bottom: 1px dotted #000 !important;">Software provide by
                                                    Tech & Byte. Mobile: 01884697775</span></td>
                                        </tr>
                                    </tfoot>

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

            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
