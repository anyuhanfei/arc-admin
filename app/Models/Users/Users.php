<?php

namespace App\Models\Users;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\BaseFilter;

/**
 * 用户表数据模型
 */
class Users extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use BaseFilter;

    protected $table = 'users';
    protected $guarded = [];
    protected $appends = ['full_avatar'];

    public function fullAvatar(): Attribute{
        return Attribute::make(
            get: fn(string|null $value, array $data) => empty($data['avatar']) ? '' : (Str::contains($data['avatar'], '//') ? $data['avatar'] : Storage::disk('admin')->url($data['avatar'])),
        );
    }

    public function balances(){
        return $this->hasOne(UserBalances::class, 'id', 'id');
    }

    public function details(){
        return $this->hasOne(UserDetails::class, 'id', 'id');
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

    public function scopeLoginStatus(Builder $builder, string $value){
        return $builder->where("login_status", $value);
    }
}
