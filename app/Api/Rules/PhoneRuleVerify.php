<?php
namespace App\Api\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

/**
 * 判断手机号是否符合规则
 */
class PhoneRuleVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        return preg_match('/^1[3456789]\d{9}$/ims', $value);
    }

    public function message(){
        return "请输入正确的手机号";
    }
}