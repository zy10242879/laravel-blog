<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <!----注意：这里两个section()用法-->
@section('info')
    @show
    <!----------------------------->
    <link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{asset('resources/views/home/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav">
        <!------------------注意：这里要将标签连在一起，不然会出现间隙-------------->
        @foreach($navs as $v)<a href="{{$v->nav_url}}"><span>{{$v->nav_name}}</span><span class="en">{{$v->nav_alias}}</span></a>@endforeach
        <!------------------------------------------------------------------>
    </nav>
</header>
<!----注意：这里两个section()用法-->
@section('content')
    <div class="news" style="float: right">
        <h3>
            <p>最新<span>文章</span></p>
        </h3>
        <ul class="rank">
            @foreach($new as $n)
                <li><a href="{{url('art/'.$n->art_id)}}" title="{{$n->art_title}}" target="_blank">{{$n->art_title}}</a></li>
            @endforeach
        </ul>
        <h3 class="ph">
            <p>点击<span>排行</span></p>
        </h3>
        <ul class="paih">
            @foreach($hot as $m=>$h)
                @if($m<5)
                    <li><a href="{{url('art/'.$h->art_id)}}" title="{{$h->art_title}}" target="_blank">{{$h->art_title}}</a></li>
                @endif
            @endforeach
        </ul>
        <h3 class="links">
            <p>友情<span>链接</span></p>
        </h3>
        <ul class="website">
            @foreach($links as $l)
                <li><a target="_blank" href="{{$l->link_url}}">{{$l->link_name}}</a></li>
            @endforeach
        </ul>
    </div>
@show
<!----------------------------->

<footer>
    <p>{!! Config::get('web.copyright') !!} <a href="/">{{Config::get('web.web_count')}}</a></p>
</footer>
<script src="{{asset('resources/views/home/js/silder.js')}}"></script>
</body>
</html>
