<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoryController extends CommonController
{
  //get.admin/category 全部分类列表
  public function index()
  {
    $categorys = Category::all();
    $data = Category::getTree($categorys,'cate_pid','cate_id');
    $data = Category::setPrefix($data,'cate_name','cate_pid');
    return view('admin.category.index')->with('data',$data);
  }
  //post.admin/category
  public function store()
  {

  }
  //get.admin/category/create 添加分类
  public function create()
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
