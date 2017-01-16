<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController
{
  //get.admin/category 全部分类列表
  public function index()
  {
    $categorys = Category::orderBy('cate_order','asc')->get();//想要获得数据可以在后面加上->toArray()
    $data = Category::getTree($categorys,'cate_pid','cate_id');
    $data = Category::setPrefix($data,'cate_name','cate_pid');
    return view('admin.category.index')->with('data',$data);
  }
  //ajax更新排序
  public function changeOrder()
  {
    //接收数据
    if($input = Input::all()){
      //更新数据
      if($cate = Category::find($input['cate_id'])){
        $cate->cate_order = $input['cate_order'];
        if($cate->update()){
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

  //get.admin/category/create 添加分类
  public function create()
  {
    $data = Category::getOptions();
    return view('admin.category.add',['data'=>$data]);
  }
  //post.admin/category //添加分类提交
  public function store()
  {
    
  }
  //get.admin/category{category} 显示单个分类信息
  public function show()
  {

  }
  //put.admin/category{category} 更新分类
  public function update()
  {

  }
  //delete.admin/category{category} 删除单个分类
  public function destroy()
  {

  }
  //get.admin/category/{category}/edit 编辑分类
  public function edit()
  {

  }
}
