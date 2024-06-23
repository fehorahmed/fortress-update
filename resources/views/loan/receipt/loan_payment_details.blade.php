@extends('layouts.master')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('title')
    Loan  Details
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table-payments" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($loan as $row)
                                    <tr>
                                        <td>{{ $row->client->name }}</td>
                                        <td>{{ $row->total }}</td>

                                        <td>৳{{ $row->paid }}</td>
                                        <td>৳{{ $row->due }}</td>
                                        <td>{{ $row->date }}</td>
                                        <td>

                                            <a target="_blank"  {{ $row->paid==0?"disabled":'' }} href="{{ route('loan_receipt.payment_print', ['payment' => $row->id]) }}" class="btn btn-primary">Receipt Print</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('#table-payments').DataTable({
                "order": [[ 0, "desc" ]],
            });
        });
    </script>
@endsection

