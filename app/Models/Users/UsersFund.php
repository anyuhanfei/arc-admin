<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 会员资金表数据模型
 */
class UsersFund extends Model{
    public $timestamps = false;
    protected $table = 'users_fund';
    protected $guarded = [];

    /**
     * 当这里的资金种类改变时，必须同步改变数据库表 user_fund 中的字段
     *
     * @return void
     */
    public static function fund_type_array(){
        return ['money'=> "余额", 'integral'=> "积分"];
    }

    public function scopeId(Builder $builder, int|array $value){
        if(is_array($value) == false){
            $value = [$value];
        }
        return $builder->whereIn('id', $value);
    }

}
