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
        #receipt-content{
            font-size: 18px;
        }

        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 1px solid black !important;
        }
        .bottom-title{
            border-top: 2px solid #000;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="box">
    {{--    <button class="pull-right btn btn-primary" onclick="getprint('prinarea')">Print</button><br><br>--}}
    <div id="prinarea">
        <div class="container" style="padding: 10px !important;margin-top: 130px !important;width: 700px !important;">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <span class="text-center" style="font-size: 18px;font-weight: bold;margin-top: 15px">Balance Transfer</span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="text-left">
                        <span  style="border: 1px solid #999;padding: 5px">Voucher No:</span>
                        <span  style="border: 1px solid #999;padding: 5px">CV#{{$transfer->receipt_no}}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-right">
                        <span  style="border: 1px solid #999;padding: 5px">Date :</span>
                        <span  style="border: 1px solid #999;padding: 5px">{{ $transfer->date}}</span>
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 10px;border: 2px solid #000;margin-top: 20px !important;background: #ededed !important;">
                <div class="col-sm-3">Accounts Head</div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3">Debit(in BDT)</div>
                <div class="col-sm-3">Credit(in BDT)</div>
            </div>

            @if($transfer->type==1)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-6">{{ $transfer->sourcebank->name.' - '.$transfer->sourceaccount->account_no }}</div>
                    <div class="col-sm-3">0.00</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                </div>
                @elseif($transfer->type==2)
                    <div class="row" style="padding: 5px;border: 1px solid #000;">
                        <div class="col-sm-6">Cash</div>
                        <div class="col-sm-3">0.00</div>
                        <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                    </div>
            @elseif($transfer->type==3)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-6">{{ $transfer->sourcebank->name.' - '.$transfer->sourceaccount->account_no }}</div>
                    <div class="col-sm-3">0.00</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                </div>
            @elseif($transfer->type==4)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-6">Cheque</div>
                    <div class="col-sm-3">0.00</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                </div>
                @else
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-6">Cheque</div>
                    <div class="col-sm-3">0.00</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                </div>
            @endif

{{--            check Number start--}}
            @if($transfer->type==1)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-4">{{ $transfer->source_cheque_no }}</div>
                    <div class="col-sm-4">Date: {{ $transfer->date}}</div>
                    <div class="col-sm-4"></div>
                </div>
            @elseif($transfer->type==2)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-4">{{ $transfer->target_cheque_no }}</div>
                    <div class="col-sm-4">Date: {{ $transfer->date}}</div>
                    <div class="col-sm-4"></div>

                </div>
            @elseif($transfer->type==3)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                        <div class="col-sm-4">{{ $transfer->source_cheque_no }}</div>
                        <div class="col-sm-4">Date: {{ $transfer->date}}</div>
                        <div class="col-sm-4"></div>
                </div>
            @elseif($transfer->type==4)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-4">{{ $transfer->target_cheque_no }}</div>
                    <div class="col-sm-4">Date: {{ $transfer->date}}</div>
                    <div class="col-sm-4"></div>

                </div>
            @else
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-4">Cheque</div>
                    <div class="col-sm-4">Date: {{ $transfer->date}}</div>
                    <div class="col-sm-4"></div>
                </div>
            @endif
{{--            check Number end--}}

            @if($transfer->type==1)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-6">Cash</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                    <div class="col-sm-3">0.00</div>
                </div>
            @elseif($transfer->type==2)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-6">{{ $transfer->targetbank->name.' - '.$transfer->targetaccount->account_no }}</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                    <div class="col-sm-3">0.00</div>

                </div>
            @elseif($transfer->type==3)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-6">{{ $transfer->targetbank->name.' - '.$transfer->targetaccount->account_no }}</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                    <div class="col-sm-3">0.00</div>

                </div>
            @elseif($transfer->type==4)
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-6">{{ $transfer->targetbank->name.' - '.$transfer->targetaccount->account_no }}</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                    <div class="col-sm-3">0.00</div>

                </div>
            @else
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-6">Cash</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                    <div class="col-sm-3">0.00</div>
                </div>
            @endif


            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-sm-3"></div>
                <div class="col-sm-3">Total:</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
                    <div class="col-sm-3">{{ number_format($transfer->amount, 2) }}</div>
            </div>
            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-sm-4">Amount In Word(in BDT):</div>
                <div class="col-sm-8 text-left">{{ $transfer->amount_in_word }}</div>
            </div>
            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-sm-4">Narration:</div>
                <div class="col-sm-8 text-left">{{ $transfer->note }}</div>
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
            </div>
        </div>
    </div>
</div>



{{--<div class="container"  style="padding: 10px !important;margin-top: 130px !important;width: 700px !important;">--}}
{{--    <div class="row">--}}
{{--        <div class="col-xs-6">--}}
{{--            <div class="text-left">--}}
{{--                <span  style="border: 1px solid #999;padding: 5px">MR:</span>--}}
{{--                <span  style="border: 1px solid #999;padding: 5px">{{ $transaction->id + 1000 }}</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-xs-6">--}}
{{--            <div class="text-right">--}}
{{--                <span  style="border: 1px solid #999;padding: 5px">Date:{{ $transaction->date->format('j F, Y') }}</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-xs-12">--}}
{{--            <div class="" style="font-size: 20px;position: relative;margin-top: 10px;">For Payment of <p style="border-bottom: 1px dotted #000;border-bottom: 1px dotted #000;position: absolute;left: 170px;top: 0; width: 75%;">{{ $transaction->accountHeadType->name.' - '.$transaction->accountHeadSubType->name }}</p></div>--}}
{{--        </div>--}}

{{--        <div class="col-xs-12">--}}
{{--            <span class="text-left" style="font-size: 20px">Narration:</span>--}}
{{--            <span style="font-size: 20px;line-height: 24px">--}}
{{--                 @if($transaction->transaction_method == 1)--}}
{{--                    Cash--}}
{{--                @else--}}
{{--                    Bank - {{ $transaction->bank->name.' - '.$transaction->branch->name.' - '.$transaction->account->account_no }}--}}
{{--                @endif--}}
{{--            </span>--}}
{{--        </div>--}}
{{--                        @if($transaction->transaction_method == 2)--}}
{{--                            <tr>--}}
{{--                                <th><span style="font-size: 20px;line-height: 24px;padding-left: 12px">Cheque No.</span></th>--}}
{{--                                <td colspan="3" ><span style="font-size: 20px;line-height: 24px">{{ $transaction->cheque_no }}</span></td>--}}
{{--                            </tr>--}}
{{--                        @endif--}}
{{--        <div class="col-xs-12">--}}
{{--            <span class="text-left" style="font-size: 20px">Payment by:</span>--}}
{{--            <span style="width: 300px;border-bottom: 1px dashed #000;font-size: 20px">--}}
{{--                @if($transaction->transaction_method == 1)--}}
{{--                    Cash--}}
{{--                @else--}}
{{--                    Bank--}}
{{--                @endif--}}
{{--            </span>--}}
{{--        </div>--}}

{{--        <div class="col-xs-12">--}}
{{--            <div class="text-left" style="font-size: 20px"><strong>Amount in word(in BDT):{{ $transaction->amount_in_word }}</strong></div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row" style="border: 1px solid #000000;padding: 5px;width: 99%;margin-left: 2px;">--}}
{{--        <div class="col-xs-4">TK:</div>--}}
{{--        <div class="col-xs-4 " style="border: 1px solid #000000;padding: 5px">{{ number_format($transaction->amount, 2) }}</div>--}}
{{--        <div class="col-xs-4"></div>--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-xs-12">--}}
{{--            <div style="font-size: 16px;margin-top: 5px;" class="text-left">For: <span></span></div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="row" >--}}
{{--        <div class="col-xs-4" style="margin-top: 25px;">--}}
{{--            <div class="text-left" style="margin-left: 10px;">--}}
{{--                <h4 class="bottom-title">Prepared By</h4>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-xs-4" style="margin-top: 25px">--}}
{{--            <div class="text-center">--}}
{{--                <h4 class="bottom-title" style="text-align: center!important;">Accountant</h4>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-xs-4" style="margin-top: 25px">--}}
{{--            <div class="text-right">--}}
{{--                <h4 class="bottom-title">Managing Director</h4>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--</div>--}}


{{--<div class="container-fluid">--}}
{{--    <div class="row">--}}
{{--        <div class="col-xs-4">--}}
{{--            <img src="{{ asset('img/logo.png') }}" height="50px" style="float: left">--}}
{{--            <h2 style="margin: 0px; float: left">RECEIPT</h2>--}}
{{--        </div>--}}

{{--        <div class="col-xs-4 text-center">--}}
{{--            <b>Date: </b> {{ $transaction->date->format('j F, Y') }}--}}
{{--        </div>--}}

{{--        <div class="col-xs-4 text-right">--}}
{{--            <b>No: </b> {{ $transaction->id + 1000 }}--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="row" style="margin-top: 20px">--}}
{{--        <div class="col-xs-12">--}}
{{--            <table class="table table-bordered">--}}
{{--                <tr>--}}
{{--                    <th width="20%">For Payment of</th>--}}
{{--                    <td>--}}
{{--                        {{ $transaction->accountHeadType->name.' - '.$transaction->accountHeadSubType->name }}--}}
{{--                    </td>--}}
{{--                    <th width="10%">Amount</th>--}}
{{--                    <td width="15%">৳{{ number_format($transaction->amount, 2) }}</td>--}}
{{--                </tr>--}}

{{--                <tr>--}}
{{--                    <th>Amount (In Word)</th>--}}
{{--                    <td colspan="3">{{ $transaction->amount_in_word }}</td>--}}
{{--                </tr>--}}

{{--                <tr>--}}
{{--                    <th>Paid By</th>--}}
{{--                    <td colspan="3">--}}
{{--                        @if($transaction->transaction_method == 1)--}}
{{--                            Cash--}}
{{--                        @else--}}
{{--                            Bank - {{ $transaction->bank->name.' - '.$transaction->branch->name.' - '.$transaction->account->account_no }}--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                </tr>--}}

{{--                @if($transaction->transaction_method == 2)--}}
{{--                    <tr>--}}
{{--                        <th>Cheque No.</th>--}}
{{--                        <td colspan="3">{{ $transaction->cheque_no }}</td>--}}
{{--                    </tr>--}}
{{--                @endif--}}

{{--                <tr>--}}
{{--                    <th>Note</th>--}}
{{--                    <td colspan="3">{{ $transaction->note }}</td>--}}
{{--                </tr>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


<script>
    window.print();
    window.onafterprint = function(){ window.close()};
</script>
</body>
</html>
