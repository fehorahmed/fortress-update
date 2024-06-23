@extends('layouts.master')

@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
          href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    Budget Distribute
@endsection

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Filter</h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body">
                    <form action="{{route('budget.distribute')}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Budget</label>
                                    <select class="form-control select2" name="budget" required>
                                        <option value="">Select Budget No</option>
                                        @foreach ($budgets as $budget)
                                            <option {{ request()->get('budget') == $budget->id ? 'selected' : '' }}
                                                    value="{{ $budget->id }}">{{ $budget->budget_no }}</option>
                                        @endforeach
                                    </select>
                                    @error('budget')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

{{--                            <div class="col-md-2">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label> &nbsp;</label>--}}
{{--                                    <input class="btn btn-primary form-control" name="show" type="submit" value="Show">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @if(count($stakeholders) > 0 && $budget->budget_update_status!=1)--}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label> &nbsp;</label>
                                    <input class="btn btn-info form-control" name="submit" type="submit" value="Submit">
                                </div>
                            </div>
{{--                            @endif--}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(count($stakeholders)>0)
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-1">
                                <a href="#" onclick="getprint('printArea')" class="btn btn-default btn-lg"><i
                                        class="fa fa-print"></i></a>
                            </div>
                            <div class="col-sm-6">
{{--                                @if($budget->budget)--}}
{{--                                    <h4>{{$budget->budget_no}} Budget: {{number_format($budget->budget,2)}}</h4>--}}
{{--                                @endif--}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm" id="printArea">

                            <hr>
                            <div style="clear: both">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Instalment Amount</th>
{{--                                        <th>Total</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stakeholders as $stakeholder)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$stakeholder->stakeholder->name}}</td>
                                            <td>{{$stakeholder->stakeholder->address}}</td>
                                            <td>{{$stakeholder->stakeholder->mobile_no}}</td>
                                            <td>{{number_format($stakeholder->budget_per_instalment_amount,2)}}</td>
{{--                                            <td>{{number_format($stakeholder->budget_per_instalment_amount * $stakeholder->budget_instalment,2)}}</td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-12">
                               <h4>No Stakeholders</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('script')
    <!-- bootstrap datepicker -->
    <script
        src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>

    <script>
        $(function () {
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
