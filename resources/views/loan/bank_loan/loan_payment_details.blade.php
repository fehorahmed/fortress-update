@extends('layouts.master')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    লোন পেমেন্টের এর বিস্তারিত তথ্য 
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
                    <hr>
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center"> টাইপ </th>
                            <th class="text-center"> পেমেন্ট মেথড </th>
                            <th class="text-center"> এমাউন্ট </th>
                            <th class="text-center"> তারিখ </th>
                            <th class="text-center"> একশন </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="text-center">
                                    @if ($payment->type ==1)
                                        <label class="label label-primary">গৃহীত লোন </label>
                                    @elseif ($payment->type == 2)
                                        <label class="label label-primary">পেমেন্ট</label>
                                    @elseif ($payment->type == 3)
                                        <label class="label label-primary">প্রদানকৃত লোন </label>
                                    @elseif($payment->type == 4)
                                        <label class="label label-primary"> রিসিভ </label>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($payment->transaction_method==1)
                                        ক্যাশ
                                    @else
                                        ব্যাংক
                                    @endif

                                </td>
                                <td class="text-center">{{number_format($payment->amount,2)}}</td>
                                <td class="text-center">{{date("Y-m-d",strtotime($payment->date))}}</td>
                                <td>
                                    <a target="_blank" class="btn btn-success " href="{{route('loan_payment_print',['payment'=>$payment->id])}}" > প্রিন্ট  </a>
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
    <script src="{{ asset('themes/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
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
