@extends('layouts.public')

@section('content')
<div class="row">
	@if($challenge->submissions->isEmpty())
	<div class="col-lg-12">
		<div class="ibox-content">
			<h2 class="text-center">There is no submission for this challenge</h2>
		</div>
	</div>
	@else
	<div class="col-lg-12">
		<div class="fh-breadcrumb">
			<div class="visible-xs">
				<select class="form-control">
					@foreach($challenge->submissions as $submission)
					<option value="{{$submission->id}}">{{$submission->user->name}}</option>
					@endforeach
				</select>
			</div>
            <div class="fh-column hidden-xs">
                <div class="full-height-scroll">
                    <ul class="list-group elements-list">
                    	@foreach($challenge->submissions as $submission)
                        <li class="list-group-item">
                            <a data-id="{{$submission->id}}" data-toggle="tab" onclick="loadSubmissionContent(this)">
                                <small class="pull-right text-muted"> {{$submission->created_at}}</small>
                                <strong>{{$submission->user->name}}</strong>
                                <div class="small m-t-xs">
                                    <p>
                                        Survived not only five centuries, but also the leap scrambled it to make.
                                    </p>
                                    <p class="m-b-none">
                                        <i class="fa fa-map-marker"></i> Riviera State 32/106
                                    </p>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
			<div class="full-height">
				<div class="full-height-scroll white-bg border-left">
					<div class="element-detail-box">
						<div class="ibox" id="submission-content">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
</div>
@stop

@section('extrascripts')
<script type="text/javascript">

	function loadSubmissionContent(obj){
		var id = $(obj).data('id');
		$.ajax({
			url : '/result/submission/'+id,
			type : 'GET',
			success: function(data){
				$('#submission-content').html(data)
			}
		})
	}
</script>
@stop