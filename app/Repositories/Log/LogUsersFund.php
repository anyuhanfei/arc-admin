<?php

namespace App\Repositories\Log;

use App\Models\Log\LogUsersFund as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * 会员资金记录表数据仓库
 */
class LogUsersFund extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 币种合集
     *
     * @return void
     */
    public static function coin_array():array{
        return Model::coin_array();
    }

    /**
     * 日志类型合集
     *
     * @return array
     */
    public static function fund_type_array():array{
        return Model::groupby("fund_type")->pluck("fund_type")->toArray();
    }

    /**
     * 添加数据
     *
     * @param integer $user_id 会员id
     * @param string $coin_type 币种
     * @param string $fund_type 操作说明
     * @param integer|float $amount 金额
     * @param integer|float $before_money 操作前金额
     * @param integer|float $after_money 操作后金额
     * @param string $relevance 关联数据
     * @param string $remark 备注
     * @return EloquentModel
     */
    public function created_data(int $user_id, string $coin_type, string $fund_type, int|float $amount, int|float $before_money, int|float $after_money, string $relevance = '', string $remark = ''):EloquentModel{
        return $this->eloquentClass::create([
            'user_id'=> $user_id,
            'coin_type'=> $coin_type,
            'fund_type'=> $fund_type,
            'amount'=> $amount,
            'before_money'=> $before_money,
            'after_money'=> $after_money,
            'relevance'=> $relevance,
            'remark'=> $remark,
        ]);
    }

    /**
     * 获取会员资金流水记录
     *
     * @param integer $user_id
     * @param integer $page
     * @param integer $limit
     * @param array $search
     * @return Collection
     */
    public function get_user_fund_list(int $user_id, int $page, int $limit, array $search):Collection{
        return $this->eloquentClass::userId($user_id)->apply($search)->page($page, $limit)->select("id", "coin_type", "fund_type", "amount", "before_money", "after_money", "relevance", "remark", "created_at")->get();
    }


    /**
     * 获取某种流水日志的总金额
     *
     * @param string $fund_type
     * @return integer|float
     */
    public function count_fund_type_sum(string $fund_type):int|float{
        return $this->eloquentClass::fundType($fund_type)->sum("amount");
    }
}
