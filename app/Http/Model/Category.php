<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table='category';
  protected $primaryKey='cate_id';
  public $timestamps=false;
  //---------------注意create()使用需要加入：$guarded（排除入库）或$fillable（允许入库）-----------
  //注意：使用create时框架对字段保护，所以需要使用以下配置来进行开放创建
  protected $guarded = [];//表示所有post的数据都可以通过create来进行入库操作[]如果写入字段，该字段将不能入库
  //protected $fillable = [];//表示post允许写入的字段，需要填入字段名才能进行入库操作
  //---------------------------------------------------------------------------------------

  //通用无限级分类
  public static function getTree($cates,$field_pid,$field_id,$pid=0){
    $tree = [];
    foreach($cates as $cate){
      if($cate->$field_pid==$pid){
        $tree[] = $cate;
        $tree = array_merge($tree,self::getTree($cates,$field_pid,$field_id,$cate->$field_id));
      }
    }
    return $tree;
  }

  //通用无限级分类加前缀
  public static function setPrefix($data,$field_name,$field_pid,$p='├──'){
    $tree = [];
    $num = 0;
    $prefix = [0=>0]; //$prefix如果设置为1则顶级分类会有前缀
    foreach($data as $key =>$value){
      if($key > 0){
        if($data[$key-1]->$field_pid != $value->$field_pid ){
          $num++;
        }
      }
      if(array_key_exists($value->$field_pid,$prefix)){ //判断当前层级的父级是否有前缀
        $num = $prefix[$value->$field_pid];  //这个层级所拥有的前缀个数
      }
      $value->$field_name = str_repeat($p,$num).$value->$field_name;//将前缀重复层级后进行拼接生成带前缀的标题
      $prefix[$value->$field_pid]= $num; //注：把parent_id对应的级别放入$prefix[]中，重点在此
      $tree[] = $value;                      //意义：为当前层级设定级别，以在array_key_exists中进行判断用
    }
    return $tree;
  }

  //获取分类信息
  public static function getOptions(){
    $cates = self::orderBy('cate_order')->get();
    $tree = self::getTree($cates,'cate_pid','cate_id');
    $res = self::setPrefix($tree,'cate_name','cate_pid');
    //---------如果加入此段注释，可减少很多传参数据--------
//    $res = [];    //只取需要的数据传入视图中，要将视图中的AR方式修改为数据方式
//    foreach ($tree as $k=> $v){
//      $res[$k]['cate_id']= $v->cate_id;
//      $res[$k]['cate_name']= $v->cate_name;
//      $res[$k]['cate_pid']= $v->cate_pid;
//    }
    //----------------------------------------------
    return $res;
  }

}
