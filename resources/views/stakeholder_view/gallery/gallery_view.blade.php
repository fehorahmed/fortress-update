@extends('stakeholder_view.layout.master')
@section('title')
    Gallery
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
                   <h4>Project Name</h4>
                </div>
                <div class="card-body">

                    <div class="row">
                        @foreach ($images as $image)

                        <div class="col-sm-4">
                        <div class="card-header">
                            <h5>{{$image->project->name??''}}</h5>
                            <h6>{{$image->description??''}}</h6>
                         </div>

                            <a href="{{asset($image->image)}}" target="_blank"> <img src="{{asset($image->image)}}" alt="" width="100%"></a>
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
