@extends('layouts.public')

@section('extraheads')
<title>Brain Games | Admin</title>
@stop

@section('extraheads')
<link rel="stylesheet" type="text/css" href="/css/dropzone.css">
<style type="text/css">	
</style>
@stop
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<a class="btn btn-white" href="create">New flash game</a>
				<a class="btn btn-white" href="flash">Manage flash file</a>
			</div>
			@foreach($flashgames as $flashgame)
			<div class="col-md-4">
				<form action="/brain-game/update/{{$flashgame->id}}" method="POST" onsubmit="return updateGame(this)">
					{!!csrf_field()!!}
					<label>Created at {{$flashgame->created_at}}</label>
					<input class="form-control" name="title" value="{{$flashgame->title}}" placeholder="Title"></input>
					</select>
					@if($flashgame->active)
					<input name="active" checked type="checkbox"></input> <label>Active</label>
					@else
					<input name="active" type="checkbox"></input> <label>Active</label>
					@endif
					<button class="btn btn-sm btn-success btn-block btn-update">Update</button>
					<a class="btn btn-block btn-white" href="/brain-game/play/{{$flashgame->id}}">Play</a>
				</form>
			</div>
			@endforeach
		</div>
	</div>
	<script type="text/javascript">
		function updateGame(form){
			$(form).find('button.btn-update').attr('disabled',true);
			$(form).find('button.btn-update').text('Updating');
			$.ajax({
				url : form.action,
				type: 'POST',
				data: $(form).serialize(),
				success:function(response){
					$(form).find('button.btn-update').attr('disabled',false);
					$(form).find('button.btn-update').text('Update');
				}
			})
			return false;
		}
	</script>
@stop