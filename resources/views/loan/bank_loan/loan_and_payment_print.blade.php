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
            border: 1px solid #000;
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

    </style>
</head>
<body>
<div class="box">
    {{--    <button class="pull-right btn btn-primary" onclick="getprint('prinarea')">Print</button><br><br>--}}
    <div id="prinarea">
        <div class="container" style="padding: 10px !important;width: 700px !important;">
            <div class="col-xs-12 text-center">
                <h2> {{ config('app.name','') }} </h2>
                <h4>এখানে চাউল, চিনি, ময়দা, তৈল, ডালডা ও বেকারী গ্রেডের মাল সুলভ মূল্যে বিক্রয় করা হয় । </h4>
                <h4>ইসলামিয়া মার্কেট, পাবনা । </h4>
                <h4>  মোবাইল : ০৭৩১-৬৩৬১৮, ০১৭৩৬-২১৬০৩৫, ০১৮২০-৫২৬৬৫৪</h4>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                        <span class="text-center" style="font-size: 18px;font-weight: bold;margin-top: 15px">
                            @if ($payment->type ==1)
                                        গৃহীত লোন
                            @elseif ($payment->type == 2)
                                         পেমেন্ট
                            @elseif ($payment->type == 3)
                                        প্রদানকৃত লোন
                            @elseif($payment->type == 4)
                                         রিসিভ
                            @endif

                        </span>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="text-left">
                        <span  style="border: 1px solid #999;padding: 5px">ভাউচার নং:</span>
                            <span  style="border: 1px solid #999;padding: 5px">100{{ $payment->id }}</span>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="text-right">
                        <span  style="border: 1px solid #999;padding: 5px">তারিখ :</span>
                        <span  style="border: 1px solid #999;padding: 5px">{{ date("d-m-Y", strtotime($payment->date)) }}</span>
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 10px;border: 2px solid #000;margin-top: 20px !important;">
                <div class="col-xs-3">একাউন্ট হেড </div>
                <div class="col-xs-3"></div>
                <div class="col-xs-3"></div>
                <div class="col-xs-3 text-right">এমাউন্ট(টাকায়)</div>
            </div>


            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-xs-6">{{ $payment->loanHolder->name }}</div>
                <div class="col-xs-3"></div>
                <div class="col-xs-3 text-right">{{ number_format($payment->amount, 2) }}</div>
            </div>
            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-xs-6">{{ $payment->transaction_method==1?"ক্যাশ":'ব্যাংক'." - ".$payment->bank->name." - ".$payment->branch->name." - ".$payment->account->account_no}}</div>
                <div class="col-xs-3"></div>
                <div class="col-xs-3 text-right">{{ number_format($payment->amount, 2) }}</div>
            </div>

            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-xs-3"></div>
                <div class="col-xs-3">মোট:</div>
                <div class="col-xs-3"></div>
                <div class="col-xs-3 text-right"> <b>{{ number_format($payment->amount, 2) }}</b> </div>
            </div>
            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-xs-4">এমাউন্ট কথায় (টাকায়):</div>
                <div class="col-xs-8 text-left">{{ $payment->amount_in_word }}</div>
            </div>
            <div class="row" style="padding: 5px;border: 1px solid #000;">
                <div class="col-xs-4">বিবরণ:</div>
                <div class="col-xs-8 text-left"></div>
            </div>
            <div class="row" style="margin-top: 20px !important;">
                <div class="col-xs-3" style="margin-top: 25px;">
                    <div class="text-left" style="margin-left: 10px;">
                        <h5 class="bottom-title">ক্রেতা</h5>
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
    </div>
</div>



<script>
    window.print();
    window.onafterprint = function(){ window.close()};
</script>
</body>
</html>
