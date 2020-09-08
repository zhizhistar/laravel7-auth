<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Closure;

class RightValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //  用户信息
        $user = Auth::user();
        //  当前用户GID
        $gid = $user->gid;
        //  获取当前用户的权限列表
        $group = DB::Table('sw_group')->where(['gid'=>$gid])->item();
        //  判断权限分组是否存在
        if(!$group){
            \response('权限组不存在',200);
        }
        $rights = $group['rights'];
        //  转为数组
        if($rights){
            $rights = \json_decode($rights,true);
        }
        //  当前访问的菜单
        $menu = $request->route()->action['controller'];
        $menu = \explode('\\',$menu);
        $menu = $menu[\count($menu) - 1];
        $menu = \explode('@',$menu);
        //  数据库查找对应的菜单
        $cur_menu = DB::Table('sw_menu')->where(['controller'=>$menu['0'],'action'=>$menu['1']])->item();
        if(!$cur_menu){
            return $this->_norights($request,-1,'访问的功能不存在',200);
        }
        if($cur_menu['status'] == -1){
            return $this->_norights($request,-1,'该功能已被禁用',200);
        }
        if(!\in_array($cur_menu['mid'],$rights)){
            return $this->_norights($request,-1,'权限不足',200);
        }
        $user->rights = $rights;
        $user->group_title = $group['title'];
        $request->user = $user;
        return $next($request);
    }





    private function _norights($request,$code,$msg,$state)
    {
        if($request->ajax()){
            return \response(\json_encode(['code'=>$code,'msg'=>$msg]),$state);
        }
        return \response($msg,$state);
    }
}
