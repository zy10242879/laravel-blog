<?php

namespace App\Http\Controllers\Home;


use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;

class IndexController extends CommonController
{
  //前台页面首页
  public function index()
  {

    //图文列表5篇每页(带分页)
    $list = Article::orderBy('art_time','desc')->paginate(4);
    return view('home.index',compact('list'));
  }
  //前台分类列表页
  public function cate($cate_id)
  {
    //----------此段2个逻辑，1将查看的分类下的所有子分类获得，2将点击的子分类下的所有分类信息获得------
    //获得所有子分类
    $cates = Category::orderBy('cate_order')->get();
    $cates = Category::getTree($cates,'cate_pid','cate_id',$cate_id);
    $category = [];
    foreach ($cates as $cate){
      $category[] = $cate->cate_id;
    }
    $category[] = $cate_id;
    $data = Article::whereIn('cate_id',$category)->orderBy('art_time','desc')->paginate(3);
    //----------------------------------------------------------------------------------
    $field = Category::find($cate_id);
    return view('home.list',compact('field','data','cates'));
  }
  //前台文章详细页
  public function article()
  {
    return view('home.new');
  }
}
