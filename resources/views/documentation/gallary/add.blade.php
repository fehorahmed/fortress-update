@extends('layouts.master')


@section('title')
    {{ $project->name }} Gallery
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header with-border">
                    <h3 class="card-title"> Project Gallery Add & View</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST"
                    action="{{ route('project.gallary.add', ['project' => $project->id]) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">Description </label>

                            <div class="col-sm-10">
                                <textarea name="description" class="form-control" id="description" cols="10"
                                    rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('images') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label">Images </label>

                            <div class="col-sm-10">

                                <input type="file" name="images[]" multiple id="images" class="form-control">
                                    <p>You can choose multiple images.</p>
                                @error('images')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add Images</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="row">

        @foreach ($projectImages as $projectImage)

        <div class="col-lg-4 col-md-12 mb-4 mb-lg-1">
            <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light">
                <img src="{{ asset($projectImage->image) }}" class="w-100 mb-2 mb-md-2 shadow-1-strong rounded" />

                <p>{{$projectImage->description}}</p>
            </div>
            <a class="text-center btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Image?')" href="{{route('project.gallary.delete',['gallery'=>$projectImage->id])}}">delete</a>

        </div>
        @endforeach


    </div>


@endsection

@section('script')
    <script>


    </script>
@endsection
