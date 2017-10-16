@extends('layouts.public')

@section('metadata')
<meta content="{{$user->name}}'s achivement" name="description" />
<meta content="{{$user->name}}" name="author" />
@stop

@section('extraheads')
<meta property="og:url"           content="{{env('APP_URL').'/share/'.$game->game_id.'/'.$user->id}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$user->name}} took {{$game->time-$gameScore->time}} seconds to complete the picture" />
<meta property="og:description"   content="Can you complete this picture within {{$game->time/60}} minutes ?" />
<meta property="og:image"         content="{{env('APP_URL').'/'.$game->original_picture}}" />
<style type="text/css">
	body{
		background-color: #ccc;
	}
</style>
@stop
@section('content')
<div class="col-md-6">	
	<h1>Player: {{$user->name}}</h1>
	<h2>Achivement: {{$game->time-$gameScore->time}} seconds</h2>
	<br/>
	<a href="/play/{{$game->game_id}}" class="btn btn-primary">PLAY THIS PUZZLE</a>
	<br/>
	<br/>
	<img src="/{{$game->original_picture}}" class="img-responsive">

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
@stop