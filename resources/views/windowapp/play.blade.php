@extends('layouts.windowapp')


@section('extraheads')
<meta property="user_id"       content="0" />
<style type="text/css">
	body{
		background-color: #ccc;
	}
</style>
@stop
@section('content')
<div class="col-md-12" name="gamecontainer">
	<input type="hidden" id="game_id" value="{{$game->game_id}}">
	<input type="hidden" id="game_time" value="{{$game->time}}">
	<div class="showonloaded">
		<p class="alert alert-warning">{!!trans('play.how_to_play')!!}</p>
	</div>
	<div class="showonloaded" id="section-bottom">
		<a id="btn-playagain" href="/windowapp/play/{{$game->game_id}}" class="btn btn-xs btn-success btn-outline">{{trans('play.play_again')}}</a>
	</div>
	<div class="game-nav">
		<img src="/img/clock.png"/> <label id="game-time">{{intval($game->time/60)}}m{{$game->time%60}}s</label>
		<button id="btn-help" class="btn btn-xs btn-success pull-right">{{trans('play.help')}}</button>
	</div>
	<div id="game-share">
		<div class="progress">
		  <div id="game-progress" class="progress-bar" role="progressbar" aria-valuenow="0"
		  aria-valuemin="0" aria-valuemax="36" style="width:0%">
		  </div>
		</div>
	</div>
	<div class="game-section">
		<canvas id="canvas"></canvas>
		<div id="game-cover">
			<img src="/{{$game->original_picture}}" class="img-responsive">
		</div>
		<button class="btn btn-lg btn-primary" id="start-btn">{{trans('play.loading')}}</button>
		<div id="game-complete">
			<br/>
			<img src="/images/youwin.png" style="margin:auto;display:block"/>
			<h2 id="congrat">{{trans('play.congrats')}}</h2>
			<h2 id="final-time">Time : 00</h2>
			
			<p class="final-message">Please play on website at http://{{env('APP_DOMAIN')}} to store your score and time</p>
			
			<button class="close-btn btn btn-white btn-block" style="text-decoration:underline;margin-top:8px">Close</button>
		</div>
		<div id="game-over">
			<br/>
			<img src="/images/timeover.png" style="margin:auto;display:block"/>
			<h2 id="congrat">You did not complete the picture</h2>
			<a href="/windowapp/play/{{$game->game_id}}" id="share-btn" class="btn btn-primary">Play again</a>
			<button class="close-btn btn btn-white btn-block" style="text-decoration:underline;margin-top:8px">Close</button>
		</div>
		
	</div>
	
	@foreach($game->getPieces() as $p)
	<img class="piece" style="display:none" src="{{$p['path']}}" id="{{$p['row'].$p['col']}}">
	@endforeach
</div>
<div class="col-md-12">
<h2>Other puzzles</h2>
<div class="row">
	@foreach($games as $game)
	<div class="col-sm-6 col-md-4 col-lg-3 game-box-outer">
		<a href="/windowapp/play/{{$game->game_id}}">
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
</div>
@stop

@section('extrascripts')
<script type="text/javascript" src="/js/fabric.min.js"></script>
<script type="text/javascript" src="/js/jquery.waitforimages.min.js"></script>
@if(env('APP_ENV') == 'production')
<script type="text/javascript" src="/js/all.js?v=4"></script>
@else
<script type="text/javascript" src="/js/game.js"></script>
@endif

<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('img.lazy').lazyload();
	})
</script>

@stop