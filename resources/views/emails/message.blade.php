@extends('layouts.email',['title'=>'Message'])

@section('content')
<table width="100%" cellpadding="0" cellspacing="0">
	@foreach ($fields as $key => $value)
	<tr>
	    <td class="content-block">
	    	{!!$value['label']!!}
	    </td>
	    <td class="content-block">
	    	{!!$value['value']!!}
	    </td>
	</tr>
	@endforeach	
</table>
@stop
