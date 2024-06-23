@extends('layouts.master')



@section('title')
    Purchase Product
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
                    <a class="btn btn-primary" href="{{ route('purchase_product.add') }}">Add Product</a>
                    <a class="btn btn-primary" href="{{ route('unit.add') }}">Add Unit</a>
                    <a class="btn btn-warning" href="{{ route('product.import') }}">CSV Import(Product)</a>


                    <hr>
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->unit->name }}</td>
                                    <td>{{ $product->code }}</td>
                                    {{--                                <td>{{ $product->estimate_cost ?? '' }}</td>--}}
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        @if ($product->status == 1)
                                            <span class="badge  badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('purchase_product.edit', ['product' => $product->id]) }}">Edit</a>
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
