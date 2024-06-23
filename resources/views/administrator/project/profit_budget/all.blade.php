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
    Project Profit Budget
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
                    {{-- <a href="{{ route('project.add') }}" class="btn btn-primary bg-gradient-primary">Add Project</a> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Profit Budget</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>{{$project->name}}</td>
                                    <td>{{$project->address}}</td>
                                    <td>{{number_format($project->profit_budget,2)}}</td>
                                    @if($project->profit_budget>0)
                                        <td></td>
                                    @else

                                        <td><a href="{{route('project.profit.budget.edit',['project'=>$project->id])}}"
                                               class="btn btn-primary btn-sm">Edit</a></td>

                                    @endif
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
    <script>
        $(function () {
            $('#table').DataTable();
            {{--$('#table').DataTable({--}}
            {{--    processing: true,--}}
            {{--    serverSide: true,--}}
            {{--    ajax: '{{ route('project.datatable') }}',--}}
            {{--    columns: [--}}
            {{--        {data: 'name', name: 'name'},--}}
            {{--        {data: 'address', name: 'address'},--}}
            {{--        {data: 'status', name: 'status'},--}}
            {{--        {data: 'action', name: 'action', orderable: false},--}}
            {{--    ],--}}
            {{--});--}}
        });
    </script>
@endsection
