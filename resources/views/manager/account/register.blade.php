<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>员工注册通道</title>
    <link rel="stylesheet" href="/plugins/layui/css/layui.css">
    <script src="/plugins/layui/layui.js"></script>
    <style>
        body{
            width: 100vw;
            height: 100vh;
            margin: 0;
            padding: 0;
            outline: 1px dashed red;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .container{
            width: 50%;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            box-sizing: border-box;

        }
        .container .title{
            display: flex;
            justify-content: center;
            padding: 10px;
            box-sizing: border-box;
            border-bottom: 1px solid #ccc;
            margin: 0 0 20px 0;
        }
        .container .title span{
            font-size: 1.3rem;
            font-weight: bold;
        }
        @media screen and (max-width: 1080px) {
                .container {
                    width: 90%;
                }
            }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            <span>员工注册</span>
        </div>
        <div class="container-box">
            <form class="layui-form">
                @csrf
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">登录名称</label>
                    <div class="layui-input-block">
                        <input type="text" class="layui-input" name="name" placeholder="请输入登陆名称" />
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">登录邮箱</label>
                    <div class="layui-input-block">
                        <input type="email"" class="layui-input" name="email" placeholder="请输入企业邮箱" />
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">登陆密码</label>
                    <div class="layui-input-block">
                        <input type="password" class="layui-input" name="password" placeholder="请输入登陆密码" />
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">重复密码</label>
                    <div class="layui-input-block">
                        <input type="password" class="layui-input" name="repassword" placeholder="请再次输入登陆密码" />
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn layui-btn-normal" onclick="save()">立即注册</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<script>
    layui.use(['layer','jquery'],function(){
        layer = layui.layer;
        $ = layui.jquery;
    })
    //  员工注册
    function save()
    {
        if($('input[name="name"]').val() == ''){
            return layer.alert('登陆名称不可为空',{icon:2});
        }
        if($('input[name="email"]').val() == ''){
            return layer.alert('登陆邮箱不可为空',{icon:2});
        }
        if($('input[name="password"]').val() == ''){
            return layer.alert('登陆密码不可为空',{icon:2});
        }
        if($('input[name="repassword"]').val() == ''){
            return layer.alert('请再次输入登陆密码',{icon:2});
        }
        if($('input[name="password"]').val() != $('input[name="repassword"]').val()){
            return layer.alert('两次输入密码不一致',{icon:2});
        }
        var data = {};
        data.name = $('input[name="name"]').val();
        data.email = $('input[name="email"]').val();
        data.password = $('input[name="password"]').val();
        data.repassword = $('input[name="repassword"]').val();
        data._token = $('input[name="_token"]').val();

        $.post('/account/save',data,function(res){
            if(res.code < 0){
                return layer.alert(res.msg,{icon:2});
            }
            layer.msg(res.msg);
            setTimeout(function(){window.location.href="/account/login"},1000);
        },'json');

    }
</script>