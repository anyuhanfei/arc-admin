<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 用户资金表数据模型
 */
class UserBalances extends Model{
    public $timestamps = false;
    protected $table = 'user_balances';
    protected $guarded = [];

    public function scopeId(Builder $builder, int|array $value){
        if(is_array($value) == false){
            $value = [$value];
        }
        return $builder->whereIn('id', $value);
    }

}
