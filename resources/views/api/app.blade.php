<html>
<head>
	<link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<style type="text/css">
		body{
			overflow: hidden;
			background:  rgba(0, 0, 0, .6);
			height: 100%;
		}
		
		.contact-form{
			border:10px solid #464646;
			background-color: #fff;
			padding: 24px;
			@if($application->getBackground())
			background: url('/background/{{$application->getBackground()}}');
			background-size: cover;
			@endif
		}
		@if($application->getBackground())
		.contact-form label{
			color: #fff;
		}
		.contact-form input,.contact-form textarea{
			background-color: rgba(255,255,255,0.8);
		}
		@endif
		.contact-form .background{
			position: absolute;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			padding: 25px;
			opacity: 0.8;
			z-index: 1;
		}
		.vcontainer{
			display: table;
			height: 100%;
		}
		.vrow{
			display: table-cell;
			vertical-align: middle;
		}
		.close-iframe{
			position: absolute;
			right: 27px;
			top: 11px;
			padding: 8px 12px;
			outline: none;
			background-color: #464646;
			color: #fff;
			cursor: pointer;
			border:none;
			z-index: 9;
		}
		@if($application->label_color)
		.contact-form label{
			color: {{$application->label_color}};
		}
		h2,p{
			color: {{$application->label_color}};
		}
		hr{
			background-color: {{$application->label_color}};
		}
		@endif
		.field-error{
			border: 1px dashed red !important;
			background-color: #FFCDD2 !important;
		}
		.form-loading{
		    background-color: rgba(250,250,250,0.8);
		    position: absolute;
		    width: 100%;
		    height: 100%;
		    left: 0;
		    top: 0;
		    display: none;
		}
		.form-loading img{
			position: absolute;
		    left: 50%;
		    top: 50%;
		    transform: translate(-50%,-50%);
		}
		.form-result{
		    background-color: rgba(250,250,250,0.8);
		    position: absolute;
		    width: 100%;
		    height: 100%;
		    left: 0;
		    top: 0;
		    display: none;
		}
		.form-result span{
			position: absolute;
		    left: 50%;
		    top: 50%;
		    transform: translate(-50%,-50%);
		    font-weight: bold;
		    font-size: 18px;
		    text-align: center;
		}
	</style>
</head>
<body>
<div class="container vcontainer">
	<div class="row vrow">
		<div class="col-md-10 col-md-offset-1" style="padding-left:0;padding-right:0">
			<button class="close-iframe" onclick="return closeIFrame();">Close</button>

			<form class="contact-form form-horizontal" role="form" method="post" onsubmit="return submitbeeform(this)">
				{!!csrf_field()!!}
				<input type="hidden" name="app_id" value="{{$application->key}}">
				<div class="form-content-zone">
					@if($application->header)
					<h2>{{$application->header}}</h2>
					@endif
					@if($application->description)
					<p>{{$application->description}}</p>
					@endif
					@if($application->header || $application->description)
					<hr>
					@endif

					@foreach($application->fields as $field)
					<div class="form-group">
						<div class="col-md-2">
							<label for="fieldTitle">{{$field->label}}</label>
						</div>
						<div class="col-md-9">
							@if($field->field->type == 'single_line')
							<input name="field[{{$field->id}}][{{$field->field_id}}]" type="text" class="form-control validate">
							@elseif($field->field->type == 'multiple_line')
							<textarea name="field[{{$field->id}}][{{$field->field_id}}]" class="form-control validate"></textarea>
							@elseif($field->field->type == 'date')
							<input name="field[{{$field->id}}][{{$field->field_id}}]" type="text" class="form-control date-picker validate">
							@elseif($field->field->type == 'select')

							<input name="field[{{$field->id}}][{{$field->field_id}}]" type="text" class="form-control date-picker validate">
							@else
							<input name="field[{{$field->id}}][{{$field->field_id}}]" type="text" class="form-control validate">
							@endif
						</div>
					</div>
					@endforeach
					<div class="form-group">
						<div class="col-md-9 col-md-offset-2">
						<label class="error" style="display:none" id="captcha">Please verify this</label>
						{!! app('captcha')->display(); !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-9 col-md-offset-2">
							<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
						</div>
					</div>
				</div>
				<div class="form-loading">
					<img src="/img/loading.gif">
				</div>
				<div class="form-result"></div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	function submitbeeform(form){
		var validated = true;
		$('.validate').each(function(i,val){
			$(val).removeClass('field-error');
			if($(val).val().length == ""){
				$(val).addClass('field-error');
				validated = false;
			}
		})
		if(!validated) return false;

		$('.form-loading').show();
		$.ajax({
			type: "POST",
			data: $(form).serialize(),
			success:function(response){
				if(response.success){
					$('.form-result').html('<span>'+response.text+'</span>');
					$('.form-result').show();
				}
				else{
					$('#captcha').show();
				}
				$('.form-loading').hide();
			}
		})
		return false;
	}

	function closeIFrame(){
		parent.window.postMessage("removetheiframe", "*");
		return false;
	}
</script>
</body>
</html>