<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 会员详情表数据模型
 */
class UserDetails extends Model{
    public $timestamps = false;
    protected $table = 'user_details';
    protected $guarded = [];

    public function user(){
        return $this->hasOne(Users::class, "id", "id");
    }

    public function scopeId(Builder $builder, int|array $value){
        if(is_array($value) == false){
            $value = [$value];
        }
        return $builder->whereIn("id", $value);
    }
}
