@extends('layouts.master')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    {{ $loans[0]->tender->name }} 's loans
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
            <div class="card">
                <div class="card-body">
                    <hr>
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Loan Number</th>
                            <th>Amount</th>
                            <th>Duration</th>
                            <th>Interest</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $interest = 0;
                        @endphp
                        @foreach($loans as $loan)

                            <tr>
                                <td>{{$loan->loan_number}}</td>
                                <td>{{number_format($loan->total,2)}}</td>
                                <td>{{ $loan->duration }} year</td>
                                <td>{{number_format($interest = ($loan->total * $loan->interest) /100 ,2)}}</td>
                                <td>{{number_format($interest + $loan->total,2)}}</td>
                                <td>{{number_format($loan->paid,2)}}</td>
                                <td>{{number_format($loan->due,2)}}</td>
                                <td>{{date("Y-m-d",strtotime($loan->date))}}</td>
                                <td>
                                   <a class="btn btn-primary btn-sm " href="{{route('project_loan_print',['loan'=>$loan->id,'type'=>$loan->loan_type])}}" > Print </a>
                                     <a class="btn btn-primary btn-sm " href="{{route('project_loan_payment_details',['loan'=>$loan->id,'type'=>$loan->loan_type])}}" > Details </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- /.modal -->

@endsection

@section('script')
    <!-- DataTables -->
    {{-- <script src="{{ asset('themes/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script> --}}
    <!-- bootstrap datepicker -->
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- sweet alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        $(function () {
            $('#table').DataTable();

        });

    </script>

@endsection
