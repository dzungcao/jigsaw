@extends('layouts.public')

@section('metadata')
<title>{{ucfirst($category->title)}} | Jigsaw Puzzle Online</title>
@stop
@section('extraheads')
<style type="text/css">
	.side-category{
		background: #efffef;
	    border: 1px dashed #ccc;
	    border-radius: 4px;
	    padding: 12px 0;
	}
	.side-category ul{
		list-style-type: none;
		padding: 0;
	}
	.side-category ul li{
		display: inline;
		margin-left: 12px;
	}
	.side-category ul li a{
		font-weight: bolder;
	}
</style>
@stop
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row side-category">
				<div class="col-md-12">
				<h4>Other topics:</h4>
				</div>
				<ul>
				@foreach($categories as $category)
					<li>
						<a class="" style="text-decoration:underline" href="/category/{{$category->id}}-{{$category->titlize()}}">{{$category->title}}</a>
					</li>
				@endforeach
				</ul>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row">
				<h3>{{$category->title}}</h3>
				@foreach($games as $game)
				<div class="col-sm-6 col-md-4 game-box-outer">
					<a href="/play/{{$game->game_id}}">
						<div class="game-box">
							<img data-original="/{{$game->original_picture}}" class="lazy img-responsive">
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
					{!!$games->links()!!}
				</div>
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