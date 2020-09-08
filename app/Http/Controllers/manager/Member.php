<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Member extends Controller
{
    // 会员列表
    public function index(Request $request)
    {
        if($request->ajax()){

        }
        //  实例化页面
        return \view('manager.member.index');
    }
}
