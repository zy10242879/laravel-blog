@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;编辑文章信息
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>文章管理</h3>
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
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
    </div>

    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/article/'.$input->art_id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th>编辑者：</th>
                    <td>
            <input type="text" class="sm" name="art_editor" value="{{$input->art_editor}}">
                    </td>
                </tr>
                    <tr>
                        <th width="120"><i class="require">*</i>分类：</th>
                        <td>
                            <select name="cate_id">
                                @foreach($data as $v)
                                    @if($input->cate_id==$v->cate_id)
                        <option selected value="{{$v->cate_id}}">{{$v->cate_name}}</option>
                                    @else
                        <option value="{{$v->cate_id}}">{{$v->cate_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_title" value="{{$input->art_title}}">
                        </td>
                    </tr>
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <input type="text" class="lg" name="art_tag" value="{{$input->art_tag}}">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="art_description">{{$input->art_description}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章内容：</th>
                        <td>
    <!-----------------------------使用uedit编辑器需要引入的文件---------------------------->
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>

                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                    <!---------重要：文章内容以实体方式输入出-------->
                            <script id="editor" name="art_content" type="text/plain" style="width:80%;height:200px;" >
                                    {!!$input->art_content!!}

                            </script>
                    <!------------------注意写法------------------------->
                            <script>//实例化编辑器
                            var ue = UE.getEditor('editor');
                            </script>
                    <!----------------------编辑器样式矫正------------>
                            <style>
                                .edui-default{line-height: 28px;}
                                div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow: hidden; height:20px;}
                                div.edui-box{overflow: hidden; height:22px;}
                            </style>
    <!--------------------------------------------------------------------------------->
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图:</th>
                        <td>
                            <input disabled type="text" placeholder="{{!empty($input->art_thumb)?$input->art_thumb:'图片上传必需小于2M　仅支持.jpg .jpeg .gif .png后缀文件'}}" style="width: 30%;" class="lg" name="art_thumb">
                            <!--注意：由于disabled无法提交，所以加入以下隐藏域作提交用-->
                            <input value="{{!empty($input->art_thumb)?$input->art_thumb:''}}" type="hidden"  name="art_thumb" >
                            <!------以下ajax中对以上两个标签都进行操作，故无需修改------>
    <!--------------------uploadfiy(上传文件的使用①先将uploadify放入org中)----------------------------->
                       <!------------ ②写入以下4个标签，修改引入地址 **4处@{{asset()}}** ------------->
                            <input  id="file_upload" name="file_upload" type="file" multiple="true">
                            <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                            <link rel="stylesheet" type="text/css" href="{{asset('resources/org/uploadify/uploadify.css')}}">
                            <script type="text/javascript">
                                <?php $timestamp = time();?>
                                $(function() {//③配置页面
                                    $('#file_upload').uploadify({
                                        'buttonText' : '上传图片',//-----修改点击框内容------
                                        'formData'     : {
                                            'timestamp' : '<?php echo $timestamp;?>',
                                            //修改csrf_token
                                            '_token'     : "{{csrf_token()}}"
                                        },
                            'swf'      : "{{asset('resources/org/uploadify/uploadify.swf')}}",
                        //④修改以下地址，提交到自己创建的控制器下，进行操作
                        {{--'uploader' : "{{asset('resources/org/uploadify/uploadify.php')}}",--}}
                            'uploader' : "{{asset('admin/upload')}}",//⑤route创建控制器upload及逻辑
                    //----------⑥文件上传成功后的操作---(同时可以加入文件上传失败的function())------
                            'onUploadSuccess':function (file,data,respose) {
                    //-----------------⑦重点注意：返回的不是json对象，是json字符串时的应用方式----------//
                                var json = eval('('+data+')');
                    //--------------------(以上重要)-------------------------------------------//
                                if(json.status == 0){
                                    //将路径写入缩略图文本框中 并生成图片显示
                                    $('input[name=art_thumb]').val(json.msg);
                                    $('#art_thumb_img').attr('src','/'+json.msg);
                                }else{
                                    $('input[name=art_thumb]').val('');
                                    $('input[name=art_thumb]').attr('placeholder',json.msg);
                                    $('#art_thumb_img').attr('src','');
                                }

                            }
                                    });
                                });
                            </script>
                        <!-------------点选框样式微调----------------->
                            <style>
                                .uploadify{display:inline-block;}
                                .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                                table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                            </style>
                        <!------------------------------------------>
                        </td>
                    </tr>
                    <!-----------显示上传的图片--------->
                    <tr>
                        <th></th>
                        <td><img style="max-width: 20%;max-height: 50%" id="art_thumb_img"  src="{{!empty($input->art_thumb)?'/'.$input->art_thumb:''}}" alt=""></td>
                    </tr>

                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="location='{{url('admin/article')}}'" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection