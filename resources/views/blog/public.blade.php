@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="post-title">
            <h1>{{$blog->title}}</h1>
            </div>
            @if($blog->image)
            <img class="img-responsive" src="/upload/{{$blog->image}}" alt="{{$blog->title}}" style="margin:12px auto; text-align:center;width:100%">
            @endif
            <div class="post-detail section-container">
                {!!$blog->content!!}
            </div>

            <div class="disqus">
                <div id="disqus_thread"></div>
<script>
/**
* RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
* LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');

s.src = '//dzungcao.disqus.com/embed.js';

s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function ajax_submit(form){
        $.ajax({
            url : $(form).attr('action'),
            type: 'POST',
            data: $(form).serialize(),
            success: function(response){
                if(response.success){
                    $(form).find('.success_save').fadeIn(100);
                    setTimeout(function(){
                        $(form).find('.success_save').fadeOut(100);
                    },1000);
                }
                else{
                    $(form).find('.error_save').fadeIn(100);
                    setTimeout(function(){
                        $(form).find('.error_save').fadeOut(100);
                    },1000);
                }
            }
        })
        return false;
    }
    function ajax_delete(form){
        if(!confirm('Are you sure?')){
            return false;
        }
        $.ajax({
            url : $(form).attr('action'),
            type: 'POST',
            data: $(form).serialize(),
            success: function(response){
                if(response.success){
                    $(form).parent().fadeOut(300);
                }
                else{
                    alert('Failed to delete');
                }
            }
        })
        return false;
    }
</script>
@stop