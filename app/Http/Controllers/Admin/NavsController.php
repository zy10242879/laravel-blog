<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class NavsController extends Controller
{
  //get.admin/navs 全部自定义导航列表
  public function index()
  {
    $data = Navs::orderBy('nav_order')->get();
    return view('admin.navs.index',compact('data'));
  }
  //ajax更新排序
  public function changeOrder()
  {
    //接收数据
    if($input = Input::all()){
      //更新数据
      if($navs = Navs::find($input['nav_id'])){
        $navs->nav_order = $input['nav_order'];
        if($navs->update()){
          $data = [
            'status' => 0,
            'msg' => '排序更新成功!'
          ];
        }
      }else{
        $data = [
          'status'=> 1,
          'msg' => '排序更新失败，请稍候重试！'
        ];
      }
      return $data;
    }
  }

  //post.admin/navs 创建自定义导航
  public function store()
  {
    $input = Input::except('_token');
    $rules = ['nav_name' => 'required', 'nav_url' => 'required',];
    $messages = ['nav_name.required' => '自定义导航名称不能为空！',
                 'nav_url.required' => '自定义导航地址不能为空！',];
    $validator = \Validator::make($input,$rules,$messages);
    if($validator->passes()){
      if(Navs::Create($input)){
        return back()->with('errors','添加自定义导航成功！');
      }else{
        return back()->with('errors','数据填充失败，请稍候重试！');
      }
    }
    return back()->withErrors($validator->errors());
  }
  //get.admin/navs/create 添加自定义导航
  public function create()
  {
    return view('admin.navs.add');
  }
  //get.admin/navs/{nav_id}/edit 编辑自定义导航
  public function edit($nav_id)
  {
    $field = Navs::find($nav_id);
    return view('admin.navs.edit',compact('field'));
  }
  //put.admin/navs{nav_id} 更新自定义导航
  public function update($nav_id)
  {
    $input = Input::except('_token', '_method');
    $rules = ['nav_name' => 'required', 'nav_url' => 'required',];
    $messages = ['nav_name.required' => '自定义导航名称不能为空！',
      'nav_url.required' => '自定义导航地址不能为空！',];
    $validator = \Validator::make($input, $rules, $messages);
    if ($validator->passes()) {
      if(Navs::where('nav_id',$nav_id)->update($input)){
        return back()->with('errors','更新自定义导航成功！');
      }else{
        return back()->with('errors','更新失败，请稍候重试！');
      }
    }
    return back()->withErrors($validator->errors());
  }
  //delete.admin/navs{nav_id} 删除单个自定义导航
  public function destroy($nav_id)
  {
    if(Navs::where('nav_id',$nav_id)->delete()){
      $data = ['status' => 0, 'msg' => '删除自定义导航成功！',];
    }else{
      $data = ['status' => 1, 'msg' => '删除自定义导航失败，请稍候重试！',];
    }
    return $data;
  }
  //get.admin/navs{nav_id} 显示单个自定义导航信息
  public function show()
  {

  }
}
