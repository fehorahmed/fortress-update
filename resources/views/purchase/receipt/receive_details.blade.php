@extends('layouts.master')

@section('title')
    Order Receive Details
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="table-responsive" id="print-area">
                        <div id="heading_area" style="margin-bottom: 10px!important;display: none">
                            <div style="padding:10px; width:100%; text-align:center;">
                                <h2>{{ env('APP_NAME') }} Holdings Ltd.</h2>
                                <h4>Rupayan Tower, (12th Floor),
                                    Sayem Sobhan Anvir Rd, <br> Plot: 02, Dhaka 1229, Bangladesh.</h4>
                                <h4>Tel: +88 02 8432643-4, Mob: 01313 714089.</h4>
                                <h4>E-mail:scm@company.com.bd Web: www.company.com.bd</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Product</th>
                                            <th>Challan no</th>
                                            <th>Quantity</th>
                                            <th>Note</th>
                                            <th>Receive by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($receives as $receive)
                                            <tr>
                                                <td>{{ $receive->date }}</td>
                                                <td>{{ $receive->product->name }}</td>
                                                <td>{{ $receive->challan_no ?? '' }}</td>
                                                <td>{{ $receive->quantity ?? '' }}</td>
                                                <td>{{ $receive->note ?? '' }}</td>
                                                <td>{{ $receive->user->name ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var APP_URL = '{!! url()->full() !!}';

        function getprint(print) {
            $('.extra_column').remove();
            $('#heading_area').show();
            $('body').html($('#' + print).html());
            window.print();
            window.location.replace(APP_URL)
        }


        $(function() {
            $('#table').DataTable({
                "order": [
                    [0, "desc"]
                ],
            });

        });
    </script>
@endsection
