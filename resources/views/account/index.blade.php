@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Account setting</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST">
                        {!! csrf_field() !!}
                        <div class="form-group">
                          <label class="control-label col-sm-2" for="name">Name</label>
                          <div class="col-sm-10">
                            @if($errors->has('name'))
                            <span class="error">{{$errors->first('name')}}</span>
                            @endif
                            <input type="text" class="form-control" name="name" placeholder="Enter email" value="{{$user->name}}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-2" for="username">Username</label>
                          <div class="col-sm-10">
                            @if($errors->has('username'))
                            <span class="error">{{$errors->first('username')}}</span>
                            @endif
                            <input readonly type="text" class="form-control" name="username" id="username" placeholder="Enter email" value="{{$user->username}}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-2" for="email">Email</label>
                          <div class="col-sm-10">
                            @if($errors->has('email'))
                            <span class="error">{{$errors->first('email')}}</span>
                            @endif
                            <input readonly type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="{{$user->email}}">
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
