@extends('layouts.public',['fluidlayout'=>true])

@section('metadata')
<title>Welcome | Jigsaw Puzzle Online</title>
@stop

@section('extraheads')
<style type="text/css">
	.btn-more{
		margin-top: 20px;
    	margin-bottom: 10px;
	}
</style>
@stop
@section('content')
	<div class="container">
		@foreach($categories as $category)
		<div class="row">
			<div class="col-xs-6">
				<h2>{{$category->title}}</h2>
			</div>
			<div class="col-xs-6">
				<a class="btn btn-white btn-sm pull-right btn-more" href="/category/{{$category->id}}-{{$category->titlize()}}" class="text-decoration:underline">View more >></a>
			</div>
		</div>
		<div class="row">
			@foreach($category->getRecent(8) as $game)
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
		<hr>
		@endforeach
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