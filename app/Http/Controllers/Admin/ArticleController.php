<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleController extends CommonController
{
  //get.admin/article 全部分类列表
  public function index()
  {

  }
  //post.admin/article  添加文章提交
  public function store()
  {

  }
  //get.admin/article/create 添加文章
  public function create()
  {
    $data = Category::getOptions();
    return view('admin.article.add',compact('data'));
  }
  //get.admin/article/{article } 显示单个文章信息
  public function show()
  {

  }
  //put.admin/article/{article } 更新文章
  public function update()
  {

  }
  //delete.admin/article/{article } 删除单个文章
  public function destroy()
  {

  }
  //get.admin/article /{article }/edit 编辑文章
  public function edit()
  {

  }

}
