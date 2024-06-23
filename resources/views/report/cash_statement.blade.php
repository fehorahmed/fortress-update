@extends('layouts.master')

@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
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
        .input-group-addon i{
            padding-top:10px;
            padding-right: 10px;
            border: 1px solid #cecccc;
            padding-bottom: 10px;
            padding-left: 10px;
        }
    </style>
@endsection

@section('title')
    Cash Statement
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Filter</h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body">
                    <form action="{{ route('report.cash_statement') }}">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right"
                                               name="start" value="{{ request()->get('start')  }}" autocomplete="off">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right"
                                               name="end" value="{{ request()->get('end')  }}" autocomplete="off">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Segment</label>
                                    <select class="form-control select2" name="segment">
                                        <option value="0">All Segment</option>
                                        @foreach($segments as $segment)
                                            <option
                                                value="{{ $segment->id }}" {{ request()->get('segment') == $segment->id ? 'selected' : '' }}>{{ $segment->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>	&nbsp;</label>
                                    <input class="btn btn-primary form-control" type="submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="min-height:300px">
            @if($result)
                <section class="card">

                    <div class="card-body">
                        <button class="pull-right btn btn-primary" onclick="getprint('prinarea')">Print</button><br><hr>

                        <div class="adv-table" id="prinarea">
                            <div class="row" id="heading_area" style="margin-bottom: 10px!important;display: none">
                                <div class="col-sm-12 text-center" style="font-size: 16px">
                                    <h2 style="margin-bottom: 0 !important;"><img width="75px" src="{{ asset('img/logo.jpeg') }}" alt="">
                                        <strong
                                            style="border-bottom: 2px dotted #000;"><i>{{ config('app.name') }}</i></strong>
                                    </h2>
                                    <strong style="border: 2px solid #000;padding: 1px 10px;font-size: 19px;">Cash Statement
                                        Report</strong>
                                    <p class="">Printed by: {{Auth::user()->name}}</p>
                                </div>
                                <div class="col-sm-3 col-sm-offset-9">
                                <span class="date-top">Date: <strong
                                        style="border: 1px solid #000;padding: 1px 10px;font-size: 16px;width: 100%;font-weight: normal;">{{ date('d-m-Y') }}</strong></span>
                                </div>
                            </div>
                            <div class="img-overlay" style="z-index: 1;">
                                <img src="{{ asset('img/logo.jpeg') }}">
                            </div>
{{--                            <div style="padding:10px; width:100%; text-align:center;">--}}
{{--                                <h4>{{ $metaData['start_date'].' - '.$metaData['end_date'] }}</h4>--}}
{{--                            </div>--}}

                            <table class="table table-bordered">
                                <tr>
                                    <th class="text-center" width="15%">Date</th>
                                    <th class="text-center" width="35%">Particular</th>
                                    <th class="text-center" width="15%">Debit</th>
                                    <th class="text-center" width="15%">Credit</th>
                                    <th class="text-center" width="20">Balance</th>
                                </tr>

                                @foreach($result as $item)
                                    <tr>
                                        <td class="text-center">
                                            @if (!empty($item['date']))
                                                {{ date('d-m-Y',strtotime($item['date'])) }}
                                            @endif
                                        </td>
                                        <td >{{ $item['particular'] }}</td>
                                        <td class="text-center">৳ {{ number_format((double)$item['credit'],2) }}</td>
                                        <td class="text-center">৳ {{ number_format((double)$item['debit'],2) }}</td>

                                        <td class="text-center">৳ {{ number_format((double)$item['balance'],2) }}</td>
                                    </tr>
                                @endforeach

                                <tfoot>
                                <tr>

                                    <th colspan="1"></th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">৳ {{ number_format((double)$metaData['total_credit'],2) }}</th>
                                    <th class="text-center">৳ {{ number_format((double)$metaData['total_debit'],2) }}</th>

                                    <th class="text-center">৳ {{ number_format((double)$item['balance'] ,2)}}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <!-- bootstrap datepicker -->
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $(function () {
            //Date picker
            $('#start, #end').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                orientation: 'bottom'
            });

            var branchSelected = '{{ request()->get('branch') }}';
            var accountSelected = '{{ request()->get('account') }}';

            $('#bank').change(function () {
                var bankId = $(this).val();
                $('#branch').html('<option value="">Select Branch</option>');
                $('#account').html('<option value="">Select Account</option>');

                if (bankId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branch') }}",
                        data: { bankId: bankId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (branchSelected == item.id)
                                $('#branch').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#branch').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });

                        $('#branch').trigger('change');
                    });
                }

                $('#branch').trigger('change');
            });

            $('#branch').change(function () {
                var branchId = $(this).val();
                $('#account').html('<option value="">Select Account</option>');

                if (branchId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_account') }}",
                        data: { branchId: branchId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (accountSelected == item.id)
                                $('#account').append('<option value="'+item.id+'" selected>'+item.account_no+'</option>');
                            else
                                $('#account').append('<option value="'+item.id+'">'+item.account_no+'</option>');
                        });
                    });
                }
            });

            $('#bank').trigger('change');
        });

        var APP_URL = '{!! url()->full()  !!}';

        function getprint(prinarea) {
            $('#heading_area').show();
            $('body').html($('#' + prinarea).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
