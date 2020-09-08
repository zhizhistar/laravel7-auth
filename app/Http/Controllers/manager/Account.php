<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\libs\common\Utility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Account extends Controller
{
    //  管理员登陆
    public function login()
    {
        return \view('manager.account.login');
    }

    //  员工登陆验证
    public function check(Request $request)
    {
        $name = $request->name;
        $password = $request->password;
        if($name == ''){
            return Utility::msg(-1,'登陆名称不得为空');
        }
        if($password == ''){
            return Utility::msg(-1,'登陆密码不得为空');
        }
        //  查询用户名、密码是否相符合
        $res = Auth::attempt(['name'=>$name,'password'=>$password,'status'=>0]);
        //  判断是否登陆成功
        if(!$res){
            return Utility::msg(-1,'登录名或者密码错误');
        }
        return Utility::msg(0,'登陆成功，即将跳转到后台首页');
    }

    //  员工注册通道
    public function register()
    {
        return \view('manager.account.register');
    }

    //  保存员工信息
    public function save(Request $request)
    {
        //  获取所有提交所需信息
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $repassword = $request->repassword;
        //  判断信息是否符合要求
        if($name == ''){
            return Utility::msg(-1,'登陆名称不得为空');
        }
        if($email == ''){
            return Utility::msg(-1,'登陆邮箱不得为空');
        }
        if($password == ''){
            return Utility::msg(-1,'登陆密码不得为空');
        }
        if($repassword == ''){
            return Utility::msg(-1,'请再次输入登陆密码');
        }
        if($password != $repassword){
            return Utility::msg(-1,'两次密码输入不一致，请检查后重新输入');
        }
        //  判断用户名是否被注册
        $info = DB::Table('sw_manager')->where(['name'=>$name])->item();
        if(!empty($info)){
            return Utility::msg(-1,'用户名已被注册，请更换后重试');
        }
        //  判断邮箱是否被注册
        $info = DB::Table('sw_manager')->where(['email'=>$email])->item();
        if(!empty($info)){
            return Utility::msg(-1,'用户邮箱已被使用，请联系管理员');
        }
        //  处理密码加密
        $password = Hash::make($password);
        //  组装数据
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'create_time' => time(),
            'update_time' => time()
        ];
        //  写入数据库
        DB::table('sw_manager')->insert($data);
        return Utility::msg(0,'注册成功，即将跳入登陆页面');
        
    }

    //  退出登录
    public function logout()
    {
        Auth::logout();
        return Utility::msg(0,'退出成功！');
    }
}
