
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>权限菜单</title>
    <link rel="stylesheet" href="/plugins/layuimini-2/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/plugins/layuimini-2/css/public.css" media="all">
    <link rel="stylesheet" href="/plugins/layuimini-2/lib/font-awesome-4.7.0/css/font-awesome.min.css" media="all">
    <style>
        .layui-btn:not(.layui-btn-lg ):not(.layui-btn-sm):not(.layui-btn-xs) {
            height: 34px;
            line-height: 34px;
            padding: 0 8px;
        }
    </style>
</head>
<body>
<div class="layuimini-container">
    <div class="layuimini-main">
        <div>
            <div class="layui-btn-group">
                <button class="layui-btn" id="create">新增菜单</button>
            </div>
            <table id="munu-table" class="layui-table" lay-filter="munu-table"></table>
        </div>
    </div>
</div>
<!-- 操作列 -->
<script type="text/html" id="auth-state">
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">修改</a>
    @{{#  if(d.status == '正常'){ }}
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="disable">禁用</a>
    @{{#  } else { }}
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="enable">启用</a>
    @{{#  } }}
    
</script>

<script src="/plugins/layuimini-2/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>
<script src="/plugins/layuimini-2/js/lay-config.js?v=1.0.4" charset="utf-8"></script>
<script>
    layui.use(['table', 'treetable'], function () {
        var $ = layui.jquery;
        var table = layui.table;
        var treetable = layui.treetable;

        // 渲染表格
        layer.load(2);
        treetable.render({
            treeColIndex: 1,
            treeSpid: 0,
            isPidData: true,
            treeIdName: 'mid',
            treePidName: 'pid',
            elem: '#munu-table',
            url: '/menu/all_menus',
            page: false,
            cols: [[
                {type: 'numbers'},
                {field: 'title', minWidth: 200, title: '权限名称'},
                {field: 'icon', width: 80, title: '图标'},
                {field: 'status', width: 80, title: '状态'},
                {field: 'ishidden', width: 120, title: '是否隐藏'},
                {field: 'controller', width: 100, title: '控制器'},
                {field: 'action', width: 140, align: 'center', title: '方法'},
                {templet: '#auth-state', width: 120, align: 'center', title: '操作'}
            ]],
            done: function () {
                layer.closeAll('loading');
            }
        });

        $('#create').click(function () {
            layer.open({
                type: 2,
                title: '新增权限菜单',
                shadeClose: true,
                shade: 0.8,
                area: ['90%', '90%'],
                content: '/menu/add'
            });
        });


        //监听工具条
        table.on('tool(munu-table)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;

            if (layEvent === 'disable') {
                layer.confirm('您确定要禁用该权限菜单？', {
                    btn: ['确定','取消'] //按钮
                    }, function(){
                        var info = {};
                        info.mid = data.mid;
                        $.get('/menu/disable',info,function(res){
                            if(res.code < 0){
                                return layer.alert(res.msg,{icon:2});
                            }
                            layer.msg(res.msg);
                            setTimeout(function(){window.location.reload()},1000)
                        },'json')
                    }, function(){
                        
                    });
            } else if (layEvent === 'edit') {
                layer.open({
                    type: 2,
                    title: '修改权限菜单',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['90%','90%'],
                    content: '/menu/edit?mid='+data.id
                });
            }else if(layEvent === 'enable') {
                layer.confirm('您确定要启用该权限菜单？', {
                    btn: ['确定','取消'] //按钮
                    }, function(){
                        var info = {};
                        info.mid = data.mid;
                        $.get('/menu/enable',info,function(res){
                            if(res.code < 0){
                                return layer.alert(res.msg,{icon:2});
                            }
                            layer.msg(res.msg);
                            setTimeout(function(){window.location.reload()},1000)
                        },'json')
                    }, function(){
                        
                    });
            }
        });
    });
</script>
</body>
</html>