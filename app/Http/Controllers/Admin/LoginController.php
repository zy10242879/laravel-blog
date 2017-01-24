<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

//载入验证码类 创建resources/org文件夹，将第三方类放入此文件夹中
//如果类使用原生session要查看在index.php(入口文件原本名为server.php)中是否加入了session_start();
require_once 'resources/org/code/Code.class.php';
class LoginController extends CommonController
{
  //载入登录页面
  public function login()
  {
    if ($input = Input::All()){
      $code = new \Code();
      $verifyCode = $code->get();//获取验证验方法
      //先验证验证码是否正确
      if(strtoupper($input['code']) != $verifyCode){
        return back()->with('msg','验证码错误!');//返回前一页
      }
      //查询数据库，验证用户名和密码是否正确
      if($user = User::where('user_name',$input['user_name'])->first()){
        if($input['user_name']==$user->user_name && $input['user_pass']==\Crypt::decrypt($user->user_pass)){
          //将数据写入session中
          session(['user_name'=>$user['user_name']]);
          //跳转到后台index首页
          return redirect('admin');
        }
      }
        return back()->with('msg','用户名或密码错误!');
      }

    return view('admin.login');
  }
  //退出并清session
  public function logout()
  {
    session(['user_name'=>null]);
    return redirect('admin/login');
  }
    //获得验证码图片的方法
    public function code()
    {
      $code = new \Code();
      $code->make();
    }
}
