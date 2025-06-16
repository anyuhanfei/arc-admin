<?php
namespace App\Api\Requests\User;

use App\Api\Requests\BaseRequest;
use App\Api\Rules\Withdraw\AmountRuleVerify;
use Illuminate\Validation\Rule;

/**
 * 提现信息验证
 */
class WithdrawRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'amount'=> ['required', new AmountRuleVerify],
            'account_type'=> ['required', Rule::in(['微信', '支付宝', '银行卡'])],
            'coin_type'=> ['required'],
        ];
    }

    public function messages(){
        return [
            'amount.required'=> '请填写提现金额',
            'account_type.required'=> '请填写提现方式',
            'coin_type.required'=> '请填写提现币种',
        ];
    }
}