<div class="row">
    <div class="col-md-10 col-md-offset-1">
        
        <form class="m-t" role="form" method="POST" action="{{ url('/auth/ajaxlogin') }}" onsubmit="return ajaxlogin(this)">
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
            
            <div class="form-group">

            <button type="submit" class="btn btn-primary pull-right">Login</button>
            <a href="{{ url('/password/reset') }}">Forgot Your Password?</a>
            <hr>

            <h3 class="text-muted text-center">
                Do not have an account?
            </h3>
            <a class="btn btn-sm btn-white btn-block" href="/register">Email Signup</a>
            
            <a class="btn btn-success btn-google btn-block" href="/auth/google"><i class="fa fa-google-plus"> </i> Login with Google</a>
            <a class="btn btn-outline btn-success btn-facebook btn-block" href="/auth/facebook"><i class="fa fa-facebook"> </i> Login with Facebook</a>
            </div>
        </form>
        <script type="text/javascript">
            function ajaxlogin(form){
                $.ajax({
                    url : form.action,
                    type: 'POST',
                    data: $(form).serialize(),
                    success:function(response){
                        if(response.success){
                            window.location.reload();
                        }
                        else{
                            console.log('Failed');
                        }
                    }
                })
            }
        </script>
    </div>
</div>