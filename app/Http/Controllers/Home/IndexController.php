<?php

namespace App\Http\Controllers\Home;


use App\Http\Model\Article;
use App\Http\Model\Links;

class IndexController extends CommonController
{
  //前台页面首页
  public function index()
  {
    //点击量最高的6篇文章
    $hot = Article::orderBy('art_view','desc')->take(6)->get();
    //最新发布文章8篇
    $new = Article::orderBy('art_time','desc')->take(8)->get();
    //图文列表5篇每页(带分页)
    $list = Article::orderBy('art_time','desc')->paginate(4);
    //友情链接
    $links = Links::orderBy('link_order','asc')->get();
    return view('home.index',compact('hot','new','list','links'));
  }
  //前台分类列表页
  public function cate()
  {
    return view('home.list');
  }
  //前台文章详细页
  public function article()
  {
    return view('home.new');
  }
}
