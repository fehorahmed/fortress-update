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
    {{$project->name}} Stakeholders
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

                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Project</th>
                            <th>Address</th>
                            <th>Phone No</th>
                            <th>Action</th>
                         </tr>
                        </thead>
                        <tbody>
                        @foreach($stakeholders as $stakeholder)
                        <tr>
                            <td>{{$stakeholder->stakeholder->name}}</td>
                            <td>{{$stakeholder->project->name??''}}</td>
                            <td>{{$stakeholder->stakeholder->address??''}}</td>
                            <td>{{$stakeholder->stakeholder->mobile_no??''}}</td>
                            <td>
                                <a class="btn btn-info" href="{{route('stakeholder.edit',['stakeholder' => $stakeholder->id])}}">Edit</a>
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
   <script>
        $(function () {
            $('#table').DataTable();
        })
    </script>
@endsection
