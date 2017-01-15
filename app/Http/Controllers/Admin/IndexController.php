<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
  //后台登录页
  public function index()
  {
    return view('admin.index');
    }
  //后台登录页中的内容信息
  public function info()
  {
    return view('admin.info');
    }
  //修改密码
  public function pass()
  {
    if($input = Input::All()){
      $rules = [//②验证规则
        'password'=>'required|between:3,20|confirmed',//bail|required...的作用为有错就停止往下验证
      ];
      $messages = [//③提示信息
        'password.required'=>'新密码不能为空！',
        'password.between'=>'密码长度为3-20位!',
        'password.confirmed'=>'两次密码输入不一致!'
      ];
      $validator = \Validator::make($input,$rules,$messages);//①验证方法写法
      if($validator->passes()){//④是否通过验证的判断
        //⑤验证数据库的密码与输入的密码是否一致
        $user = User::where('user_name',session('user_name'))->first();
        if(decrypt($user->user_pass) == $input['password_o']){
          $user->user_pass = \Crypt::encrypt($input['password']);
          $user->update();
          return back()->with('errors','密码修改成功！');
        }else{
          return back()->with('errors','原密码错误，请重新输入!');
        }
      }else{
        //验证失败，返回错误信息
          return back()->withErrors($validator);//返回到页面的是写入session中的$errors
      }
    }
    return view('admin.pass');
  }
}
