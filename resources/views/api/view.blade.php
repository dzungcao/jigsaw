@extends('layouts.public')

@section('content')
<div class="row">
	<div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h3>{{$question->title}}</h3>
                <div class="ibox-tools">
                    <form style="display:inline" method="POST" action="/question/{{$question->id}}">
                    {!! csrf_field() !!}
                    <input type="hidden" value="DELETE" name="_method"></input>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </form>
                    <a class="btn btn-primary" href="/question/{{$question->id}}/edit">
                        <i class="fa fa-edit"></i> Edit</a>
                    <a class="btn btn-primary" href="/question">
                        <i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/question') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-md-2 control-label">Title</label>

                        <div class="col-md-10">
                            <input readonly type="text" class="form-control" name="title" value="{{ $question->title }}">
                            @if ($errors->has('title'))
                            <label class="error">{{ $errors->first('title') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Text</label>

                        <div class="col-md-10">
                            <input readonly type="text" class="form-control" name="text" value="{{ $question->text }}">
                            @if ($errors->has('text'))
                            <label class="error">{{ $errors->first('text') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Subhed</label>

                        <div class="col-md-10">
                            <input readonly type="text" class="form-control" name="Subhed" value="{{ $question->subhed }}">
                            @if ($errors->has('subhed'))
                            <label class="error">{{ $errors->first('subhed') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Topimage</label>

                        <div class="col-md-10">
                            <input readonly type="text" class="form-control" name="topimage" value="{{ $question->topimage }}">
                            @if ($errors->has('topimage'))
                            <label class="error">{{ $errors->first('topimage') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Topvideoembed</label>

                        <div class="col-md-10">
                            <input readonly type="text" class="form-control" name="topvideoembed" value="{{ $question->topvideoembed }}">
                            @if ($errors->has('topvideoembed'))
                            <label class="error">{{ $errors->first('topvideoembed') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Backgroundimage</label>

                        <div class="col-md-10">
                            <input readonly type="text" class="form-control" name="backgroundimage" value="{{ $question->backgroundimage }}">
                            @if ($errors->has('backgroundimage'))
                            <label class="error">{{ $errors->first('backgroundimage') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Bottomimage</label>

                        <div class="col-md-10">
                            <input readonly type="text" class="form-control" name="bottomimage" value="{{ $question->bottomimage }}">
                            @if ($errors->has('bottomimage'))
                            <label class="error">{{ $errors->first('bottomimage') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Bottomvideoembed</label>

                        <div class="col-md-10">
                            <input readonly type="text" class="form-control" name="bottomvideoembed" value="{{ $question->bottomvideoembed }}">
                            @if ($errors->has('bottomvideoembed'))
                            <label class="error">{{ $errors->first('bottomvideoembed') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Middleimage</label>
                        <div class="col-md-10">
                            <input readonly type="text" class="form-control" name="middleimage" value="{{ $question->middleimage }}">
                            @if ($errors->has('middleimage'))
                            <label class="error">{{ $errors->first('middleimage') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Middlevideoembed</label>

                        <div class="col-md-10">
                            <input readonly type="text" class="form-control" name="middlevideoembed" value="{{ $question->middlevideoembed }}">
                            @if ($errors->has('middlevideoembed'))
                            <label class="error">{{ $errors->first('middlevideoembed') }}</label>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>
@stop

@section('extrastyles')
<link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="/css/plugins/toastr/toastr.min.css" rel="stylesheet">

<style type="text/css">
    .readonly-summernote{
        border: 1px solid #ededed;
        padding: 20px;
        background-color: #efefef;
    }
    .pendingJoinedMembers tr td{
        padding: 2px 0;
    }
</style>
@stop

@section('extrascripts')
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<script src="/js/plugins/toastr/toastr.min.js"></script>

<script>
    $(function(){
        __searchTimeout = null;
        __searchRequest = null;
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $('#search_user_input').keyup(function(){
            var val = $(this).val();
            if(val && val.length >= 3){
                if(!__searchTimeout){
                    var icon = 
                    "<h4>Searching...</h4>" +
                    "<div class='sk-spinner sk-spinner-wandering-cubes'>"+
                    "<div class='sk-cube1'></div>"+
                    "<div class='sk-cube2'></div>" +
                    "</div>";
                    $('#search_result').html(icon);
                }
                $('#search_result').show();
                __searchTimeout = setTimeout(function(){
                    if(__searchRequest){
                        __searchRequest.abort();
                    }
                    __searchRequest = $.ajax({
                        url : '/ajax/search/'+val,
                        type: 'GET',
                        success:function(data){
                            $('#search_result').html(data);
                        }
                    })
                },1000);
            }
        })
        $(document).on('click','.client-avatar',function(){
            $('#search_user_input').hide();
            $('#search_user_input').val($(this).data('email'));
            $('#search_result').hide();
            ajaxInviteToChallenge($('#search_form'))
            return false;
        })
    });

    function ajaxInviteToChallenge(form){
        $('#sending-invitation').removeClass('hidden');
        $.ajax({
            url : $(form).attr('action'),
            type: $(form).attr('method'),
            data: $(form).serialize(),
            success: function(data){
                if(data.success){
                    toastr.success('Invitation sent','Invitation has been sent!')
                }
                else{

                }
                $('#search_user_input').show();
                $('#sending-invitation').addClass('hidden');
            }
        })
        return false;
    }
</script>
@stop