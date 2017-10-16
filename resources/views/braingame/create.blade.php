@extends('layouts.public')

@section('extraheads')
<title>Brain Games | Admin</title>
@stop

@section('extraheads')
<link rel="stylesheet" type="text/css" href="/css/dropzone.css">
<style type="text/css">	
</style>
@stop
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
	            <div class="panel panel-default">
	                <div class="panel-heading">Create brain game</div>
	                <div class="panel-body">
	                    <form class="form-horizontal" role="form" method="POST">
	                        {!! csrf_field() !!}
	                        <div class="form-group">
	                            <label class="col-md-2 control-label">Title</label>
	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
	                                @if ($errors->has('title'))
	                                    <strong>{{ $errors->first('title') }}</strong>
	                                @endif
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-md-2 control-label">Link</label>
	                            <div class="col-md-8">
	                                <input type="text" class="form-control" name="link" value="{{ old('link') }}">
	                                @if ($errors->has('link'))
	                                    <strong>{{ $errors->first('link') }}</strong>
	                                @endif
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-md-2 control-label">Active</label>
	                            <div class="col-md-8">
	                                <input type="checkbox" name="active" checked>
	                            </div>
	                        </div>
	                        
	                        <div class="form-group">
	                            <div class="col-md-8 col-md-offset-2">
	                                <button type="submit" class="btn btn-primary">
	                                    <i class="fa fa-btn fa-sign-in"></i>Create
	                                </button>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
@stop