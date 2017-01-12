<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
//载入验证码类 创建resources/org文件夹，将第三方类放入此文件夹中
//如果类使用原生session要查看在index.php(入口文件原本名为server.php)中是否加入了session_start();
require_once 'resources/org/code/Code.class.php';
class LoginController extends CommonController
{
  //载入登录页面
  public function login()
  {
    return view('admin.login');
  }
  //获得验证码图片的方法
  public function code()
  {
    $code = new \Code();
    $code->make();
  }
  //获得验证码的方法
  public function getCode()
  {
    $code = new \Code();
    echo $code->get();
  }
}
