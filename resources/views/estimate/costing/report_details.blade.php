@extends('layouts.app')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <style>
        .bottom-title{
            border-top: 2px solid #000;
            text-align: center;
        }
    </style>
@endsection

@section('title')
    Estimation And Costing Details
@endsection

@section('content')
    <div class="box">
        <button class="pull-right btn btn-primary" onclick="getprint('prinarea')">Print</button><br><br>
        <div id="prinarea">
            <div class="container" style="padding: 10px !important;margin-top: 50px !important;width: 700px !important;">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <span class="text-center" style="font-size: 18px;font-weight: bold;margin-top: 15px">Journal</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="text-left">
                            <span  style="border: 1px solid #999;padding: 5px">Voucher No:</span>
                            <span  style="border: 1px solid #999;padding: 5px">JV#{{ $budget->order_no }}</span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="text-right">
                            <span  style="border: 1px solid #999;padding: 5px">Date :</span>
                            <span  style="border: 1px solid #999;padding: 5px">{{ $budget->date }}</span>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 10px;border: 2px solid #000;margin-top: 20px !important;background: #ededed;">
                    <div class="col-xs-3"><strong>Budget Product</strong></div>
                    <div class="col-xs-3"></div>
                    <div class="col-xs-3 text-right"><strong>Budget Amount</strong></div>
                    <div class="col-xs-3 text-right"><strong>Expense Amount</strong></div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">

                    <div class="col-xs-3">
                        @foreach($budget->products as $product)
                            {{$product->name}}<br>
                        @endforeach
                    </div>
                    <div class="col-xs-3"></div>
                    <div class="col-xs-3 text-right">
                        @foreach($budget->products as $product)
                            {{$product->budget_amount}}<br>
                        @endforeach
                    </div>
                    <div class="col-xs-3 text-right">
                        {{$totalProductExpenses->sum('total')}}
                    </div>

                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-xs-3"></div>
                    <div class="col-xs-3"><strong>Total:</strong></div>
                    <div class="col-xs-3 text-right"><strong>{{number_format($budget->total,2)}}</strong></div>
                    <div class="col-xs-3 text-right"><strong>{{number_format($budget->total,2)}}</strong></div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-xs-12"><strong>Amount In Word (in BDT):</strong> {{ $budget->amount_in_word }}</div>
                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-xs-12"><strong>Narration: </strong> {{ $budget->note }}</div>
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
@endsection

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('themes/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script>
        $(function () {
            $('#table-payments').DataTable({
                "order": [[ 0, "desc" ]],
            });
        });
    </script>
    <script>


        var APP_URL = '{!! url()->full()  !!}';
        function getprint(prinarea) {

            $('body').html($('#'+prinarea).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
