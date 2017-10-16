@extends('layouts.public')

@section('extraheads')
<style type="text/css">
    body{
        background-color: #ccc;
    }
    label.error{
        color: red;
    }
</style>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel beepanel beepanel-tab">
                <div class="panel-heading">
                    <h4>Setting</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-10 col-md-offset-1">
                        <form class="form-horizontal" role="form" method="post">
                            {!!csrf_field()!!}
                            @if(session('success'))
                            <div class="form-group">
                                <p class="alert alert-success"><i class="fa fa-check"></i> {{session('success')}}</p>
                            </div>
                            @endif
                            <div class="form-group">
                                <label>Email</label>
                                <input readonly type="text" class="form-control" value="{{$user->email}}">
                            </div>

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Your name" value="{{$user->name}}" name="name">
                                @if($errors->has('name'))
                                <label class="error">{{$errors->first('name')}}</label>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>New password</label>
                                <input type="text" class="form-control" name="password">
                                @if($errors->has('password'))
                                <label class="error">{{$errors->first('password')}}</label>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Repeat password</label>
                                <input type="text" class="form-control"  name="password_confirmation">
                                @if($errors->has('password_confirmation'))
                                <label class="error">{{$errors->first('password_confirmation')}}</label>
                                @endif
                            </div>

                            <div class="form-group">
                                <input id="submit" name="submit" type="submit" value="Save changes" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
