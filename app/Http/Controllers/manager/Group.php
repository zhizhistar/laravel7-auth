<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\libs\common\Utility;

class Group extends Controller
{
    //  账号分组首页
    public function index()
    {
        return \view('manager.group.index');
    }

    //  获取所有分组
    public function all_group()
    {
        $groups = DB::Table('sw_group')->lists();
        //  格式化数据
        foreach ($groups as $key => $val) {
            switch ($val['status']) {
                case 0:
                    $groups[$key]['status'] = '正常';
                break;
                case -1:
                    $groups[$key]['status'] = '禁用';
                break;
                default:
                    $groups[$key]['status'] = '未知错误';
            }
        }
        return Utility::dataMsg(0, '', \count($groups), $groups);
    }

    //  新增权限组
    public function add()
    {
        return \view('manager.group.add');
    }

    //  保存权限分组
    public function save(Request $request)
    {
        $gid = $request->gid;
        $title = $request->title;
        $rights = $request->rights;
        $status = $request->status;
        if ($title == '') {
            return Utility::msg(-1, '权限分组名称不能为空');
        }
        //  组装数据
        $data = [
            'title' => $title,
            'rights' => json_encode($rights),
            'status' => $status == 'on' ? -1:0,
            'update_time' => \time()
        ];
        if ((int)$gid > 0) {
            //  更新操作
            DB::Table('sw_group')->where(['gid'=>$gid])->update($data);
            return Utility::msg(0,'修改成功');
        }
        //  新增操作，需要新增时间
        $data['create_time'] = time();
        //  查看是否存在
        $info = DB::Table('sw_group')->where(['title'=>$title])->item();
        if ($info) {
            return Utility::msg(-1, '权限分组已经存在');
        }

        DB::Table('sw_group')->insert($data);
        return Utility::msg(0, '新增成功');
    }

    //  修改权限组
    public function edit(Request $request)
    {
        $gid = (int)$request->gid;
        //  获取权限组数据
        $data['group'] = DB::Table('sw_group')->where(['gid'=>$gid])->item();
        if ($request->ajax()) {
            $gid = (int)$request->gid;
            //  获取权限组数据
            $data['group'] = DB::Table('sw_group')->where(['gid'=>$gid])->item();
            //  获取所有菜单
            $all_menus = DB::Table('sw_menu')->lists();
            //  获取所有一级菜单
            $data['pmenu'] = DB::Table('sw_menu')->where(['pid'=>0])->lists();
            //  该权限组拥有的菜单
            $rights = json_decode($data['group']['rights'], true);
            //  判断是否为数组
            if(!\is_array($rights)){
                $rights = [];
            }
            //  循环，获取拥有的权限，默认选中,二级栏目
            foreach ($data['pmenu'] as $key => $val) {
                $data['pmenu'][$key]['list'] = [];
                if (\in_array($val['mid'], $rights) && !empty($rights)) {
                    $data['pmenu'][$key]['checked'] = true;
                }
                foreach ($all_menus as $k => $v) {
                    if (\in_array($v['mid'], $v) && !empty($rights)) {
                        $v['checked'] = true;
                    }
                    if ($v['pid'] == $val['mid']) {
                        $data['pmenu'][$key]['list'][] = $v;
                    }
                }
            }
            //  循环，获取拥有的权限，默认选中,三级栏目
            foreach ($data['pmenu'] as $key => $val) {
                if (!empty($val['list'])) {
                    foreach ($val['list'] as $k => $v) {
                        if (\in_array($v['mid'], $rights)) {
                            $val['list'][$k]['checked'] = true;
                        }
                        $data['pmenu'][$key]['list'][$k]['list'] = [];
                        foreach ($all_menus as $ak => $av) {
                            if ($v['mid'] == $av['pid']) {
                                if (\in_array($av['mid'], $rights)) {
                                    $av['checked'] = true;
                                }
                                $data['pmenu'][$key]['list'][$k]['list'][] = $av;
                            }
                        }
                    }
                }
            }
            return Utility::dataMsg(0, '', \count($data), $data['pmenu']);
        }
        return \view('manager.group.edit', $data);
    }

    //  禁用权限组
    public function disable(Request $request)
    {
        $gid = $request->gid;
        DB::Table('sw_group')->where(['gid'=>$gid])->update(['status'=>-1,'update_time'=>time()]);
        return Utility::msg(0,'禁用成功');
    }

        //  启用权限组
        public function enable(Request $request)
        {
            $gid = $request->gid;
            DB::Table('sw_group')->where(['gid'=>$gid])->update(['status'=>0,'update_time'=>time()]);
            return Utility::msg(0,'启用成功');
        }
}
