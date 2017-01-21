@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;添加友情链接
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>链接管理</h3>
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
                <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部链接</a>
            </div>
        </div>
    </div>

    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/links')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                        <th><i class="require">*</i>链接名称：</th>
                        <td>
                            <input type="text" style="width: 35%;" name="link_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>链接名称必需填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>链接标题：</th>
                        <td>
                            <input type="text" class="lg" name="link_title">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>URL：</th>
                        <td>
                            <input type="text" class="lg" name="link_url" value="http://">
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="link_order"><span><i class="fa fa-exclamation-circle yellow"></i>数字越小越靠前</span>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="location='{{url('admin/links')}}'" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection