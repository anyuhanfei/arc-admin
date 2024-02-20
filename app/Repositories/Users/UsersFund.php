<?php

namespace App\Repositories\Users;

use App\Models\Users\UsersFund as Model;
use App\Repositories\Log\LogUsersFund;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * 会员资产表数据仓库
 */
class UsersFund extends EloquentRepository{
    protected $eloquentClass = Model::class;

    /**
     * 获取币种类型合集
     *
     * @return array
     */
    public static function fund_type_array():array{
        return Model::fund_type_array();
    }

    /**
     * 创建数据
     *   一般伴随创建会员是调用
     *
     * @param integer $id
     * @return EloquentModel
     */
    public function create_data(int $id):EloquentModel{
        return $this->eloquentClass::create([
            'id'=> $id,
        ]);
    }

    /**
     * 对会员的资金进行操作并添加记录信息
     * 正常情况下，需要在事务内调用此方法，可以让悲观锁生效
     *
     * @param int $user_id 会员id
     * @param string $coin_type 币种
     * @param float|int $money 金额
     * @param string $fund_type 操作说明
     * @param string $relevance 关联数据
     * @param string $remark 备注
     * @return int|float 币种余额
     */
    public function update_fund(int $user_id, string $coin_type, float|int $money, string $fund_type, string $relevance = '', string $remark = ''):int|float{
        // 查询数据并获取排它锁，修改会员资产
        $user_fund = $this->eloquentClass::where('id', $user_id)->lockForUpdate()->first();
        $before_money = floatval($user_fund->$coin_type);
        $user_fund->$coin_type += $money;
        $after_money = floatval($user_fund->$coin_type);
        $user_fund->save();
        // 添加资产记录
        (new LogUsersFund())->created_data($user_id, $coin_type, $fund_type, $money, $before_money, $after_money, $relevance, $remark);
        return $user_fund->$coin_type;
    }

    /**
     * 通过会员id获取会员资产
     *
     * @param integer $user_id
     * @return EloquentModel|null
     */
    public function use_id_get_data(int $user_id):EloquentModel|null{
        return $this->eloquentClass::id($user_id)->first();
    }
}
