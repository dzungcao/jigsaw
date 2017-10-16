@extends('layouts.iframe')

@section('metadata')
<meta content="Play jigsaw puzzles online for free" name="description" />
@if(!$game->custom_game)
<meta content="JigsawPuzzle1" name="author" />
@else
<meta content="{{$game->author->name}}" name="author" />
@endif
@stop

@section('extraheads')
<meta property="og:url"           content="{{env('APP_URL').'/play/'.$game->game_id}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="Jigsaw Puzzles Online" />
<meta property="og:description"   content="Can you complete this picture within {{$game->time/60}} minutes ?" />
<meta property="og:image"         content="{{env('APP_URL').'/'.$game->original_picture}}" />
<meta property="csrf_token"       content="{{csrf_token()}}" />

<style type="text/css">
	
</style>
@stop
@section('content')

<div class="col-md-12">
	<input type="hidden" id="game_id" value="{{$game->game_id}}">
	<input type="hidden" id="game_time" value="{{$game->time}}">
	<div class="game-nav">
		<img src="/img/clock.png"/> <label id="game-time">{{intval($game->time/60)}}m{{$game->time%60}}s</label>
		<button id="btn-help" class="btn btn-xs btn-success pull-right">HELP</button>
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
		<button class="btn btn-lg btn-primary" id="start-btn">LOADING...</button>
		<div id="game-complete">
			<h2 id="congrat">Congratulations</h2>
			<h2 id="final-time">Time : 00</h2>
			@if(\Auth::check())
			<p class="final-message">This time and score will be stored into your personal page</p>
			@else
			<p class="final-message">This time and score will NOT be stored into your personal page, you must login to make them appear in your list</p>
			@endif
			<button id="share-btn" class="btn btn-primary">Share this</button>
			<button class="close-btn btn btn-white btn-block" style="text-decoration:underline;margin-top:8px">Close</button>
		</div>
		<div id="game-over">
			<h2 id="congrat">You did not complete the picture</h2>
			<a href="/play/{{$game->game_id}}" id="share-btn" class="btn btn-primary">Play again</a>
			<button class="close-btn btn btn-white btn-block" style="text-decoration:underline;margin-top:8px">Close</button>
		</div>
	</div>
	<div class="showonloaded">
	<br/>
	<p class="alert alert-warning"><strong>How to play:</strong> Drag and drop pieces into their correct positions</p>
	<a href="http://{{env('APP_DOMAIN')}}" target="_blank" class="btn btn-xs btn-success btn-outline">Click here to play more</a>
	</div>

	@foreach($game->getPieces() as $p)
	<img class="piece" style="display:none" src="{{$p['path']}}" id="{{$p['row'].$p['col']}}">
	@endforeach
</div>
@stop

@section('extrascripts')
<script type="text/javascript" src="/js/fabric.min.js"></script>
<script type="text/javascript" src="/js/jquery.waitforimages.min.js"></script>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '263099647415657',
      xfbml      : true,
      version    : 'v2.7'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
@if(env('APP_ENV') == 'production')
<script type="text/javascript" src="/js/all.js?v=4"></script>
@else
<script type="text/javascript" src="/js/game.js"></script>
@endif
@stop