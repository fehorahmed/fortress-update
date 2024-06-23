@extends('layouts.master')
@section('title')
    Stakeholder Receive Details
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary" target="_blank" href="{{ route('payment_details.print',['stakeholder' => $stakeholder->id]) }}">Print</a>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                            <table id="table-payments" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Payment Id</th>
                                    <th>Transaction Method</th>
                                    <th>Project</th>
                                    <th>Bank</th>
                                    <th>Branch</th>
                                    <th>Account</th>
                                    <th>Amount</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->date }}</td>
                                        <td>{{ $payment->payment_id }}</td>
                                        <td>
                                            @if($payment->transaction_method == 1)
                                                Cash
                                            @else
                                                Bank
                                            @endif
                                        </td>
                                        <td>{{ $payment->project->name }}</td>
                                        <td>{{ $payment->bank ? $payment->bank->name : '' }}</td>
                                        <td>{{ $payment->branch ? $payment->branch->name : '' }}</td>
                                        <td>{{ $payment->account ? $payment->account->account_no : '' }}</td>
                                        <td>৳ {{ number_format($payment->total, 2) }}</td>
                                        <td>{{ $payment->note }}</td>
                                        <td>
                                            <a href="{{ route('stakeholder.payment_receipt', ['payment' => $payment->id]) }}"
                                               class="btn btn-primary btn-sm" style="margin-bottom: 5px">Details</a>

                                            <a href="{{ route('stakeholder.payment_receipt.edit', ['stakeholderPayment' => $payment->id]) }}"
                                               class="btn btn-info btn-sm">Edit</a>

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
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('#table-payments').DataTable({
                "order": [[1, "desc"]],
            });

        });
    </script>
@endsection
