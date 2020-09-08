<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\libs\common\Utility;

class Menu extends Controller
{
    //  权限菜单首页
    public function index()
    {
        return \view('manager.menu.index');
    }

    //  获取所有权限菜单
    public function all_menus()
    {
        //  获取所有有权限访问权限菜单
        $menus = DB::Table('sw_menu')->lists();
        foreach ($menus as $key => $menu) {
            //  状态
            switch ((int)$menu['status']) {
                case 0:
                    $menus[$key]['status'] = '正常';
                break;
                case -1:
                    $menus[$key]['status'] = '禁用';
                break;
                default:
                    $menus[$key]['status'] = '未知';
            }
            //  是否隐藏
            switch ((int)$menu['ishidden']) {
                case 0:
                    $menus[$key]['ishidden'] = '显示';
                break;
                case 1:
                    $menus[$key]['ishidden'] = '隐藏';
                break;
                default:
                    $menus[$key]['ishidden'] = '未知';
            }
            //  图标
            $menus[$key]['icon'] = '<i class="'.$menu['icon'].'"></i>';
        }
        return Utility::dataMsg(0, '', \count($menus), $menus);
    }

    //  权限树所需内容
    public function menus_tree()
    {
        //获取所有一级菜单
        $data['pmenus'] = DB::Table('sw_menu')->where(['pid'=>0,'status'=>0])->lists();
        //获取所有菜单
        $data['menus'] = DB::Table('sw_menu')->where(['status'=>0])->lists();
        foreach($data['pmenus'] as $key => $value){
            $data['pmenus'][$key]['list'] = [];
            foreach($data['menus'] as $k => $v){
                if($value['mid'] == $v['pid']){
                    if(!empty($v)){
                        $data['pmenus'][$key]['list'][] = $v;
                    }
                }
            } 
        }
        //二级栏目
        foreach($data['pmenus'] as $key => $val){
            if(!empty($val['list'])){
                foreach($val['list'] as $k => $v){
                    $data['pmenus'][$key]['list'][$k]['list'] = [];
                    foreach($data['menus'] as $ak => $av){
                        if($v['mid'] == $av['pid']){
                            $data['pmenus'][$key]['list'][$k]['list'][] = $av;
                        }
                    }
                }
            }
        }
        //  返回数据
        return Utility::dataMsg(0,'',\count($data['pmenus']),$data['pmenus']);
    }


    //  新增权限菜单
    public function add()
    {
        $data['menus'] = DB::Table('sw_menu')->lists();
        return \view('manager.menu.add', $data);
    }

    //  写入权限菜单到数据库
    public function save(Request $request)
    {
        $mid = $request->mid;
        $title = trim($request->title);
        $pid = (int)trim($request->pid);
        $ishidden = trim($request->ishidden) == 'on' ? 0 : 1;
        $status = trim($request->status) == 'on' ? -1 : 0;
        $controller = trim($request->controller);
        $action = trim($request->action);
        $icon = trim($request->icon);
        $target = trim($request->target);
        //  判断数据
        if ($title == '') {
            return Utility::msg(-1, '菜单标题不得为空');
        }
        //  组装数据
        $data = [
            'title' => $title,
            'pid' => $pid,
            'ishidden' => $ishidden,
            'status' => $status,
            'controller' => $controller,
            'action' => $action,
            'icon' => $icon,
            'target' => $target,
            'update_time' => time()
        ];
        if ((int)$mid > 0) {
            //  修改操作
            DB::Table('sw_menu')->where(['mid'=>$mid])->update($data);
            return Utility::msg(0,'修改成功');
        }
        //  新增操作,所以需要新增时间
        $data['create_time'] = time();
        //  查看同是否重复添加
        $menu = DB::Table('sw_menu')->where(['pid'=>$pid,'title'=>$title])->item();
        if ($menu) {
            return Utility::msg(-1, '栏目已经存在，请勿重复添加');
        }

        DB::Table('sw_menu')->insert($data);
        return Utility::msg(0, '添加成功');
    }

    //  编辑权限菜单
    public function edit(Request $request)
    {
        $mid = $request->mid;
        //  获取权限菜单内容
        $data['menu'] = DB::Table('sw_menu')->where(['mid'=>$mid])->item();
        //  获取所有菜单
        $data['menus'] = DB::Table('sw_menu')->where(['status'=>0])->lists();
        return \view('manager.menu.edit', $data);
    }

    //  禁用权限菜单
    public function disable(Request $request)
    {
        $mid = $request->mid;
        DB::Table('sw_menu')->where(['mid'=>$mid])->update(['status'=>-1,'update_time'=>time()]);
        return Utility::msg(0,'禁用成功');
    }

    //  启用权限菜单
    public function enable(Request $request)
    {
        $mid = $request->mid;
        DB::Table('sw_menu')->where(['mid'=>$mid])->update(['status'=>0,'update_time'=>time()]);
        return Utility::msg(0,'启用成功');
    }


}
