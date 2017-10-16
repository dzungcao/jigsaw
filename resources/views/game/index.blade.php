@extends('layouts.public')

@section('extraheads')
<title>Game Admin | Administration</title>
@stop
@section('extraheads')
<link rel="stylesheet" type="text/css" href="/css/dropzone.css">
<style type="text/css">
	
</style>
@stop
@section('content')
	<div class="container">
		@foreach(App\Models\Category::all() as $cate)
		<a class="btn btn-primary" href="?cat_id={{$cate->id}}">{{$cate->title}}</a>
		@endforeach
		<div class="row">			
			@foreach($games as $game)
			<div class="col-md-3" style="margin-bottom:32px">
				<img src="/{{$game->original_picture}}" class="img-responsive">
				<form action="/game/update/{{$game->id}}" method="POST" onsubmit="return updateGame(this)">
				{!!csrf_field()!!}
				<label>Created at {{$game->created_at}}</label>
				<input class="form-control" name="time" value="{{$game->time}}" placeholder="Time in seconds"></input>
				<input class="form-control" name="title" value="{{$game->title}}" placeholder="Title"></input>
				<textarea class="form-control" name="description" placeholder="Description">{{$game->description}}</textarea>
				<select class="form-control" name="category_id">
				@foreach(App\Models\Category::all() as $cate)
				@if($cate->id == $game->category_id)
				<option value="{{$cate->id}}" selected>{{$cate->title}}</option>
				@else
				<option value="{{$cate->id}}">{{$cate->title}}</option>
				@endif
				@endforeach
				</select>
				<button class="btn btn-sm btn-success btn-block btn-update">Update</button>
				<a class="btn btn-block btn-white" href="/play/{{$game->game_id}}">Play</a>
				</form>
				<form action="/game/delete/{{$game->id}}" method="POST">
					{!!csrf_field()!!}
					<button class="btn btn-sm btn-danger btn-block">Delete</button>
				</form>
			</div>
			@endforeach
		</div>
		<div class="row">
		<div class="col-md-12">
			{!!$games->links()!!}
		</div>
		</div>
	</div>

	<script type="text/javascript">
		function updateGame(form){
			$(form).find('button.btn-update').attr('disabled',true);
			$(form).find('button.btn-update').text('Updating');
			$.ajax({
				url : form.action,
				type: 'POST',
				data: $(form).serialize(),
				success:function(response){
					$(form).find('button.btn-update').attr('disabled',false);
					$(form).find('button.btn-update').text('Update');
				}
			})
			return false;
		}
	</script>
@stop