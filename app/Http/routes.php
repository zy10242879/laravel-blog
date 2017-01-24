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
  Route::get('/','Home\IndexController@index');//前台首页路由
  Route::get('/cate/{cate_id}','Home\IndexController@cate');//前台分类页路由
  Route::get('/art','Home\IndexController@article');//前台详细页路由

  Route::any('admin/login','Admin\LoginController@login');//后台登录页路由
  Route::get('admin/code','Admin\LoginController@code');//后台获取验证码路由
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

  //-----注意：其它路由方法要放在资源路由上面，不然容易产生误读路由的情况---------
  //配置项写入根目录下的config文件夹中，生成web.php配置文件的路由
  Route::get('config/putFile','ConfigController@putFile');
  //ajax更新配置排序
  Route::post('config/changeOrder','ConfigController@changeOrder');
  //配置项提交路由
  Route::post('config/changeContent','ConfigController@changeContent');
  //创建配置使用的资源控制器
  Route::resource('config','ConfigController');


});