<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\libs\common\Utility;

class Setting extends Controller
{
    //  站点设置
    public function index()
    {
        //  获取站点信息
        $data['setting'] = DB::Table('sw_setting')->where(['name'=>'site_info'])->item();
        if($data['setting']){
            $data['setting']['value'] = \json_decode($data['setting']['value'],true);
        }
        return \view('manager.setting.index',$data);
    }

    //  保存站点设置
    public function save(Request $request)
    {
        $title = $request->title;
        $des = $request->des;
        $keywords = $request->keywords;
        $url = $request->url;
        $open_register = $request->open_register == 'on' ? 0:-1;
        $close_register_des = $request->close_register_des;
        $open_status = $request->open_status == 'on' ? 0:-1;
        $close_des = $request->close_des;

        $data = [
            'title' => $title,
            'des' => $des,
            'keywords' => $keywords,
            'url' => $url,
            'open_register' => $open_register,
            'close_register_des' => $close_register_des,
            'open_status' => $open_status,
            'close_des' => $close_des,
            'update_time' => time()
        ];

        $item = DB::Table('sw_setting')->where(['name'=>'site_info'])->item();
        if($item){
            //更新操作
            DB::Table('sw_setting')->where(['name'=>'site_info'])->update(['name'=>'site_info','value'=>\json_encode($data)]);
            return Utility::msg(0,'更新成功');
        }
        $data['create_time'] = time();
        DB::Table('sw_setting')->insert(['name'=>'site_info','value'=>\json_encode($data)]);
        return Utility::msg(0,'保存成功');
    }
}
