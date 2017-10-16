@extends('layouts.public')

@section('metadata')

<title>{{$user->name}}' achievements | Jigsaw Puzzle Online</title>

<meta content="{{$user->name}}' achievements | Jigsaw Puzzles Online" name="description" />
<meta content="{{$user->name}}" name="author" />

<meta property="og:url"           content="{{env('APP_URL').'/player/'.$user->username}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$user->name}}' achievements | Jigsaw Puzzles Online" />
<meta property="og:description"   content="{{$user->name}}, score {{$user->score}} with {{$user->time/60}}+ minutes remaining" />
@stop
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Name: {{$user->name}}</h1>
				<h1>Score: {{$user->score}}</h1>
				<h1>Time remaining: {{$user->time}} seconds</h1>

				<button id="share-btn" class="btn btn-primary">Share this</button>
				<br/>
				<br/>
				<!-- Your like button code -->
				<div class="fb-like" data-href="http://{{env('APP_DOMAIN')}}/player/{{$user->username}}" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
			<h2>Completed pictures</h2>
			</div>
			@foreach($games as $g)
			{{--*/$game = $g->game()/*--}}
			@if($game)
			<div class="col-sm-6 col-md-4 col-lg-3 game-box-outer" style="margin-bottom: 8px;">
				<a href="/play/{{$game->game_id}}">
					<div class="game-box">
						<img data-original="/{{$game->original_picture}}" class="lazy img-responsive">
						@if($game->title)
						<div class="pic-title">
							{{$game->title}}
						</div>
						@endif
					</div>
					<div style="padding:4px;">
						<label class="pull-left" style="font-weight: bold">SCORE {{$g->score}}</label>
						<label class="pull-right" style="font-weight: bold">REMAINING {{$g->time}} s</label>
					</div>
					<br/>
				</a>
			</div>
			@endif
			@endforeach
		</div>
	</div>
@stop

@section('extrascripts')
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
<script type="text/javascript" src="/js/jquery.lazyload.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('img.lazy').lazyload();
		$('#share-btn').click(function(){
			FB.ui({
			    method: 'share',
			    display: 'popup',
			    href: $('meta[property="og:url"]').attr('content'),
			  }, function(response){});
		})
	})
</script>
@stop