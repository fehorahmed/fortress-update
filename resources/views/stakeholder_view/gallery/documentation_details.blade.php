@extends('stakeholder_view.layout.master')
@section('title')
    Documentation
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
                    <h4>{{$documentation->name}}</h4>
                 </div>

                <div class="card-body">
                    <p>{{$documentation->description}}</p>
                        <div class="row">
                            @foreach ($documentationDetails as $documentationDetail )
                            <div class="col-sm-4">
                                <a href="{{asset($documentationDetail->image)}}" target="_blank"> <img src="{{asset($documentationDetail->image)}}" width="100%" alt=""></a>
                            </div>
                            @endforeach
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
