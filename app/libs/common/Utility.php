<?php

namespace App\libs\common;

class Utility
{
    /**
     * 返回正常的JSON消息给前端
     *
     * @param integer $code
     * @param string $msg
     * @return void
     */
    public static function msg(int $code, string $msg)
    {
        return response()->json(['code'=>$code,'msg'=>$msg]);
    }

    public static function dataMsg(int $code, string $msg, int $count, array $data){
        return response()->json(['code'=>$code,'msg'=>$msg,'count'=>$count,'data'=>$data]);
    }
}