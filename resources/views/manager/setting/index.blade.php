
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>站点设置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/plugins/layuimini-2/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/plugins/layuimini-2/css/public.css" media="all">
    <style>
        body {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
<div class="layui-form layuimini-form">
    <form name="add-menu">
        @csrf
    <div class="layui-form-item">
        <label class="layui-form-label required">站点名称</label>
        <div class="layui-input-block">
            <input value="{{$setting['value']['title']}}" type="text" name="title" placeholder="请输入站点名称"  class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">站点描述</label>
        <div class="layui-input-block">
          <textarea class="layui-textarea" name="des" placeholder="请输入站点描述，针对于搜索引擎SEO优化，推荐200字以内">{{$setting['value']['des']}}</textarea>
        </div>
      </div>
    <div class="layui-form-item">
        <label class="layui-form-label">关键词</label>
        <div class="layui-input-block">
            <input value="{{$setting['value']['keywords']}}" type="text" placeholder="请输入站点关键词，针对于搜索引擎SEO优化，用小写,隔开" lay-skin="primary" class="layui-input" name="keywords">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">站点URL</label>
        <div class="layui-input-block">
            <input type="text" value="{{$setting['value']['url']}}" placeholder="不需要加http://，如：www.baidu.com" lay-skin="primary" class="layui-input" name="url">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开放注册</label>
        <div class="layui-input-block">
            @if ($setting['value']['open_register'] == 0)
            <input type="checkbox" name="open_register" lay-skin="switch" lay-text="开放注册|关闭注册" checked>
            @else
            <input type="checkbox" name="open_register" lay-skin="switch" lay-text="开放注册|关闭注册">
            @endif
            
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">关闭注册说明</label>
        <div class="layui-input-block">
            <textarea  type="text" name="close_register_des" placeholder="关闭对外注册之后，对外的提示信息" class="layui-textarea">{{$setting['value']['close_register_des']}}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">对外访问</label>
        <div class="layui-input-block">
            @if ($setting['value']['open_status'] == 0)
            <input type="checkbox" name="open_status" lay-skin="switch" lay-text="允许访问|关闭访问" checked>
            @else
            <input type="checkbox" name="open_status" lay-skin="switch" lay-text="允许访问|关闭访问">
            @endif
            
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">关站说明</label>
        <div class="layui-input-block">
            <textarea type="text" name="close_des" placeholder="关闭对外访问之后，对外的提示信息" class="layui-textarea">{{$setting['value']['close_des']}}</textarea>
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn layui-btn-normal" type="button" onclick="save()">确认保存</button>
        </div>
    </div>
    </form>
</div>
</div>
<script src="/plugins/layuimini-2/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>
<script>
    layui.use(['form'], function () {
            form = layui.form,
            layer = layui.layer,
            $ = layui.$;
    });

    //确定新增
    function save()
    {
        var title = $.trim($('input[name="title"]').val());
        var des = $.trim($('textarea[name="des"]').val());
        var keywords = $.trim($('input[name="keywords"]').val());
        var url = $.trim($('input[name="url"]').val());
        var open_register = $.trim($('input[name="open_register"]').val());
        var close_register_des = $.trim($('input[name="close_register_des"]').val());
        var open_status = $.trim($('input[name="open_status"]').val());
        var close_des = $.trim($('input[name="close_des"]').val());
        var _token = $('input[name="_token"]').val();
        //  提交后台处理
        $.post('/setting/save',$('form').serialize(),function(res){
            if(res.code < 0){
                return layer.alert(res.msg,{icon:2});
            }
            layer.msg(res.msg);
            setTimeout(function(){  
                window.location.reload();
                },1000)
        },'json')
    }
</script>
</body>
</html>