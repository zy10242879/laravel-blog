<?php

namespace App\Http\Controllers\Home;


class IndexController extends CommonController
{
  //前台页面首页
  public function index()
  {
    return view('home.index');
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
