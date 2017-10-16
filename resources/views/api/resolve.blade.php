@extends('layouts.public',['fluid_container'=>true])

@section('content')
<div class="row">
	<div class="col-md-6" id="submission-area">
		<div class="ibox">
			<div class="ibox-title">
				<h3>Challenge submission</h3>
				<div class="ibox-tools">
					<button onclick="submitform()" class="btn btn-primary">
					<i class="fa fa-edit"></i> Submit</button>
				</div>
			</div>
			<div class="ibox-content">
				<form id="submission-form" class="form-horizontal" role="form" method="POST" action="{{ url('/submission') }}" enctype="multipart/form-data">
					{!! csrf_field() !!}
					<input type="hidden" name="challenge_id" value="{{$challenge->id}}"></input>
					<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
						<label class="control-label">Content</label>

						<div class="col-md-12">
							<div id="summernote" class="summernote" name="content">
								{!! $challenge->lastSavedContent() !!}
							</div>
							<textarea name="content" class="hidden"></textarea>
							@if ($errors->has('content'))
								<span class="help-block">
									<strong>{{ $errors->first('content') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
						<label class="col-md-2 control-label">Attachment</label>
						<div class="col-md-10">
							<input type="file" name="file[]" multiple="true">
							 @if ($errors->has('file'))
								<span class="help-block">
									<strong>{{ $errors->first('file') }}</strong>
								</span>
							@endif
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6" id="challenge-area">
		<div class="ibox">
			<div class="ibox-title">
				<h3>{{$challenge->title}}</h3>
				<div class="ibox-tools">
					<a id="btn-hide" data-arr="66->" class="btn btn-default btn-outline">Hide <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
			<div class="ibox-content">
				
				<form class="form-horizontal" role="form">
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

@section('extrastyles')
<link href="/css/plugins/summernote/summernote.css" rel="stylesheet">
<link href="/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
<style type="text/css">
	.note-editor{
		border: 1px solid #eee;
	}
</style>
@stop

@section('extrascripts')
<!-- SUMMERNOTE -->
<script src="/js/plugins/summernote/summernote.min.js"></script>
<script>
	$(document).ready(function(){
		$('.summernote').summernote({
			focus:true,
		});

		$('.note-editable').on("blur", function(){
			$('textarea[name="content"]').html($('.summernote').code());
		});

		$('#btn-hide').click(function(){
			if($(this).data('arr') == '66->'){
				$(this).data('arr','75->');
				$("#challenge-area").attr('class','col-md-5');
				$("#submission-area").attr('class','col-md-7');
			}
			else if($(this).data('arr') == '75->'){
				$(this).data('arr','84-<');
				$(this).html('<i class="fa fa-arrow-left"></i> Expand');
				$("#challenge-area").attr('class','col-md-4');
				$("#submission-area").attr('class','col-md-8');
			}
			else if($(this).data('arr') == '84-<'){
				$(this).data('arr','75-<');
				$("#challenge-area").attr('class','col-md-5');
				$("#submission-area").attr('class','col-md-7');
			}
			else if($(this).data('arr') == '75-<'){
				$(this).data('arr','66->');
				$(this).html('Hide <i class="fa fa-arrow-right"></i>');
				$("#challenge-area").attr('class','col-md-6');
				$("#submission-area").attr('class','col-md-6');
			}
		});

		//save draft content every 3 seconds
		setInterval(function(){
			$.ajax({
				url : '/resolve/draft',
				type : 'POST',
				data : $('#submission-form').serialize(),
				success: function(data){
					if(data.success){
						console.log('Draft saved...');
					}
				}
			})
		},3000);

	});
	function submitform(){
		$.ajax({
			url : '/submission',
			type : 'POST',
			data : $('#submission-form').serialize(),
			success: function(data){
				if(data.success){
					console.log('You have submitted your solution');
				}
			}
		})
		return false;
	}

</script>
@stop