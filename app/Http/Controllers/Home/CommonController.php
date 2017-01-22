<?php

namespace App\Http\Controllers\Home;

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
    View::share('navs',$navs);//View::是门面　use Illuminate\Support\Facades\View;
  }
  //------View::share('navs',$navs);共享参数传递方法-----
}
