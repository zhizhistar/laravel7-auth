
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>权限分组</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/plugins/layuimini-2/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/plugins/layuimini-2/css/public.css" media="all">
</head>
<body>
<div class="layuimini-container">
    <div class="layuimini-main">


        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container">
                <button class="layui-btn layui-btn-normal layui-btn-sm data-add-btn" lay-event="create"> 新增权限组 </button>
            </div>
        </script>

        <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

        <script type="text/html" id="currentTableBar">
            <a class="layui-btn layui-btn-normal layui-btn-xs data-count-edit" lay-event="edit">编辑</a>
            @{{#  if(d.status == '正常'){ }}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="disable">禁用</a>
            @{{#  } else { }}
            <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="enable">启用</a>
            @{{#  } }}
        </script>

    </div>
</div>
<script src="/plugins/layuimini-2/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>
<script>
    layui.use(['form', 'table'], function () {
        var $ = layui.jquery,
            form = layui.form,
            table = layui.table;

        table.render({
            elem: '#currentTableId',
            url: '/group/all_group',
            toolbar: '#toolbarDemo',
            defaultToolbar: ['filter', 'exports', 'print', {
                title: '提示',
                layEvent: 'LAYTABLE_TIPS',
                icon: 'layui-icon-tips'
            }],
            cols: [[
                {type: "checkbox", width: 50},
                {field: 'gid', width: 80, title: 'GID', sort: true},
                {field: 'title', width: 160, title: '权限组名称'},
                {field: 'status', width: 80, title: '状态', sort: true},
                {title: '操作', minWidth: 150, toolbar: '#currentTableBar', align: "center"}
            ]],
            limits: [10, 15, 20, 25, 50, 100],
            limit: 15,
            page: true,
            skin: 'line'
        });


        /**
         * toolbar监听事件
         */
        table.on('toolbar(currentTableFilter)', function (obj) {
            if (obj.event === 'create') {  // 监听添加操作
                var index = layer.open({
                    title: '添加权限组',
                    type: 2,
                    shade: 0.2,
                    maxmin:true,
                    shadeClose: true,
                    area: ['90%', '90%'],
                    content: '/group/add',
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
            } else if (obj.event === 'disable') {  // 监听删除操作
            alert('aaaa');
                var checkStatus = table.checkStatus('currentTableId')
                    , data = checkStatus.data;
                layer.alert(JSON.stringify(data));
            }
        });


        table.on('tool(currentTableFilter)', function (obj) {
            var data = obj.data;
            if (obj.event === 'edit') {

                
                var index = layer.open({
                    title: '编辑权限组',
                    type: 2,
                    shade: 0.8,
                    maxmin:true,
                    shadeClose: true,
                    area: ['90%', '90%'],
                    content: '/group/edit?gid='+data.gid,
                });
                $(window).on("resize", function () {
                    layer.full(index);
                });
                return false;
            } else if (obj.event === 'disable') {
                layer.confirm('您确定要禁用权限组吗？', function (index) {
                    $.get('/group/disable',{'gid':obj.data.gid},function(res){
                        if(res.code < 0){
                            return layer.alert(res.msg,{icon:2});
                        }
                        layer.msg(res.msg);
                        setTimeout(function(){window.location.reload()},1000);
                    },'json');
                });
            } else if (obj.event === 'enable') {
                layer.confirm('您确定要启用权限组吗？', function (index) {
                    $.get('/group/enable',{'gid':obj.data.gid},function(res){
                        if(res.code < 0){
                            return layer.alert(res.msg,{icon:2});
                        }
                        layer.msg(res.msg);
                        setTimeout(function(){window.location.reload()},1000);
                    },'json');
                });
            }
        });

    });
</script>

</body>
</html>