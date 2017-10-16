@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="/blog/{{$blog->id}}/edit" class="btn btn-info">Edit bog</a>
                </div>
                <div class="panel-body">
                    <p>Sharable link</p>
                    <a href="{{$blog->getLink()}}" class="btn btn-success">Xem thử</a>
                    
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $blog->title }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" name="slug" value="{{ $blog->slug }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Introduction</label>
                        <div>
                            {!!$blog->introduction!!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <div>
                            {!!$blog->content!!}
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label>Blog</label>
                        <br/>
                        <img src="/download/blog/{{$blog->image}}" align="Blog image">
                    </div>
                </div>
            </div>
        </div>
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