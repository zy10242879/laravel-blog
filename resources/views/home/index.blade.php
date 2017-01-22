@extends('layouts.home')
@section('info')
  <title>个人博客首面</title>
  <meta name="keywords" content="个人博客模板,博客模板" />
  <meta name="description" content="寻梦主题的个人博客模板，优雅、稳重、大气,低调。" />
@endsection
@section('content')
<div class="banner">
  <section class="box">
    <ul class="texts">
      <p>打了死结的青春，捆死一颗苍白绝望的灵魂。</p>
      <p>为自己掘一个坟墓来葬心，红尘一梦，不再追寻。</p>
      <p>加了锁的青春，不会再因谁而推开心门。</p>
    </ul>
    <div class="avatar"><a href="#"><span>阿勇</span></a> </div>
  </section>
</div>
<div class="template">
  <div class="box">
    <h3>
      <p><span>站长</span>推荐 Recommend</p>
    </h3>
    <ul>
      @foreach($hot as $h)
      <li><a href="{{url('art/'.$h->art_id)}}"  target="_blank"><img src="{{url($h->art_thumb)}}"></a><span>{{$h->art_title}}</span></li>
      @endforeach
    </ul>
  </div>
</div>
<article>
  <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
  <div class="bloglist left">
    @foreach($list as $l)
    <h3>{{$l->art_title}}</h3>
    <figure><img src="{{url($l->art_thumb)}}"></figure>
    <ul>
      <p>{{$l->art_description}}...</p>
      <a title="{{$l->art_title}}" href="{{url('art/'.$l->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <p class="dateview"><span>{{date('Y-m-d',$l->art_time)}}</span><span>作者：{{$l->art_editor}}</span></p>
    @endforeach
    <!--------分页------>
      <div class="page">
        {{$list->links()}}
      </div>
    <!------------------>
  </div>
  <!-- Baidu Button BEGIN -->
  <div style="padding-left: 10px" id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
  <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
  <script type="text/javascript" id="bdshell_js"></script>
  <script type="text/javascript">
    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
  </script>
  <!-- Baidu Button END -->
  <aside class="right">
    <div class="weather"><iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe></div>
    <div class="news">
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

    </aside>
</article>
@endsection