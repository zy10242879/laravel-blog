@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;添加自定义导航
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>导航管理</h3>
            <!-----------注意写法----------->
            @if(is_object($errors))
                @if(count($errors)>0)
                    <div class="mark">
                    @foreach($errors->all() as $error)<!--注意写法-->
                        <p>{{$error}}</p>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="mark">
                    <p>{{$errors}}</p>
                </div>
        @endif
        <!----------------------------->
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>全部导航</a>
            </div>
        </div>
    </div>

    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/navs')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                        <th><i class="require">*</i>导航名称：</th>
                        <td>
                            <input placeholder="导航名称" type="text" style="width: 20%;" name="nav_name">
                            <input placeholder="导航别名" type="text" style="width: 15%;" name="nav_alias">
                            <span><i class="fa fa-exclamation-circle yellow"></i>导航名称必需填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>URL：</th>
                        <td>
                            <input type="text" class="lg" name="nav_url" value="http://">
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="nav_order"><span><i class="fa fa-exclamation-circle yellow"></i>数字越小越靠前</span>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="location='{{url('admin/navs')}}'" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection