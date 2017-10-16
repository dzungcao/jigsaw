@extends('layouts.public')

@section('extraheads')
<script id="dsq-count-scr" src="//dzungcao.disqus.com/count.js" async></script>
@stop
@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<ul class="post-list">
				@foreach($blogs as $blog)
				<li>
                    <!-- begin post-left-info -->
                    <div class="post-left-info">
                        <div class="post-date">
                            <span class="day">21</span>
                            <span class="month">OCT</span>
                        </div>
                    </div>
                    <!-- end post-left-info -->
                    <!-- begin post-content -->
                    <div class="post-content">
                        <!-- begin post-image -->
                        <!-- end post-image -->
                        <!-- begin post-info -->
                        <div class="post-info">
                            <h4 class="post-title">
                                <a href="{{$blog->slug}}">{{$blog->title}}</a>
                            </h4>
                            <div class="post-by">
                                Posted By <a>{{$blog->user->name}}</a>
                            </div>
	                        @if($blog->image)
	                        <a href="{{$blog->slug}}"><img class="img-responsive" src="/upload/{{$blog->image}}" alt="{{$blog->title}}" style="margin:12px auto; text-align:center;width:100%"></a>
	                        @endif
                            <div class="post-desc">
                                 {!!$blog->content!!}
                            </div>
                        </div>
                        <!-- end post-info -->
                    </div>
                    <!-- end post-content -->
                </li>
				@endforeach
				</ul>
			</div>
		</div>
	</div>
@stop