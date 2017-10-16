@extends('layouts.public')

@section('extraheads')

@stop
@section('content')
	<div class="container">
		<h2>New pictures</h2>
		<div class="row">
			@foreach($games as $game)
			<div class="col-sm-6 col-md-4 col-lg-3 game-box-outer">
				<a href="/play/{{$game->game_id}}">
					<div class="game-box">
						<img data-original="{{$game->original_picture}}" class="lazy img-responsive">
						@if($game->title)
						<div class="pic-title">
							{{$game->title}}
						</div>
						@endif
					</div>
				</a>
			</div>
			@endforeach
		</div>
		<div class="row">
			<div class="col-md-12">
			{{ $games->links() }}
			</div>
		</div>
	</div>
@stop

@section('extrascripts')
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('img.lazy').lazyload();
	})
</script>
@stop