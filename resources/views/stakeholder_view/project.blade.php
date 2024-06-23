@extends('stakeholder_view.layout.master')
@section('title')
    Project Info
@endsection

@section('content')
    @if (Session::has('message'))
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
                    <form action="{{ route('stakeholder.project') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Project</label>
                                    <select class="form-control select2" name="project" required>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option
                                                {{ request()->get('project') == $project->id ? 'selected' : '' }} value="{{$project->id}}">{{$project->name}}</option>
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


@if($datas['project']!=null)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="prinarea">

                            <div style="clear: both">

                                <div class="row">
{{--                                    <div class="col-sm-6">--}}
{{--                                        <h3>All Stakeholder</h3>--}}
{{--                                        <table class="table table-bordered">--}}
{{--                                            <thead>--}}
{{--                                            <tr>--}}

{{--                                                <th>Name</th>--}}
{{--                                                <th>Address</th>--}}
{{--                                                <th>Phone</th>--}}
{{--                                            </tr>--}}
{{--                                            </thead>--}}
{{--                                            <tbody>--}}

{{--                                            @foreach($stakeholders as $stake)--}}
{{--                                                <tr>--}}
{{--                                                    <td>{{$stake->name}}</td>--}}
{{--                                                    <td>{{$stake->address}}</td>--}}
{{--                                                    <td>{{$stake->mobile_no}}</td>--}}
{{--                                                </tr>--}}
{{--                                            @endforeach--}}
{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
                                    <div class="col-sm-6">
                                        <h3>Budget</h3>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Total Budget</th>
                                                <td>{{number_format($datas['project']->budget??0,2)}}</td>
                                            </tr>

                                            <tr>
                                                <th>Total Expense</th>
                                                <td>{{number_format($expenses??0,2)}}</td>
                                            </tr>

                                            <tr>
                                                <th>In Hand</th>
                                                <td>{{number_format($incomes-$expenses??0,2)}}</td>
                                            </tr>
{{--                                            <tr>--}}
{{--                                                <th>Next Payment date</th>--}}
{{--                                                <td>{{$datas['nextPayment']}}</td>--}}
{{--                                            </tr>--}}

                                        </table>

                                        <h3>Duration</h3>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Start Date</th>
                                                <td>{{  date('Y F d',strtotime($datas['project']->duration_start??''))}}</td>
                                            </tr>
                                            <tr>
                                                <th>End Date</th>
                                                <td>{{  date('Y F d',strtotime($datas['project']->duration_end??''))}}</td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td>{{  $datas['project']->total_duration??''}} Months</td>
                                            </tr>

                                        </table>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-8">

                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Total budget Cost (Individual)</th>
                                                <td>{{ number_format($datas['budgetTotal']) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Paid</th>
                                                <td>{{ number_format($datas['budgetTotal']-$datas['budget_due']) }}</td>
                                            </tr>
                                            <tr class="bg-red">
                                                <th>Due</th>
                                                <td> {{ number_format($datas['budget_due']) }} </td>
                                            </tr>

                                        </table>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-5"><h3>Own Payments</h3></div>

                                        </div>

                                        <div class="table-responsive">
                                            <table id="payments-table" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>SL No.</th>
                                                    <th> Instalment No</th>
                                                    <th>Paid</th>
                                                    <th>Due</th>


                                                </tr>
                                                </thead>
                                                <tbody>

                                                @php
                                                         $total_p=0;
                                                        $total_d=0;
                                                        $total=0;
                                                @endphp
                                                @foreach($stakePayments as $payments)

                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$payments->instalment_no??0}}</td>
                                                        <td>{{$payments->paid??0}}</td>
                                                        <td>{{$payments->due??0}}</td>

                                                    </tr>
                                                    @php
                                                        $total_p+=$payments->paid;
                                                       $total_d+=$payments->due;

                                                    @endphp
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>

                                                    <th colspan="2" class="text-right">Total</th>

                                                    <th>{{number_format($total_p,2)}}</th>
                                                    <th>{{number_format($total_d,2)}}</th>

                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endif

@endsection

@section('script')
    <script>
        $(function() {
            $('#table').DataTable();
            $('#payments-table').DataTable();
            //  $('#table').DataTable({
            //  processing: true,
            //  serverSide: true,
            //  ajax: '{{ route('purchase_inventory.datatable') }}',
            //  columns: [

            //     {data: 'product', name: 'product.name'},
            //     {data: 'project', name: 'project.name'},
            //     {data: 'segment', name: 'segment.name'},
            //     {data: 'quantity', name: 'quantity'},
            //     {data: 'unit_price', name: 'unit_price'},
            //     {data: 'action', name: 'action'},
            //  ],
            //  });

        });
    </script>
@endsection
