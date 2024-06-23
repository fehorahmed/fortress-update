@extends('layouts.master')

@section('title')
     Segments of {{$project->name}}
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
                    <div class="table-responsive">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
{{--                            <th>Project Name</th>--}}
                            <th>Segment Percentage</th>
                            <th>Total Unit</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($segments as $segment)
                            <tr>
                                <td>{{ $segment->name }}</td>
{{--                                <td>{{ $segment->project->name??'' }}</td>--}}
                                <td>{{ $segment->segment_percentage }} {{$segment->segment_percentage?'%':''}} </td>
                                <td>{{ $segment->total_unit }}</td>
                                <td>{{ $segment->description }}</td>
                                <td>
                                    @if ($segment->status == 1)
                                        <span class="badge  badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('segment.edit', ['segment' => $segment->id]) }}">Edit</a>
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
@endsection

@section('script')

    <script>
        $(function () {
            $('#table').DataTable();
        })
    </script>
@endsection
