<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * 模型搜索基类
 */
trait BaseFilter{
    /**
     * 用于参数不稳定的筛选情况
     *
     * @param Builder $builder
     * @param array $params
     * @return void
     */
    public function scopeApply(Builder $builder, array $params){
        foreach($params as $field_name=> $value){
            if(method_exists($this, 'scope' . ucfirst($field_name))){
                call_user_func_array([$builder, $field_name], array_filter([$value]));
            }
        }
        return $builder;
    }

    /**
     * 分页查询
     *
     * @param Builder $builder
     * @param integer $page
     * @param integer $limit
     * @return void
     */
    public function scopePage(Builder $builder, int $page, int $limit){
        return $builder->offset(($page - 1) * $limit)->limit($limit);
    }
}