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
    //---------------------增加查看次数-自增的用法(静默处理)----------------
    Category::where('cate_id',$cate_id)->increment('cate_view');
    //('cate_view',5)访问一次加5，
    //----------------------------------------------------------------
    return view('home.list',compact('field','data','cates'));
  }
  //前台文章详细页
  public function article($art_id)
  {
    //----------关联查询的使用
    $data = Article::where('art_id',$art_id)->Join('category','article.cate_id','=','category.cate_id')->first();
    //------上一篇，下一篇
    $art['pre']=Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
    $art['next']=Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
    //----相关文章
    $articles = Article::where('cate_id',$data->cate_id)->take(6)->get();
    //---------------------增加查看次数-自增的用法(静默处理)----------------
    Article::where('art_id',$art_id)->increment('art_view');
        //('art_view',5)访问一次加5，可以按进入ip算pv次数，同一ip半小时点N次算一次的算法
    //----------------------------------------------------------------
    return view('home.new',compact('data','art','articles'));
  }
}
