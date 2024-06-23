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
    Project Physical Progress
@endsection

@section('content')
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">

                    {{ $project->name }}
                    {{-- <a href="{{ route('physical_progress.add') }}" class="btn btn-primary bg-gradient-primary">Add Physical Progress</a> --}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Segment</th>
                                    <th>Unit Done</th>
                                    <th>Segment Percentage</th>
                                    <th>Project Percentage</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($physicalProgress as $progress)
                                    <tr>
                                        <td>{{ $progress->date }}</td>
                                        <td>{{ $progress->segment->name ?? '' }}</td>
                                        <td>{{ $progress->daily_unit_done }}</td>
                                        <td>{{ $progress->segment_progress_percentage }}</td>
                                        <td>{{ $progress->project_progress_percentance }}</td>
                                        <td>{{ $progress->note }}</td>
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
        $(function() {
            $('#table').DataTable({
                order: [[3, 'desc']],
            });
        });
        // $(function () {
        //     $('#table').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: '{{ route('physical_progress.project.datatable') }}',
        //         columns: [
        //             {data: 'name', name: 'name'},
        //             {data: 'address', name: 'address'},
        //             {data: 'status', name: 'status'},
        //             {data: 'action', name: 'action', orderable: false},
        //         ],
        //     });
        // });
    </script>
@endsection
