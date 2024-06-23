@extends('layouts.master')


@section('title')
    Requisition Details
@endsection

@section('content')
    <div class="card">
        <button class="pull-right btn btn-primary" onclick="getprint('prinarea')">Print</button><br><br>
        <div id="prinarea">
            <div class="container" style="padding: 10px !important;margin-top: 50px !important;width: 700px !important;">
                <div class="row">
                    <div style="padding:10px; width:100%; text-align:center;">
                        <h2>{{ env('APP_NAME') }} Holdings Ltd.</h2>
                        <h4>Rupayan Tower, (12th Floor),
                            Sayem Sobhan Anvir Rd, <br> Plot: 02 Dhaka 1229, Bangladesh.</h4>
                        <h4>Tel: +88 02-8432643-4, 55085298, Mobile: +88 01313 714089.</h4>
                        <h4>E-mail:scm@company.com.bd Web: www.company.com.bd</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h5><strong>Requisition Project Name: {{ $requisition->project->name ?? '' }}</strong></h5>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right">
                            <span style="border: 1px solid #999;padding: 5px">Date :</span>
                            <span style="border: 1px solid #999;padding: 5px">{{ $requisition->date }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <p>No:{{ $requisition->id_no }}</p>
                    </div>
                    <div class="col-sm-8">
                        <p class="text-center">Segment : <strong>{{ $requisition->segment->name }}</strong></p>
                    </div>

                </div>

                <div class="row"
                    style="padding: 10px;border: 2px solid #000;margin-top: 20px !important;background: #ededed;">
                    <div class="col-sm-6"><strong>Requisition Products</strong></div>
                    <div class="col-sm-6"><strong>Quantity</strong></div>

                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">

                    <div class="col-sm-6">
                        @foreach ($requisition->products as $product)
                            {{ $product->name ?? '' }}<br>
                        @endforeach
                    </div>

                    <div class="col-sm-6 ">
                        @foreach ($requisition->products as $product)
                            {{ $product->quantity }} {{ $product->product->unit->name ?? '' }}<br>
                        @endforeach
                    </div>

                </div>
                <div class="row" style="padding: 5px;border: 1px solid #000;">

                    <div class="col-sm-6"><strong>Total:</strong></div>
                    <div class="col-sm-6 "><strong>{{ number_format($requisition->quantity, 2) }}</strong></div>
                </div>

                <div class="row" style="padding: 5px;border: 1px solid #000;">
                    <div class="col-sm-12"><strong>Narration: </strong> {{ $requisition->note }}</div>
                </div>
                <div class="row" style="margin-top: 20px !important;">
                    <div class="col-sm-3" style="margin-top: 25px;">
                        <div class="text-left" style="margin-left: 10px;">
                            <h5 style="border-top: 2px solid black;" class="bottom-title">Received By</h5>
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 25px">
                        <div class="text-center">
                            <h5 style="border-top: 2px solid black;" class="bottom-title"
                                style="text-align: center!important;">Prepared By</h5>
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 25px">
                        <div class="text-right">
                            <h5 style="border-top: 2px solid black;" class="bottom-title">Checked By</h5>
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 25px">
                        <div class="text-right">
                            <h5 style="border-top: 2px solid black;" class="bottom-title">Approved By</h5>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <p>Created by:{{ $requisition->user->name ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('#table-payments').DataTable({
                "order": [
                    [0, "desc"]
                ],
            });
        });
    </script>
    <script>
        var APP_URL = '{!! url()->full() !!}';

        function getprint(prinarea) {

            $('body').html($('#' + prinarea).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
