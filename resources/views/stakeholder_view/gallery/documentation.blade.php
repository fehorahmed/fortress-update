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

                <div class="card-body">

                 <table id="table" class="table table-striped table-bordered">
                     <thead>
                     <tr>

                             <th> Project</th>
                             <th>Documentation Name</th>
                             <th>Description</th>
                             <th>Action</th>

                     </tr>
                     </thead>
                     <tbody>
                     @foreach ($documentations as $documentation)
                     <tr>
                        <td>{{$documentation->project->name}}</td>
                        <td>{{$documentation->name}}</td>
                        <td>{{$documentation->description}}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{route('stakeholder.documentation.details',['documentation'=>$documentation->id])}}">Details</a></td>
                     </tr>
                     @endforeach
                     </tbody>
                 </table>

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
