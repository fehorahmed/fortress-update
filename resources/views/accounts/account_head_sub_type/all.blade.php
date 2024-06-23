@extends('layouts.master')

@section('style')
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
    Account Head Sub Type
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
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <a href="{{ route('account_head.sub_type.add') }}" class="btn btn-primary bg-gradient-primary">Add Account Sub Head</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
{{--                            <th>Project Name</th>--}}
                            <th>Account Head Type</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subTypes as $type)
                            <tr>
                                <td>{{ $type->name }}</td>
{{--                                <td>{{ $type->project->name??'' }}</td>--}}
                                <td>{{ $type->accountHeadType->name }}</td>
                                <td>
                                    @if ($type->transaction_type == 1)
                                        <span class="label label-success">Income</span>
                                    @else
                                        <span class="label label-warning">Expense</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($type->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('account_head.sub_type.edit', ['subType' => $type->id]) }}">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables -->
{{--    <script src="{{ asset('themes/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>--}}
{{--    <script src="{{ asset('themes/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>--}}

    <script>
        $(function () {
            $('#table').DataTable();
        })
    </script>
@endsection

@section('script')
    <!-- DataTables -->
   <script>
        {{--$(function () {--}}
        {{--    $('#table').DataTable({--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        ajax: '{{ route('unit.datatable') }}',--}}
        {{--        columns: [--}}
        {{--            {data: 'name', name: 'name'},--}}
        {{--            {data: 'status', name: 'status'},--}}
        {{--            {data: 'action', name: 'action', orderable: false},--}}
        {{--        ],--}}
        {{--    });--}}
        {{--})--}}
    </script>
@endsection
