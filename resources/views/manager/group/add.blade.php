
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/plugins/layui/css/layui.css">
    <script src="/plugins/layui/layui.js"></script>
    <title>新增权限组</title>
</head>
<body style="padding: 10px">
    <form class="layui-form">
        @csrf
        <div class="layui-form-item">
            <label for="" class="layui-form-label">角色名称</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="title">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" title="禁用"  lay-skin="primary" class="layui-input" name="status">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="" class="layui-form-label">拥有权限</label>
            <div class="layui-input-block">
                <div id="LAY-auth-tree-index"></div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" type="button" onclick="save()">保存</button>
            </div>
        </div>
    </form>
    

    <script>
        layui.config({
            base: '/plugins/layui/extends/authtree/',
        }).extend({
            authtree: 'authtree',
        });
        layui.use(['form','jquery','layer','authtree'],function(){
            form = layui.form;
            $ = layui.jquery;
            layer = layui.layer;
            authtree = layui.authtree;


            //  ajax获取远程权限表
            $.get('/menu/menus_tree',function(res){
                var data = res.data;
                console.log(data);
                
                authtree.render('#LAY-auth-tree-index', data,{
                    inputname: 'rights[]', 
                    layfilter: 'lay-check-auth', 
                    autowidth: true,
                    nameKey: 'title',
                    valueKey: 'mid',
                    theme: 'auth-skin-universal',
                    themePath: '/plugins/layui/extends/authtree/tree_themes/'
                });
            },'json')


        });


            //提交数据
            function save()
            {
                var title = $.trim($('input[name="title"]').val());
                if(title == ''){
                    return layer.alert('权限组名称不能为空',{icon:2});
                }
                var data = $('form').serialize();
                //  提交数据给后台
                $.post('/group/save',data,function(res){
                    if(res.code < 0){
                        return layer.alert(res.msg,{icon:2});
                    }
                    layer.msg(res.msg);
                    setTimeout(function(){
                        var iframeIndex = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(iframeIndex);
                        window.parent.location.reload();
                    },1000);
                },'json');
            }




        









    </script>
</body>
</html>