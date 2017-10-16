@extends('layouts.public')


@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<table class="table">
				<tr class="active">
					<th>Username</th>
					<th>Name</th>
					<th>Email</th>
					<th>Facebook</th>
					<th>Admin</th>
					<th>Manager</th>
					<th>Approver</th>
					<th>Editor</th>
					<th>User</th>
					<th>Created at</th>
					<th></th>
					<th></th>
				</tr>
				@foreach($users as $user)
				<tr>
					<td><a href="/player/{{$user->username}}">{{$user->username}}</a></td>
					<td>{{$user->name}}</td>
					<td>{{$user->email}}</td>
					<td>{{$user->fb_id}}</td>
					<td>{{$user->admin}}</td>
					<td>{{$user->manager}}</td>
					<td>{{$user->approver}}</td>
					<td>{{$user->editor}}</td>
					<td>{{$user->user}}</td>
					<td>{{$user->created_at}}</td>
					<td><a href="/user/edit/{{$user->id}}" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a></td>
					<td><a href="/user/view/{{$user->id}}" class="btn btn-xs btn-info"><span class="fa fa-arrow-right"></span> View</a></td>
				</tr>
				@endforeach
				</table>
			</div>
		</div>
	</div>
@stop

@section('extrascripts')

@stop