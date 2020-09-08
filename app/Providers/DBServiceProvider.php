<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder as QueryBuilder;

class DBServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //  获取单条数据转换为数组
        QueryBuilder::macro('item',function(){
            $data = $this->first();
            $data = (array) $data;
            return $data;
        });

        //  获取多条数据转换为数组
        QueryBuilder::macro('lists',function(){
            $data = $this->get()->toArray();
            $result = [];
            foreach($data as $val){
                $result[] = (array)$val;
            }
            return $result;
        });
    }
}
