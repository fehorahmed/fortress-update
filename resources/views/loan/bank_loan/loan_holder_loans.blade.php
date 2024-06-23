@extends('layouts.master')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    লোন হোল্ডারের লোনসমূহ
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
            <div class="box">
                <div class="box-body">
                    <h3> {{ $loan_holder->name }} এর লোনসমূহ </h3>
                    <hr>

                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> তারিখ </th>
                                <th> ভাউচার  </th>
                                <th> এমাউন্ট </th>
                                <th> পেইড </th>
                                <th> বাকি </th>
                                <th> নোট </th>
                                <th> একশন </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                                <tr>
                                    <th> {{ date('y-m-d', strtotime($loan->date)) }} </th>
                                    <th> {{ $loan->voucher_no }} </th>
                                    <th> {{ $loan->total }} </th>
                                    <th>{{ $loan->paid }}</th>
                                    <th>{{ $loan->due }}</th>
                                    <th>{{ $loan->note }}</th>
                                    <th>
                                        <a href="{{ route('loan.edit', $loan->id) }}" class="btn btn-primary btn-sm"> এডিট </a> 
                                        <a href="{{ route('loan_print', $loan->id) }}" class="btn btn-info btn-sm" target="_blank"> প্রিন্ট </a>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('themes/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- sweet alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        $(function () {
            $('#table').DataTable();
            // $('#table').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     ajax: '{{ route('capital.partner.datatable') }}',
            //     columns: [
            //         {data: 'amount', name: 'amount'},
            //         {data: 'balance', name: 'balance'},
            //         {data: 'note', name: 'note'},
            //         {data: 'action', name: 'action', orderable: false},
            //     ],
            // });

            //Date picker
            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

        });

    </script>

@endsection
