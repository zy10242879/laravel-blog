<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table='category';
  protected $primaryKey='cate_id';
  public $timestamps=false;

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



}
