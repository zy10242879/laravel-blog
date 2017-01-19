<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use MongoDB\BSON\Timestamp;

class ArticleController extends CommonController
{
  //get.admin/article 全部文章列表
  public function index()
  {
    //-----------------分页效果-------------------
    $data = Article::orderBy('art_id','desc')->paginate(8);
    return view('admin.article.index',compact('data'));
    //------------------------------------------
  }

  //post.admin/article  添加文章提交
  public function store()
  {
    if($input = Input::except('_token')){
      $input['art_time']= time();
      $rules = [
        'art_title' => 'required',
        'art_content' => 'required',
      ];
      $messages = [
        'art_title.required'=>'文章标题不能为空！',
        'art_content.required'=>'文章内容不能为空！',
      ];
      $validator = \Validator::make($input,$rules,$messages);
      if($validator->passes()){
        if(!empty($input['art_thumb'])){
          $new_name = substr($input['art_thumb'],0,8).substr($input['art_thumb'],11);
          rename('./'.$input['art_thumb'],'./'.$new_name);
          $input['art_thumb'] = $new_name;
        }
        if(Article::create($input)){
          return redirect('admin/article');
        }else{
          return back()->with('input',$input)->with('errors','数据填充失败，请稍候重试');
        }
      }else{
        //此处最好的方法为，在提交时，通过js来控制提交字段的验证
        return back()->with('input',$input)->withErrors($validator->errors());
      }
    }
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
