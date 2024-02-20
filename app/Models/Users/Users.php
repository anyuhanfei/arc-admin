<?php

namespace App\Models\Users;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\BaseFilter;

/**
 * 会员表数据模型
 */
class Users extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use BaseFilter;

    protected $table = 'users';
    protected $guarded = [];

    public static function login_status_array(){
        return ['0'=> '冻结', '1'=> '正常'];
    }

    public function funds(){
        return $this->hasOne(UsersFund::class, 'id', 'id');
    }

    public function detail(){
        return $this->hasOne(UsersDetail::class, 'id', 'id');
    }

    public function parentUser(){
        return $this->hasOne(self::class, 'id', 'parent_user_id');
    }

    public function scopeId(Builder $builder, int|array $value){
        if(is_array($value) == false){
            $value = [$value];
        }
        return $builder->whereIn("id", $value);
    }

    public function scopeAccount(Builder $builder, string $account){
        return $builder->where("account", "like", '%'.$account.'%');
    }

    public function scopePhone(Builder $builder, string|int $phone){
        return $builder->where("phone", $phone);
    }

    public function scopeEmail(Builder $builder, string $email){
        return $builder->where("email", $email);
    }

    public function scopeParentUserId(Builder $builder, int $value){
        return $builder->where("id", $value);
    }

    public function scopeOpenid(Builder $builder, string $value){
        return $builder->where("openid", $value);
    }

    public function scopeUnionid(Builder $builder, string $value){
        return $builder->where("unionid", $value);
    }

    public function scopeLoginStatus(Builder $builder, string $value){
        return $builder->where("login_status", $value);
    }
}
