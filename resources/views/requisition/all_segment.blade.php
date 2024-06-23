@extends('layouts.master')


@section('title')
    Costing Segments for {{$project->name}}
@endsection

@section('style')
    <style>
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            white-space: nowrap;
        }
    </style>
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
                                <th>Date</th>
                                <th>Estimate Project</th>
                                <th>Estimate Segment</th>

                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($costings as $costing)
                                <tr>
                                    <td>{{$costing->date??''}}</td>
                                    <td>{{$costing->project->name??''}}</td>
                                    <td>{{$costing->segment->name??''}}</td>

                                    <td>
                                        <a href="{{route('requisition',['costing'=>$costing->id])}}"
                                           class="btn btn-primary">Requisitions </a>
                                        <a href="{{route('requisition.add',['costing'=>$costing->id])}}"
                                           class="btn btn-primary">Add </a>
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

    <div class="modal fade" id="modal-receive">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Receive Date</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Date</label>

                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="date" name="date"
                                   value="{{ date('Y-m-d') }}" autocomplete="off">
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-receive-btn-save">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('script')
    <script>
        $(function () {
            $('#table').DataTable();
        })
    </script>

@endsection

