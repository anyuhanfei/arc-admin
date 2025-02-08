<?php

namespace App\Models\Users;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Users\Users;
use App\Models\BaseFilter;


/**
 * 会员资金记录表数据模型
 */
class UserBalanceLogs extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use BaseFilter;

    protected $table = 'user_balance_logs';
    protected $guarded = [];

    /**
     * 币种类型
     *
     * @return void
     */
    public static function coin_array(){
        return UserBalances::fund_type_array();
    }

    public function user(){
        return $this->hasOne(Users::class, "id", "user_id");
    }

    public function scopeUserId(Builder $builder, int|array $value){
        if(!is_array($value)){
            $value = [$value];
        }
        return $builder->whereIn("user_id", $value);
    }

    public function scopeCoinType(Builder $builder, string $value){
        return $builder->where("coin_type", $value);
    }

    public function scopeFundType(Builder $builder, string $value){
        return $builder->where("fund_type", "like", '%'.$value.'%');
    }

    public function scopeRelevance(Builder $builder, string $value){
        return $builder->where("relevance", $value);
    }

    public function scopeRemark(Builder $builder, string $value){
        return $builder->where("remark", $value);
    }
}
