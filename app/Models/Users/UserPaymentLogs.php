<?php

namespace App\Models\Users;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Users\Users;

/**
 * 用户支付记录表数据模型
 */
class UserPaymentLogs extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'user_payment_logs';
    protected $guarded = [];


    public function user(){
        return $this->hasOne(Users::class, "id", "user_id");
    }

    public function scopeOutTradeNo(Builder $builder, string $value){
        return $builder->where("out_trade_no", $value);
    }

    public function scopeRelevance(Builder $builder, string $value){
        return $builder->where("relevance", $value);
    }

    public function scopeOutRefundNo(Builder $builder, string $value){
        return $builder->where("out_refund_no", $value);
    }

    public function scopeUserId(Builder $builder, int $value){
        return $builder->where("user_id", $value);
    }
}
