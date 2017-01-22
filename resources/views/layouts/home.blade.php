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
    @show
<!----------------------------->
<footer>
    <p>Design by zy10242879 <a href="http://www.miitbeian.gov.cn/" target="_blank">http://github.com/zy10242879</a> <a href="/">网站统计</a></p>
</footer>
<script src="{{asset('resources/views/home/js/silder.js')}}"></script>
</body>
</html>
