<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--Favicon-->
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />

    <!-- theme css -->
    <link rel="stylesheet" href="{{ asset('themes/backend/dist/css/adminlte.min.css') }}">

    <style>
        #receipt-content{
            font-size: 18px;
        }

        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 1px solid black !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 text-center" style="font-size: 16px">
                <h2 style="margin-bottom: 10px !important;"><img width="75px" src="{{ asset('img/logo.png') }}" alt=""> <strong style="border-bottom: 2px dotted #000;"><i>{{ config('app.name') }}</i></strong></h2>
                <strong style="border: 2px solid #000;padding: 1px 10px;font-size: 19px;">Stock Report</strong>
            </div>
            <div class="col-sm-3 offset-sm-9">
                <span class="date-top">Date:  <strong style="border: 1px solid #000;padding: 1px 10px;font-size: 16px;width: 100%;font-weight: normal;">{{ date('d-m-Y') }}</strong></span>
            </div>
        </div>
        <div class="row" style="margin-top: 8px;">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-bordered">
                                <tr>

                                    <th>Product</th>
                                    <th>Project</th>
                                    <th>Segment</th>

                                    <th>Quantity</th>
                                    <th>AVG. Price</th>
                                    <th>Last Price</th>
                                    {{-- <th>Selling Price</th> --}}
                                </tr>
                                @foreach($inventories as $inventory)
                                    <tr>

                                        <td>{{ $inventory->product->name }}</td>
                                        <td>{{ $inventory->project->name }}</td>
                                        <td>{{ $inventory->segment->name }}</td>
                                        <td>{{ number_format($inventory->quantity,2) }}</td>
                                        <td>{{ number_format($inventory->avg_unit_price,2) }}</td>
                                        <td>{{ number_format($inventory->unit_price,2) }}</td>
                                        {{-- <td>{{ number_format($inventory->selling_price,2) }}</td> --}}
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-right">Total</th>
                                    <th>{{ number_format($inventories->sum('quantity'),2) }}</th>
                                    <th>{{ number_format($inventories->sum('avg_unit_price'),2) }}</th>
                                    <th>{{ number_format($inventories->sum('unit_price'),2) }}</th>
                                    {{-- <th>{{ number_format($inventories->sum('selling_price'),2) }}</th> --}}
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    window.print();
    window.onafterprint = function(){ window.close()};
</script>
</body>
</html>
