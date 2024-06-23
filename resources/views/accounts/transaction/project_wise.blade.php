@extends('layouts.master')
@section('title')
   Project Wise Transaction
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
                <div class="card-body">
                    <a class="btn btn-primary" href="{{ route('transaction.project_wise.add') }}">Add Transaction</a>
                    <a target="_blank" style="float: right;margin-left:5px" class="btn btn-secondary btn-sm" href="{{route('supplier_payment.all')}}">Supplier Payment</a>
                    <a target="_blank" style="float: right" class="btn btn-info btn-sm" href="{{route('balance_transfer.all')}}">Balance Transfer</a>
                    <p style="float: right;margin-right:5px" >Total Cash Amount:৳ <b><i><u>{{number_format($totalCashAmount->amount??0)}}</u></i></b></p>
                    <p style="float: right;margin-right:5px" >Total Bank Amount:৳ <b><i><u>{{number_format($totalBankAmount->balance??0)}}</u></i></b> |</p>

                    <hr>

                    <div class="table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Voucher No</th>
                            <th>Project</th>
                            <th>Project Segment</th>
                            <th>Type</th>
                            <th>Group Summary Type</th>
                            <th>Group Summary Sub Type</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables -->

    <script>
        $(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('projectWise.datatable') }}',
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'receipt_no', name: 'receipt_no'},
                    {data: 'project', name: 'project'},
                    {data: 'segment', name: 'segment'},
                    {data: 'transaction_type', name: 'transaction_type'},
                    {data: 'accountHeadType', name: 'accountHeadType.name'},
                    {data: 'accountHeadSubType', name: 'accountHeadSubType.name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                order: [[ 0, "desc" ]],
            });
        })
    </script>
@endsection
