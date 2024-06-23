@extends('stakeholder_view.layout.master')
@section('title')
    Payments
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
                    <h4></h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                    <table id="table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Project</th>
                            <th>Date</th>
                            <th>Instalment no</th>
                            <th>Instalment count</th>
                            <th>Method</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        @php
                            $total=0;
                        @endphp
                        <tbody>
                        @foreach ($payments as $payment)

                            <tr>
                                <td>{{$payment->project->name}}</td>
                                <td>{{$payment->date}}</td>
                                <td>{{$payment->instalment_no}}</td>
                                <td>{{$payment->instalment_count?? ''}}</td>
                                @if ($payment->transaction_method==1)
                                    <td>Cash</td>
                                @elseif ($payment->transaction_method==2)
                                    <td>Bank</td>
                                @else
                                    <td>Mobile Banking</td>
                                @endif

                                <td>{{number_format($payment->total,2)}}</td>

                                @php
                                    $total+=$payment->paid;
                                @endphp
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>

                            <th colspan="5" class="text-right">Total</th>
                            <th>{{number_format($total,2)}}</th>
                        </tr>
                        </tfoot>
                    </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('#table').DataTable();
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
