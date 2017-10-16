@extends('layouts.public',['fluid_container'=>true])

@section('content')
<div class="loginColumns animated fadeInDown">
    <div class="row">
        
        <div class="col-md-6 col-md-offset-3">
            <div class="ibox-content">
                <h2>LOGIN</h2>
                <form class="m-t" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Username" required="" name="email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" required="" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>

                    <p class="text-muted text-center">
                        <small>Do not have an account?</small>
                    </p>
                    <a class="btn btn-sm btn-white btn-block" href="/register">Create an account</a>
                    <div class="hr-line-dashed"></div>
                    <a class="btn btn-outline btn-success btn-facebook btn-block" href="/auth/facebook"><i class="fa fa-facebook"> </i> Login with Facebook</a>
                </form>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('extrastyles')
<style type="text/css">
.loginColumns{
    padding:0px;
}
</style>
@stop