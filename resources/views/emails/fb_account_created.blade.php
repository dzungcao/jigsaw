@extends('layouts.email',['title'=>'Email address confirmation'])

@section('content')
<table width="100%" cellpadding="0" cellspacing="0">
	
	<tr>
	    <td class="content-block">
Hi, {{$name}}
	    </td>	    
	</tr>
	<tr>
		<td class="content-block">
			<a href="http://contactformaz.com/confirm/{{$token}}" class="btn-primary">Confirm email address</a>
		</td>
	</tr>
	<tr>
	    <td class="content-block">
We may need to send you critical information about our service and it is important that we have an accurate email address.
	    </td>	    
	</tr>
	<tr>
		<td class="content-block">
			&mdash; ContactFormAZ Team
		</td>
	</tr>
</table>
@stop
