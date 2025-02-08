<?php
namespace App\Api\Rules\Withdraw;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\DataAwareRule;

use App\Repositories\Sys\SysSettings;
use App\Repositories\Users\UserBalances;


/**
 * 提现金额规则判断
 *  1. 判断是否达到最低提现金额要求
 *  2. 判断是否有足够的余额
 */
class AmountRuleVerify implements ValidationRule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail):void{
        $withdraw_minimum_amount_set = floatval((new SysSettings())->get_value_by_key("withdraw_minimum_amount"));
        if($withdraw_minimum_amount_set > $value){
            $fail("最低提现金额为：{$withdraw_minimum_amount_set}");
            return;
        }
        $user_fund = (new UserBalances())->get_data_by_user($this->data['user_id']);
        if(!$user_fund){
            $fail("系统异常");
            return;
        }
        $coin_type = $this->data['coin_type'] ?? '';
        if(floatval($user_fund->$coin_type) < $value){
            $fail("可提现金额不足");
            return;
        }
    }

}
