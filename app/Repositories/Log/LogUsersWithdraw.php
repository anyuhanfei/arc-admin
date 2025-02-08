<?php

namespace App\Repositories\Log;

use App\Models\Log\LogUsersWithdraw as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 会员提现表数据仓库
 */
class LogUsersWithdraw extends EloquentRepository{
    protected $eloquentClass = Model::class;

    public static function status_array():array{
        return Model::status_array();
    }

    /**
     * 创建
     *
     * @param integer $user_id
     * @param integer|float $amount
     * @param integer|float $fee
     * @param string $coin_type
     * @param array $accounts
     * @return void
     */
    public function create_data(int $user_id, int|float $amount, int|float $fee, string $coin_type, array $accounts, string $content = '', string $remark = ''):EloquentModel{
        return $this->eloquentClass::create([
            'user_id'=> $user_id,
            'coin_type'=> $coin_type,
            'amount'=> $amount,
            'fee'=> $fee,
            'content'=> $content,
            'remark'=> $remark,
            'status'=> 0,
            'alipay_account'=> $accounts['alipay_account'] ?? '',
            'alipay_username'=> $accounts['alipay_username'] ?? '',
            'wx_account'=> $accounts['wx_account'] ?? '',
            'wx_username'=> $accounts['wx_username'] ?? '',
            'wx_openid'=> $accounts['wx_openid'] ?? '',
            'bank_card_code'=> $accounts['bank_card_code'] ?? '',
            'bank_card_username'=> $accounts['bank_card_username'] ?? '',
            'bank_card_bank'=> $accounts['bank_card_bank'] ?? '',
            'bank_card_sub_bank'=> $accounts['bank_card_sub_bank'] ?? '',
        ]);
    }

    /**
     * 获取会员提现列表
     *
     * @param integer $user_id
     * @param integer $page
     * @param integer $limit
     * @return void
     */
    public function get_list_by_user(int $user_id, int $limit):LengthAwarePaginator{
        return $this->eloquentClass::userId($user_id)->paginate($limit);
    }
}
