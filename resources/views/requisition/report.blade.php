@extends('layouts.master')

@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    Costing Report
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Filter</h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body">
                    <form action="{{ route('requisition.project.report') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Project</label>
                                    <select class="form-control select2" name="project" required>
                                        {{--                                        <option value="">Select Project</option> --}}
                                        @foreach ($projects as $project)
                                            <option {{ request()->get('project') == $project->id ? 'selected' : '' }}
                                                value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> &nbsp;</label>
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
        <div class="col-sm-12">
            @if ($projects)
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <a href="#" onclick="getprint('printArea')" class="btn btn-default btn-lg"><i
                                class="fa fa-print"></i></a>
                    </div>
                    <div class="card-body">
                        {{-- <button class="pull-right btn btn-primary" onclick="getprint('prinarea')">Print</button><br><hr> --}}

                        <div class="table-responsive-sm" id="printArea">
                            <div style="padding:10px; width:100%; text-align:center;">
                                <h2>{{ env('APP_NAME') }} Holdings Ltd.</h2>
                                <h4>Rupayan Tower, (12th Floor),
                                    Sayem Sobhan Anvir Rd, <br> Plot: 02, Dhaka 1229, Bangladesh.</h4>
                                <h4>Tel: +88 02 8432643-4, Mob: 01313 714089.</h4>
                                <h4>E-mail:scm@company.com.bd Web: www.company.com.bd</h4>
                                <h4><strong> Requisition Report</strong></h4>
                                @foreach ($projects as $project)
                                    <h4>{{ request()->get('project') == $project->id ? $project->name : '' }}</h4>
                                @endforeach

                            </div>
                            <hr>
                            <div class="row">
                                @foreach ($requisitions as $requisition)
                                    <div class="col-sm-6">
                                        <div style="clear: both">


                                            @foreach ($costingTypes as $costingType)
                                                @if ($requisition->product_segment_id == $costingType->id)
                                                    <h6 class="text-center">Estimation and Costing of
                                                        <strong> {{ $costingType->name }}</strong> Date:
                                                        <strong>{{ $requisition->date }}</strong> by
                                                        {{ $requisition->user->name ?? '' }}
                                                    </h6>
                                                    <table class="table table-bordered" style="width:100%; float:left">
                                                        <tr>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Quantity</th>
                                                            <th class="text-center">Unit</th>

                                                        </tr>
                                                        @php
                                                            $total = 0;
                                                        @endphp
                                                        @foreach ($requisition->products as $estimateProduct)
                                                            <tr>
                                                                <th class="text-center">{{ $estimateProduct->name }}
                                                                </th>

                                                                <td class="text-center">
                                                                    {{ $estimateProduct->quantity }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $estimateProduct->unit->name }}</td>

                                                            </tr>
                                                            @php
                                                                $total += $estimateProduct->quantity ?? 0;
                                                            @endphp
                                                        @endforeach
                                                    </table>
                                                @endif
                                            @endforeach
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <!-- bootstrap datepicker -->
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>

    <script>
        $(function() {
            //Date picker
            $('#start, #end').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });

        var APP_URL = '{!! url()->full() !!}';

        function getprint(print) {

            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
