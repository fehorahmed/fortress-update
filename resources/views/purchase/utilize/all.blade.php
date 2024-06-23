@extends('layouts.master')


@section('title')
    Utilize Logs of {{$project->name}}
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
                    <a class="btn btn-primary" href="{{ route('purchase_product.utilize.add',['project'=>$project->id]) }}">Add</a>

                    <hr>
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Project</th>
                                <th>Segment</th>

                                <th>Date</th>
                                <th>Product</th>
                                <th>Unit price</th>
                                <th>Quantity</th>
                                <th>Note</th>
                            </tr>
                            </thead>
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
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                {{--ajax: '{{ route('purchase_product.utilize.all.datatable') }}',--}}
                ajax: {
                    url: '{{ route('purchase_product.utilize.all.datatable') }}',
                    data: function(d) {
                        d.project = '{{ $project->id }}';
                    }
                },
                columns: [
                    {data: 'project', name: 'project.name'},
                    {data: 'segment', name: 'segment.name'},
                    {data: 'date', name: 'date'},
                    {data: 'product', name: 'product'},
                    {data: 'unit_price', name: 'unit_price'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'note', name: 'note'},
                ],
                order: [[0, "desc"]],
            });
        });
    </script>
@endsection
