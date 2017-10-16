@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Update account email</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/account/email">
                        {!! csrf_field() !!}
                        <div class="form-group">
                          <label class="control-label col-sm-2" for="email">Username</label>
                          <div class="col-sm-10">
                            @if($errors->has('username'))
                            <span class="error">{{$errors->first('username')}}</span>
                            @endif
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{old('username')}}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-2" for="email">Your email</label>
                          <div class="col-sm-10">
                            @if($errors->has('email'))
                            <span class="error">{{$errors->first('email')}}</span>
                            @endif
                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="{{old('email')}}">
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
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
