@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit user</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <h3>{{$user->name}}</h3>
                                <span>{{$user->email}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label>Admin</label>
                                @if($user->admin)
                                <input type="checkbox" name="admin" checked>
                                @else
                                <input type="checkbox" name="admin">
                                @endif
                            </div>
                            <div class="col-sm-2">
                                <label>Manager</label>
                                @if($user->manager)
                                <input type="checkbox" name="manager" checked>
                                @else
                                <input type="checkbox" name="manager">
                                @endif
                            </div>
                            <div class="col-sm-2">
                                <label>User</label>
                                @if($user->user)
                                <input type="checkbox" name="user" checked>
                                @else
                                <input type="checkbox" name="user">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a class="btn btn-default" href="/user">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
