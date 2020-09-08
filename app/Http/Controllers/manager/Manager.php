<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\libs\common\Utility;

class Manager extends Controller
{
    //  所有管理员
    public function index(Request $request)
    {
        if($request->ajax()){
            //  获取所有管理员
            $manager = DB::Table('sw_manager')->lists();
            //  获取权限组
            $group = DB::Table('sw_group')->lists();
            //  格式化数据
            foreach($manager as $key => $val){
                //  权限组
                foreach($group as $k => $v){
                    if($val['gid'] == $v['gid']){
                        $manager[$key]['gid'] = $v['title'];
                    }
                }
                //  状态
                switch($manager[$key]['status']){
                    case 0:
                        $manager[$key]['status'] = '正常';
                    break;
                    case 1:
                        $manager[$key]['status'] = '禁用';
                    break;
                    default:
                    $manager[$key]['status'] = '未知错误';
                }
            }
            //  返回数据给前台
            return Utility::dataMsg(0,'',\count($manager),$manager);
        }
        //  渲染视图
        return \view('manager.manager.index');
    }

    //  新增管理员
    public function add()
    {
        //  获取权限组
        $data['group'] = DB::Table('sw_group')->where(['status'=>0])->lists();
        return \view('manager.manager.add',$data);
    }

    //  保存管理员
    public function save(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $password = $request->password;
        $email = $request->email;
        $gid = $request->gid;
        //  判断
        if($name == ''){
            return Utility::msg(-1,'登陆名称不得为空');
        }
        if($email == ''){
            return Utility::msg(-1,'邮箱不得为空');
        }
        if($gid == ''){
            return Utility::msg(-1,'用户组不得为空');
        }
        //  组装数据
        $data = [
            'name' => $name,
            'email' => $email,
            'gid' => $gid,
            'update_time' => time()
        ];
        if((int)$id > 0){
            //  更新操作  
            if(!($password == '')){
                $data['password'] = Hash::make($password);
            }
            DB::Table('sw_manager')->where(['id'=>$id])->update($data);
            return Utility::msg(0,'编辑成功');
        }
        $data['password'] = Hash::make($password);
        $data['create_time'] = time();
        //  判断管理员名称是否存在
        $name_info = DB::Table('sw_manager')->where(['name'=>$name])->item();
        //  判断管理员邮箱是否被使用
        $email_info = DB::Table('sw_manager')->where(['email'=>$email])->item();
        if($name_info){
            return Utility::msg(-1,'用户名已被使用');
        }
        if($email_info){
            return Utility::msg(-1,'邮箱已被使用');
        }
        //  写入数据库
        DB::Table('sw_manager')->insert($data);
        return Utility::msg(0,'新增成功');
    }


    //  编辑管理员
    public function edit(Request $request)
    {
        $uid = $request->uid;
        //  获取对应管理员信息
        $data['manager'] = DB::Table('sw_manager')->where(['id'=>$uid])->item();
        //  获取所有的权限组
        $data['group'] = DB::Table('sw_group')->lists();
        return \view('manager.manager.edit',$data);
    }

    //  禁用管理员
    public function disable(Request $request)
    {
        $id = $request->uid;
        DB::Table('sw_manager')->where(['id'=>$id])->update(['status'=>-1,'update_time'=>time()]);
        return Utility::msg(0,'禁用成功');
    }

    //  启用管理员
    public function enable(Request $request)
    {
        $id = $request->uid;
        DB::Table('sw_manager')->where(['id'=>$id])->update(['status'=>0,'update_time'=>time()]);
        return Utility::msg(0,'启用成功');
    }
}
