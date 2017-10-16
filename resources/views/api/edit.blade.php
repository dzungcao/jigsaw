@extends('layouts.public')

@section('content')
<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
        <div class="ibox">
            <div class="ibox-title">
                <h3>Edit question</h3>
                <div class="ibox-tools">
                    <a class="btn btn-primary" href="/question/{{$question->id}}">
                    <i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/question/'.$question->id) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT"/>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Title</label>

                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" value="{{ $question->title }}">
                            @if ($errors->has('title'))
                            <label class="error">{{ $errors->first('title') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Content</label>
                        <div class="col-md-10">
                            <div class="summernote" name="content">
                                {!! $challenge->content !!}
                            </div>

                            <textarea name="content" id="content" class="hidden">{!! $challenge->content !!}</textarea>
                            @if ($errors->has('content'))
                            <label class="error">{{ $errors->first('content') }}</label>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Start date</label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="start_date" value="{{ date('Y-m-d',strtotime($challenge->start_date)) }}" placeholder="YYYY-MM-DD">
                                    </div>
                                    @if ($errors->has('start_date'))
                                    <label class="error">{{ $errors->first('start_date') }}</label>
                                    @endif
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="start_hour" value="{{ date('H',strtotime($challenge->start_date)) }}" placeholder="Hour">
                                    @if ($errors->has('start_hour'))
                                    <label class="error">{{$errors->first('start_hour')}}</label>
                                    @endif
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="start_min" value="{{ date('i',strtotime($challenge->start_date)) }}" placeholder="Minute">
                                    @if ($errors->has('start_min'))
                                    <label class="error">{{$errors->first('start_min')}}</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">End date</label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="end_date" value="{{ date('Y-m-d',strtotime($challenge->end_date))}}" placeholder="YYYY-MM-DD">
                                    </div>
                                    @if ($errors->has('start_date'))
                                    <label class="error">{{ $errors->first('start_date') }}</label>
                                    @endif
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="end_hour" value="{{ date('H',strtotime($challenge->end_date))}}" placeholder="Hour">
                                    @if ($errors->has('end_hour'))
                                    <label class="error">{{$errors->first('end_hour')}}</label>
                                    @endif
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="end_min" value="{{ date('i',strtotime($challenge->end_date))}}" placeholder="Minute">
                                    @if ($errors->has('end_min'))
                                    <label class="error">{{$errors->first('end_min')}}</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Public</label>
                        <div class="col-md-10">
                            @if($challenge->public))
                            <input type="checkbox" class="i-checks" name="public" checked>
                            @else
                            <input type="checkbox" class="i-checks" name="public">
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Attachment</label>
                        <div class="col-md-10">
                            <input type="file" name="file[]" multiple="true">
                            @if($errors->has('file'))
                            <label class="error">{{ $errors->first('file') }}</label>
                            @endif
                        </div>
                    </div>

                    @if(!$challenge->attachments->isEmpty())
                    <div class="form-group">
                        <div class="col-md-12">
                            <h2>Attachments</h2>
                            <ul class="downloads">
                                @foreach($challenge->attachments as $attachment)
                                <li>
                                    <a href="/attachment/{{$attachment->attachment->id}}/{{$attachment->attachment->file_name}}">{{$attachment->attachment->file_name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <div class="col-md-10 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
<link href="/css/plugins/summernote/summernote.css" rel="stylesheet">
<link href="/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
<link href="/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<style type="text/css">
    .note-editor{
        border: 1px solid #eee;
    }
</style>
@stop

@section('extrascripts')
<!-- SUMMERNOTE -->
<script src="/js/plugins/summernote/summernote.min.js"></script>
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<script src="/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script>
    $(function(){
        $('.summernote').summernote({focus:true});
        $('.note-editable').on("blur", function(){
            $('textarea[name="content"]').html($('.summernote').code());
        });
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('.input-group.date').datepicker({
            todayBtn: "linked",
            forceParse: false,
            autoclose: true,
            format: "yyyy-mm-dd"
        });
    });
</script>
        

@stop