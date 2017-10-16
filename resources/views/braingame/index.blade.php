@extends('layouts.public')

@section('extraheads')
<title>Brain Games | Jigsaw Puzzle Online</title>
@stop

@section('extraheads')
<link rel="stylesheet" type="text/css" href="/css/dropzone.css">
<style type="text/css">	
</style>
@stop
@section('content')
	<div class="container">
		<div class="row">
			
			@foreach($flashgames as $flashgame)
			<div class="col-md-4">
				<a href="/brain-game/{{$flashgame->id}}-{{$flashgame->titlize()}}">{{$flashgame->title}}</a>
			</div>
			@endforeach
		</div>
	</div>
@stop