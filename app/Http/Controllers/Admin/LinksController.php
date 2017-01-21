<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\DocBlock\Tags\Link;

class LinksController extends Controller
{
  //get.admin/links 全部链接列表
  public function index()
  {
    $data = Links::orderBy('link_order')->get();
    return view('admin.links.index',compact('data'));
  }
  //ajax更新排序
  public function changeOrder()
  {
    //接收数据
    if($input = Input::all()){
      //更新数据
      if($links = Links::find($input['link_id'])){
        $links->link_order = $input['link_order'];
        if($links->update()){
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

  //post.admin/links 创建链接
  public function store()
  {
    $input = Input::except('_token');
    $rules = ['link_name' => 'required', 'link_url' => 'required',];
    $messages = ['link_name.required' => '友情链接名称不能为空！',
                 'link_url.required' => '友情链接地址不能为空！',];
    $validator = \Validator::make($input,$rules,$messages);
    if($validator->passes()){
      if(Links::Create($input)){
        return back()->with('errors','添加链接成功！');
      }else{
        return back()->with('errors','数据填充失败，请稍候重试！');
      }
    }
    return back()->withErrors($validator->errors());
  }
  //get.admin/links/create 添加链接
  public function create()
  {
    return view('admin.links.add');
  }
  //get.admin/links/{link_id}/edit 编辑链接
  public function edit($link_id)
  {
    $field = Links::find($link_id);
    return view('admin.links.edit',compact('field'));
  }
  //put.admin/links{link_id} 更新链接
  public function update($link_id)
  {
    $input = Input::except('_token', '_method');
    $rules = ['link_name' => 'required', 'link_url' => 'required',];
    $messages = ['link_name.required' => '友情链接名称不能为空！',
      'link_url.required' => '友情链接地址不能为空！',];
    $validator = \Validator::make($input, $rules, $messages);
    if ($validator->passes()) {
      if(Links::where('link_id',$link_id)->update($input)){
        return back()->with('errors','更新链接成功！');
      }else{
        return back()->with('errors','更新失败，请稍候重试！');
      }
    }
    return back()->withErrors($validator->errors());
  }
  //delete.admin/links{link_id} 删除单个链接
  public function destroy($link_id)
  {
    if(Links::where('link_id',$link_id)->delete()){
      $data = ['status' => 0, 'msg' => '删除链接成功！',];
    }else{
      $data = ['status' => 1, 'msg' => '删除链接失败，请稍候重试！',];
    }
    return $data;
  }
  //get.admin/links{link_id} 显示单个链接信息
  public function show()
  {

  }
}
