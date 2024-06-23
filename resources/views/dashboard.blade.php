@extends('layouts.master')
@section('title','Dashboard')

@section('content')
    <div class="row">
        @if (\Illuminate\Support\Facades\Auth::user()->admin_status == 1)
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$datas['project_count']}}</h3>

                        <p>Total Projects</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>

                    </div>
                    <a href="{{route('project.report')}}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$datas['supplier_count']??0}}</h3>

                    <p>Stakeholders </p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('stakeholder.projects')}}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$datas['product_count']??0}}</h3>

                    <p>Total Products</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('purchase_product')}}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$datas['stakeholder_count']??0}}</h3>

                    <p>Suppliers </p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('purchase.report')}}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Projects </h3>
                </div>
                <div class="card-body table-responsive ">
                    <table id="project-table" class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Progress Completed</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{$project->name}}</td>
                                <td>{{$project->address}}</td>
                                <td>{{$project->totalCompleted}} %</td>
{{--                                <td>{{number_format($project->budget,2)}}</td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
{{--        <div class="col-sm-5">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h3 class="card-title">Browser Usage</h3>--}}

{{--                    <div class="card-tools">--}}
{{--                        <button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
{{--                            <i class="fas fa-minus"></i>--}}
{{--                        </button>--}}
{{--                        <button type="button" class="btn btn-tool" data-card-widget="remove">--}}
{{--                            <i class="fas fa-times"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- /.card-header -->--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-8">--}}
{{--                            <div class="chart-responsive">--}}
{{--                                <canvas id="pieChart" height="150"></canvas>--}}
{{--                            </div>--}}
{{--                            <!-- ./chart-responsive -->--}}
{{--                        </div>--}}
{{--                        <!-- /.col -->--}}
{{--                        <div class="col-md-4">--}}
{{--                            <ul class="chart-legend clearfix">--}}
{{--                                <li><i class="far fa-circle text-danger"></i> Chrome</li>--}}
{{--                                <li><i class="far fa-circle text-success"></i> IE</li>--}}
{{--                                <li><i class="far fa-circle text-warning"></i> FireFox</li>--}}
{{--                                <li><i class="far fa-circle text-info"></i> Safari</li>--}}
{{--                                <li><i class="far fa-circle text-primary"></i> Opera</li>--}}
{{--                                <li><i class="far fa-circle text-secondary"></i> Navigator</li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                        <!-- /.col -->--}}
{{--                    </div>--}}
{{--                    <!-- /.row -->--}}
{{--                </div>--}}
{{--                <!-- /.card-body -->--}}
{{--                <div class="card-footer p-0">--}}
{{--                    <ul class="nav nav-pills flex-column">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="#" class="nav-link">--}}
{{--                                United States of America--}}
{{--                                <span class="float-right text-danger">--}}
{{--                        <i class="fas fa-arrow-down text-sm"></i>--}}
{{--                        12%</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="#" class="nav-link">--}}
{{--                                India--}}
{{--                                <span class="float-right text-success">--}}
{{--                        <i class="fas fa-arrow-up text-sm"></i> 4%--}}
{{--                      </span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="#" class="nav-link">--}}
{{--                                China--}}
{{--                                <span class="float-right text-warning">--}}
{{--                        <i class="fas fa-arrow-left text-sm"></i> 0%--}}
{{--                      </span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <!-- /.footer -->--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Today Purchase</h3>
                </div>
                <div class="card-body table-responsive ">
                    <table id="purchase-table" class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Supplier</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($todayOrders as $order)
                            <tr>
                                <td> {{$order->order_no}}</td>
                                <td> {{$order->supplier->name}}</td>
                                <td> {{$order->total}}</td>
                                <td> {{$order->paid}}</td>
                                <td> {{$order->due}}</td>
                                <td>
                                    <a href="{{ route('purchase_receipt.details', ['order' => $order->id]) }}"
                                       class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Today Utilize</h3>
                </div>
                <div class="card-body table-responsive ">
                    <table id="utilize-table" class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>Project</th>
                            <th>Segment</th>
                            <th>Product</th>
                            <th>Quantity</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($todayUtilizes as $todayUtilize)
                            <tr>
                                <td> {{$todayUtilize->project->name}}</td>
                                <td> {{$todayUtilize->segment->name}}</td>
                                <td> {{$todayUtilize->product->name}}</td>
                                <td> {{$todayUtilize->quantity}}</td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card -->
        </div>


    </div>
@endsection

@section('script')

    <script>
        $(function () {
            $('#utilize-table').DataTable();
            $('#purchase-table').DataTable();
            $('#project-table').DataTable();

        });
    </script>

@endsection
