<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //-----------------文件上传方法--------------
  public function upload()
  {
    //注：要获取页面中异步传过来的数据，在uploadify中(是文件)要使用file来获取
    $file = Input::file('Filedata');
    //----------------文件上传需要参数的获得方法--------------
//    if($file->isValide()){}//判断上传文件是否有效
//      $clientName = $file->getClientOriginalName();//获取文件名称（基本不用）
//      $tmpName = $file->getFileName();//获取缓存在tmp文件夹中的文件名(基本不用)
//        $realPath = $file->getRealPath();//获取级存文件tmp文件夹的绝对路径，包含文件名
//        $entension = $file->getClientOriginalExtension();//获取上传文件的后缀
//        $mimeTye = $file->getMimeType();//获得文件的类型(很少用)
//        $path = $file->move(app_path().'/storage/uploads',$newName);//文件移动并重命名
    //------由于服务器上传文件逻辑问题（此处只将临时文件路径返回，待成功提交后，将文件移到服务器上）---------
    if($file->isValid()){
      $fileTypes = array('jpg','jpeg','gif','png');
      $entension = $file->getClientOriginalExtension();
      if (in_array($entension,$fileTypes)) {
        $newName = 'tmp'.date('YmdHis').mt_rand(100,999).'.'.$entension;
        $path = $file->move(base_path().'/uploads',$newName);//bash_path根目录
        $filePath = 'uploads/'.$newName;
        $data = [
          'status'=>0,
          'msg'=>$filePath,
        ];
      } else {
        $data = [
          'status'=>1,
          'msg'=>'上传失败：图片上传仅支持.jpg .jpeg .gif .png后缀文件且小于2M!',
        ];
      }
      return $data;
    }
  }
  //-----------------------------------------------------
}
