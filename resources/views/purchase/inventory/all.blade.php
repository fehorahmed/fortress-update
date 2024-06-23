@extends('layouts.master')
@section('title')
    {{$project->name}} Stocks
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
                <div class="card-header">
                    <a target="_blank" class="btn btn-primary btn-sm pull-right"
                        href="{{ route('purchase_inventory_print') }}"><i class="fa fa-print"></i> Print</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Product</th>

                                    <th>Segment</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            @foreach ($inventories as $inventory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $inventory->product->name }}</td>
                                    <td>{{ $inventory->segment->name }}</td>
                                    <td>{{ $inventory->quantity }}</td>
                                    <td>{{ $inventory->unit_price }}</td>
                                    <td><a href="{{route('purchase_inventory.details', ['product' => $inventory->product_id,'project' => $inventory->project_id,'segment' => $inventory->segment_id])}}" class="btn btn-primary btn-sm">Details</a></td>

                                </tr>
                            @endforeach


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('#table').DataTable();
            //  $('#table').DataTable({
            //  processing: true,
            //  serverSide: true,
            //  ajax: '{{ route('purchase_inventory.datatable') }}',
            //  columns: [

            //     {data: 'product', name: 'product.name'},
            //     {data: 'project', name: 'project.name'},
            //     {data: 'segment', name: 'segment.name'},
            //     {data: 'quantity', name: 'quantity'},
            //     {data: 'unit_price', name: 'unit_price'},
            //     {data: 'action', name: 'action'},
            //  ],
            //  });

        });
    </script>
@endsection
