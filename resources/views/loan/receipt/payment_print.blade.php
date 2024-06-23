<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--Favicon-->
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <style>
        #receipt-content{
            font-size: 18px;
        }

        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 1px solid black !important;
        }
        .box{

            padding:10px;
        }
        .dotted{
            border-bottom: 1px dotted #000;width: 150px;
        }
        /*.bottom-title{*/
        /*    border-top: 1px solid #000;*/
        /*    text-align: center;*/
        /*}*/
        .bottom-title{
            border-top: 2px solid #000;
            text-align: center;
        }
        .img-overlay {
            position: absolute;
            left: 0;
            top: 130px;
            width: 100%;
            height: 100%;
            overflow: hidden;
            text-align: center;
            z-index: 9;
            opacity: 0.2;
        }

        .img-overlay img {
            width: 300px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="box">
{{--    <button class="pull-right btn btn-primary" onclick="getprint('prinarea')">Print</button><br><br>--}}
    <div id="prinarea">
        <div class="container" style="padding: 10px !important;width: 700px !important;">
            <div class="row" style="margin-bottom: 10px">
                <div class="col-xs-4 text-left">
                    <div class="logo-area-report">
                        <img width="100%" src="{{ asset('img/head_logo.jpeg') }}">
                    </div>
                </div>
                <div class="col-xs-8 text-center">
                    <h2 style="font-size: 25px;margin: 0 ">BigApple Limited</h2>
                    <h4 style="margin: 0 ">katasur, Mohammdadpur</h4>
                    <h4 style="margin-top: 5px;margin-bottom: 0">Phone: 01934507070, 01943107080, 01935607090</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    @if($payment->loan_type == 2)
                    <span class="text-center" style="font-size: 18px;font-weight: bold;margin-top: 15px">Payment</span>
                    @else
                        <span class="text-center" style="font-size: 18px;font-weight: bold;margin-top: 15px">Receive</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="text-left">
                        <span  style="border: 1px solid #999;padding: 5px">Voucher No:</span>
                        @if($payment->loan_type == 2)
                        <span  style="border: 1px solid #999;padding: 5px">PV#{{ $payment->receipt_no }}</span>
                        @else
                            <span  style="border: 1px solid #999;padding: 5px">RV#{{ $payment->receipt_no }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="text-right">
                        <span  style="border: 1px solid #999;padding: 5px">Date :</span>
                        <span  style="border: 1px solid #999;padding: 5px">{{ date("d-m-Y", strtotime($payment->date)) }}</span>
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 10px;border: 2px solid #000;margin-top: 20px !important;">
                <div class="img-overlay">
                    <img src="{{ asset('img/logo.png') }}">
                </div>
                <div class="col-xs-3">Accounts Head</div>
                <div class="col-xs-3"></div>
                <div class="col-xs-3">Debit(in BDT)</div>
                <div class="col-xs-3">Credit(in BDT)</div>
            </div>
            @if($payment->loan_type == 1)
            <div class="row" style="padding: 5px;border: 1px solid #000;">
                @if ($payment->loan->client != '')
                    <div class="col-xs-6">{{ $payment->loan->client->name }}</div>
                @elseif($payment->loan->project != '')
                    <div class="col-xs-6">{{ $payment->loan->project->name }}</div>
                @else
                    <div class="col-xs-6">{{ $payment->loan->loanHolder->name }}</div>
                @endif
                <div class="col-xs-3">0.00</div>
                <div class="col-xs-3">{{ number_format($payment->amount, 2) }}</div>
            </div>
            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-xs-6"></div>
                <div class="col-xs-3">{{ number_format($payment->amount, 2) }}</div>
                <div class="col-xs-3">0.00</div>

            </div>
            @else
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-xs-6"></div>
                    <div class="col-xs-3">0.00</div>
                    <div class="col-xs-3">{{ number_format($payment->amount, 2) }}</div>

                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    @if ($payment->loan->client != '')
                        <div class="col-xs-6">{{ $payment->loan->client->name }}</div>
                    @elseif($payment->loan->project != '')
                        <div class="col-xs-6">{{ $payment->loan->project->name }}</div>
                    @else
                        <div class="col-xs-6">{{ $payment->loan->loanHolder->name }}</div>
                    @endif
                    <div class="col-xs-3">{{ number_format($payment->amount, 2) }}</div>
                    <div class="col-xs-3">0.00</div>

                </div>

                @endif
            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-xs-3"></div>
                <div class="col-xs-3">Total:</div>
                <div class="col-xs-3">{{ number_format($payment->amount, 2) }}</div>
                <div class="col-xs-3">{{ number_format($payment->amount, 2) }}</div>
            </div>
            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-xs-4">Amount In Word(in BDT):</div>
                <div class="col-xs-8 text-left">{{ $payment->amount_in_word }}</div>
            </div>
            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-xs-4">Narration:</div>
                <div class="col-xs-8 text-left"></div>
            </div>
            <div class="row" style="margin-top: 20px !important;">
                <div class="col-xs-3" style="margin-top: 25px;">
                    <div class="text-left" style="margin-left: 10px;">
                        <h5 class="bottom-title">Received By</h5>
                    </div>
                </div>
                <div class="col-xs-3" style="margin-top: 25px">
                    <div class="text-center">
                        <h5 class="bottom-title" style="text-align: center!important;">Prepared By</h5>
                    </div>
                </div>
                <div class="col-xs-3" style="margin-top: 25px">
                    <div class="text-right">
                        <h5 class="bottom-title">Checked By</h5>
                    </div>
                </div>
                <div class="col-xs-3" style="margin-top: 25px">
                    <div class="text-right">
                        <h5 class="bottom-title">Approved By</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    window.print();
    window.onafterprint = function(){ window.close()};
</script>
</body>
</html>
