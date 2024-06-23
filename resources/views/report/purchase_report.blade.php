@extends('layouts.master')

@section('title')
    Purchase Report
@endsection
@section('style')
    <!-- daterange picker -->
    <link rel="stylesheet"
          href="{{ asset('themes/backend/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <style>
        .img-overlay {
            position: absolute;
            left: 0;
            top: 200px;
            width: 100%;
            height: 100%;
            overflow: hidden;
            text-align: center;
            z-index: 9;
            opacity: 0.2;
        }

        .img-overlay img {
            width: 400px;
            height: auto;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('purchase.report') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Start Date</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder=" Select Date " class="form-control pull-right"
                                               name="start" value="{{ request()->get('start') }}"
                                               autocomplete="off">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>End Date</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="Select Date " class="form-control pull-right"
                                               name="end" value="{{ request()->get('end') }}"
                                               autocomplete="off">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Supplier</label>

                                    <select class="form-control select2" name="supplier">
                                        <option value="">All Supplier</option>

                                        @foreach($suppliers as $supplier)
                                            <option
                                                value="{{ $supplier->id }}" {{ request()->get('supplier') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Projects</label>
                                    <select class="form-control select2" name="project">
                                        <option value="">All Projects</option>

                                        @foreach($projects as $project)
                                            <option
                                                value="{{ $project->id }}" {{ request()->get('project') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> &nbsp;</label>

                                    <input class="btn btn-primary form-control" type="submit" value="Search">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <section class="card">
                <div class="card-heading">
                    <a href="#" role="button" onclick="getprint('print-area')" class="btn btn-primary btn-sm"><i
                            class="fa fa-print"></i> Print</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="print-area">
                        <div class="row" id="heading_area" style="margin-bottom: 10px!important;display: none">
                            <div class="col-sm-12 text-center" style="font-size: 16px">
                                <h2 style="margin-bottom: 0 !important;"><img width="75px"
                                  src="{{ asset('img/logo.png') }}" alt="">
                                    <strong
                                        style="border-bottom: 2px dotted #000;"><i>{{ config('app.name') }}</i></strong>
                                </h2>
                                <strong style="border: 2px solid #000;padding: 1px 10px;font-size: 19px;">Purchase
                                    Report</strong>
                                <p class=" d-block">Printed by: {{Auth::user()->name}}</p>
                            </div>
                            <div class="col-sm-3 col-xs-offset-9">
                                <span class="date-top">Date:  <strong
                                        style="border: 1px solid #000;padding: 1px 10px;font-size: 16px;width: 100%;font-weight: normal;">{{ date('d-m-Y') }}</strong></span>
                            </div>
                        </div>
                        <div style="clear: both">
                            <div class="img-overlay" style="display: none">
                                <img src="{{ asset('img/logo.jpeg') }}">
                            </div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Date</th>

                                    <th>Order No.</th>
                                    <th>Project</th>
                                    <th>Supplier</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th class="extra_column">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->date }}</td>

                                        <td>{{ $order->order_no }}</td>
                                        <td>{{ $order->project->name }}</td>
                                        <td>{{ $order->supplier->name }}</td>
                                        <td>{{ number_format($order->total, 2) }}</td>
                                        <td>{{ number_format($order->paid, 2) }}</td>
                                        <td>{{ number_format($order->due, 2) }}</td>
                                        <td class="extra_column"><a
                                                href="{{ route('purchase_receipt.details', ['order' => $order->id]) }}">View
                                                Invoice</a></td>
                                    </tr>
                                @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total</th>
                                    <th>{{ number_format($total, 2) }}</th>
                                    <th>{{ number_format($paid, 2) }}</th>
                                    <th>{{ number_format($due, 2) }}</th>
                                    <th class="extra_column"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{ $orders->appends($appends)->links() }}
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('script')
    <!-- date-range-picker -->
    <script src="{{ asset('themes/backend/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('themes/backend/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script>

        var APP_URL = '{!! url()->full()  !!}';

        function getprint(print) {
            $('.extra_column').remove();
            $('#heading_area').show();
            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
        $(function () {
            //Date picker
            $('#start, #end').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });

    </script>
@endsection
