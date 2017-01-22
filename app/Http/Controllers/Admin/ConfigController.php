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
  //------------------对field_type字段进行判断后组合输出-----------------
    foreach($data as $k=>$v){
      switch ($v->field_type){
        case 'input':  //使用$data[$k]，是针对每一组数据进行拼接
          $data[$k]->_html = '<input type="text" class="lg" name="conf_content" value="'.$v->conf_content.'">';
          break;
        case 'textarea':
          $data[$k]->_html = '<textarea type="text" class="lg" name="conf_content">'.$v->conf_content.'</textarea>';
          break;
        case 'radio':
          //$v->field_value 是字符串 1|开启,0|关闭
          $arr = explode(',',$v->field_value); //通过','分割成数组 [0=>'1|开启',1=>'0|关闭']
          $str = '';//用于拼接
          foreach($arr as $m=>$n){ //遍历上面分割的数组
            //遍历后的$n='1|开启'
            $r = explode('|',$n);  //再次通过遍历分割为：[0=>1,1=>'开启']
            $c = $v->conf_content==$r[0]?' checked':'';//判断是否被选中的三元
            $str .= '<input type="radio" name="conf_content" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
          }
          $data[$k]->_html = $str;
          break;
      }
    }
  //----------------------------------------------------------------
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
