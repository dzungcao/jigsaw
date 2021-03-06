@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">View</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="col-md-2 control-label">Title</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="title" value="{{ $category->title }}">
                                @if ($errors->has('title'))
                                    <strong>{{ $errors->first('title') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Order</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="order" value="{{ $category->order }}">
                                @if ($errors->has('order'))
                                    <strong>{{ $errors->first('order') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Active</label>
                            <div class="col-md-8">
                                @if($category->active)
                                <input type="checkbox" name="active" checked>
                                @else
                                <input type="checkbox" name="active">
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
