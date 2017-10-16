@extends('layouts.public')

@section('extraheads')
<link rel="stylesheet" type="text/css" href="/css/dropzone.css">
<style type="text/css">
	.libpic{
		padding: 8px;
	}
</style>
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
		        <div id="dropzone">
		            <form action="/file" class="dropzone needsclick dz-clickable" id="file-upload">
		                {!! csrf_field() !!}
		                <input type="hidden" name="zone" value="blog">
		              <div class="dz-message needsclick">
		                Kéo file hoặc click vào đây để upload file.<br>
		              </div>
		            </form>
		        </div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<a href="/admin/blog/create">Create</a>
				<table class="table">
				<tr class="active">
					<th>Title</th>
					<th>Image</th>
					<th>Created at</th>
					<th>Created by</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				@foreach($blogs as $blog)
				<tr>
					<td>{{$blog->title}}</td>
					<td>{{$blog->image}}</td>
					<td>{{$blog->created_at}}</td>
					<td>{{$blog->user->name}}</td>
					<td>{{$blog->active}}</td>
					<td><a href="/admin/blog/{{$blog->id}}">View</a></td>
					<td><a href="/admin/blog/{{$blog->id}}/edit">Edit</a></td>
					<td>
						<form action="/admin/blog/{{$blog->id}}" method="POST" onsubmit="return confirm('Are you sure?')">
							{!!csrf_field()!!}
							<input type="hidden" name="_method" value="DELETE"></input>
							<button class="btn btn-sm btn-danger">Delete</button>
						</form>
					</td>
				</tr>
				@endforeach
				</table>
			</div>
		</div>
	</div>
@stop