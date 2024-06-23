@extends('layouts.master')


@section('title')
     Costing for {{$project->name}}
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
                            <th>Costing</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($costing as $cost)
                        <tr>
                            <td>{{$cost->date??''}}</td>
                            <td>{{$cost->project->name??''}}</td>
                            <td>{{$cost->segment->name??''}}</td>
                            <td>{{number_format($cost->total??'',2)}}</td>
                            <td><a href="{{route('costing.details', ['costing' => $cost->id])}}" class="btn btn-primary btn-sm">View</a> <a href="{{route('costing.edit',['costing'=>$cost->id])}}" class="btn btn-primary btn-sm">Edit</a></td>
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
                            <input type="text" class="form-control pull-right" id="date" name="date" value="{{ date('Y-m-d') }}" autocomplete="off">
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
            var selectedOrderId;

            $('#table').DataTable({

                //order: [[ 0, "desc" ]],
            });

            //Date picker
            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('body').on('click', '.btn-receive', function () {
                var orderId = $(this).data('id');
                selectedOrderId = orderId;

                $('#modal-receive').modal('show');
            });

            {{--$('#modal-receive-btn-save').click(function () {--}}
            {{--    var date = $('#date').val();--}}

            {{--    if (date == '') {--}}
            {{--        Swal.fire({--}}
            {{--            icon: 'error',--}}
            {{--            title: 'Oops...',--}}
            {{--            text: 'Please select date.',--}}
            {{--        })--}}
            {{--    } else {--}}
            {{--        $.ajax({--}}
            {{--            method: "POST",--}}
            {{--            url: "{{ route('purchase_receipt.receive') }}",--}}
            {{--            data: { date: date, orderId: selectedOrderId }--}}
            {{--        }).done(function( response ) {--}}
            {{--            $('#modal-receive').modal('hide');--}}
            {{--            Swal.fire(--}}
            {{--                'Received!',--}}
            {{--                'Order has been Received.',--}}
            {{--                'success'--}}
            {{--            ).then((result) => {--}}
            {{--                location.reload();--}}
            {{--            });--}}
            {{--        });--}}
            {{--    }--}}
            {{--});--}}
            {{--$('body').on('click', '.btn-delete', function (e) {--}}
            {{--    e.preventDefault();--}}
            {{--    var orderId = $(this).data('id');--}}

            {{--    Swal.fire({--}}
            {{--        title: 'Are you sure?',--}}
            {{--        text: "You won't be able to revert this!",--}}
            {{--        icon: 'warning',--}}
            {{--        showCancelButton: true,--}}
            {{--        confirmButtonColor: '#3085d6',--}}
            {{--        cancelButtonColor: '#d33',--}}
            {{--        confirmButtonText: 'Yes, delete it!'--}}
            {{--    }).then((result) => {--}}
            {{--        if (result.isConfirmed) {--}}
            {{--            $.ajax({--}}
            {{--                method: "Post",--}}
            {{--                url: "{{ route('purchase_order_delete') }}",--}}
            {{--                data: { orderId: orderId }--}}
            {{--            }).done(function( response ) {--}}
            {{--                if (response.success) {--}}
            {{--                    Swal.fire(--}}
            {{--                        'Deleted!',--}}
            {{--                        response.message,--}}
            {{--                        'success'--}}
            {{--                    ).then((result) => {--}}
            {{--                        //location.reload();--}}
            {{--                        window.location.href = response.redirect_url;--}}
            {{--                    });--}}
            {{--                } else {--}}
            {{--                    Swal.fire({--}}
            {{--                        icon: 'error',--}}
            {{--                        title: 'Oops...',--}}
            {{--                        text: response.message,--}}
            {{--                    });--}}
            {{--                }--}}
            {{--            });--}}

            {{--        }--}}
            {{--    })--}}

            {{--});--}}
        });
    </script>
@endsection
