@extends('layouts.public')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<a href="/category/create">Create</a>
				<table class="table">
				<tr class="active">
					<th>Order</th>
					<th>Title</th>
					<th>Active</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				@foreach($categories as $category)
				<tr>
					<td>{{$category->order}}</td>
					<td>{{$category->title}}</td>
					<td>{{$category->active}}</td>
					<td><a href="/category/view/{{$category->id}}">View</a></td>
					<td><a href="/category/edit/{{$category->id}}">Edit</a></td>
					<td>
						<form action="/category/delete/{{$category->id}}" method="POST" onsubmit="return confirm('Are you sure?')">
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