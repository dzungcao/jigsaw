@extends('layouts.public')

@section('metadata')
<title>Jigsaw Puzzle Online</title>
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

@if(\Auth::check())
<meta property="user_id"       content="{{\Auth::user()->id}}" />
@else
<meta property="user_id"       content="0" />
@endif

<style type="text/css">
	body{
		background-color: #ccc;
	}
</style>
@stop
@section('content')
@if(!\Auth::check())
<div class="col-md-12">
<p class="alert alert-warning myalert">{!!trans('play.login_notice')!!}</p>
</div>
@endif
<div class="col-md-12" name="gamecontainer">
	<input type="hidden" id="game_id" value="{{$game->game_id}}">
	<input type="hidden" id="game_time" value="{{$game->time}}">
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
			@if(\Auth::check())
			<p class="final-message">This time and score will be stored into your personal page</p>
			@else
			<p class="final-message">This time and score will NOT be stored into your personal page, you must login to make them appear in your list</p>
			@endif
			<button id="share-btn" class="btn btn-primary">Share this</button>
			<button class="close-btn btn btn-white btn-block" style="text-decoration:underline;margin-top:8px">Close</button>
		</div>
		<div id="game-over">
			<br/>
			<img src="/images/timeover.png" style="margin:auto;display:block"/>
			<h2 id="congrat">You did not complete the picture</h2>
			<a href="/play/{{$game->game_id}}" id="share-btn" class="btn btn-primary">Play again</a>
			<button class="close-btn btn btn-white btn-block" style="text-decoration:underline;margin-top:8px">Close</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-7">
			<div class="showonloaded" id="section-bottom">
				<br/>
				<p class="alert alert-warning">{!!trans('play.how_to_play')!!}</p>
				<a id="btn-playagain" href="" class="btn btn-xs btn-success btn-outline">{{trans('play.play_again')}}</a>
				<br/>
				<!-- Your like button code -->
				<div class="fb-like" data-href="http://{{env('APP_DOMAIN')}}/play/{{$game->game_id}}" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>

				<label>{{trans('play.embeded_link')}}</label>
				<textarea rows="3" readonly class="form-control iframe-link"><iframe src="http://{{env('APP_DOMAIN')}}/iframe/{{$game->game_id}}" style="width: 100%;min-height:800px;"></iframe></textarea>

				<br/>
				<div class="fb-comments" data-href="http://{{env('APP_DOMAIN')}}/play/{{$game->game_id}}" data-numposts="5" style="background-color:#fff;width:100% !important"></div>
			</div>
		</div>
		@if($category)
		<div class="col-md-5">
			<h3>Similar pictures in this category</h3>
			<div class="row">
				@foreach($category->games->take(6) as $gm)
					@if($gm->id != $game->id)
					<div class="col-sm-6 col-md-4 game-box-outer">
						<a href="/play/{{$gm->game_id}}">
							<div class="game-box">
								<img data-original="/{{$gm->original_picture}}" class="lazy img-responsive">
								@if($gm->title)
								<div class="pic-title">
									{{$gm->title}}
								</div>
								@endif
							</div>
						</a>
					</div>
					@endif
				@endforeach	
			</div>
		</div>
		@endif
	</div>
	@foreach($game->getPieces() as $p)
	<img class="piece" style="display:none" src="{{$p['path']}}" id="{{$p['row'].$p['col']}}">
	@endforeach
</div>
@stop

@section('extrascripts')
<script type="text/javascript" src="/js/fabric.min.js"></script>
<script type="text/javascript" src="/js/jquery.waitforimages.min.js"></script>
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
<script>
	$(function(){
		$('img.lazy').lazyload();
	})
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
<script type="text/javascript" src="/js/game-dev.js"></script>
@endif
@stop