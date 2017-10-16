@extends('layouts.public')

@section('extraheads')
<script src="/css/dropzone.css"></script>
@stop

@section('content')
<div class="col-md-12">
    <table class="table">
        <tr class="active">
            <th>Title</th>
            <th>Created at</th>
            <th></th>
        </tr>
        @foreach($collections as $collection)
        <tr>
            <td>{{$collection->title}}</td>
            <td>{{$collection->created_at}}</td>
            <td></td>
        </tr>
        @endforeach
    </table>
    
</div>
@stop

@section('extrascripts')
<script src="/js/dropzone.js"></script>
@stop