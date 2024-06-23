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
        .bottom-title{
            border-top: 2px solid #000;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="box">
    <div id="prinarea">
        @if ($transaction->transaction_type == 2)
            <div class="container" style="padding: 10px !important;width: 700px !important;">
                <div style="padding:10px; width:100%; text-align:center;">
                    <h2> {{ config('app.name','') }} </h2>
                    <h4>এখানে চাউল, চিনি, ময়দা, তৈল, ডালডা ও বেকারী গ্রেডের মাল সুলভ মূল্যে বিক্রয় করা হয় । </h4>
                    <h4>ইসলামিয়া মার্কেট, পাবনা । </h4>
                    <h4>  মোবাইল : ০৭৩১-৬৩৬১৮, ০১৭৩৬-২১৬০৩৫, ০১৮২০-৫২৬৬৫৪</h4>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <span class="text-center" style="font-size: 18px;font-weight: bold;margin-top: 15px"> ডেবিট ভাউচার </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="text-left">
                            <span  style="border: 1px solid #999;padding: 5px">ভাউচার নাম্বার:</span>
                            <span  style="border: 1px solid #999;padding: 5px">{{$loan->loan_number}}</span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="text-right">
                            <span  style="border: 1px solid #999;padding: 5px">তারিখ :</span>
                            <span  style="border: 1px solid #999;padding: 5px">{{ $transaction->date->format('d-m-Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 10px;border: 2px solid #000;margin-top: 20px !important;">
                    <div class="col-xs-3"><strong>একাউন্ট হেড</strong></div>
                    <div class="col-xs-3"></div>
                    <div class="col-xs-6 text-right"><strong>এমাউন্ট(টাকায়)</strong></div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
                    <div class="col-xs-6">{{ $transaction->accountHeadSubType->name??'' }}</div>
                    <div class="col-xs-3 text-right">{{ number_format($transaction->amount, 2) }}</div>
                    <div class="col-xs-3 text-right"></div>
                </div>

                @if ($transaction->transaction_method == 2)
                    <div class="row" style="padding: 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
                        <div class="col-xs-3">চেক নং: {{ $transaction->cheque_no }}</div>
                        <div class="col-xs-3">তারিখ: {{ $transaction->cheque_date }}</div>
                        <div class="col-xs-5">ব্যাংক : {{ $transaction->bank->name }}</div>
                    </div>
                @endif
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-xs-3"></div>
                    <div class="col-xs-3"><strong>মোট:</strong></div>
                    <div class="col-xs-6 text-right"><strong>{{ number_format($transaction->amount, 2) }}</strong></div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-xs-12"><strong>এমাউন্ট কথায় (টাকায়):</strong> {{ $transaction->amount_in_word }}</div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-xs-12"><strong>বিবরণ:</strong> {{ $transaction->note }}</div>
                </div>
                <div class="row" style="margin-top: 20px !important;">
                    <div class="col-xs-3" style="margin-top: 25px;">
                        <div class="text-left" style="margin-left: 10px;">
                            <h5 class="bottom-title">গ্রহণকারী</h5>
                        </div>
                    </div>
                    <div class="col-xs-3" style="margin-top: 25px">
                        <div class="text-center">
                            <h5 class="bottom-title" style="text-align: center!important;">প্রস্তুতকারী</h5>
                        </div>
                    </div>
                    <div class="col-xs-3" style="margin-top: 25px">
                        <div class="text-right">
                            <h5 class="bottom-title">যাচাইকারী</h5>
                        </div>
                    </div>
                    <div class="col-xs-3" style="margin-top: 25px">
                        <div class="text-right">
                            <h5 class="bottom-title">কর্তৃপক্ষ</h5>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container" style="padding: 10px !important;width: 700px !important;">
                <div style="padding:10px; width:100%; text-align:center;">
                    <h2> {{ config('app.name','') }} </h2>
                    <h4>এখানে চাউল, চিনি, ময়দা, তৈল, ডালডা ও বেকারী গ্রেডের মাল সুলভ মূল্যে বিক্রয় করা হয় । </h4>
                    <h4>ইসলামিয়া মার্কেট, পাবনা । </h4>
                    <h4>  মোবাইল : ০৭৩১-৬৩৬১৮, ০১৭৩৬-২১৬০৩৫, ০১৮২০-৫২৬৬৫৪</h4>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <span class="text-center" style="font-size: 18px;font-weight: bold;margin-top: 15px"> ক্রেডিট ভাউচার </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="text-left">
                            <span  style="border: 1px solid #999;padding: 5px">ভাউচার নং:</span>
                            <span  style="border: 1px solid #999;padding: 5px">{{$loan->loan_number}}</span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="text-right">
                            <span  style="border: 1px solid #999;padding: 5px">তারিখ :</span>
                            <span  style="border: 1px solid #999;padding: 5px">{{ $transaction->date->format('d-m-Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 10px;border: 2px solid #000;margin-top: 20px !important;">
                    <div class="col-xs-3"><strong>একাউন্ট হেড</strong></div>
                    <div class="col-xs-3"></div>
                    <div class="col-xs-6 text-right"><strong>এমাউন্ট(টাকায়)</strong></div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
                    <div class="col-xs-6">{{ $transaction->accountHeadSubType->name??'' }}</div>
                    <div class="col-xs-3 text-right"></div>
                    <div class="col-xs-3 text-right">{{ number_format($transaction->amount, 2) }}</div>
                </div>
                {{-- <div class="row" style="padding: 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
                    <div class="col-xs-6">{{ $transaction->transaction_method == 1 ? 'Cash' : 'Cheque Received' }}</div>
                    <div class="col-xs-3 text-right">{{ number_format($transaction->amount, 2) }}</div>
                    <div class="col-xs-3 text-right">0.00</div>
                </div> --}}
                @if ($transaction->transaction_method == 2)
                    <div class="row" style="padding: 5px;border: 1px solid #000;border-bottom: 0px solid #000;">
                        <div class="col-xs-3">চেক নং: {{ $transaction->cheque_no }}</div>
                        <div class="col-xs-3">তারিখ: {{ $transaction->cheque_date }}</div>
                        <div class="col-xs-5">ব্যাংক : {{ $transaction->bank->name }}</div>
                    </div>
                @endif
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-xs-3"></div>
                    <div class="col-xs-3"><strong>মোট:</strong></div>
                    <div class="col-xs-6 text-right"><strong>{{ number_format($transaction->amount, 2) }}</strong></div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-xs-12"><strong>এমাউন্ট (কথায়):</strong> {{ $transaction->amount_in_word }}</div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-xs-12"><strong>বিবরণ:</strong> {{ $transaction->note }}</div>
                </div>
                <div class="row" style="margin-top: 20px !important;">
                    <div class="col-xs-3" style="margin-top: 25px;">
                        <div class="text-left" style="margin-left: 10px;">
                            <h5 class="bottom-title">গ্রহণকারী</h5>
                        </div>
                    </div>
                    <div class="col-xs-3" style="margin-top: 25px">
                        <div class="text-center">
                            <h5 class="bottom-title" style="text-align: center!important;">প্রস্তুতকারী</h5>
                        </div>
                    </div>
                    <div class="col-xs-3" style="margin-top: 25px">
                        <div class="text-right">
                            <h5 class="bottom-title">যাচাইকারী</h5>
                        </div>
                    </div>
                    <div class="col-xs-3" style="margin-top: 25px">
                        <div class="text-right">
                            <h5 class="bottom-title">কর্তৃপক্ষ</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>



<script>
    window.print();
    window.onafterprint = function(){ window.close()};
</script>
</body>
</html>
