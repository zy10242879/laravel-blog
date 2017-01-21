<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class ConfigController extends Controller
{
  //get.admin/config 全部配置项列表
  public function index()
  {
    $data = Config::orderBy('conf_order')->get();
    return view('admin.config.index',compact('data'));
  }
  //ajax更新排序
  public function changeOrder()
  {
    //接收数据
    if($input = Input::all()){
      //更新数据
      if($config = Config::find($input['conf_id'])){
        $config->conf_order = $input['conf_order'];
        if($config->update()){
          $data = [
            'status' => 0,
            'msg' => '配置项排序更新成功!'
          ];
        }
      }else{
        $data = [
          'status'=> 1,
          'msg' => '配置项排序更新失败，请稍候重试！'
        ];
      }
      return $data;
    }
  }

  //post.admin/config 创建配置项
  public function store()
  {
    $input = Input::except('_token');
    $rules = ['conf_title' => 'required', 'conf_name' => 'required',];
    $messages = ['conf_title.required' => '配置项标题不能为空！',
                 'conf_name.required' => '配置项名称不能为空！',];
    $validator = \Validator::make($input,$rules,$messages);
    if($validator->passes()){
      if(Config::Create($input)){
        return back()->with('errors','添加配置项成功！');
      }else{
        return back()->with('errors','数据填充失败，请稍候重试！');
      }
    }
    return back()->withErrors($validator->errors());
  }
  //get.admin/config/create 添加配置项
  public function create()
  {
    return view('admin.config.add');
  }
  //get.admin/config/{conf_id}/edit 编辑配置项
  public function edit($conf_id)
  {
    $field = Config::find($conf_id);
    return view('admin.config.edit',compact('field'));
  }
  //put.admin/config/{conf_id} 更新配置项
  public function update($conf_id)
  {
    $input = Input::except('_token', '_method');
    $rules = ['conf_name' => 'required', 'conf_title' => 'required',];
    $messages = ['conf_name.required' => '配置项名称不能为空！',
      'conf_title.required' => '配置项标题不能为空！',];
    $validator = \Validator::make($input, $rules, $messages);
    if ($validator->passes()) {
      if(Config::where('conf_id',$conf_id)->update($input)){
        return back()->with('errors','更新配置项成功！');
      }else{
        return back()->with('errors','更新失败，请稍候重试！');
      }
    }
    return back()->withErrors($validator->errors());
  }
  //delete.admin/config{conf_id} 删除单个配置项
  public function destroy($conf_id)
  {
    if(Config::where('conf_id',$conf_id)->delete()){
      $data = ['status' => 0, 'msg' => '删除配置项成功！',];
    }else{
      $data = ['status' => 1, 'msg' => '删除配置项失败，请稍候重试！',];
    }
    return $data;
  }
  //get.admin/config/{conf_id} 显示单个配置项信息
  public function show()
  {

  }
}
