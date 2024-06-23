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
            border-top: 1px solid #000;
            text-align: center;
        }

    </style>
</head>
<body>
<div class="container"  style="padding: 10px !important;margin-top: 130px !important;width: 700px !important;">
    <div class="row">
        <div style="padding:10px; width:100%; text-align:center;">
            <h2>FAIR FACE HOLDINGS LTD</h2>
            <h4>House:48(2nd Floor) Road:12,Sector:13,Uttara Model Town, Dhaka-1230.</h4>
            <h4>Tel: +88 02 55085297, 55085298, Fax: 88 02 55085298.</h4>
            <h4>E-mail:fairfacebd@hotail.com Web: www.fairfacebd.com</h4>
            <h4><strong>Maney Receipt</strong></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="text-left">
                <span  style="border: 1px solid #999;padding: 5px">MR:</span>
                <span  style="border: 1px solid #999;padding: 5px">RV#{{$transaction->receipt_no}}</span>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="text-right">
                <span  style="border: 1px solid #999;padding: 5px">Date: {{ $transaction->date->format('Y-m-d') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
        <div class="" style="font-size: 20px;position: relative;margin-top: 10px;padding-bottom: 10px!important;">Received With thanks from: <p style="border-bottom: 1px dotted #000;border-bottom: 1px dotted #000;position: absolute;left: 253px;top: 0; width: 63%;">{{ $transaction->accountHeadSubType->name??'' }}</p></div>
        </div>
        <div class="col-xs-12">
            <br>
            <div  style="font-size: 20px;padding-bottom: 10px!important;">Address:<p style="border-bottom: 1px dotted #000;border-bottom: 1px dotted #000;position: absolute;left: 111px;top: 0; width: 83%;"> . </p></div>
        </div>
        <div class="col-xs-12">
            <div style="line-height: 28px;padding-bottom: 10px!important;"><span style="visibility: hidden">Address:</span><span style="border-bottom: 1px dotted #000;border-bottom: 1px dotted #000;position: absolute;left: 111px;top: 0; width: 83%;"><span style="visibility: hidden">Address:</span></span></div>
        </div>
        <div class="col-xs-12">
            <span class="text-left" style="display: inline-block;font-size: 20px;padding: 10px 0!important;">Narration:</span>
            <span style="font-size: 20px;line-height: 24px">
                {{ $transaction->note }}
            </span>
        </div>
        <div class="col-xs-12">
            <span class="text-left" style="display:inline-block;font-size: 20px;padding-bottom: 10px!important;">Payment by:
                @if ($transaction->transaction_method == 1) Cash
                @elseif($transaction->transaction_method == 2) Bank
                @elseif($transaction->transaction_method == 3) Mobile Bangking
                @endif </span><span style="width: 300px;border-bottom: 1px dashed #000">
            </span>
        </div>
        <div class="col-xs-12">
            <div class="text-left" style="font-size: 20px;padding-bottom: 10px!important;display:inline-block"><strong>Amount in word(in BDT):</strong> {{ $transaction->amount_in_word }} Only</div>
        </div>
    </div>
       <div class="row" style="border: 1px solid #000000;padding: 5px;width: 99%;margin-left: 2px;">
           <div class="col-xs-4"><h4  style="margin-top: 15px;"><strong>TK:</strong></h4></div>
           <div class="col-xs-4 " style="border: 1px solid #000000;padding: 5px"><h4 class="text-center"><strong>{{ number_format($transaction->amount, 2) }}</strong></h4></div>
           <div class="col-xs-4"></div>
       </div>
        <div class="row">
        <div class="col-xs-12">
            <div style="font-size: 16px;margin-top: 5px;" class="text-left">For: <span> Panama LanDev (pvt) Limited</span></div>
        </div>
        </div>

    <div class="row" >
        <div class="col-xs-4" style="margin-top: 25px;">
            <div class="text-left" style="margin-left: 10px;">
                <h4 class="bottom-title">Prepared By</h4>
            </div>
        </div>
        <div class="col-xs-4" style="margin-top: 25px">
            <div class="text-center">
                <h4 class="bottom-title" style="text-align: center!important;">Accountant</h4>
            </div>
        </div>
        <div class="col-xs-4" style="margin-top: 25px">
            <div class="text-right">
                <h4 class="bottom-title">Managing Director</h4>
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


{{-- @section('style')
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
        border-top: 1px solid #000;
        text-align: center;
    }

</style>
@endsection

@section('title')
    Transaction Money Receipt Details
@endsection

@section('content')

@endsection --}}
