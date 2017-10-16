@extends('layouts.public')

@section('content')
<form method="POST" enctype="multipart/form-data">
	{!!csrf_field()!!}
	<label>Import your picture</label>
	<input type="file" name="picture"></input>
	<button type="submit" class="btn btn-primary">Upload</button>
</form>
<div>
	@if(count($pictures) > 0)
		<h2>Recent uploads</h2>
		<div class="row">
		@foreach($pictures as $pic)
		<div class="col-sm-2 col-md-4 col-lg-3">
		<img src="/piclib/{{$pic->path}}" class="img-responsive">
		<div class="row">
			<div class="col-md-6">
				<form method="POST" action="/makegame">
		            <input type="hidden" name="picture_id" value="{{$pic->id}}">
		            {!!csrf_field()!!}
		            <button type="submit" class="btn btn-sm btn-primary btn-block">Make Game</button>
		        </form>
			</div>
			<div class="col-md-6">
				<form method="POST" action="/deletepic/{{$pic->id}}" method="POST">
		            {!!csrf_field()!!}
		            <button type="submit" class="btn btn-sm btn-danger btn-block">Delete</button>
		        </form>
			</div>
		</div>
		</div>
		@endforeach
		</div>
	@else
		<h2>There is no pictures in your list</h2>
	@endif

	@if(count($games) > 0)
		<h2>Game created by you</h2>
		<div class="row">
		@foreach($games as $game)
		<div class="col-sm-6 col-md-4 col-lg-3 game-box-outer">
			<a href="/play/{{$game->game_id}}">
				<div class="game-box">
					<img src="/{{$game->original_picture}}" class="img-responsive">
				</div>
			</a>
		</div>
		@endforeach
		</div>
	@else
		<h2>There is no game in your list</h2>
	@endif

</div>
@stop