<?php

namespace App\Repositories\Log;

use App\Models\Log\LogUsersPay as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * 会员支付记录表数据仓库
 */
class LogUsersPay extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 创建支付记录
     *
     * @param integer $user_id
     * @param string $out_trade_no
     * @param string $pay_method
     * @param integer|float $amount
     * @param string $relevance
     * @return void
     */
    public function create_data(int $user_id, string $out_trade_no, string $pay_method, string $pay_type, int|float $amount, string $relevance):EloquentModel{
        return $this->eloquentClass::create([
            'out_trade_no'=> $out_trade_no,
            'user_id'=> $user_id,
            'pay_method'=> $pay_method,
            'pay_type'=> $pay_type,
            'amount'=> $amount,
            'status'=> 0,
            'relevance'=> $relevance
        ]);
    }

    /**
     * 获取支付订单的流水号
     *
     * @param string $out_trade_no
     * @return EloquentModel|null
     */
    public function use_no_get_data(string $out_trade_no):EloquentModel|null{
        return $this->eloquentClass::outTradeNo($out_trade_no)->first();
    }

    /**
     * 修改日志的状态
     * 0=未支付 1=已支付 2=已退款
     *
     * @param string $out_trade_no
     * @param integer $status
     * @return integer
     */
    public function use_no_update_status(string $out_trade_no, int $status):int{
        return $this->eloquentClass::outTradeNo($out_trade_no)->update([
            'status'=> $status
        ]);
    }

}
