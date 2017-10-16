@extends('layouts.public')

@section('extraheads')
<script src="/css/dropzone.css"></script>
@stop

@section('content')
<div class="col-md-12">
    <div id="dropzone">
        <form action="/picture/create" class="dropzone needsclick dz-clickable" id="file-upload">
            {!! csrf_field() !!}
          <div class="dz-message needsclick">
            Kéo file hoặc click vào đây để upload file.<br>
          </div>
        </form>
    </div>
</div>

<div class="col-md-12 ui-sortable">
    <!-- begin panel -->
    <table class="table">
        <tr class="active">
            <th>Title</th>
            <th>Created at</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($pictures as $picture)
        <tr>
            <td><img src="/piclib/{{$picture->path}}" class="img-responsive" style="max-width:300px;height:auto"></td>
            <td>{{$picture->created_at}}</td>
            <td>
                <form method="POST" action="/game/create">
                    <input type="hidden" name="picture_id" value="{{$picture->id}}">
                    {!!csrf_field()!!}
                    <button type="submit" class="btn btn-sm btn-primary">Make Game</button>
                </form>
            </td>
            <td>
                <form method="POST" action="/picture/delete/{{$picture->id}}">
                    {!!csrf_field()!!}
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    
</div>
@stop

@section('extrascripts')
<script src="/js/dropzone.js"></script>
@stop