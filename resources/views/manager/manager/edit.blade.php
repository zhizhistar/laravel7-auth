
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>新增管理员</title>
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
        <label class="layui-form-label required">管理员名称</label>
        <div class="layui-input-block">
            <input type="text" name="name" value="{{$manager['name']}}" lay-verify="required" lay-reqtext="管理员名称不能为空" placeholder="请输入管理员名称" value="" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">权限组</label>
        <div class="layui-input-block">
          <select class="gid" name="gid" lay-verify="required">
            @foreach ($group as $item)
                <option value="{{$item['gid']}}" {{$manager['gid']==$item['gid']?'selected':''}}>{{$item['title']}}</option>
            @endforeach
          </select>
        </div>
      </div>
    <div class="layui-form-item">
        <label class="layui-form-label">登录密码</label>
        <div class="layui-input-block">
            <input type="text" placeholder="不修改请留空"  class="layui-input" name="password">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">邮箱号码</label>
        <div class="layui-input-block">
            <input type="email" value="{{$manager['email']}}" placeholder="请输入邮箱号码" class="layui-input" name="email">
        </div>
    </div>

    <input type="hidden" name="id" value="{{$manager['id']}}">


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
        var name = $.trim($('input[name="name"]').val());
        var gid = $.trim($('select[name="gid"]').val());
        var password = $.trim($('input[name="password"]').val());
        var email = $.trim($('input[name="email"]').val());
        var _token = $('input[name="_token"]').val();
        if(name == ''){
            return layer.alert('登陆名称不能为空',{icon:2});
        }
        if(gid == ''){
            return layer.alert('用户权限组不能为空',{icon:2});
        }
        if(email == ''){
            return layer.alert('邮箱不能为空',{icon:2});
        }
        //  提交后台处理
        $.post('/manager/save',$('form').serialize(),function(res){
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