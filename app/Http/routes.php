<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//开发blog项目
Route::group(['middleware' => ['web']], function () {

  Route::get('/', function () {
        return view('welcome');
    });
  Route::any('admin/login','Admin\LoginController@login');
  Route::get('admin/code','Admin\LoginController@code');
});
//建立admin下的路由及中间件的设置 用于判断session，是否是登录状态
Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
  Route::get('index','IndexController@index');
  Route::get('info','IndexController@info');
  Route::get('logout','LoginController@logout');
  Route::any('pass','IndexController@pass');
  //创建文章分类使用的资源控制器
  Route::resource('category','CategoryController');
  //ajax更新排序
  Route::post('category/changeOrder','CategoryController@changeOrder');
  //创建文章的资源控制器
  Route::resource('article','ArticleController');
  //创建文件上传控制器
  Route::any('upload','CommonController@upload');
});