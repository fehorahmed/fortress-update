@extends('layouts.master')


@section('title')
    Project Documentation
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
                <div class="card-header">
                    <a href="{{route('documentation.project.add',['project'=>$project->id])}}" class="btn btn-primary btn-sm">Add Documentation</a>
                </div>
                <div class="card-body table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($documentationInfos as $documentationInfo)
                            <tr>
                                <td>{{$documentationInfo->name}}</td>
                                <td>{{$documentationInfo->description}}</td>
                                <td><a href="{{route('documentation.project.edit',['info'=>$documentationInfo->id])}}" class="btn btn-primary btn-sm"> Edit</a>
                                </td>
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

    <script>
        $(function () {
            $('#table').DataTable();
            {{--$('#table').DataTable({--}}
            {{--    processing: true,--}}
            {{--    serverSide: true,--}}
            {{--    ajax: '{{ route('estimate_project.datatable') }}',--}}
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
