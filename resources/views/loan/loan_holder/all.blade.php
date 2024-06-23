@extends('layouts.master')

@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <style>
        table.table-bordered.dataTable th, table.table-bordered.dataTable td {
            text-align: center;
            vertical-align: middle;
        }
        .page-item.active .page-link {
            background-color: #009f4b;
            border-color: #009f4b;
        }
    </style>
@endsection

@section('title')
    Loan Holder
@endsection

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="card card-outline card-primary">
                <div class="card-header">
                    <a href="{{ route('loan_holder.add') }}" class="btn btn-primary bg-gradient-primary"> Add Loan Holder </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive-sm">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Mobile </th>
                            <th>Email</th>
                            <th> Address </th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($loanHolders as $loanHolder)
                            <tr>
                                <td>{{ $loanHolder->name }}</td>
                                <td>{{ $loanHolder->mobile }}</td>
                                <td>{{ $loanHolder->email }}</td>
                                <td>{{ $loanHolder->address }}</td>
                                <td>
                                    @if ($loanHolder->status == 1)
                                        <span class="label label-success"> Active</span>
                                    @else
                                        <span class="label label-danger">Inactive </span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('loan_holder.edit', ['loanHolder' => $loanHolder->id]) }}"> Edit </a>
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
    <!-- DataTables -->
    {{-- <script src="{{ asset('themes/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script> --}}

    <script>
        $(function () {
            $('#table').DataTable();
        })
    </script>
@endsection
