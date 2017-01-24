<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Links;
use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
  //---------注意：这里构造函数的用法及共享参数的传递--------
  public function __construct()
  {
    $navs = Navs::all();
    //点击量最高的6篇文章
    $hot = Article::orderBy('art_view','desc')->take(6)->get();
    //最新发布文章8篇
    $new = Article::orderBy('art_time','desc')->take(8)->get();
    //友情链接
    $links = Links::orderBy('link_order','asc')->get();
    View::share(['navs'=>$navs,'hot'=>$hot,'new'=>$new,'links'=>$links]);//View::是门面　use Illuminate\Support\Facades\View;
  }
  //------View::share('navs',$navs);共享参数传递方法-----
}
