
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
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
        <label class="layui-form-label required">菜单名称</label>
        <div class="layui-input-block">
            <input type="text" name="title" lay-verify="required" lay-reqtext="菜单名称不能为空" placeholder="请输入菜单名称" value="" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">父级菜单</label>
        <div class="layui-input-block">
          <select class="pid" name="pid" lay-verify="required">
            <option value="0">顶级栏目</option>
            @foreach ($menus as $item)
                <option value="{{$item['mid']}}">{{$item['title']}}</option>
            @endforeach
          </select>
        </div>
      </div>
    <div class="layui-form-item">
        <label class="layui-form-label">显示菜单</label>
        <div class="layui-input-block">
            <input type="checkbox" title="显示菜单" lay-skin="primary" class="layui-input" name="ishidden">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">禁用</label>
        <div class="layui-input-block">
            <input type="checkbox" title="禁用" lay-skin="primary" class="layui-input" name="status">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">控制器</label>
        <div class="layui-input-block">
            <input type="text" name="controller" placeholder="请输入控制器名称" value="" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">方法</label>
        <div class="layui-input-block">
            <input type="text" name="action" placeholder="请输入方法名称" value="" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">菜单图标</label>
        <div class="layui-input-block">
            <input type="text" name="icon" placeholder="请输入菜单图标" value="" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">打开方式</label>
        <div class="layui-input-block">
            <input type="text" name="target" placeholder="请输入打开方式" value="_self" class="layui-input">
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
        var pid = $.trim($('select[name="pid"]').val());
        var ishidden = $.trim($('input[name="ishidden"]').val());
        var status = $.trim($('input[name="status"]').val());
        var controller = $.trim($('input[name="controller"]').val());
        var action = $.trim($('input[name="action"]').val());
        var icon = $.trim($('input[name="icon"]').val());
        var target = $.trim($('input[name="target"]').val());
        var _token = $('input[name="_token"]').val();
        if(title == ''){
            return layer.alert('菜单名称不能为空',{icon:2});
        }
        //  提交后台处理
        $.post('/menu/save',$('form').serialize(),function(res){
            if(res.code < 0){
                return layer.alert(res.msg,{icon:2});
            }
            layer.msg(res.msg);
            setTimeout(function(){
                var iframeIndex = parent.layer.getFrameIndex(window.name);
                parent.layer.close(iframeIndex);
                window.parent.location.reload();
                },1000)
        },'json')
    }
</script>
</body>
</html>