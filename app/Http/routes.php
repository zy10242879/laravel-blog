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
  //创建友情链接使用的资源控制器
  Route::resource('links','LinksController');
  //ajax更新链接排序
  Route::post('links/changeOrder','LinksController@changeOrder');
  //创建自定义导航使用的资源控制器
  Route::resource('navs','NavsController');
  //ajax更新链接排序
  Route::post('navs/changeOrder','NavsController@changeOrder');

  //创建配置使用的资源控制器
  Route::resource('config','ConfigController');
  //ajax更新配置排序
  Route::post('config/changeOrder','ConfigController@changeOrder');
  //配置项提交路由
  Route::post('config/changeContent','ConfigController@changeContent');
});