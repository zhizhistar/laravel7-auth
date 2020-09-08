<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//员工登陆注册相关
Route::get('account/register','manager\Account@register');
Route::get('account/login','manager\Account@login')->name('login');
Route::get('account/logout','manager\Account@logout');
Route::post('account/save','manager\Account@save');
Route::post('account/check','manager\Account@check');


Route::namespace('manager')->middleware(['auth','rights'])->group(function(){
    //后台相关
    Route::get('manager/main','Home@index');
    Route::get('manager/init_menu','Home@init_menu');
    Route::get('home/welcome','Home@welcome');

    //权限菜单相关
    Route::get('menu/index','Menu@index');
    Route::get('menu/all_menus','Menu@all_menus');
    Route::get('menu/add','Menu@add');
    Route::post('menu/save','Menu@save');
    Route::get('menu/edit','Menu@edit');
    Route::get('menu/disable','Menu@disable');
    Route::get('menu/enable','Menu@enable');
    Route::get('menu/menus_tree','Menu@menus_tree');

    //权限分组相关
    Route::get('group/index','Group@index');
    Route::get('group/all_group','Group@all_group');
    Route::get('group/add','Group@add');
    Route::get('group/edit','Group@edit');
    Route::post('group/save','Group@save');
    Route::get('group/disable','Group@disable');
    Route::get('group/enable','Group@enable');

    //管理员管理
    Route::get('manager/index','Manager@index');
    Route::get('manager/add','Manager@add');
    Route::post('manager/save','Manager@save');
    Route::get('manager/edit','Manager@edit');
    Route::get('manager/disable','Manager@disable');
    Route::get('manager/enable','Manager@enable');

    //站点设置
    Route::get('setting/index','Setting@index');
    Route::post('setting/save','Setting@save');

});


