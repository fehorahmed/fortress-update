@extends('layouts.master')

@section('style')
    <style>
        .img-overlay {
            position: absolute;
            left: 0;
            top: 200px;
            width: 100%;
            height: 100%;
            /* overflow: hidden; */
            text-align: center;
            z-index: 9;
            opacity: 0.1;
            margin-top:100px;
        }

        .img-overlay img {
            width: 600px;
            height: auto;
        }

        .address-left{
            position: absolute;
            overflow: hidden;
            margin-top:1300px;
            margin-left:20px;
            /* z-index: 10000; */
        }

        .address-right{
            position: absolute;
            overflow: hidden;
            margin-top:1375px;
            right:35px;
            top:0;
        }

        .mobile{
            width: 20px;
            float: left;
            margin-right: 10px;
        }

        .mail{
            width: 20px;
            margin-right: 10px;
        }

        .web{
            width: 20px;
            margin-right: 10px;
        }
    </style>
@endsection

@section('title')
    Payment Details
@endsection

@section('content')

    <div class="row" id="receipt-content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button style="margin-right: 8px" class="btn btn-primary" onclick="getprint('prinarea')">Voucher Print</button>
                            <br><hr>
                        </div>
                    </div>

                    <div id="prinarea">
                            <div class="row" id="heading_area" style="margin-bottom: 10px!important;display: none; position: relative">
                                <div class="col-sm-12 text-center" style="font-size: 16px">
                                    <div style="float:left">
                                        <img style="width:350px;margin-top: -8px;opacity:0.4" src="{{ asset('img/topbar.jpg') }}">
                                    </div>

                                    <div style="float:right">
                                        <img style="width:200px;margin-top:50px" src="{{ asset('img/name.png') }}" alt="">
                                    </div>
                                    <div style="float:right">
                                        <img style="width:80px;margin-top:20px" src="{{ asset('img/logo.png') }}" alt="">
                                    </div>
                                    <br><br>

                                    {{-- <h2 style="margin-bottom: 0 !important;"><img width="75px" src="{{ asset('img/logo.png') }}" alt=""> <strong style="border-bottom: 2px dotted #000;"><i>{{ config('app.name') }}</i></strong></h2> --}}
                                    <strong style="border: 2px solid #000;padding: 1px 10px;font-size: 19px;">Debit Voucher</strong>
                                    <p class="">Printed by: {{Auth::user()->name}}</p>
                                </div>

                                <div class="col-sm-3 col-sm-offset-9">
                                    <span class="date-top">Date: <strong style="border: 1px solid #000;padding: 1px 10px;font-size: 16px;width: 100%;font-weight: normal;">{{ date('d-m-Y') }}</strong></span>
                                </div>

                                <div class="img-overlay">
                                    <img src="{{ asset('img/logo.png') }}">
                                </div>

                                <div class="address-left">
                                    <img src="{{ asset('img/icons/location.png')}}" style="width:20px" alt=""><br><br>
                                    <img src="{{ asset('img/only_logo.png')}}" style="width:190px;height:30px" alt="">
                                    <img src="{{ asset('img/only_name.png')}}" style="width:190px;height:20px" alt="">
                                    <p style="font-size: 20px;height:15px">Nargis Gardern,House-04,Road-07,Block-E,Sec-01,</p>
                                    <p style="font-size: 20px;margin-top:0px">Kaderabad Housing,Mohammadpur,Dhaka-1207</p>
                                </div>


                                <div class="address-right">
                                    <img class="mobile"src="{{ asset('img/icons/mobile.png')}}" alt="">
                                    <p style="font-size: 20px;height:15px">01776-88 88 88,01732-51 57 47</p>


                                    <p>
                                        <span style="font-size: 20px;height:15px">
                                            <img class="mail" src="{{ asset('img/icons/mail.png')}}" alt=""> Info@babl.com.bd
                                        </span>


                                        <span style="font-size: 20px;">
                                            <img class="web" src="{{ asset('img/icons/web.png')}}" style="" alt="">www.babl.com.bd
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="col-xs-12 text-center">
                                <h4 ><span style="font-weight: 700" class="pull-left">Serial No: {{ $loan->loan_number }}</span> <span style="font-size: 20px;font-weight: bold;text-transform: uppercase; margin-right: 100px;"> @if($loan->loan_type==1) Debit Voucher @else Credit Voucher @endif </span><span style="text-align: center; font-weight: normal;font-size: 16px;position: absolute;text-transform: capitalize;right: 20px;"><b>Date: </b> {{ date('Y-m-d') }}</span></h4>

                            </div>

                            <div class="col-xs-12">
{{--                                <div class="img-overlay">--}}
{{--                                    <img src="{{ asset('img/logo.png') }}">--}}
{{--                                </div>--}}
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td width="80%" style="border-bottom: 1px solid #fff !important;" colspan="7">Client Name: &nbsp;&nbsp;<strong>{{ $loan->client->name }}</strong><p style="border-bottom: 1px dotted #000;margin-left: 150px;"></p></td>
                                        <td width="20%" class="text-center"><strong>Amount</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom: 1px solid #fff !important;" colspan="7">Purpose of: <strong>

                                                {{ $loan->loan_type==1 ? 'Loan Taken' : 'Loan Given' }}


                                            </strong> <p style="border-bottom: 1px dotted #000;margin-left: 60px;"></p></td>
                                        <th rowspan="3" class="text-right">৳ {{ number_format($loan->total, 2) }}</th>

                                    </tr>
                                    <tr>
                                        <td width="80%" style="border-bottom: 1px solid #fff !important;" colspan="7">Address: <strong>{{ $loan->client->address }}</strong><p style="border-bottom: 1px dotted #000;margin-left: 50px;"></p></td>

                                    </tr>

                                    <tr>
                                        <td style="border-right:1px solid #fff !important;border-bottom: 1px solid #fff !important;" colspan="2">Loan Duration: <strong>{{$loan->duration}} year</strong><p style="border-bottom: 1px dotted #000;margin-left: 80px;"></p></td>
                                         <td><strong>Loan Interest: &nbsp;{{$loan->interest}}%</strong><p style="border-bottom: 1px dotted #000;margin-left: 80px;"></p></td>
                                        <td style="border-left:2px solid #fff !important;border-right:2px solid #fff !important; border-bottom: 1px solid #fff !important;" colspan="2"><strong> Date: {{ $loan->date }} </strong><p style="border-bottom: 1px dotted #000;margin-left: 38px;"></p></td>

                                    </tr>
                                    <tr>

                                        {{-- <td style="border-bottom: 1px solid #fff !important;" colspan="8">
                                            <div style="width: 33.33%;float: left;text-align: left" class="three-half">Bank Name: <strong>@if (!empty($payment->bank->name)) {{$payment->bank->name}} @endif</strong><p style="border-bottom: 1px dotted #000;margin-left: 85px;"></p></div>
                                            <div style="width: 33.33%;float: left;text-align: left" class="three-half">Branch: <strong>@if (!empty($payment->branch->name)){{$payment->branch->name}}@endif</strong><p style="border-bottom: 1px dotted #000;margin-left: 52px;"></p></div>
                                            <div style="width: 33.33%;float: left;text-align: left" class="three-half">Account No.: <strong>@if (!empty($payment->account->account_no)){{$payment->account->account_no}}@endif</strong><p style="border-bottom: 1px dotted #000;margin-left: 84px;"></p></div>
                                        </td> --}}
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 0;" colspan="8">Amount in word: <strong>{{ $loan->amount_in_word }}</strong><p style="border-bottom: 1px dotted #000;margin-left: 117px;"></p></td>
                                    </tr>

                                    </tbody>
                                    <tfoot>
                                    <tr style="margin-top: 50px !important;border: 1px solid #fff !important;">
                                        <th style="border:0px solid !important;border: 0px solid !important;padding-top: 40px;padding-bottom: 0px;text-align: center;padding-top: 45px !important;" width="25%" colspan="2">Sign of Receiver <p style="border-top: 1px solid #000;margin-top: -26px;margin-left: 30px;margin-right: 30px;"></p></th>
                                        <th style="border:0px solid !important;padding-top: 40px;padding-bottom: 0px;text-align: center;padding-top: 45px !important;" width="25%" colspan="2">Prepared By <p style="border-top: 1px solid #000;margin-top: -26px;margin-left: 40px;margin-right: 40px;"></p></th>
                                        <th style="border:0px solid !important;padding-top: 40px;padding-bottom: 0px;text-align: center;padding-top: 45px !important;" width="25%" colspan="2">Checked By <p style="border-top: 1px solid #000;margin-top: -26px;margin-left: 45px;margin-right: 45px;"></p></th>
                                        <th style="border:0px solid !important;padding-top: 40px;padding-bottom: 0px;text-align: center;padding-top: 45px !important;" width="25%" colspan="2">Authorised By <p style="border-top: 1px solid #000;margin-top: -26px;margin-left: 35px;margin-right: 35px;"></p></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection
{{-- @section('script')
    <script>
        var APP_URL = '{!! url()->full()  !!}';
        function getprint(prinarea) {

            $('body').html($('#'+prinarea).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection --}}
@section('script')
    <script>
        var APP_URL = '{!! url()->full()  !!}';
        function getprint(prinarea) {
            $('#heading_area').show();
            $('body').html($('#'+prinarea).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
