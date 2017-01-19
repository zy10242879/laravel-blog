<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

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
  //get.admin/article /{article }/edit 编辑文章
  public function edit($art_id)
  {
    $input = Article::find($art_id);
    $data = Category::getOptions();
    return view('admin.article.edit',compact('data','input'));

  }
  //put.admin/article/{article } 更新文章
  public function update($art_id)
  {
    //可以验证一下标题和内容不为空，这里不做验证了
    $input = Input::except('_token','_method');
    $art_thumb = Article::find($art_id)->art_thumb;//数据库查出原来的文件名路径
    //如果上传的图片修改了，那么就把临时文件的图片名改名为正式上传的图片名，并移除原来的图片
    if(strpos($input['art_thumb'],'tmp')){
      if(!empty($art_thumb)){//如果不为空字符串
        unlink($art_thumb);//删除以前的文件
      }
      $new_name = substr($input['art_thumb'],0,8).substr($input['art_thumb'],11);
      rename('./'.$input['art_thumb'],'./'.$new_name);
      $input['art_thumb'] = $new_name;
    }
      if(Article::where('art_id',$art_id)->update($input)){
      return back()->with('errors','文章更新成功！');
    }else{
      return back()->with('errors','更新文章失败，请稍候再试！');
    }
  }
  //ajax  delete.admin/article/{article } 删除单个文章
  public function destroy($art_id)
  {
    $art = Article::find($art_id);
    if($art != null){
      $art_thumb = $art->art_thumb;
      if(Article::where('art_id',$art_id)->delete()){
        if(!empty($art_thumb)){
          unlink($art_thumb);
        }
        $data = ['status'=>0, 'msg'=>'文章删除成功!'];
      }else{
        $data = ['status'=>1,'msg'=>'删除文章失败，请稍候重试！'];
      }
    }else{
      $data = ['status'=>1,'msg'=>'参数异常，请联系管理员！'];
    }
   return $data;
  }
}
