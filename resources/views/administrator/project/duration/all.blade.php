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
    Project Duration
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
                     <a href="{{ route('budget.add') }}" class="btn btn-primary bg-gradient-primary">Add Budget</a>
                     <a href="{{ route('budget.distribute') }}" class="btn btn-primary bg-gradient-primary">Budget Distribution</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Budget No</th>
                                <th>Project Name</th>
{{--                                <th>Start</th>--}}
{{--                                <th>End</th>--}}
                                <th>Budget</th>
{{--                                <th>Total Duration</th>--}}
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($budgets as $budget)
                                <tr>
                                    <td>{{$budget->budget_no}}</td>
                                    <td>{{$budget->project->name??''}}</td>
{{--                                    <td>{{$project->duration_start}}</td>--}}
{{--                                    <td>{{$project->duration_end}}</td>--}}
                                    <td>{{$budget->budget}}</td>
{{--                                    <td>{{$project->total_duration ? $project->total_duration.' Months' :''}} </td>--}}
                                    <td><a href="{{route('duration.edit',['budget'=>$budget->id])}}" class="btn btn-primary btn-sm">Edit</a></td>
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
