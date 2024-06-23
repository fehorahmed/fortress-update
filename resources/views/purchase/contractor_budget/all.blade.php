@extends('layouts.master')


@section('title')
    Contractor Budget Distribution
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
                    <a class="btn btn-primary" href="{{ route('contractor_budget.add') }}">Add Budget</a>

                    <hr>

                    <div class="table-responsive">

                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Contractor Name</th>
                                <th>Segment</th>
                                <th>Budget</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($contractors as $contractor)
                                <tr>
                                    <td>{{ $contractor->contractor->name }}</td>
                                    <td>
                                        @if($contractor->segment_id == 0)
                                            All
                                        @else
                                            {{ $contractor->segment->name ?? '' }}
                                        @endif
                                    </td>
                                    <td>{{ $contractor->total }}</td>
                                    <td>
                                        @if ($contractor->status == 1)
                                            <span class="badge  badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('contractor_budget.edit', ['contractorBudget' => $contractor->id]) }}">Edit</a>
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
