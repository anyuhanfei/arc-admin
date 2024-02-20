<?php

namespace App\Models\Log;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\BaseFilter;
use App\Models\Users\Users;

/**
 * 会员提现表数据模型
 */
class LogUserWithdraw extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use BaseFilter;

    protected $table = 'log_user_withdraw';
    protected $guarded = [];

    public static function status_array(){
        return ['申请中', '已通过', '已打款', '已驳回'];
    }

    public function user(){
        return $this->hasOne(Users::class, "id", "user_id");
    }

    public function scopeId(Builder $builder, int|array $value){
        if(is_array($value) == false){
            $value = [$value];
        }
        return $builder->whereIn("id", $value);
    }

    public function scopeUserId(Builder $builder, int|array $value){
        if(is_array($value) == false){
            $value = [$value];
        }
        return $builder->whereIn("user_id", $value);
    }

    public function scopeCoinType(Builder $builder, string $value){
        return $builder->where("coin_type", $value);
    }

    public function scopeStatus(Builder $builder, int $value){
        return $builder->where("status", $value);
    }
}
