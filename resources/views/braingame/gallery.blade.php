
<style type="text/css">
	.libpic{
		padding: 8px;
	}
</style>

<div class="row">
	@foreach($photos as $photo)
	<div class="col-sm-4">
		<div class="panel libpic">
			<div class="panel-body">
				<img src="/background/{{$photo->getFileName()}}" class="img-responsive">
				<button class="btn btn-sm btn-primary picture-select" data-url="{{$photo->getFileName()}}">Select</button>
			</div>
		</div>
	</div>
	@endforeach
	</div>
</div>

