@extends('layouts.public')

@section('extraheads')
<script src="/js/ckeditor/ckeditor.js"></script>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">View</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/blog/'.$blog->id) }}" enctype="multipart/form-data">
                        {!! method_field('PUT') !!}
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-md-2 control-label">Title</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="title" value="{{ $blog->title }}">
                                @if ($errors->has('title'))
                                    <strong>{{ $errors->first('title') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Slug</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="slug" value="{{ $blog->slug }}">
                                @if ($errors->has('slug'))
                                    <strong>{{ $errors->first('slug') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Image</label>
                            <div class="col-md-8">
                                <div class = "input-group">
                                    <input readonly class="form-control" type="text" name="image" placeholder="Image" value="{{$blog->image}}"></input>
                                    <span class = "input-group-btn">
                                        <button class="picture-picker btn btn-default" type = "button" data-url="/gallery-blog">Image</button>
                                    </span>
                                </div><!-- /input-group -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Active</label>
                            <div class="col-md-8">
                                @if($blog->active)
                                <input type="checkbox" name="active" checked>
                                @else
                                <input type="checkbox" name="active">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Content</label>
                            <div class="col-md-8">
                                <textarea type="text" class="ckeditor form-control" name="content">{{ $blog->content }}</textarea>
                                @if($errors->has('content'))
                                    <strong>{{ $errors->first('content') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
