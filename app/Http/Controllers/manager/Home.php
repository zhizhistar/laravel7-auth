<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Home extends Controller
{
    //  后台首页
    public function index()
    {
        return \view('manager.home.index');
    }

    //  获取对应的菜单
    public function init_menu(Request $request)
    {
        //  获取用户信息
        $rights = $request->user->rights;
        //  获取所有菜单
        $menus = DB::Table('sw_menu')->whereIn('mid',$rights)->where(['pid'=>0,'status'=>0,'ishidden'=>0])->lists();
        //  获取子菜单
        foreach($menus as $key => $menu){
            //  地址
            $childs = DB::Table('sw_menu')->whereIn('mid',$rights)->where(['pid'=>$menu['mid'],'ishidden'=>0])->lists();
            foreach($childs as $k => $val){
                $childs[$k]['href'] = '/'. strtolower($val['controller']).'/'.$val['action'];
                $childss = DB::Table('sw_menu')->whereIn('mid',$rights)->where(['pid'=>$val['mid'],'ishidden'=>0])->lists();
                $childs[$k]['child'] = $childss;
            }
            $menus[$key]['child'] = $childs;
        }
        $data = [
            "homeInfo" => [
                "title"=> "首页",
                "href"=> "/home/welcome"
            ],
            "logoInfo" => [
                "title"=> "LAYUI MINI",
                "image"=> "/plugins/layuimini-2/images/logo.png",
                "href"=> ""
            ],
            "menuInfo" => $menus
        ];
        return \json_encode($data);
    }

    //  后台首页欢迎页面
    public function welcome()
    {
        return \view('manager.home.welcom');
    }
}
