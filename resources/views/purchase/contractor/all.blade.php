@extends('layouts.master')


@section('title')
    Contractor
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
                    <a class="btn btn-primary" href="{{ route('contractor.add') }}">Add Contractor</a>

                    <hr>

                    <div class="table-responsive">

                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company Name</th>
                                <th>Mobile</th>
                                <th>email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($contractors as $contractor)
                                <tr>
                                    <td>{{ $contractor->name }}</td>
                                    <td>{{ $contractor->company_name }}</td>
                                    <td>{{ $contractor->mobile }}</td>
                                    <td>{{ $contractor->email }}</td>
                                    <td>{{ $contractor->address }}</td>
                                    <td>
                                        @if ($contractor->status == 1)
                                            <span class="badge  badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('contractor.edit', ['contractor' => $contractor->id]) }}">Edit</a>
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
