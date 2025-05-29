<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

/**
 * 模型搜索基类
 */
trait BaseFilter{

    public function fullImage(): Attribute{
        return Attribute::make(
            get: fn(string|null $value, array $data) => Str::contains($data['image'], '//') ? $data['image'] : Storage::disk('admin')->url($data['image']),
        );
    }

    public function fullImages(): Attribute{
        return Attribute::make(
            get: fn (string|null $value, array $data) => array_map(function ($image) {
                    return Str::contains($image, '//') ? $image : Storage::disk('admin')->url($image);
                }, comma_str_to_array($data['images'])),
        );
    }

    public function images(): Attribute{
        return Attribute::make(
            get: fn (string|null $value) => comma_str_to_array($value),
        );
    }

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