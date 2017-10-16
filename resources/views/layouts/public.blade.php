<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta property="app_domain" content="{{env('APP_DOMAIN')}}" />
    @yield('metadata')
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/assets/plugins/flag-icon/css/flag-icon.css" rel="stylesheet" />
    <link href="/assets/css/animate.min.css" rel="stylesheet" />
    <link href="/assets/css/style.min.css" rel="stylesheet" />
    <link href="/assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="/assets/css/theme/default.css" id="theme" rel="stylesheet" />
    <link href="/css/myapp.css" rel="stylesheet" />
    @yield('extraheads')
</head>
<body>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-38757619-15', 'auto');
      ga('send', 'pageview');

    </script>

    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default mynav">
        <!-- begin container -->
        <div class="container">
            <!-- begin navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/" class="navbar-brand">
                    <img src="/images/logo.png" align="JIGSAWPUZZLE1">
                </a>
            </div>
            <!-- end navbar-header -->
            <!-- begin navbar-collapse -->
            <div class="collapse navbar-collapse" id="header-navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/brain-game">BRAIN GAMES</a></li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="dropdown">JIGSAW <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @foreach(\App\Models\Category::orderBy('order')->get() as $cat)
                            <li><a href="/category/{{$cat->id}}-{{$cat->titlize()}}">{{strtoupper($cat->title)}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @if(!\Auth::check())
                    <li><a href="/login">{{trans('public.login')}}</a></li>
                    @else
                    @if(\Auth::user()->admin)
                    <li>
                        <a href="javascript:;" data-toggle="dropdown">ADMIN <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/user">ADMIN</a></li>
                            <li><a href="/category">CATEGORY</a></li>
                            <li><a href="/brain-game/admin">BRAIN GAME</a></li>
                            <li><a href="/gamesize">GAMESIZE</a></li>
                            <li><a href="/admin/blog">BLOG</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(\Auth::user()->editor || \Auth::user()->approver || \Auth::user()->manager)
                    <li><a href="/picture">PICTURE</a></li>
                    <li><a href="/game">GAME</a></li>
                    @endif
                    <li>
                        <a href="javascript:;" data-toggle="dropdown">{{strtoupper(\Auth::user()->name)}}({{\Auth::user()->score}}) <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/player/{{\Auth::user()->username}}" style="text-transform: uppercase;background-color: #2196f3 ;color:#fff">{{\Auth::user()->name}}</a></li>
                            <li><a href="/account">ACCOUNT</a></li>
                            <li><a href="/logout">LOGOUT</a></li>
                        </ul>
                    </li>
                    @endif
                    <li class="dropdown navbar-language">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="flag-icon flag-icon-{{\App::getLocale()}}" title="{{\App::getLocale()}}"></span>
                            <span class="name" style="text-transform:uppercase">{{\App::getLocale()}}</span> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight p-b-0">
                            <li class="arrow"></li>
                            <li><a href="/language?locale=us"><span class="flag-icon flag-icon-us" title="us"></span> English</a></li>
                            <li><a href="/language?locale=vn"><span class="flag-icon flag-icon-vn" title="vn"></span> Tiếng Việt</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- end navbar-collapse -->
        </div>
        <!-- end container -->
    </div>
    <!-- end #header -->

    <!-- begin #content -->
    
    <div id="content" class="content">
        <div class="container">
        @yield('content')
        </div>
    </div>
    <a style="position:fixed;bottom:8px;right:4px" href="/custompic" class="create-game btn btn-primary btn-lg"><strong>{{trans('public.import')}}</strong></a>
    <!-- end #content -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    
    @yield('extrascripts')
    
</body>
</html>