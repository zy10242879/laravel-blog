@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部友情导航
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>导航管理</h3>
                </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加导航</a>
                    <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>全部导航</a>
                    <a href="{{url('admin/navs')}}"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>

                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>导航名称</th>
                        <th>导航别名</th>
                        <th>URL:</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr id="delNav{{$v->nav_id}}">

                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,'{{$v->nav_id}}')" name="ord[]" value="{{$v->nav_order}}">
                        </td>
                        <td class="tc">{{$v->nav_id}}</td>
                        <td>
                            <a href="#">{{$v->nav_name}}</a>
                        </td>
                        <td>
                            <a href="#">{{$v->nav_alias}}</a>
                        </td>
                        <td>{{$v->nav_url}}</td>
                        <td>
                            <a href="{{url('admin/navs/'.$v->nav_id.'/edit')}}">修改</a>
                            <a href="javascript:delNav({{$v->nav_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>


<!-----------此处可添加分页(分类一般不用添加------->




            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(obj,nav_id) {
            $.post('{{url('admin/navs/changeOrder')}}',{'_token':'{{csrf_token()}}','nav_id':nav_id,'nav_order':obj.value},function(data) {
                if(data.status == 0){
                    layer.msg(data.msg, {icon: 6});
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
        }
        //ajax删除分类
        function delNav(nav_id) {
            layer.msg('你确定要删除分类吗？', {
                btn: ['确认', '取消'],yes: function(){
                    $.post("{{url('admin/navs')}}/"+nav_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
                        if(data.status==0){
                            layer.msg(data.msg, {icon: 6});
                            $('#delNav'+nav_id).remove()
                        }else{
                            layer.msg(data.msg, {icon: 5});
                        }
                    });
                }
            });
        }

    </script>
@endsection