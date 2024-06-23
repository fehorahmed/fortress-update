@extends('layouts.master')
@section('title')
    Purchase Receipt
@endsection

@section('style')
    <style>
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            white-space: nowrap;
        }
    </style>
@endsection


@section('content')
    @if (Session::has('message'))
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
                            <th>Title</th>
                            <th>Content</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (auth()->user()->notifications()->paginate(10) as $notification)
                            <tr>
                                <td>{{ $notification->data['title'] }}</td>
                                <td><a href="{{ $notification->data['link'] }}">{{ $notification->data['text'] }}</a></td>
                                <td>{{ $notification->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        {{ auth()->user()->notifications()->paginate(10)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- /.modal -->
@endsection

