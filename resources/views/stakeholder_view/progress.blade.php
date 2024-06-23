@extends('stakeholder_view.layout.master')
@section('title')
    Physical Progress Report
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Filter</h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body">
                    <form action="{{ route('stakeholder.project.progress') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Project</label>
                                    <select class="form-control select2" name="project" required>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option
                                                {{ request()->get('project') == $project->id ? 'selected' : '' }} value="{{$project->id}}">{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> &nbsp;</label>
                                    <input class="btn btn-primary form-control" type="submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="prinarea">
                        <div style="clear: both">

                            <table id="table" class="table table-bordered table-striped">
                                @php
                                    $Total=0;
                                @endphp
                                <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Segment</th>
                                    <th class="text-center">Unit Done</th>
                                    <th class="text-center">Percentage</th>
                                    <th class="text-center">Project Percentage</th>
                                </tr>
                                </thead>
                                @foreach($segments as $segment)
                                    <tbody>

                                    @php
                                        $segmentT=0;
                                        $projectT=0;
                                        $segmentName='';
                                    @endphp

                                    @foreach($progresses as $progress)
                                        @if($progress->product_segment_id == $segment->id)
                                            <tr>
                                                <td class="text-center">{{$progress->date}}</td>
                                                <td>{{$progress->segment->name}}</td>
                                                <td>{{$progress->daily_unit_done}}</td>
                                                <td>{{$progress->segment_progress_percentage}} %</td>
                                                <td>{{$progress->project_progress_percentance}} %</td>
                                                @php
                                                    $segmentName=$progress->segment->name;
                                                        $segmentT+=$progress->segment_progress_percentage;
                                                        $projectT+=$progress->project_progress_percentance;
                                                @endphp
                                            </tr>
                                        @endif

                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <th colspan="2">Total for {{$segment->name}}</th>
                                        <th>{{number_format($segmentT,2)}} %</th>
                                        <th>{{number_format($projectT,2)}} %</th>
                                    </tr>
                                    @php
                                        $Total+=$projectT;
                                    @endphp
                                    </tbody>
                                @endforeach


                            </table>

                        </div>
                        <div class="row">
                            <div class="col-sm-6 offset-sm-6">


                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Total Project Complete</th>
                                        <th>{{number_format($Total,2)}} %</th>
                                    </tr>
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
        $(function () {
            //Date picker
            $('#start, #end').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });

    </script>
    <script>
        var APP_URL = '{!! url()->full()  !!}';

        function getprint(prinarea) {
            $('#heading_area').show();
            $('body').html($('#' + prinarea).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
