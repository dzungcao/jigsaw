@extends('layouts.public')

@section('content')
<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		<div class="ibox">
			<div class="ibox-title">
			  	<h3>{{$challenge->title}}</h3>
			  	<div class="ibox-tools">
			  		<form style="display:inline" method="POST" action="/invite/accept/{{$challenge->id}}">
					{!! csrf_field() !!}
					<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Accept</button>
					</form>
					<form style="display:inline" method="POST" action="/invite/reject/{{$challenge->id}}">
					{!! csrf_field() !!}
					<button type="submit" class="btn btn-primary">Reject</button>
					</form>
			  </div>
			</div>
			<div class="ibox-content">
				<form class="form-horizontal" role="form" method="POST" action="{{ url('/challenge') }}">
					{!! csrf_field() !!}
					<div class="form-group">
						<label class="col-md-4">Start date: <strong>{{date('Y-m-d',strtotime($challenge->start_date))}}</strong></label>
						<label class="col-md-4">Due date: <strong>{{date('Y-m-d',strtotime($challenge->end_date))}}</strong></label>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<div class="readonly-summernote">
								{!! $challenge->content !!}
							</div>
						</div>
					</div>

					@if(!$challenge->attachments->isEmpty())
					<div class="form-group">
						<div class="col-md-12">
							<h2>Attachments</h2>
							<ul class="downloads">
								@foreach($challenge->attachments as $attachment)
								<li>
									<a href="/attachment/{{$attachment->attachment->id}}/{{$attachment->attachment->file_name}}">{{$attachment->attachment->file_name}}</a>
								</li>
								@endforeach
							</ul>
						</div>
					</div>
					@endif
				</form>
			</div>
		</div>
	</div>
</div>
@stop
